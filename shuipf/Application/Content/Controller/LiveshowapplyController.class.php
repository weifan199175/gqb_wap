<?php
namespace Content\Controller;

use Common\Controller\Base;
use Content\Model\ContentModel;


class LiveshowapplyController extends Base {
	
	public function _initialize(){
	parent::_initialize ();
			
		$this->liveshowapply=D("liveshowapply");
		$this->course=M("courses");
		$this->member=M("member");
		$this->memberclass=M("memberClass");
	}
	
    //判断是否有申请权限
	public function apply()
	{
		
		if(empty($_SESSION['userid'])){
			$this->error('请先登陆');
		}else{
			//防止输入链接直接访问
			//会员是否购买相应的报股权博弈课程就可以
        	//或者他是铁杆社员级别以上也可以报名直播
			$count_1 = M('order')->where('product_type=1 and status>=1 and member_id='.$_SESSION['userid'].' and product_id in (select id from jbr_courses where catid=13)')->count();
			$count_2 = M('Member')->where('id='.$_SESSION['userid'].' and member_class>=4')->count();
			$count = $count_1+$count_2;
			
			if($count>0){
				//可以申请
				$member = $this->member->where('id='.$_SESSION['userid'])->find();
				$this->assign('course',$course);
				$this->assign('member',$member);
				$this->display(); 
			}else{
			//不可以申请
			 	$this->error('由于您可能没有“股权博弈”课程，或者不是铁杆社员以上级别的会员，故无法申请直播路演哦！');exit; 
			}
			
		}
	}
	
	

	//// 订单状态是>=1的
	public function check_apply()
	{
		$data = I('post.');
		//print_r($data);die;
		if(IS_AJAX){
		//	会员是否购买相应的报股权博弈课程就可以
        // 或者他是铁杆社员级别以上也可以报名直播
			$count_1 = M('order')->where('product_type=1 and status>=1 and member_id='.$_SESSION['userid'].' and product_id in (select id from jbr_courses where catid eq 13')->count();
			$count_2 = M('Member')->where('id='.$_SESSION['userid'].' and member_class>=4')->count();
			$count = $count_1+$count_2;
			if($count>0){
				echo 1;exit; //可以申请
			}else{
				echo 0;exit; //不可以申请
			}
		}
	}

	// 保存申请
	public function save_apply()
	{
		$data = I('post.');
		$_POST['apply_time'] = date('Y-m-d H:i:s',time());
		$_POST['member_id'] = $_SESSION['userid'];
		if($this->liveshowapply->create()){
			
			$id = $this->liveshowapply->add();
			if($id){
				echo 1;
			}else{
				echo 0;
			}
		}else{
			echo 0;
		}
		
			
	}

	
	
	
	
	
	
	
   
}