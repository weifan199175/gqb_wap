<?php
// +----------------------------------------------------------------------
// | ShuipFCMS 网站定时任务处理接口
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------

namespace Content\Controller;

use Common\Controller\Base;
use Content\Model\ContentModel;

require_once $_SERVER['DOCUMENT_ROOT']."/weixin/lib/WxPay.Api.php";
require_once $_SERVER['DOCUMENT_ROOT']."/weixin/example/WxPay.JsApiPay.php";
require_once $_SERVER['DOCUMENT_ROOT']."/weixin/example/log.php";
require_once $_SERVER['DOCUMENT_ROOT']."/alipay/alirefund.config.php";
require_once $_SERVER['DOCUMENT_ROOT']."/alipay/lib/alipay_core.function.php";
require_once $_SERVER['DOCUMENT_ROOT']."/alipay/lib/alipay_md5.function.php";

class TaskController extends Base {
	public $funding = null;
	public $funding_log = null;
	public $errorlog = null;

	public function _initialize() {
		parent::_initialize();
		$this -> funding = M("funding");
		$this -> funding_log = M("funding_log");
		$this -> errorlog = M("errorlog");
	}
	
	/**
	 * 更新所有过期的众筹，状态改为已过期
	 */
	public function updateFundingStatus(){
	    M("test")->add(array("content"=>"执行updateFundingStatus","createtime"=>date("Y-m-d H:i:s",time())));
	    $this->funding->where(time()." >= end_time AND status = 0")->save(array("status"=>-1));
	}
	
