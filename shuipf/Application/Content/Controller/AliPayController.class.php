<?php
namespace Content\Controller;

use Common\Controller\Base;
use Content\Model\ContentModel;

require_once $_SERVER['DOCUMENT_ROOT']."/alipay/alipay.config.php";
require_once $_SERVER['DOCUMENT_ROOT']."/alipay/lib/alipay_core.function.php";
require_once $_SERVER['DOCUMENT_ROOT']."/alipay/lib/alipay_md5.function.php";

class AliPayController extends Base {
	
	//public $alipay_config;
	
	
	//支付确认页面
	public function confirm()
	{
		$order_num = I('get.order_num');
		/*
		$order_res = M('order')->where("verification_code='{$order_num}'")->find();
		
		if($order_num)
		{
			$order_res = M('order')->where("verification_code='{$order_num}'")->find();
			
			$course = M('courses')->where('id='.$order_res['product_id'])->find();
		}
		if($order_res['product_type']=='15'){
			$this->assign('铁杆社员',$title);
		}else if($order_res['product_type']=='16'){
			$this->assign('铁杆社员',$title);
		}
		$this->assign('course',$course);
		*/
		$order_type = I('get.order_type',"order");//新加入订单类型变量，默认为原始订单
		switch ($order_type) {
		    case "zc"://众筹
		        $res = M("funding_log")->alias('log')->join('LEFT JOIN jbr_funding f on log.fid=f.id')->join('LEFT JOIN jbr_courses c on f.product_id=c.id')->where("log.verification_code='{$order_num}'")->field('log.fid,c.title,log.money as price,log.status')->find();
		        if($res['status'] == 1){//如果这笔众筹订单已经付款了，就跳到众筹活动页面中
		            redirect('/index.php?m=Funding&a=share&id='.$res['fid']);
		        }
		        break;
		    case "zdq"://股权诊断器
		        $res = M("order")->alias('a')->field('a.id as fid,a.*,b.*')->join('jbr_dia_tool b on a.verification_code = b.verification_code')->where("a.verification_code='{$order_num}'")->find();
		        $res['title'] = '股权诊断器';
		        $res['thumb'] = '/statics/default/images/logo1.png';
		        $order_type = 'zdq';
		        if($res['status'] == 1){//如果这笔诊断器订单已经付款了，就跳到诊断器结果页面
		            redirect('/index.php?m=WeixinPay&a=EquityOrder&id='.$res['id']);
		        }
		        break;
		    case "wk"://微课
		        $res = M("order")->where("verification_code='{$order_num}'")->find();
		        $res['title'] = '微课';
		        $res['thumb'] = '/statics/default/images/logo1.png';
		        $order_type = 'wk';
		        if($res['status'] == 1){//如果这笔诊断器订单已经付款了，就跳到诊断器结果页面
		            redirect('index.php/Content/DiacrisisTool/pay_wk_success?order_num='.$order_num);
		        }
		        break;
		    default:
        		$res=M('order')->alias('o')->join('LEFT JOIN jbr_courses c on o.product_id=c.id')->where("o.verification_code='{$order_num}'")->field('o.*,c.title,c.thumb,c.description,c.mix_price,c.mix_score')->find();        		
        		if($res['product_type']=='2')
        		{
        			//$res['price'] = $res['score'];
        			$res['title'] = '积分充值';
        			$res['thumb'] ='/statics/default/images/jfcz.jpg';  //图片	 
        		}
        	
        		if($res['product_type'] == '16')
        		{
        		    $res['title'] = '社员升级';
                    $res['thumb'] ='/statics/default/images/logo1.png';  //图片	 			
        		}
        		
		        if($res['status'] == 1){//如果这笔普通订单已经付款了，就跳到我的订单中（已支付）
		            redirect('/index.php?m=User&a=order&status=1');
		        }
        		
		        break;
		}
		$this->assign('order',$res);
		$this->assign('order_num',$order_num);
		$this->assign('order_type',$order_type);
		$this->display();
	}
	
	
	
