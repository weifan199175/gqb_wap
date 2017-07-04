<?php
namespace Content\Controller;

use Common\Controller\Base;

require_once $_SERVER['DOCUMENT_ROOT']."/weixin/lib/WxPay.Config.php";


/*****************************************************
   微信事件推送接受地址
*****************************************************/

class WxController extends Base {
  
	/**
	 * 接受微信推送过来的事件
	 */
    public function index() {
    	$timestamp = $_GET['timestamp'];//获得微信传递过来的时间戳
    	$nonce = $_GET['nonce'];//获得随机参数
    	$token = "guquanbang_token";//token是我们在微信后台配置的
    	$signature = $_GET['signature'];//签名
    	$echostr = $_GET['echostr'];
    	$array = array($timestamp,$nonce,$token);
    	sort($array);//按照字典序排序
    	$string = implode('', $array);//拼接成字符串
    	$string = sha1($string);//加密
    	if($signature == $string && $echostr){//如果加密后和微信传过来的签名一致，说明请求验证成功
    		echo $echostr;//把验证成功的字符串返回输出给微信
    		exit();
    	}
    	
    	$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];//获得微信发送过来的XML
    	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);//将XML转换成对象
    	$jsonmsg = json_encode($postObj,JSON_UNESCAPED_UNICODE);//将对象转成JSON数组
    	$wxmsg = json_decode($jsonmsg,true);
    	
     	//保存到文件里