	/**
	 * 微信退款（一次只处理5条）
	 */
	public function weixinPayBack(){
// 	    M("test")->add(array("content"=>"执行weixinPayBack","createtime"=>date("Y-m-d H:i:s",time())));
	    $ids = $this->funding->where("status=-1")->field("id")->select();
	    foreach ($ids as $k=>$d){
	        $fid[]=$d['id'];
	    }
	    $fid = "(".implode(",", $fid).")";
	    $logs = $this->funding_log->join("LEFT JOIN jbr_member ON jbr_member.id=jbr_funding_log.member_id")->where("jbr_funding_log.status=1 AND jbr_funding_log.pay_type='weixin' AND jbr_funding_log.fid in {$fid}")->field("jbr_funding_log.*,jbr_member.openid")->limit(5)->select();
	    if(!empty($logs)){
    	    foreach ($logs as $l){
        		$input = new \WxPayRefund();
        		$input->SetOut_trade_no($l['verification_code']);
        		$input->SetOut_refund_no($l['verification_code']);
        		$input->SetTotal_fee($l['money']*100);                   //订单价格   单位：分   $price
        		$input->SetRefund_fee($l['money']*100);
        		$input->SetOp_user_id(\WxPayConfig::MCHID);
        		$input->SetRefund_account("REFUND_SOURCE_RECHARGE_FUNDS");
        	    $result = \WxPayApi::refund($input);
        	    if(isset($result['result_code']) && $result['result_code'] == "SUCCESS"){
        	        $this->funding_log->where("id=".$l['id'])->save(array("status"=>2,'updatetime'=>date("Y-m-d H:i:s",time())));
        	        /**   发送退款成功模板消息 ——start——*/
        	        $openid=$l['openid'];
        	        $first = "你好，您支持的众筹活动未成功，付款将在1-3个工作日以内原路返还。";
        	        $reason = "众筹未成功";
        	        $refund = $l['money']."元";
        	        $remark = "如对众筹活动有疑问，请致电400-027-9828联系我们";
        	        sendTplPayBack($openid, $first, $reason, $refund, $remark);
        	        /**   发送退款成功模板消息 ——end——*/
        	    }else {
    	            if(isset($result['err_code']) && $result['err_code'] == "NOTENOUGH"){//当商户后台充值金额不够用的时候
        	            $wx = S("is_send_weixin_NOTENOUGH");
        	            if(!$wx){
        	                $this->send_sms("公众号的商户后台余额不足了，快去充值！", "15071161567");
        	                S("is_send_weixin_NOTENOUGH",1,43200);
        	            }
    	            }
        	        $data = array(
        	            "position"=>"微信自动退款失败，众筹订单",
        	            "info"=>"错误信息：".json_encode($result),
        	            "extra"=>"众筹订单信息".json_encode($l),
        	            "datetime"=>date("Y-m-d H:i:s", time()),
        	        );
        	        $this->errorlog->add($data);
        	    }
    	    }
	    }
	}
	
	
	/*
	 * 支付宝退款
	 * */
	public function Alirefund()
	{
	   //获得alipay配置
	   $alipay_config = json_decode(ALIREFUND_CONFIG,true);
	   //获取已过期的众筹活动订单
	   $ids = $this->funding->where("status=-1")->field("id")->select();
	   foreach ($ids as $k=>$d){
	        $fid[]=$d['id'];
	    }
	   $fids = implode(',',$fid);
	   
	   //获取过期众筹活动支付者的信息
	   $log_info = $this ->funding_log->where(array(
	       'status'=>array('eq','1'),
	       'pay_type'=>array('eq','zhifubao'),
	       'fid'=>array('in',$fids)
	   ))->limit(5)->select();
	   
         if(empty($log_info))
          {
           //服务器异步通知页面路径
           $notify_url = "http://".$_SERVER['HTTP_HOST']."/index.php/content/Task/notify_url.html";
           //获取这一批次的退款批次号
           $batch_no = get_batch_no();
           $refund_date = date('Y-m-d H:i:s',time());
           $batch_num = count($log_info);           
           //组装符合规则的
//            $batch_num = '1';
//            $detail_data = '2017050921001004130211724975^0.01^qq';
           $detail_data = get_refund_detail($log_info); 
           //构造要请求的参数数组，无需改动
           $parameter = array(
               "service" => "refund_fastpay_by_platform_nopwd",
               "partner" => trim($alipay_config['partner']),
               "notify_url"	=> $notify_url,
               "batch_no"	=> $batch_no,
               "refund_date"	=>$refund_date,
               "batch_num"	=> "$batch_num",
               "detail_data"	=> $detail_data,
               "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
           );
//             dump($parameter);die;
           //建立请求
           $alipaySubmit = new AlipaySubmit($alipay_config);    
           $html_text = $alipaySubmit->buildRequestHttp($parameter); 
           $dataobj = simplexml_load_string($html_text, 'SimpleXMLElement', LIBXML_NOCDATA);
           $jsonmsg = json_encode($dataobj,JSON_UNESCAPED_UNICODE);//将对象转成JSON数组
           $msg = json_decode($jsonmsg,true);
           dump($msg);
           if($msg['is_success'] == 'T')
           {
               $data = array(
                   "position"=>"支付宝退款申请成功，众筹订单",
                   "info"=>"订单批次号：".json_encode($batch_no),
                   "datetime"=>date("Y-m-d H:i:s", time()),
               );
               $this->errorlog->add($data);
           }else
           {
               $data = array(
                   "position"=>"支付宝退款申请失败，众筹订单",
                   "info"=>"订单批次号：".json_encode($batch_no),
                   "extra"=>"错误信息".json_encode($msg['error']),
                   "datetime"=>date("Y-m-d H:i:s", time()),
               );
               $this->errorlog->add($data);
           }
         }
	}
	
// 	//微信临时退款
// 	public function refund()
// 	{
// 	    dump(12312);
// 	    $input = new \WxPayRefund();
// 	    $input->SetOut_trade_no("pc2017050898495157");
// 	    $input->SetOut_refund_no("pc2017050898495157");
// 	    $input->SetTotal_fee(1);                   //订单价格   单位：分   $price
// 	    $input->SetRefund_fee(1);
// 	    $input->SetOp_user_id(\WxPayConfig::MCHID);
// // 	    $input->SetRefund_account("REFUND_SOURCE_RECHARGE_FUNDS");
// 	    $result = \WxPayApi::refund($input);
// 	    print_r($result);exit();
// 	}
	
// 支付宝临时退狂
   public function alirefund_lishi()
   {
       //获得alipay配置
       $alipay_config = json_decode(ALIREFUND_CONFIG,true);     
       //服务器异步通知页面路径
       $notify_url = "http://".$_SERVER['HTTP_HOST']."/index.php/content/Task/notify_url.html";
       //获取这一批次的退款批次号
       $batch_no = get_batch_no();
       $refund_date = date('Y-m-d H:i:s',time());
       //组装符合规则的
       $batch_num = '4';
       $detail_data = '2017052721001004850254794033^0.01^qq#2017052721001004850254967932^0.01^qq#2017052721001004130230011892^0.01^qq#2017052721001004130229961185^0.01^qq';
       //构造要请求的参数数组，无需改动
       $parameter = array(
           "service" => "refund_fastpay_by_platform_nopwd",
           "partner" => trim($alipay_config['partner']),
           "notify_url"	=> $notify_url,
           "batch_no"	=> $batch_no,
           "refund_date"	=>$refund_date,
           "batch_num"	=> "$batch_num",
           "detail_data"	=> $detail_data,
           "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
       );
       //             dump($parameter);die;
       //建立请求
       $alipaySubmit = new AlipaySubmit($alipay_config);
       $html_text = $alipaySubmit->buildRequestHttp($parameter);
       $dataobj = simplexml_load_string($html_text, 'SimpleXMLElement', LIBXML_NOCDATA);
       $jsonmsg = json_encode($dataobj,JSON_UNESCAPED_UNICODE);//将对象转成JSON数组
       $msg = json_decode($jsonmsg,true);
       dump($msg);       
   }
	
