<?php

// +----------------------------------------------------------------------
// | // | 微信共用代码
// +----------------------------------------------------------------------

/**
 * 获取微信appid
 */
function getWxAppid(){
    return \WxPayConfig::APPID;
}

/**
 * 获得微信appsecret
 * @return string
 */
function getWxAppSecret(){
    return \WxPayConfig::APPSECRET;
}

/**
 * 获得微信access_token
 */
function getWxAccessToken($refresh=false){
    $access_token = S("access_token");//首先查缓存
    if(!empty($access_token) && $access_token != false && $refresh == false){
        return $access_token;//查到了就返回
    }
    //没查到就去请求
    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".getWxAppid()."&secret=".getWxAppSecret();
    $output = phpGet($url);
    $jsoninfo = json_decode($output, true);
    $access_token = $jsoninfo["access_token"];
    if(!empty($access_token)){//请求拿到了就设置缓存
        S('access_token',$access_token,500);
    }
    return $access_token;
}

/**
 * 微信回复文本消息
 * @param $content 文本消息的内容
 * @param $openid 发送给用户的openid
 * @param $gAccount 公众号的gaccount
 */
function echoWxTextMsg($content,$openid,$gAccount){
	$data = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                </xml>";
	$return = sprintf($data,$openid,$gAccount,time(),$content);
	echo  $return;exit();
}

/**
 * 微信回复图片消息
 * @param $media_id 素材ID
 * @param $openid 发送给用户的openid
 * @param $gAccount 公众号的gaccount
 */
function echoWxImgMsg($media_id,$openid,$gAccount){
	$data = "<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[image]]></MsgType>
				<Image>
				<MediaId><![CDATA[%s]]></MediaId>
				</Image>
				</xml>";
	$return = sprintf($data,$openid,$gAccount,time(),$media_id);
	echo  $return;exit();
}

/**
 * 微信回复图文消息
 * @param $items 图文数组
 * @param $openid 发送给用户的openid
 * @param $gAccount 公众号的gaccount
 */
function echoWxNewsMsg($items,$openid,$gAccount){
	$data1 = "<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[news]]></MsgType>
				<ArticleCount>%s</ArticleCount>
				<Articles>";
	$data1 = sprintf($data1,$openid,$gAccount,time(),count($items));
	
	$data2 = "";
	
	foreach ($items as $i){
		$model = "<item>
				<Title><![CDATA[%s]]></Title> 
				<Description><![CDATA[%s]]></Description>
				<PicUrl><![CDATA[%s]]></PicUrl>
				<Url><![CDATA[%s]]></Url>
				</item>";
	$data2 .= sprintf($model,$i['title'],$i['desc'],$i['picurl'],$i['url']);
	}
	
	$data3 = "</Articles></xml> ";
	
	echo $data1.$data2.$data3;exit();
}

/**
 * 发送购买成功的模板消息
 * @param $openid 接受者的openid
 * @param $goodsInfo 商品信息
 * @param $remark 备注信息
 * @param $url 跳转的URL
 */
function sendTplPaySuccess($openid,$goodsInfo,$remark,$url=""){
    
    $msg = '';
    $template = '{
			   "name": {
			       "value":"%s",
			       "color":"#173177"
			   },
			   "remark":{
			       "value":"%s",
			       "color":""
			   }
			}';
    
    if(ENV == "product"){
        $templateId = '6VQEcl1pimpm-ZIg729l_CzI__91ZI4W_0t6VuD6b0s';
    }else {
        $templateId = 'xmF8Wj1j2Pxe6wIx5OZnl4-jLQX6uFu9inMscV6UlaQ';
    }
    
    $data = sprintf($template, $goodsInfo, $remark);//模板消息
    
    
    if($url){
        $_pushTpl_url = '{"touser": "%s","template_id": "%s","url":"%s","data": %s}';
        $msg = sprintf($_pushTpl_url,$openid,$templateId,$url,$data);
    }else {
        $_pushTpl = '{"touser": "%s","template_id": "%s","data": %s}';
        $msg = sprintf($_pushTpl,$openid,$templateId,$data);
    }
    
    $templateUrl = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.getWxAccessToken();
    $result = phpPost($templateUrl, $msg);
    return $result;
}

/**
 * 发送退款的模板消息
 * @param $openid 接受者的openid
 * @param $first 第一排文字
 * @param $reason 退款原因
 * @param $refund 退款金额
 * @param $remark 备注
 * @param $url 跳转地址（可为空）
 */
function sendTplPayBack($openid,$first,$reason,$refund,$remark,$url=""){
    $template = '{
			   "first": {
			       "value":"%s",
			       "color":""
			   },
			   "reason":{
			       "value":"%s",
			       "color":""
			   },
			   "refund": {
			       "value":"%s",
			       "color":""
			   },
			   "remark":{
			       "value":"%s",
			       "color":""
			   }
			}';
    if(ENV == "product"){
        $templateId = 'XcQDo5QtZ2basBM14hWQYmM9hOpUhVj1rXzSNJZjARc';
    }else {
        $templateId = 'IIQyflAUwtiv2KwHGKmg-omR7ZxIcrpTmfLvjs_x05E';
    }
    $data = sprintf($template, $first, $reason, $refund, $remark);//模板消息
    
    
    if($url){
        $_pushTpl_url = '{"touser": "%s","template_id": "%s","url":"%s","data": %s}';
        $msg = sprintf($_pushTpl_url,$openid,$templateId,$url,$data);
    }else {
        $_pushTpl = '{"touser": "%s","template_id": "%s","data": %s}';
        $msg = sprintf($_pushTpl,$openid,$templateId,$data);
    }
    
    $templateUrl = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.getWxAccessToken();
    $result = phpPost($templateUrl, $msg);
    return $result;
}

