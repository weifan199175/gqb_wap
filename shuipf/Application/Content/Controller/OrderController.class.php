<?php
namespace Content\Controller;

use Common\Controller\Base;
use Content\Model\ContentModel;


class OrderController extends Base {
	
	public function _initialize(){
	parent::_initialize ();
			
			$this->order=M("order");
			$this->course=M("courses");
			$this->member=M("member");
			$this->memberclass=M("memberClass");
	}
	
    //订单提交
	public function create_order()
	{
		$course_id = I('get.id');     //课程id

		//$_SESSION['userid'] = 1;
		//课程信息
		$course = $this->course->where('id='.$course_id)->find();
		
		//会员信息
// 		header("Content-type: text/html; charset=utf-8");
// 		print_r($course);exit();
		$member = $this->member->where('id='.$_SESSION['userid'])->find();
		
		//print_r($course);
		
		$this->assign('course',$course);
		$this->assign('member',$member);
		
		/** 众筹活动新加代码  ——start—— */
		$order_type = I('get.order_type','default','htmlspecialchars');//订单类型，zc = 众筹，default=默认
		switch ($order_type) {//根据订单类型的不同，跳转到不同的页面中去
		    case "zc":
		          $templete = "order/create_zcorder";
		        break;
		    default:
		          $templete = "order/create_order";
		        break;
		}
		/** 众筹活动新加代码  ——end—— */
		$this->display($templete);
	}
	
	
	//生成订单
	public function addorder()
	{
		$data = I('post.');
		//print_r($data);die;
		if(IS_AJAX){
			$is = M('order')->where('product_id='.$data['product_id'].' and product_type=1 and member_id='.$_SESSION['userid'].' and status>=1')->find();
			//var_dump($is);exit;
			
			/** 众筹活动新加代码  ——start—— */
			if($data['pay_type'] == 5){//如果是众筹订单，还要判断是否已经有过众筹订单了
			    if($data['product_type'] == 1 && getOverTime($data['product_id']) < time()){//如果购买的是课程，还要判断是否过期了
    				echo json_encode(array('code'=>3));exit; //该课程已经过期，不能再进行众筹了
			    }
			    
    			$isfunD = M('funding')->where('member_id='.$_SESSION['userid'].' AND product_id='.$data['product_id'])->find();
    			if($isfunD){
    				echo json_encode(array('code'=>2));exit; //该课程已经创建过众筹活动了，无法再次创建
    			}
			}
			/** 众筹活动新加代码  ——end—— */
			
			if($is){
				echo json_encode(array('code'=>2));exit; //该课程已经报过名
			}
			
			$r = add_order($data['product_id'],$data['product_type'],$data['pay_type'],$data['price'],$data['score'],$_SESSION['userid'],$data['mobile'],$data['truename']);
			
			$order = $this->order->where('id='.$r)->find();
			
			
			/** 众筹活动新加代码  ——start—— */
			if($data['pay_type'] == 5){//如果是众筹订单，还需要增加一条众筹活动记录
			    $res = createFunding($order['member_id'], $order['verification_code'], $order['product_id'], $order['price'],$order['truename'],$order['mobile']);
			    $fund = $res['ret'] == "success"?true:false;
			    $funding_id = isset($res['funding_id'])?$res['funding_id']:"";
			}else {//如果不是众筹活动
			    $fund = true;
			    $funding_id = null;
			}
			/** 众筹活动新加代码  ——end—— */
			
			//print_r($order);exit;
			if($r && $fund)
			{
			   echo json_encode(array('code'=>0,'order_num'=>$order['verification_code'],"funding_id"=>$funding_id));exit; //提交成功
			}else{
			   echo json_encode(array('code'=>1));exit;  //提交失败
			}
		}
	}
}