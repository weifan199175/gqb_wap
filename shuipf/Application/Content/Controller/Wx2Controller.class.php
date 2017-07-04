<?php
namespace Content\Controller;

use Common\Controller\Base;
use Content\Model\ContentModel;

/*****************************************************
   微信事件推送接受地址
*****************************************************/

class Wx2Controller extends Base {
    //ceshi
    public function test()
    {
        $result = $this->Create_img('4601');
        dump($result);
    }
  
    //生成微信公众号关注图片
    protected function Create_img($referee_id)
    {
        $access_token = $this->getAccessToken();
        if(empty($access_token))
        {
            M('errorlog')->add(array(
                'position'=>'Wx/Create_img',
                'info'=>'access_token为空',
                'datetime'=>date(time,'Y-m-d H:i:s'),
            ));
            return false;
        }
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
        if(empty($rs))
        {
            M('errorlog')->add(array(
                'position'=>'Wx/Create_img',
                'info'=>'请求ticket失败',
                'datetime'=>date(time,'Y-m-d H:i:s'),
            ));
            return false;
        }
        $ticket = urlencode($rs['ticket']);
        $filename = md5(time().$ticket).'.png';
        $qrcode_url ="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket={$ticket}";
        $logo= 'http://'.$_SERVER['HTTP_HOST'].'/statics/WxShare/staticImg/muban.png';
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
                M('errorlog')->add(array(
                    'position'=>'Wx/Create_img',
                    'info'=>'获取media_id失败',
                    'datetime'=>date(time,'Y-m-d H:i:s'),
                ));
                return false;
            }
        }else
        {
            M('errorlog')->add(array(
                'position'=>'Wx/Create_img',
                'info'=>'合成图片失败',
                'datetime'=>date(time,'Y-m-d H:i:s'),
            ));
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
	
	
}
?>