	//支付宝回调地址，
	public function notify_url()
	{
	    //计算得出通知验证结果
	    $alipay_config = json_decode(ALIREFUND_CONFIG, true);
	    $alipayNotify = new AlipayNotify($alipay_config);
	    $verify_result = $alipayNotify->verifyNotify();	   	    
	    if($verify_result) {//验证成功
	        $batch_no = $_POST['batch_no'];
	        $success_num = $_POST['success_num'];
	        $result_details = $_POST['result_details'];	
	        if($result_details)
	        {
	            //处理返回的数据
	            $de = change_result_details($result_details);
	            $data = array(
	                "position"=>"支付宝退款，处理返回数据",
	                "info"=>"订单批次号：".json_encode($batch_no),
	                "extra"=>"结果".json_encode($de),
	                "datetime"=>date("Y-m-d H:i:s", time()),
	            );
	            $this->errorlog->add($data);
	            //将根据返回的结果将修改订单状态
	            if($de)
	            {
	                //数据处理完毕
	                foreach($de as $k =>$v)
	                {
	                    if($v['result'] == 'SUCCESS')
	                    {	                        
	                        //退款成功，修改订单状态
	                        $o = zc_refund_success($v['transaction_id']);
	                        if(!$o)
	                        {
	                            //修改订单不成功
	                            $data = array(
	                                "position"=>"支付宝退款，修改订单状态",
	                                "info"=>"订单批次号：".json_encode($batch_no),
	                                "extra"=>"结果".json_encode($v),
	                                "datetime"=>date("Y-m-d H:i:s", time()),
	                            );
	                            $this->errorlog->add($data);
	                        }
	                    }else
	                    {
	                        $data = array(
	                            "position"=>"支付宝退款失败，众筹订单",
	                            "info"=>"订单批次号：".json_encode($batch_no),
	                            "extra"=>"错误信息".json_encode($v['result']),
	                            "datetime"=>date("Y-m-d H:i:s", time()),
	                        );
	                        $this->errorlog->add($data);
	                    }
	                    //无论添加退款成功失败，增加批次号
	                    $this->funding_log->where('transaction_id='.$v['transaction_id'])->save(array('batch_id'=>$batch_no,'updatetime'=>date("Y-m-d H:i:s",time())));
	                }
	            }
	        } 	    
	        //判断是否在商户网站中已经做过了这次通知返回的处理
	        //如果没有做过处理，那么执行商户的业务程序
	        //如果有做过处理，那么不执行商户的业务程序    
	        echo "success";		//请不要修改或删除	    
	    }
	    else {
	        //验证失败
	        echo "fail";	    
	        //调试用，写文本函数记录程序运行情况是否正常
	        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
	    }
	}

