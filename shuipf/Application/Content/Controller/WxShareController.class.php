<?php
namespace Content\Controller;

use Common\Controller\Base;
use Content\Model\ContentModel;
//require_once $_SERVER['DOCUMENT_ROOT']."/shuipf/Common/Controller/MediaController.class.php";

/*****************************************************
   微信公众号被动回复图片
    by wf   
*****************************************************/

class WxShareController extends Base 
{	

  
  //生成分享关注图片
  public function get_ShareImg($QR,$logo,$filename)
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
  public function uploadfileToWx($filename,$type)
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