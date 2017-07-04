<?php
/**   
 * 支付通知API【供外部服务器访问】
 *
 */
namespace Api\Controller;

use Common\Controller\ShuipFCMS;

require_once $_SERVER['DOCUMENT_ROOT']."/weixin/lib/WxPay.Api.php";
require_once $_SERVER['DOCUMENT_ROOT']."/weixin/lib/WxPay.Notify.php";
require_once $_SERVER['DOCUMENT_ROOT']."/weixin/example/WxPay.NativePay.php";
require_once $_SERVER['DOCUMENT_ROOT']."/weixin/example/log.php";
require_once $_SERVER['DOCUMENT_ROOT']."/weixin/lib/WxPay.Data.php";
require_once $_SERVER['DOCUMENT_ROOT']."/weixin/lib/WxPay.Exception.php";

require_once $_SERVER['DOCUMENT_ROOT']."/alipay/alipay.config.php";
require_once $_SERVER['DOCUMENT_ROOT']."/alipay/lib/alipay_core.function.php";
require_once $_SERVER['DOCUMENT_ROOT']."/alipay/lib/alipay_md5.function.php";

class PayNotifyController extends ShuipFCMS {
    
   
	
    //微信:支付通知入口
    public function webchatpay_notify(){
		 //M('hotel')->where("id=80")->delete();
        //初始化日志
        $logHandler= new \CLogFileHandler($_SERVER['DOCUMENT_ROOT']."/weixin/logs/".date('Y-m-d').'.log');
        $log = \Log::Init($logHandler, 15);

        \Log::DEBUG("begin notify");
		// echo 11111;exit;
		//M('member')->where('id=12')->setField('email','54322@qq.com3333');
		
        $notify = new PayNotifyCallBack();
        $notify->Handle(false);
    }
	
	//支付宝：支付通知入口   异步
	public function ali_notify_url()
	{
				//计算得出通知验证结果
	    $alipay_config = json_decode(ALIPAY_CONFIG, true);
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyNotify();

		if($verify_result) {//验证成功
				$out_trade_no = $_POST['out_trade_no'];

			//支付宝交易号

			$trade_no = $_POST['trade_no'];

			//交易状态
			$trade_status = $_POST['trade_status'];
			switch ($_POST['body']) {
			    case "众筹":
			        $log = M('funding_log')->where("verification_code='".$out_trade_no."'")->find();
			        if(!is_array($log)){//如果没有找到这笔订单
			            $num=str_replace('mix','',$out_trade_no);
			        }else {//找到了这笔订单
			            $num=$log["verification_code"];
			        }
			        
			        if(isset($log['status']) && $log['status'] != 1)
			        {
			            pay_zc_success($num,$_POST['trade_no']);
			        }
			    break; 
			    case "股权诊断器":
			        $o = M('order')->where("verification_code='".$out_trade_no."'")->find();
			        if($o['status']!=1){
    			        $num=str_replace('pc','',$out_trade_no);//去掉PC站支付时拼接的pc字符串
    			        pay_zdq_success($num,"zhifubao");
			        }
			    break;
			    case "微课":
			        $o = M('order')->where("verification_code='".$out_trade_no."'")->find();
			        if($o['status']!=1){
    			        $num=str_replace('pc','',$out_trade_no);//去掉PC站支付时拼接的pc字符串
    			        M('order')->where("verification_code='{$out_trade_no}'")->data(array('status'=>1,'pay_time'=>date('Y-m-d H:i:s',time()),'pay_channel'=>"zhifubao"))->save();//订单表更新支付状态
			        }
			    default:
        			$o = M('order')->where("verification_code='".$out_trade_no."'")->find();
//         		    if($o['status']!=1 && $_POST['total_fee']== $o['price'])   //上线时开启金额验证
        			if($o['status']!=1)	
        			{
        				pay_success($out_trade_no,"zhifubao");
        			}
			    break;
			}
			echo "success";		//请不要修改或删除
		}
		else {
			//验证失败
			echo "fail";

			//调试用，写文本函数记录程序运行情况是否正常
			//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
		}
   }
   
	
		
}


	
//微信支付通知处理类
class PayNotifyCallBack extends \WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new \WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = \WxPayApi::orderQuery($input);
		\Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
	    
		\Log::DEBUG("call back:" . json_encode($data));
		$notfiyOutput = array();		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}
// 		M("test")->add(array("content"=>"微信支付回调地址，post=".json_encode($data),"createtime"=>date("Y-m-d H:i:s",time())));
		switch ($data["attach"]) {
		    case "众筹":
//         		M("test")->add(array("content"=>"走到这了","createtime"=>date("Y-m-d H:i:s",time())));
		        $log = M('funding_log')->where("verification_code='".$data["out_trade_no"]."'")->find();
		        if(!is_array($log)){//如果没有找到这笔订单
		            $num=str_replace('mix','',$data["out_trade_no"]);
		        }else {//找到了这笔订单
		            $num=$log["verification_code"];
		        }
		        
		        if(isset($log['status']) && $log['status'] != 1)
		        {
		            pay_zc_success($num,$data["transaction_id"]);
		        }
		    break;
		    case "股权诊断器":
        		$num=str_replace('pc','',$data["out_trade_no"]);//去掉PC站支付时拼接的pc字符串
        		pay_zdq_success($num,"weixin");
		    break;
		    case "微课":
        		$num=str_replace('pc','',$data["out_trade_no"]);//去掉PC站支付时拼接的pc字符串
        		M('order')->where("verification_code='{$num}'")->data(array('status'=>1,'pay_time'=>date('Y-m-d H:i:s',time()),'pay_channel'=>"weixin"))->save();//订单表更新支付状态
		    break;
	    
		    default:
		        //M('member')->where('id=12')->setField('qq','54322333');
		        $o = M('order')->where("verification_code='".$data["out_trade_no"]."'")->find();
		        
		        if(!is_array($o)){//如果没有找到这笔订单
		            $num=str_replace('mix','',$data["out_trade_no"]);//去掉混合支付时拼接的mix字符串
		            $num=str_replace('pc','',$num);//去掉PC站支付时拼接的pc字符串
		            //$data["out_trade_no"]=str_replace('mix','',$data["out_trade_no"]);
		            //$o=M('order')->where("verification_code='".$data["out_trade_no"]."'")->find();
		            $o=M('order')->where("verification_code='".$num."'")->find();
		        }else {//找到了这笔订单
		            $num=$o["verification_code"];
		        }
		        
		        if(isset($o['status']) && $o['status'] != 1)
		        {
		            pay_success($num,"weixin");
		        }
		        
		    break;
		}
		return true;
		
	
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