	/**
	 * 发送统计报告（根据参数选择发送昨天、上周、上个月、去年的数据）
	 */
	public function sendStatisticsEmail(){
	    $sendType = I("get.sendType","day","string");
	    switch ($sendType) {
	        case "day"://昨天的统计报告
	            //查询时间条件
	            $date = strtotime("-1 day");//要统计的那一天0点0分0秒的时间戳
	            $today = date("Y年m月d日",$date);
	            $starttime = date("Y-m-d 00:00:00",$date);
	            $endtime = date("Y-m-d 23:59:59",$date);
	            $HTMLtitle = "股权帮WAP站 - ".$today." 运营数据";
	        break;
	        case "week"://上一周的统计报告
	            //查询时间条件
	            $week = date("Y年m月d日",mktime(0,0,0,date('m'),date('d')-date('w')+1-7,date('Y')))." - ".date("Y年m月d日",mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y')));
	            $starttime = date("Y-m-d 00:00:00",mktime(0,0,0,date('m'),date('d')-date('w')+1-7,date('Y')));
	            $endtime = date("Y-m-d 23:59:59",mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y')));
	            $HTMLtitle = "股权帮WAP站 （".$week."） 运营数据";
	        break;
	        case "month"://上个月的统计报告
	            //查询时间条件
	            $month = date("Y年m月份",mktime(0, 0 , 0,date("m")-1,1,date("Y")));
	            $starttime = date("Y-m-d 00:00:00",mktime(0, 0 , 0,date("m")-1,1,date("Y")));
	            $endtime = date("Y-m-d 23:59:59",mktime(23,59,59,date("m") ,0,date("Y")));
	            $HTMLtitle = "股权帮WAP站 （".$month."） 运营数据";
	        break;
	        case "year"://去年一整年的统计报告
	            //查询时间条件
	            $year = date("Y年",strtotime("-1 year"));
	            $starttime = date("Y-m-d 00:00:00",mktime(0, 0 , 0,1,1,date("Y")-1));
	            $endtime = date("Y-m-d 23:59:59",mktime(23,59,59,12 ,31,date("Y")-1));
	            $HTMLtitle = "股权帮WAP站 （".$year."） 运营数据";
	        break;
	    }
	    //访问次数
	    $pv = M("statistics")->where("createtime >= '{$starttime}' AND createtime <= '{$endtime}'")->count("id");
	    //访问人数
	    $uv = M("statistics")->where("createtime >= '{$starttime}' AND createtime <= '{$endtime}'")->count('distinct ip');
	    //关键字统计
	    $keyword = M("wxmsglog")->where("msgtype='text' AND datetime >= '{$starttime}' AND datetime <= '{$endtime}'")->group("content")->field(array("count(content) as num,content"))->select();
	     
	    /** 自定义菜单统计  ——start——*/
	    $menu = json_decode(phpGet("https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".getWxAccessToken()),true);
	    $freemenu=array();
	    foreach ($menu['menu']['button'] as $k=>$b){
	        $freemenu[$k]['menuName']=$b['name'];//自定义菜单的名字
	        if($b['type'] == "view"){//跳转页面
	            $where = "event='".strtoupper($b['type'])."' AND eventKey='".$b['url']."' AND datetime >= '{$starttime}' AND datetime <= '{$endtime}'";
	        }else {
	            $where = "event='".strtoupper($b['type'])."' AND eventKey='".$b['key']."' AND datetime >= '{$starttime}' AND datetime <= '{$endtime}'";
	        }
	        $freemenu[$k]['clickNum'] = M("wxeventlog")->where($where)->count("id");//自定义菜单被点击次数
	        $freemenu[$k]['people'] = M("wxeventlog")->where($where)->count("distinct openid");//自定义菜单被点击人数
	    }
	    /** 自定义菜单统计  ——end——*/
	      
	    /** 课程订单统计  ——start——*/
	    $courseOrder=M("order")->where("product_type = 1 AND addtime >= '{$starttime}' AND addtime <= '{$endtime}'")->group("status")->field(array("count(id) AS num","status"))->select();
	    foreach ($courseOrder as $k=>$c){
	        switch ($c['status']) {
	            case 0:
	                $courseOrder[$k]['status']="未支付";
	                break;
	            case 1:
	                $courseOrder[$k]['status']="已付款";
	                break;
	            case 2:
	                $courseOrder[$k]['status']="已使用";
	                break;
	        }
	    }
	    /** 课程订单统计  ——end——*/
	      
	        
	    /** 铁杆社员订单统计  ——start——*/
	    $vip=M("order")->where("product_id = 0 AND product_type = 16 AND addtime >= '{$starttime}' AND addtime <= '{$endtime}'")->group("status")->field(array("count(id) AS num","status"))->select();
	    foreach ($vip as $k=>$c){
	        switch ($c['status']) {
	            case 0:
	                $vip[$k]['status']="未支付";
	                break;
	            case 1:
	                $vip[$k]['status']="已付款";
	                break;
	            case 2:
	                $vip[$k]['status']="已使用";
	                break;
	        }
	    }
	    /** 铁杆社员订单统计  ——end——*/
	      
	        
	    /** 微信粉丝数统计 ——start—— */
	    $rs = json_decode(phpGet("https://api.weixin.qq.com/cgi-bin/user/get?access_token=".getWxAccessToken()),true);
	    if(!isset($rs['total'])){//如果没查到，更新token再查一次
    	    $rs = json_decode(phpGet("https://api.weixin.qq.com/cgi-bin/user/get?access_token=".getWxAccessToken(true)),true);
	    }
	    //粉丝总数
	    $fans['total'] = $rs['total'];
	    //关注人数
	    $fans['add'] = M("wxeventlog")->where("event = 'subscribe' AND datetime >= '{$starttime}' AND datetime <= '{$endtime}'")->count("distinct openid");
	    //取关人数
	    $fans['del'] = M("wxeventlog")->where("event = 'unsubscribe' AND datetime >= '{$starttime}' AND datetime <= '{$endtime}'")->count("distinct openid");
	    //净新增人数
	    $fans['num'] = $fans['add']-$fans['del'];
	    //注册人数
	    $fans['reg'] = M("member")->where("regtime >= '{$starttime}' AND regtime <= '{$endtime}'")->count("id");
	    /** 微信粉丝数统计 ——end—— */
	      
	    /** 灿哥统计图专用 ——start——  */
	    $img = file_exists(SITE_PATH."d/upload/lican.jpg")?"data:image/jpg;base64,".base64_encode(file_get_contents(SITE_PATH."d/upload/lican.jpg")):null;
	    /** 灿哥统计图专用 ——end——  */
	    
	    
	    /** 股权诊断器统计 ——start—— */
	    $dia['not_pay'] = M("dia_tool")->where("status=0 AND datetime >= '".strtotime($starttime)."' AND datetime <= '".strtotime($endtime)."'")->count();
	    $dia['pay'] = M("dia_tool")->where("status=1 AND datetime >= '".strtotime($starttime)."' AND datetime <= '".strtotime($endtime)."'")->count();
	    $dia['num']=$dia['not_pay']+$dia['pay'];
	    $dia['data'] = M("dia_tool")->where("datetime >= '".strtotime($starttime)."' AND datetime <= '".strtotime($endtime)."' AND star>0")->group("star")->field("star,count(id) AS num")->order("star DESC")->select();
	    /** 股权诊断器统计 ——end—— */
	    
	    ob_start();
	    include_once(TEMPLATE_PATH.'/Default/Content/Task/index.php');
	    $template = ob_get_contents();
	    ob_end_clean();
	    SendMail("yunying@bogleunion.com", $HTMLtitle, $template);
	}
}

class AlipaySubmit {

    var $alipay_config;
    /**
     *支付宝网关地址（新）
     */
    var $alipay_gateway_new = 'https://mapi.alipay.com/gateway.do?';

    function __construct($alipay_config){
        $this->alipay_config = $alipay_config;
    }
    function AlipaySubmit($alipay_config) {
        $this->__construct($alipay_config);
    }

    /**
     * 生成签名结果
     * @param $para_sort 已排序要签名的数组
     * return 签名结果字符串
     */
    function buildRequestMysign($para_sort) {
        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = createLinkstring($para_sort);

        $mysign = "";
        switch (strtoupper(trim($this->alipay_config['sign_type']))) {
            case "MD5" :
                $mysign = md5Sign($prestr, $this->alipay_config['key']);
                break;
            default :
                $mysign = "";
        }

        return $mysign;
    }

    /**
     * 生成要请求给支付宝的参数数组
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数数组
     */
    function buildRequestPara($para_temp) {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = paraFilter($para_temp);

        //对待签名参数数组排序
        $para_sort = argSort($para_filter);

        //生成签名结果
        $mysign = $this->buildRequestMysign($para_sort);

        //签名结果与签名方式加入请求提交参数组中
        $para_sort['sign'] = $mysign;
        $para_sort['sign_type'] = strtoupper(trim($this->alipay_config['sign_type']));

        return $para_sort;
    }

    /**
     * 生成要请求给支付宝的参数数组
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数数组字符串
     */
    function buildRequestParaToString($para_temp) {
        //待请求参数数组
        $para = $this->buildRequestPara($para_temp);

        //把参数组中所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
        $request_data = createLinkstringUrlencode($para);

        return $request_data;
    }

    /**
     * 建立请求，以表单HTML形式构造（默认）
     * @param $para_temp 请求参数数组
     * @param $method 提交方式。两个值可选：post、get
     * @param $button_name 确认按钮显示文字
     * @return 提交表单HTML文本
     */
    function buildRequestForm($para_temp, $method, $button_name) {
        //待请求参数数组
        $para = $this->buildRequestPara($para_temp);

        $sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='".$this->alipay_gateway_new."_input_charset=".trim(strtolower($this->alipay_config['input_charset']))."' method='".$method."'>";
        while (list ($key, $val) = each ($para)) {
            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }

        //submit按钮控件请不要含有name属性
        $sHtml = $sHtml."<input type='submit' value='".$button_name."'></form>";

        $sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";

        return $sHtml;
    }

    /**
     * 建立请求，以模拟远程HTTP的POST请求方式构造并获取支付宝的处理结果
     * @param $para_temp 请求参数数组
     * @return 支付宝处理结果
     */
    function buildRequestHttp($para_temp) {
        $sResult = '';

        //待请求参数数组字符串
        $request_data = $this->buildRequestPara($para_temp);

        //远程获取数据
        $sResult = getHttpResponsePOST($this->alipay_gateway_new, $this->alipay_config['cacert'],$request_data,trim(strtolower($this->alipay_config['input_charset'])));

        return $sResult;
    }

    /**
     * 建立请求，以模拟远程HTTP的POST请求方式构造并获取支付宝的处理结果，带文件上传功能
     * @param $para_temp 请求参数数组
     * @param $file_para_name 文件类型的参数名
     * @param $file_name 文件完整绝对路径
     * @return 支付宝返回处理结果
     */
    function buildRequestHttpInFile($para_temp, $file_para_name, $file_name) {

        //待请求参数数组
        $para = $this->buildRequestPara($para_temp);
        $para[$file_para_name] = "@".$file_name;

        //远程获取数据
        $sResult = getHttpResponsePOST($this->alipay_gateway_new, $this->alipay_config['cacert'],$para,trim(strtolower($this->alipay_config['input_charset'])));

        return $sResult;
    }

    /**
     * 用于防钓鱼，调用接口query_timestamp来获取时间戳的处理函数
     * 注意：该功能PHP5环境及以上支持，因此必须服务器、本地电脑中装有支持DOMDocument、SSL的PHP配置环境。建议本地调试时使用PHP开发软件
     * return 时间戳字符串
     */
    function query_timestamp() {
        $url = $this->alipay_gateway_new."service=query_timestamp&partner=".trim(strtolower($this->alipay_config['partner']))."&_input_charset=".trim(strtolower($this->alipay_config['input_charset']));
        $encrypt_key = "";

        $doc = new DOMDocument();
        $doc->load($url);
        $itemEncrypt_key = $doc->getElementsByTagName( "encrypt_key" );
        $encrypt_key = $itemEncrypt_key->item(0)->nodeValue;

        return $encrypt_key;
    }
}

class AlipayNotify {
    /**
     * HTTPS形式消息验证地址
     */
    var $https_verify_url = 'https://mapi.alipay.com/gateway.do?service=notify_verify&';
    /**
     * HTTP形式消息验证地址
     */
    var $http_verify_url = 'http://notify.alipay.com/trade/notify_query.do?';
    var $alipay_config;

    function __construct($alipay_config){
        $this->alipay_config = $alipay_config;
    }
    function AlipayNotify($alipay_config) {
        $this->__construct($alipay_config);
    }
    /**
     * 针对notify_url验证消息是否是支付宝发出的合法消息
     * @return 验证结果
     */
    function verifyNotify(){
        if(empty($_POST)) {//判断POST来的数组是否为空
            return false;
        }
        else {
            //生成签名结果
            $isSign = $this->getSignVeryfy($_POST, $_POST["sign"]);
            //获取支付宝远程服务器ATN结果（验证是否是支付宝发来的消息）
            $responseTxt = 'false';
            if (! empty($_POST["notify_id"])) {$responseTxt = $this->getResponse($_POST["notify_id"]);}
            	
            //写日志记录
            //if ($isSign) {
            //	$isSignStr = 'true';
            //}
            //else {
            //	$isSignStr = 'false';
            //}
            //$log_text = "responseTxt=".$responseTxt."\n notify_url_log:isSign=".$isSignStr.",";
            //$log_text = $log_text.createLinkString($_POST);
            //logResult($log_text);
            	
            //验证
            //$responsetTxt的结果不是true，与服务器设置问题、合作身份者ID、notify_id一分钟失效有关
            //isSign的结果不是true，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有关
            if (preg_match("/true$/i",$responseTxt) && $isSign) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * 针对return_url验证消息是否是支付宝发出的合法消息
     * @return 验证结果
     */
    function verifyReturn(){
        if(empty($_GET)) {//判断POST来的数组是否为空
            return false;
        }
        else {
            //生成签名结果
            $isSign = $this->getSignVeryfy($_GET, $_GET["sign"]);
            //获取支付宝远程服务器ATN结果（验证是否是支付宝发来的消息）
            $responseTxt = 'false';
            if (! empty($_GET["notify_id"])) {$responseTxt = $this->getResponse($_GET["notify_id"]);}
            	
            //写日志记录
            //if ($isSign) {
            //	$isSignStr = 'true';
            //}
            //else {
            //	$isSignStr = 'false';
            //}
            //$log_text = "responseTxt=".$responseTxt."\n return_url_log:isSign=".$isSignStr.",";
            //$log_text = $log_text.createLinkString($_GET);
            //logResult($log_text);
            	
            //验证
            //$responsetTxt的结果不是true，与服务器设置问题、合作身份者ID、notify_id一分钟失效有关
            //isSign的结果不是true，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有关
            if (preg_match("/true$/i",$responseTxt) && $isSign) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * 获取返回时的签名验证结果
     * @param $para_temp 通知返回来的参数数组
     * @param $sign 返回的签名结果
     * @return 签名验证结果
     */
    function getSignVeryfy($para_temp, $sign) {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = paraFilter($para_temp);

        //对待签名参数数组排序
        $para_sort = argSort($para_filter);

        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = createLinkstring($para_sort);

        $isSgin = false;
        switch (strtoupper(trim($this->alipay_config['sign_type']))) {
            case "MD5" :
                $isSgin = md5Verify($prestr, $sign, $this->alipay_config['key']);
                break;
            default :
                $isSgin = false;
        }

        return $isSgin;
    }

    /**
     * 获取远程服务器ATN结果,验证返回URL
     * @param $notify_id 通知校验ID
     * @return 服务器ATN结果
     * 验证结果集：
     * invalid命令参数不对 出现这个错误，请检测返回处理中partner和key是否为空
     * true 返回正确信息
     * false 请检查防火墙或者是服务器阻止端口问题以及验证时间是否超过一分钟
     */
    function getResponse($notify_id) {
        $transport = strtolower(trim($this->alipay_config['transport']));
        $partner = trim($this->alipay_config['partner']);
        $veryfy_url = '';
        if($transport == 'https') {
            $veryfy_url = $this->https_verify_url;
        }
        else {
            $veryfy_url = $this->http_verify_url;
        }
        $veryfy_url = $veryfy_url."partner=" . $partner . "&notify_id=" . $notify_id;
        $responseTxt = getHttpResponseGET($veryfy_url, $this->alipay_config['cacert']);

        return $responseTxt;
    }
}