	//订单支付成功页面
	public function pay()
	{	
        header("Content-Type: text/html; charset=utf-8");    
		$alipay_config = json_decode(ALIPAY_CONFIG, true);
		//print_r($alipay_config);die;
		$order_num = I('get.order_num');
		$order_type = I('get.order_type','order');//新增订单类型，默认为原始订单
		switch ($order_type) {
		    case "zc":
		        $res = M("funding_log")->alias('log')->join('LEFT JOIN jbr_funding f on log.fid=f.id')->join('LEFT JOIN jbr_courses c on f.product_id=c.id')->where("log.verification_code='{$order_num}'")->field('c.title,log.money as price')->find();
		        $body = "众筹";
		        break;
		    case "zdq":
		        $res['title'] = '股权诊断器';
		        $res['price'] = 1;
		        $body = '股权诊断器';
		        break;
		    case "wk":
		        $res['title'] = '微课';
		        $res['price'] = 9.9;
		        $body = '微课';
		        break;
		    default:
		        $res=M('order')->alias('o')->join('LEFT JOIN jbr_courses c on o.product_id=c.id')->where("o.verification_code='{$order_num}'")->field('o.*,c.title,c.thumb,c.description')->find();
		        $body = "订单";
		        if($res['product_type']=='2')
		        {
		            $res['price'] = $res['score'];
		            $res['title'] = '积分充值';
		            $res['thumb'] ='/statics/default/images/jfcz.jpg';  //图片
		            $res['url'] = '/index.php?m=WeixinPay&a=charge';
		        }
		        
		        if($res['product_type'] == '16')
		        {
		            $res['title'] = '社员升级';
		            $res['thumb'] ='/statics/default/images/logo1.png';  //图片
		         	$res['url'] = '/index.php?a=lists&catid=16';
		        }
		    break;
		}
		//构造要请求的参数数组，无需改动
		$parameter = array(
		    "service"       => $alipay_config['service'],
		    "partner"       => $alipay_config['partner'],
		    "seller_id"  => $alipay_config['seller_id'],
		    "payment_type"	=> $alipay_config['payment_type'],
		    "notify_url"	=> $alipay_config['notify_url'],
		    "return_url"	=> $alipay_config['return_url'],
		    "_input_charset"	=> trim(strtolower($alipay_config['input_charset'])),
		    "out_trade_no"	=> $order_num,
		    "subject"	=> $res['title'],
		    "total_fee"	=> $res['price'],
		    "show_url"	=> 'http://'.$_SERVER['HTTP_HOST'].$res['url'],
		    //"app_pay"	=> "Y",//启用此参数能唤起钱包APP支付宝
		    "body"	=> $body,
		    //其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.2Z6TSk&treeId=60&articleId=103693&docType=1
		    //如"参数名"	=> "参数值"   注：上一个参数末尾需要“,”逗号。
		);
		/**   如果是开发环境，则把金额调整为1分钱   -start-*/
        if(ENV == "dev"){
            $parameter['total_fee']=0.01;
        }
		/**   如果是开发环境，则把金额调整为1分钱   -end-*/

		//print_r($parameter);exit;
		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		echo $html_text;
	}
	
	//股权诊断器订单生成页面
	public function dia_pay_confirm()
	{
	    if(AJAX){
	        $userid = $_SESSION['userid'];
	        if(empty($userid))
	        {
	            echo json_encode(array('code'=>-2,'msg'=>'请先登录！'));exit;
	        }
	        $price = 9.9;//股权诊断器1块钱
	        
	        $r = add_order(0,7,1,$price,0,$userid,null,null);//生成订单 product_type: 7 ;
	        if($r)
	        {
	            $order_num = M('order')->where('id='.$r)->field('verification_code')->find();	          
	            echo json_encode(array('code'=>1,'msg'=>$order_num));exit;
	        }
	    }
	   
	}
	

	//支付成功页面（支付宝同步跳转地址）
	public function pay_success()
	{
	    $alipay_config = json_decode(ALIPAY_CONFIG, true);
	    $alipayNotify = new AlipayNotify($alipay_config);
	    $verify_result = $alipayNotify->verifyReturn();
	    if($verify_result) {//验证成功
	        $body = $_GET['body'];
	        $order_num = $_GET['out_trade_no'];
	        switch ($body) {
	            case "众筹":
	                $log = M('funding_log')->where("verification_code='".$order_num."'")->find();
	                if(!is_array($log)){//如果没有找到这笔订单
	                    $num=str_replace('mix','',$order_num);
	                }else {//找到了这笔订单
	                    $num=$log["verification_code"];
	                }
	                 
	                if(isset($log['status']) && $log['status'] != 1)
	                {
	                    pay_zc_success($num,$_GET['trade_no']);
	                }
	                $this->display();
	            break;
	            case "股权诊断器":
	                $num=str_replace('pc','',$order_num);//去掉PC站支付时拼接的pc字符串
	                pay_zdq_success($num,"zhifubao");
	                //找到这笔订单
	                $id = M('dia_tool')->where('verification_code='.$num)->field('id')->find();
	                //跳转到原来诊断结果上面你去
	                redirect('/index.php?m=WeixinPay&a=EquityOrder&id='.$id['id']);
	            break;
	            case "微课":
	                $num=str_replace('pc','',$order_num);//去掉PC站支付时拼接的pc字符串	
	                M('test')->add(array(
	                    'content'=>'同步回调地址中，订单号为'.$num,
	                    'createtime'=>time()
	                ));
	                //找到这笔订单
	                $o = M('order')->where("verification_code='".$num."'")->find();
	                M('test')->add(array(
	                    'content'=>'同步回调地址中2，订单详情为'.json_encode($o),
	                    'createtime'=>time()
	                ));
			        if($o['status']!=1){   			       
    			        M('order')->where("verification_code='{$num}'")->data(array('status'=>1,'pay_time'=>date('Y-m-d H:i:s',time()),'pay_channel'=>"zhifubao"))->save();//订单表更新支付状态
			        }
	                //跳转到原来诊断结果上面你去
	                redirect('/index.php/Content/DiacrisisTool/pay_wk_success?order_num='.$num);
	                break;
	            default:
        	        //修改订单状态
        	        $o = M('order')->where("verification_code='{$order_num}'")->find();
        	        if($o['status'] != 1 && $_GET['total_fee'] == $o['price']) {//当订单状态为未支付，支付宝的金额和订单金额一致时
        	            pay_success($_GET['out_trade_no'],"zhifubao");
        	        }
        	        $this->display();
	            break;
	        }
	    }else {
	        exit("error");
	    }
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
        $sHtml = $sHtml."<input type='submit'  value='".$button_name."' style='display:none;'></form>";
		
		$sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";
		
		return $sHtml;
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

//支付宝通知处理类

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

