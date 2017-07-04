<?php
namespace Content\Controller;

use Common\Controller\Base;
use Content\Model\ContentModel;


class FundingController extends Base {
	
	public function _initialize(){
	parent::_initialize ();			
		$this->funding=M("funding");
		$this->funding_log=M("funding_log");
		$this->memberclass=M("memberClass");
	}
	
   /*
    * 众筹分享页面
    * @param $funding_id string 众筹活动表ID
    * @param $fundinfo unknow type 众筹活动的详细信息
    * */
   public function share()
   {
       // 检测是否登陆
       $this->check_islogin();
       
       //获取众筹分享页面的数据
       $funding_id  = I('get.id');
//        if(ENV=='dev')
//        {
//            $funding_id=1;
//        }
       $data = array();
       if($funding_id)
       {
         //获取众筹的信息
         $data['fundinfo'] = $this->funding->where("id='$funding_id'")->find(); 
         if(!$data['fundinfo']['id'])
         {
             //数据库中找不到该条众筹信息
             showErrorInfo("该众筹活动已经失效！");exit;
         }
       }else
       {
           //没有接受到众筹活动ID
           showErrorInfo("无效的众筹活动！");exit;
       }
       if($data['fundinfo']['member_id'] == $_SESSION['userid']){
         //获取众筹的人的信息
         $data['userinfo'] = M('member')->field('truename,userimg')->where(array(
             'id'=>array('eq',$data['fundinfo']['member_id']),
         ))->find();
         //获取众筹课程信息
         $data['courseinfo']=M('courses')->where(array(
             'id'=>array('eq',$data['fundinfo']['product_id'])
         ))->find(); 
         //获取众筹已开启时间
         $data['start_time'] = getTime($data['fundinfo']['create_time']);
         //获取众筹支持人数
         $rec = M('funding_log')->where(array(
             'fid'=>array('eq',$funding_id),
             'status'=>array('eq','1')
         ))->group('member_id')->field('member_id')->select();
         $data['count'] = count($rec);
         if(empty($data['count']))
         {
             $data['count'] = '0';
         }
         //获取众筹人的回复和评论
         $data['replay'] = M('funding_log')->alias(a)->join('jbr_member as b on a.member_id = b.id','left')->field('a.id,a.money,a.reply,a.message,a.msg_time,b.truename,b.userimg')->where(array(
             'fid'=>array('eq',$funding_id),
             'message'=>array('exp','is not null'),
             'status'=>array('eq','1')
         ))->select();
         //微信分享相关参数
         $time = time();
         //如果存在邀请码，则分享链接上加上邀请码
         $share_url = 'http://'.$_SERVER['HTTP_HOST'].'/index.php?m=funding&a=otherFunding&id='.$funding_id;
         $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
         $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
         //	    $signature = sha1('jsapi_ticket='.$_SESSION['jsapi_ticket'].'&noncestr=BogLeUnion&timestamp='.$time.'&url='.$share_url); //源代码
         $signature = sha1('jsapi_ticket='.$_SESSION['jsapi_ticket'].'&noncestr=BogLeUnion&timestamp='.$time.'&url='.$url); //现在代码         
         $this->assign('appid', $this->getAppid());
         $this->assign('time', $time);
         $this->assign('share_url', $share_url);
         $this->assign('signature', $signature);
         $this->assign('jsapi_ticket', $_SESSION['jsapi_ticket']);
         $this ->assign('data',$data);
         $this->display();
       }else
       {
          //如果进入别人我的众筹页面，跳转到otherFunding控制器中
           header("location:/index.php?m=funding&a=otherFunding&id=$funding_id");
           exit;
       }
   }
   
   
   /*
    * 他人众筹页面
    * @param $funding_id string 众筹活动表ID
    * @param $fundinfo unknow type 众筹活动的详细信息
    * */
   public function otherFunding()
   {             
       //获取众筹分享页面的数据
       $funding_id = I('get.id');
       $data = array();
       if($funding_id)
       {
           //获取众筹的信息
           $data['fundinfo'] = $this->funding->where("id='$funding_id'")->find();
           if(!$data['fundinfo']['id'])
           {
               //数据库中找不到该条众筹信息
               showErrorInfo("该众筹活动已经失效！");exit;
           }
           if(isset($_SESSION['userid']) && $data['fundinfo']['member_id'] == $_SESSION['userid'] )
           {
               //如果点进他人众筹活动页面的ID和登录的ID相同，则直接跳转到他自己的活动页面
               header("location:/index.php?m=funding&a=share&id=$funding_id");
               exit();
           }
       }else
       {
           showErrorInfo("该众筹活动已失效！");
           exit;
       }
       //获取众筹的人的信息
         $data['userinfo'] = M('member')->field('truename,userimg')->where(array(
             'id'=>array('eq',$data['fundinfo']['member_id']),
         ))->find();
         //获取众筹课程信息
         $data['courseinfo']=M('courses')->where(array(
             'id'=>array('eq',$data['fundinfo']['product_id'])
         ))->find(); 
         //获取众筹已开启时间
         $data['start_time'] = getTime($data['fundinfo']['create_time']);
         //获取众筹支持人数
         $rec = M('funding_log')->where(array(
             'fid'=>array('eq',$funding_id),
             'status'=>array('eq','1')
         ))->group('member_id')->field('member_id')->select();
         $data['count'] = count($rec);
         if(empty($data['count']))
         {
             $data['count'] = '0';
         }
         //获取众筹人的回复和评论
         $data['replay'] = M('funding_log')->alias(a)->join('jbr_member as b on a.member_id = b.id','left')->field('a.id,a.money,a.reply,a.message,a.msg_time,b.truename,b.userimg')->where(array(
             'fid'=>array('eq',$funding_id),
             'message'=>array('exp','is not null'),
             'status'=>array('eq','1')
         ))->select();
       //微信分享相关参数
       $time = time();
       //如果存在邀请码，则分享链接上加上邀请码
       $share_url = 'http://'.$_SERVER['HTTP_HOST'].'/index.php?m=funding&a=otherFunding&id='.$funding_id;
       $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
       $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
       //	    $signature = sha1('jsapi_ticket='.$_SESSION['jsapi_ticket'].'&noncestr=BogLeUnion&timestamp='.$time.'&url='.$share_url); //源代码
       $signature = sha1('jsapi_ticket='.$_SESSION['jsapi_ticket'].'&noncestr=BogLeUnion&timestamp='.$time.'&url='.$url); //现在代码
       $this->assign('appid', $this->getAppid());
       $this->assign('time', $time);
       $this->assign('share_url', $share_url);
       $this->assign('signature', $signature);
       $this->assign('jsapi_ticket', $_SESSION['jsapi_ticket']);
       $this ->assign('data',$data);
       $this->display();
   }
   
   /*
    * ajax方法将分享话语插入到数据库中
    * 
    * */
   public function ajaxSaveShare()
   {
       $data = array();
       $data['share'] = I('share');
       $data['id'] = I('id');
       if($data)
       {
           $r = M('funding')->where(array(
               'id'=>array('eq',$data['id']),
           ))->save($data);
       }
       if($r)
       {
           echo 1;exit;
       }
   }
   
   /*
    * ajax方法将分享话语插入到数据库中
    *
    * */
   public function ajaxSavereplay()
   {
       $data = array();
       $data['reply'] = I('reply');
       $data['id'] = I('id');
       if($data)
       {
           $r = M('funding_log')->where(array(
               'id'=>array('eq',$data['id']),
           ))->save($data);
       }
       if($r)
       {
           echo 1;
           exit;
       }
   }

	
	
	
	
	
	
	
}