<?php
// +----------------------------------------------------------------------
// | 扫码页面
// +----------------------------------------------------------------------
// | Author: xcp
// | LastEdittimeAndAuthor : 
// +----------------------------------------------------------------------

namespace Content\Controller;

use Common\Controller\Base;
use Content\Model\ContentModel;
//require_once $_SERVER['DOCUMENT_ROOT']."/shuipf/Application/Content/Controller/WxbindController.class.php";

class SaomaController extends Base {
	
	public function _initialize(){
		parent::_initialize ();
		
		
	}
	
	//首页
	public function index()
	{
		
	   $this->display();
	}
	
	//课程详情
	public function show_saomadetail()
	{

		$id = I('get.id', 0, 'intval');
		$res = M('courses')->where('id='.$id)->find();
		//echo M('courses')->getLastsql();print_r($res);exit;
		$this->assign('res',$res);
		$this->assign('img_duo',$res['img_duo']);
		$this->display();

	}

	//报到页面
	public function saoma_baodao(){
		//微信获取openid
		$tools = new \JsApiPay();
		$openid = $tools->GetOpenid();
		//var_dump($openid);exit;
		//查询课程信息
		$id=$_GET['id'];
		$res=M('courses')->where("id=".$id)->find();
		//var_dump($res);exit;
		$this->assign('openid',$openid);
		$this->assign('res',$res);
		$this->display();
	}

	//查询扫描的用户是否购买了该课程
	public function chaxun(){
		//var_dump($_POST);exit;
		$id=I('id');
		$where['openId']=I('openid');
		$r=M('member')->where($where)->find();
		if($r){
		//echo 111;exit;
			$res=M('order')->where(array("member_id"=>$r['id'],"product_id"=>$id,"status"=>1))->find();
			if($res){
				echo 0;exit;
			}else{
				echo 1;exit;
			}
		}else{
		//echo 222;exit;
			echo 2;exit;
		}
	}

	//核销
	public function hexiao(){
		$id=I('id');
		$where['openId']=I('openid');
		$r=M('member')->where($where)->find();
		$data['status']=2;
		$res=M('order')->where(array("member_id"=>$r['id'],"product_id"=>$id))->save($data);
		if($res){
				echo 0;exit;
			}else{
				echo 1;exit;
		}
	}

	public function saoma_success(){
		//查询
		$id=$_GET['id'];
		$res=M('courses')->where('id='.$id)->find();
		$r=M('member')->where('id='.$res['member_id'])->find();
		$this->assign('res',$res);
		$this->assign('r',$r);
		$this->display();
	}
	
}	
?>