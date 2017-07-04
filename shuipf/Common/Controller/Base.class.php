<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 前台Controller
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Common\Controller;

 require_once $_SERVER['DOCUMENT_ROOT']."/weixin/example/WxPay.JsApiPay.php";
 require_once($_SERVER['DOCUMENT_ROOT'] . "/weixin/lib/WxPay.Api.php");
 require_once($_SERVER['DOCUMENT_ROOT'] . "/weixin/example/log.php");

class Base extends ShuipFCMS {

    //初始化
    protected function _initialize() {
        parent::_initialize();
        //静态资源路径
        $this->assign('model_extresdir', self::$Cache['Config']['siteurl'] . MODULE_EXTRESDIR);
		
		if(I('get.source')!='')
		{
		    $_SESSION['source'] = I('get.source');	
		}
		
		
		if($_SESSION['jsapi_ticket']=='' || (time()-$_SESSION['set_time'])>7000){
			//获取access_token
			//获取jsapi_ticket
	        $t = $this->http('https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$this->getAccessToken().'&type=jsapi');
		   
		    $tes = json_decode($t,true);
		    
	        $_SESSION['jsapi_ticket'] = $tes['ticket'];
		    $_SESSION['set_time'] = time();
		}
		
    }

    // 检测是否登陆
	public function check_islogin(){
	    $_SESSION['redirectUrl'] = "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];//获得他要跳转回去的页面
		if($_SESSION['userid']==''){
		    if($this->is_Weixin()){
		        $tools = new \JsApiPay();
		        $openid = $tools->GetOpenid();
		        $u=M('member')->alias('m')->join('jbr_member_class c on m.member_class=c.id')->where("m.openId='".$openid."'")->field('m.*,c.class_name')->find();
		        if(!empty($u)){
		            $_SESSION['userid'] = $u['id'];
		            $_SESSION['member_class'] = $u['member_class'];
		            return true;
		        }else {
        			redirect('/index.php?m=User&a=login');
		        }
		    }else {
    			redirect('/index.php?m=User&a=login');
		    }
			
			 // $this->error('对不起，您还没有登陆，请先登陆，谢谢',U('User/login'));
			// exit;
		}else {
		    return true;
		}
	}

    /**
     * 模板显示 调用内置的模板引擎显示方法，
     * @access protected
     * @param string $templateFile 指定要调用的模板文件
     * 默认为空 由系统自动定位模板文件
     * @param string $charset 输出编码
     * @param string $contentType 输出类型
     * @param string $content 输出内容
     * @param string $prefix 模板缓存前缀
     * @return void
     */
    protected function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '') {
        $this->view->display(parseTemplateFile($templateFile), $charset, $contentType, $content, $prefix);
    }
	
	
	 /**
     * 分页输出
     * @param type $total 信息总数
     * @param type $size 每页数量
     * @param type $number 当前分页号（页码）
     * @param type $config 配置，会覆盖默认设置
     * @return type
     */
    protected function page($total, $size = 20, $number = 0, $config = array()) {
        $Page = parent::page($total, $size, $number, $config);
        //$Page->SetPager('default', '<span class="all">共有{recordcount}条信息</span>{first}{prev}{liststart}{list}{listend}{next}{last}');
		$Page->SetPager('default', '<span class="all">共有{recordcount}条信息</span><span class="pageindex">{pageindex}/<font id="total_page">{pagecount}</font></span>{first}{prev}{liststart}{list}{listend}{next}{last}');
		//'<span class="all">共有{recordcount}条信息</span><span class="pageindex">{pageindex}/<font id="total_page">{pagecount}</font></span>{first}{prev}{liststart}{list}{listend}{next}{last}',
       	return $Page;
    }
	
	/********************************
		$show  分页控件
		$param 参数数组
		$res   返回改变后的分页控件
	********************************/
	function page_add_param($show, $param)
	{
		$str = "";
		foreach($param as $k => $v)
		{   
            if(is_array($v)){
			$str .= "&" . $k . "=" . str_replace("%",'',$v[1]);
			}else{		
			$str .= "&" . $k . "=" . $v;
			}
		}
		$res = preg_replace("/href=(\'|\")(.*)(\'|\")/U", "href=\${1}\${2}" . $str . "\${3}", $show);
		return $res;
	}    
	
	//短信发送
	function send_sms($content,$mobile)
	{
		$clapi  = new SmsApi();
		$result = $clapi->sendSMS($mobile, $content,'true');
		$result = $clapi->execResult($result);
		return $result;
		
	}
	//正式配置

	
	
	//获取appid
	protected function getAppid()
	{
	    return getWxAppid();
	}
	
	//获取appsecret
	protected function getAppsecret()
	{
	    return getWxAppSecret();
	}

    protected function load($url)
	{
		$ch = curl_init($url); 
		
		curl_setopt($ch, CURLOPT_HEADER, 0); 
		curl_setopt($ch, CURLOPT_NOBODY, 0); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$packge = curl_exec($ch);
		$httpinfo = curl_getinfo($ch);
		curl_close($ch);
		
		$msg = array_merge(array('header' => $httpinfo), array('body' => $packge));
		return $msg;
	}	
	
	//获取该access_token
	protected function getAccessToken()
	{
	    return getWxAccessToken();
	}
	
	//微信 发送
	
	protected  function wx_request( $url ){
		
		$ch = curl_init();  
		curl_setopt($ch,CURLOPT_URL,$url);  
		curl_setopt($ch,CURLOPT_HEADER,0);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );  
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);  
		$res = curl_exec($ch);  
		curl_close($ch);  
		$json_obj = json_decode($res,true); 
	 
     return $json_obj; 
	}

	 //https请求
    public function http($url, $data = null)
    {

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		if (!empty($data)){
		  curl_setopt($curl, CURLOPT_POST, 1);
		  curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);
		return $output;
		//json_decode($output, true);
   }
   
   /**
    * 判断当前环境是不是微信
    */
   public function is_Weixin() {
       if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) { 
           return true; 
       }
       return false;
   }
   
   /**
    * 微信自动登录（在微信浏览器中，自动登录）
    */
   public function wx_auto_login(){
       if($_SESSION['userid']=='' && $this->is_Weixin()){//在没有登录的情况下并且是微信，则自动登录
           $tools = new \JsApiPay();
           $openid = $tools->GetOpenid();         
           $u=M('member')->alias('m')->join('jbr_member_class c on m.member_class=c.id')->where("m.openId='".$openid."'")->field('m.*,c.class_name')->find();
           if(!empty($u)){
               $_SESSION['userid'] = $u['id'];
               $_SESSION['member_class'] = $u['member_class'];
           }
       }
   }
   
   //获取当前登录者的openid
   public function get_openid()
   {
       if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
         $tools = new \JsApiPay();
         $openid = $tools->GetOpenid();
         return $openid;
       }
       return false;
   }
}