/**
 * 发送发展下线的模板消息
 * @param $openid 接受者的openid
 * @param $first 第一排文字
 * @param $name 姓名
 * @param $time 时间
 * @param $remark 备注
 * @param $url 跳转地址（可为空）
 */
function sendTplInviteFriend($openid,$first,$name,$time,$remark,$url=""){
    $template = '{
			   "first": {
			       "value":"%s",
			       "color":""
			   },
			   "keyword1":{
			       "value":"%s",
			       "color":""
			   },
			   "keyword2": {
			       "value":"%s",
			       "color":""
			   },
			   "remark":{
			       "value":"%s",
			       "color":""
			   }
			}';
    if(ENV == "product"){
        $templateId = 'D-_AtEXx7Phgl-MtTsGFY6vWjgI1-UctvheViVifmAo';
    }else {
        $templateId = 'm3jSf5FUuSe4BzgT7NeR5jNaRMHxtf035uwpe368_0E';
    }
    $data = sprintf($template, $first, $name, $time, $remark);//模板消息
    
    
    if($url){
        $_pushTpl_url = '{"touser": "%s","template_id": "%s","url":"%s","data": %s}';
        $msg = sprintf($_pushTpl_url,$openid,$templateId,$url,$data);
    }else {
        $_pushTpl = '{"touser": "%s","template_id": "%s","data": %s}';
        $msg = sprintf($_pushTpl,$openid,$templateId,$data);
    }
    
    $templateUrl = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.getWxAccessToken();
    $result = phpPost($templateUrl, $msg);
    return $result;
}

/**
 * 发送众筹收到支持通知
 * @param $openid 接受者的openid
 * @param $first 第一排文字
 * @param $title 项目标题
 * @param $name 支持者
 * @param $money 支持金额
 * @param $time 时间
 * @param $remark 备注
 * @param $url 跳转地址（可为空）
 */
function sendTplFundingPartner($openid,$first,$title,$name,$money,$time,$remark,$url=""){
    $template = '{
			   "first": {
			       "value":"%s",
			       "color":""
			   },
			   "keyword1":{
			       "value":"%s",
			       "color":""
			   },
			   "keyword2": {
			       "value":"%s",
			       "color":""
			   },
			   "keyword3": {
			       "value":"%s",
			       "color":""
			   },
			   "keyword4": {
			       "value":"%s",
			       "color":""
			   },
			   "remark":{
			       "value":"%s",
			       "color":""
			   }
			}';
    if(ENV == "product"){
        $templateId = 'TsKD2NmX29xSPF41m3jvIenUDpUVuPnWiean-xhvHzo';
    }else {
        $templateId = 'a3LvQIZuS0zRpo4NT4fmJip904L36VeXl22rE05KZPU';
    }
    $data = sprintf($template, $first,$title,$name,$money,$time,$remark);//模板消息
    
    
    if($url){
        $_pushTpl_url = '{"touser": "%s","template_id": "%s","url":"%s","data": %s}';
        $msg = sprintf($_pushTpl_url,$openid,$templateId,$url,$data);
    }else {
        $_pushTpl = '{"touser": "%s","template_id": "%s","data": %s}';
        $msg = sprintf($_pushTpl,$openid,$templateId,$data);
    }
    
    $templateUrl = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.getWxAccessToken();
    $result = phpPost($templateUrl, $msg);
    return $result;
}

/**
 * 发送SEM用户新消息给小明（提醒）
 * @param $name 姓名
 * @param $time 时间
 * @param $mobile 手机号
 * @param $company 公司名
 * @param $job 职位
 * @param $source 渠道
 */
function sendTplSemToXiaoMing($name,$time,$mobile,$company,$job,$source){
    $first = "SEM有新的成员信息";
    $template = '{
			   "first": {
			       "value":"%s",
			       "color":""
			   },
			   "keyword1":{
			       "value":"%s",
			       "color":""
			   },
			   "keyword2": {
			       "value":"%s",
			       "color":""
			   },
			   "remark":{
			       "value":"%s",
			       "color":""
			   }
			}';
    if(ENV == "product"){
        $templateId = 'D-_AtEXx7Phgl-MtTsGFY6vWjgI1-UctvheViVifmAo';
        $openid="oBZpmxHwS0A7OFGKSltKP9jhuhjI";
    }else {
        $templateId = 'm3jSf5FUuSe4BzgT7NeR5jNaRMHxtf035uwpe368_0E';
        $openid="oaf2kwZ1QrripCXHO7-tGeUxknzA";
    }
    
    $remark = "电话：".$mobile."\\n公司名：".$company."\\n职位：".$job."\\n渠道：".$source;
    $data = sprintf($template, $first, $name, $time, $remark);//模板消息
    $_pushTpl = '{"touser": "%s","template_id": "%s","data": %s}';
    $msg = sprintf($_pushTpl,$openid,$templateId,$data);
    $templateUrl = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.getWxAccessToken();
    $result = phpPost($templateUrl, $msg);
    return $result;
}