// 		$filename="wx_event_log.txt";
// 		$handle=fopen($filename,"a+");
// 		$str=fwrite($handle,$jsonmsg."\n");
// 		fclose($handle);

    	if(isset($wxmsg['MsgType']) && $wxmsg['MsgType'] == "event"){//事件
    	    $data['openid'] = $wxmsg['FromUserName'];
    	    $data['event'] = $wxmsg['Event'];
    	    $data['eventKey'] = isset($wxmsg['EventKey'])?$wxmsg['EventKey']:null;
    	    $data['ticket'] = isset($wxmsg['Ticket'])?$wxmsg['Ticket']:null;
    	    $data['latitude'] = isset($wxmsg['Latitude'])?$wxmsg['Latitude']:null;
    	    $data['longitude'] = isset($wxmsg['Longitude'])?$wxmsg['Longitude']:null;
    	    $data['precision'] = isset($wxmsg['Precision'])?$wxmsg['Precision']:null;
    	    $data['gaccount'] = $wxmsg['ToUserName'];
    	    $data['createtime'] = $wxmsg['CreateTime'];
    	    $data['datetime'] = date("Y-m-d H:i:s");
    	    M("wxeventlog")->add($data);
    	}else {//消息
    	    $data['openid'] = $wxmsg['FromUserName'];
    	    $data['msgtype'] = $wxmsg['MsgType'];
    	    $data['content'] = $wxmsg['Content'];
    	    $data['content'] = isset($wxmsg['Content'])?$wxmsg['Content']:null;
    	    $data['picUrl'] = isset($wxmsg['PicUrl'])?$wxmsg['PicUrl']:null;
    	    $data['mediaId'] = isset($wxmsg['MediaId'])?$wxmsg['MediaId']:null;
    	    $data['format'] = isset($wxmsg['Format'])?$wxmsg['Format']:null;
    	    $data['thumbMediaId'] = isset($wxmsg['ThumbMediaId'])?$wxmsg['ThumbMediaId']:null;
    	    $data['location_X'] = isset($wxmsg['Location_X'])?$wxmsg['Location_X']:null;
    	    $data['location_Y'] = isset($wxmsg['Location_Y'])?$wxmsg['Location_Y']:null;
    	    $data['scale'] = isset($wxmsg['Scale'])?$wxmsg['Scale']:null;
    	    $data['label'] = isset($wxmsg['Label'])?$wxmsg['Label']:null;
    	    $data['title'] = isset($wxmsg['Title'])?$wxmsg['Title']:null;
    	    $data['description'] = isset($wxmsg['Description'])?$wxmsg['Description']:null;
    	    $data['url'] = isset($wxmsg['Url'])?$wxmsg['Url']:null;
    	    $data['msgid'] = $wxmsg['MsgId'];
    	    $data['gaccount'] = $wxmsg['ToUserName'];
    	    $data['createtime'] = $wxmsg['CreateTime'];
    	    $data['datetime'] = date("Y-m-d H:i:s");
    	    M("wxmsglog")->add($data);
    	}
    	
    	
    	switch ($wxmsg['MsgType']) {
    		case "event"://事件
				switch ($wxmsg['Event']) {
					case "subscribe"://关注
						if(isset($wxmsg['EventKey']) && isset($wxmsg['Ticket'])){//未关注用户扫二维码关注
// 							M("test")->add(array("content"=>"未关注用户扫二维码关注","createtime"=>date("Y-m-d H:i:s",time())));
							$EventKey = explode("_",$wxmsg['EventKey']);
							if(isset($EventKey[1])){//如果存在推荐人并且是推荐人ID
								$score_record = M("score_record")->where("share_type_id=8 AND openid='{$wxmsg['FromUserName']}'")->count();//关注者曾经有没有给过别人积分奖励
								if($score_record == 0){//没有给过说明可以+积分（防止刷积分）
									$rule = M("score_rules")->where("id=8")->find();//找到积分规则
									
									$param = array('member_id'=>$EventKey[1],
										'score'=>$rule['get_score'],
										'score_type'=>$rule['name'],
										'source'=>$rule['name'],
										'share_type_id'=>$rule['id'],
										'addtime'=>date('Y-m-d H:i:s',time()),
										'openid'=>$wxmsg['FromUserName'],
									);
									if(add_score_record($param)){//添加积分记录
										//增加会员积分
										M('member')->where('id='.$EventKey[1])->setInc('score',$rule['get_score']);//可用积分
										M('member')->where('id='.$EventKey[1])->setInc('total_score',$rule['get_score']);//累计积分
									}
								}
								
								$num = M("follow_relation")->where("openid='{$wxmsg['FromUserName']}'")->count();
								$data = array(
										"openid"=>$wxmsg['FromUserName'],
										"member_id"=>$EventKey[1],
										"updatetime"=>date("Y-m-d H:i:s",time()),
								);
								if($num>0){//更新
									M("follow_relation")->where("openid='{$wxmsg['FromUserName']}'")->data($data)->save();
								}else {//新增
									$data['createtime']=date("Y-m-d H:i:s",time());
									M("follow_relation")->add($data);//新增
								}
							}
							$msg="终于等到你，还好我没放弃！\n欢迎关注“股权帮”，在分享股权智慧，创造股权增值的路上，我们与你同行！\n<a href='http://".$_SERVER['HTTP_HOST']."/index.php?m=User&a=reg'>点击此处进行股权帮注册后</a>，\n就可以分享和购买课程了\n回复关键字1，获取股权帮介绍\n回复关键字2，获取往期微课\n回复关键字3，报名参加《股权博弈》最新课程";
							echoWxTextMsg($msg, $wxmsg['FromUserName'],  \WxPayConfig::GACCOUNT);
						}else {//普通的关注事件
							$msg="终于等到你，还好我没放弃！\n欢迎关注“股权帮”，在分享股权智慧，创造股权增值的路上，我们与你同行！\n<a href='http://".$_SERVER['HTTP_HOST']."/index.php?m=User&a=reg'>点击此处进行股权帮注册后</a>，\n就可以分享和购买课程了\n回复关键字1，获取股权帮介绍\n回复关键字2，获取往期微课\n回复关键字3，报名参加《股权博弈》最新课程";
							echoWxTextMsg($msg, $wxmsg['FromUserName'], \WxPayConfig::GACCOUNT);
						}
					break;
					case "SCAN"://已关注用户扫二维码
						$msg="欢迎您回来~";
						echoWxTextMsg($msg, $wxmsg['FromUserName'], \WxPayConfig::GACCOUNT);
					break;
					case "unsubscribe"://取消关注
						//$msg="您刚刚取消了关注，下次再见~";
						//echoWxTextMsg($msg, $wxmsg['FromUserName'], \WxPayConfig::GACCOUNT);
					break;
					case "LOCATION":
						//$msg="您刚刚发送了一个地理位置消息";
						//echoWxTextMsg($msg, $wxmsg['FromUserName'], \WxPayConfig::GACCOUNT);
					break;
					case "CLICK":
						if($wxmsg['EventKey'] == "share_pic"){//点击分享
							$user = M("member")->where("openid='{$wxmsg['FromUserName']}'")->find();
							if(!empty($user)){
								$media_id = $this->Create_img($user['id']);
								if(!empty($media_id)){
									echoWxImgMsg($media_id, $wxmsg['FromUserName'], \WxPayConfig::GACCOUNT);
								}else {
									$msg = "分享二维码生成失败，请联系<a href='tel:4000279828'>客服人员</a>解决！";
									echoWxTextMsg($msg, $wxmsg['FromUserName'], \WxPayConfig::GACCOUNT);
								}
							}else {
								$msg="<a href='http://".$_SERVER['HTTP_HOST']."/index.php?m=User&a=reg'>点击此处进行股权帮注册后</a>，\n就可以分享和购买课程了，还有更多积分优惠在等你哦~";
								echoWxTextMsg($msg, $wxmsg['FromUserName'], \WxPayConfig::GACCOUNT);
							}
						}else {
							//$msg="您刚刚点击一个自定义菜单,EventKey=".$wxmsg['EventKey'];
							//echoWxTextMsg($msg, $wxmsg['FromUserName'], \WxPayConfig::GACCOUNT);
						}
					break;
					case "VIEW":
						//$msg="您刚刚通过自定义菜单跳转到别的地方去了";
						//echoWxTextMsg($msg, $wxmsg['FromUserName'], \WxPayConfig::GACCOUNT);
					break;
					default:
					break;
				}
    		break;
    		case "text"://用户向公众号发送文本消息
    			switch ($wxmsg['Content']) {
    				case "1":
    					if(ENV == "product"){
	    					$res = $this->getForeverMedia("WUy0eI-2Jhct_Fm-DzgEBoKDCH1aVFpZ_QbOkVxCkHc", "news");
    					}else {
	    					$res = $this->getForeverMedia("3KVr_7Mqa7XWiQBBrIW0yG77XLEKl96LdlqtnJHg0r8", "news");
    					}
    					$items = array();
    					foreach ($res['news_item'] as $k=>$t){
    						$items[$k]['title']=$t['title'];
    						$items[$k]['desc']=isset($t['digest'])?$t['digest']:"";
    						$items[$k]['picurl']=$t['thumb_url'];
    						$items[$k]['url']=$t['url'];
    					}
    					echoWxNewsMsg($items, $wxmsg['FromUserName'], \WxPayConfig::GACCOUNT);
    				break;
    				case "2":
    					if(ENV == "product"){
	    					$res = $this->getForeverMedia("u-yIG6t2N9-FcYpnPt365321jvfAgXXb3QZabDqJXzo", "news");
    					}else {
	    					$res = $this->getForeverMedia("3KVr_7Mqa7XWiQBBrIW0yM15wVXiUMWeOt44O7v5EYs", "news");
    					}
    					$items = array();
    					foreach ($res['news_item'] as $k=>$t){
    						$items[$k]['title']=$t['title'];
    						$items[$k]['desc']=isset($t['digest'])?$t['digest']:"";
    						$items[$k]['picurl']=$t['thumb_url'];
    						$items[$k]['url']=$t['url'];
    					}
    					echoWxNewsMsg($items, $wxmsg['FromUserName'], \WxPayConfig::GACCOUNT);
    				break;
    				case "3":
    					$msg = "报名链接：\nhttp://{$_SERVER['HTTP_HOST']}/index.php?a=shows&catid=13&id=0\n报名电话：<a href='tel:4000279828'>400-027-9828</a>\n李老师：18610127110";
		    			echoWxTextMsg($msg, $wxmsg['FromUserName'], \WxPayConfig::GACCOUNT);
    				break;
    				default:
    				break;
    			}
    			//$msg="您刚刚发送了一条文本消息，消息的内容是".$wxmsg['Content'];
    			//echoWxTextMsg($msg, $wxmsg['FromUserName'], \WxPayConfig::GACCOUNT);
    		break;
    		case "image"://图片消息
    			//$msg="您刚刚发送了一条图片消息";
    			//echoWxTextMsg($msg, $wxmsg['FromUserName'], \WxPayConfig::GACCOUNT);
    		break;
    		case "voice"://语音消息
    			//$msg="您刚刚发送了一条语音消息";
    			//echoWxTextMsg($msg, $wxmsg['FromUserName'], \WxPayConfig::GACCOUNT);
    		break;
    		case "video"://视频消息
    			//$msg="您刚刚发送了一条视频消息";
    			//echoWxTextMsg($msg, $wxmsg['FromUserName'], \WxPayConfig::GACCOUNT);
    		break;
    		case "shortvideo"://小视频消息
    			//$msg="您刚刚发送了一条小视频消息";
    			//echoWxTextMsg($msg, $wxmsg['FromUserName'], \WxPayConfig::GACCOUNT);
    		break;
    		case "location"://地理位置消息
    			//$msg="您刚刚发送了一条地理位置消息";
    			//echoWxTextMsg($msg, $wxmsg['FromUserName'], \WxPayConfig::GACCOUNT);
    		break;
    		case "link"://链接消息
    			//$msg="您刚刚发送了一条链接消息";
    			//echoWxTextMsg($msg, $wxmsg['FromUserName'], \WxPayConfig::GACCOUNT);
    		break;
    		default://默认
    		break;
    	}
	}
	
	//生成微信公众号关注图片
	protected function Create_img($referee_id)
	{
		$access_token = getWxAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token={$access_token}";
		$config = array(
				"expire_seconds"=>2592000,//该二维码有效时间，以秒为单位。 最大不超过2592000（即30天），此字段如果不填，则默认有效期为30秒。
				"action_name"=>"QR_SCENE",//二维码类型，QR_SCENE为临时,QR_LIMIT_SCENE为永久,QR_LIMIT_STR_SCENE为永久的字符串参数值
				"action_info"=>array(//二维码详细信息
						"scene"=>array(
								"scene_id"=>$referee_id,//场景值ID，临时二维码时为32位非0整型，永久二维码时最大值为100000（目前参数只支持1--100000）
						),
				),
		);
		$config = json_encode($config);
		$rs = $this->http($url,$config);
		$rs = json_decode($rs,true);
		
		/** 如果没有生成成功，就获取真实的token再生成一次 */
		if(!isset($rs['ticket'])){
		    $access_token = getWxAccessToken(true);
		    $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token={$access_token}";
		    $config = array(
		        "expire_seconds"=>2592000,//该二维码有效时间，以秒为单位。 最大不超过2592000（即30天），此字段如果不填，则默认有效期为30秒。
		        "action_name"=>"QR_SCENE",//二维码类型，QR_SCENE为临时,QR_LIMIT_SCENE为永久,QR_LIMIT_STR_SCENE为永久的字符串参数值
		        "action_info"=>array(//二维码详细信息
		            "scene"=>array(
		                "scene_id"=>$referee_id,//场景值ID，临时二维码时为32位非0整型，永久二维码时最大值为100000（目前参数只支持1--100000）
		            ),
		        ),
		    );
		    $config = json_encode($config);
		    $rs = $this->http($url,$config);
		    $rs = json_decode($rs,true);
		}
		
		$ticket = urlencode($rs['ticket']);
		$filename = md5(time().$ticket).'.png';
		$qrcode_url ="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket={$ticket}";
		$logo= 'http://'.$_SERVER['HTTP_HOST'].'/statics/WxShare/staticImg/muban.jpg';
		$rs = $this->get_ShareImg($logo,$qrcode_url,$filename);
		if($rs)
		{
			//生成了临时图片，将图片上传到微信的临时素材接口
			$data = $this->uploadfileToWx($filename,'image');
			//临时图片上传无论成功，删除本地临时图片
			@unlink($_SERVER['DOCUMENT_ROOT'].'/statics/WxShare/CacheImg/'.$filename);
			$data = json_decode($data,true);
			if($data['media_id'])
			{
				//返回图片id
				return $data['media_id'];
			}else
			{
				return false;
			}
		}else{
			return false;
		}
	}
	
	//生成分享关注图片
	protected function get_ShareImg($QR,$logo,$filename)
	{
		if ($logo !== FALSE) {
			$QR = imagecreatefromstring(file_get_contents($QR));
			$logo = imagecreatefromstring(file_get_contents($logo));
			$QR_width = imagesx($QR);//二维码图片宽度 300 300
			$QR_height = imagesy($QR);//二维码图片高度 250 920
			$logo_width = imagesx($logo);//logo图片宽度
			$logo_height = imagesy($logo);//logo图片高度
			$logo_qr_width = $QR_width /5;
			$scale = $logo_width/$logo_qr_width;
			$logo_qr_height = $logo_height/$scale;
			$from_width = ($QR_width - $logo_qr_width) / 2;
			//重新组合图片并调整大小
			imagecopyresampled($QR,$logo, 250, 920, 0, 0, 300,
					300, $logo_width,$logo_height);
		}
		//输出图片
		$rs = imagepng($QR,"./statics/WxShare/CacheImg/".$filename);
		imagedestroy($QR);
		imagedestroy($logo);
		return $rs;
	}
	
	//微信临时素材上传
	protected function uploadfileToWx($filename,$type)
	{
		$filepath = $_SERVER['DOCUMENT_ROOT'].'/statics/WxShare/CacheImg/'.$filename;
		$url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$this->getAccessToken()}&type={$type}";
		if (class_exists('\CURLFile')) {
			$data = array("media" => new \CURLFile(realpath($filepath)));
		} else {
			$data = array("media" => '@'.realpath($filepath));
		}
		$result = $this ->http($url,$data);
		return $result;
	}
	
    /**
     * 获取永久素材
     * @param $media_id 素材ID
     * @param $type 素材类型，news图文，图片（image）、语音（voice）、视频（video）和缩略图（thumb） 
     */
    protected function getForeverMedia($media_id,$type){
    	switch ($type) {
    		case "news":
    			$url = "https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=".$this->getAccessToken();
    			$data = array("media_id"=>$media_id);
    			$res = $this->http($url,json_encode($data));
    			$result = json_decode($res,true);
    		break;
    		case "image":
    		break;
    		case "voice":
    		break;
    		case "video":
    		break;
    		case "thumb":
    		break;
    		default:
    		break;
    	}
	return $result;
}
	
	public function getToken()
	{
		if(ENV == "dev" || ENV == "test"){
		   $access_token = $this ->getAccessToken();
		   echo $access_token;
		}
	}
	
	
}
?>