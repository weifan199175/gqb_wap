<?php
namespace Content\Controller;

use Common\Controller\Base;
use Content\Model\ContentModel;
//require_once $_SERVER['DOCUMENT_ROOT']."/shuipf/Common/Controller/MediaController.class.php";

/*****************************************************
   微信帐号关联
    by lxf   
*****************************************************/

class WxbindController extends Base 
{	
   // 微信关联页面
  
  public function account(){
	  
	$json_info = $this->getUserinfo( $_GET['code'] );
	$_SESSION['json_info_wx'] =  $json_info;
	//dump($json_info);exit;
	$this->assign( 'json_info', $json_info );
	$this->display(); 
  }  
    
   // 跳转至微信的用户授权页。
   
   public function wx_index(){
	   
	// 公众号的唯一标识   
	$appid = $this->getAppid();
	
	//授权后重定向的回调链接地址
	$redirect_uri =urlencode('http://' . $_SERVER['HTTP_HOST'] . '/index.php/Wxbind/account');
    $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';  
    
	//echo $url;exit;
	header("Location:".$url);  
	   
   }

    //  获取用户微信openid和access_token信息
	
  protected function getWxinfo($code){
	  
	    $appid = $this->getAppid();  
		$secret = $this->getAppsecret();
		$get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';  
		
		//return $get_token_url;
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $get_token_url );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		$jsoninfo = json_decode($output, true);
	  
	  return $jsoninfo;
   }

    // 获取微信信息
 
  protected function getUserinfo( $code ){
	  
	$json=  $this->getWxinfo( $code );
	//var_dump($json);exit;
	$access_token = $json['access_token'];  
    $openid = $json['openid'];  
    $get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';  
   
    $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $get_user_info_url );
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	curl_close($ch);
	$jsoninfo = json_decode($output, true);
	//var_dump($jsoninfo);exit;
	
	return $jsoninfo;
  } 
}
?>