<?php 
// +----------------------------------------------------------------------
// | 后台订单管理
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014
// +----------------------------------------------------------------------
// | Author: zh  2016-10-10
// +----------------------------------------------------------------------

namespace Jbr_Order\Controller;

use Common\Controller\AdminBase;
use Admin\Service\User;

class OrderCheckController extends AdminBase{
		public $order=null;
		
		public function _initialize(){
		parent::_initialize ();
			
			$this->order=M("order");
			$this->member=M("member");
			$this->memberClass=M("memberClass");
		}
		
		/*
		*	列表
		*   添加条件筛选
		*/
		public function index()
		{	
			
			
			//核销码
			$where_onm = I("ordernum", '', 'string');
			
			if($_POST){
				$this->redirect('index', $_POST);
			}
            
			if($where_onm){
			
			$periodList=$this->order->alias('o')->join('jbr_courses c on o.product_id=c.id')->where("o.verification_code=".$where_onm)->field('o.*,c.title,c.start_time,c.teacher')->find();
			
			//echo $this->order->getLastSql();
			
			 //订单状态
		     switch ($periodList['status']){
				case 0:
					$periodList['rstatus'] = '未付款';
					break;
				case 1:
				    if($periodList['start_time']<time())
					{
						$periodList['rstatus'] = '已过期';
						break;
					}else{
						$periodList['rstatus'] = '待使用';
						break;
					}
				case 2:
					$periodList['rstatus'] = '已使用';
					break;
			    }
			
			//支付方式	
    		switch ($periodList['pay_type']){
				case 1:
					$periodList['rpay_type'] = '在线支付';
					break;
				case 2:
					$periodList['rpay_type'] = '积分支付';
				    break;
				case 3:
					$periodList['rpay_type'] = '会员特权';
					break;
			    }
	

                 $this->assign('res',$periodList);
                 $this->assign('verification_code',$where_onm);
				 
	        }
	
			
			$this->display();
		}
	


	
	public function check()
	{
		
		$verification_code = I('verification_code');
		
		$order = $this->order->alias('o')->join('jbr_courses c on o.product_id=c.id')->where("o.verification_code=".$verification_code)->field('o.*,c.start_time')->find();
		//echo $this->order->getLastSql();
		
		//print_r($order);die;
		if($order['status']==0){
			$this->error("该订单未付款");
		}else if($order['status']==2){
			$this->error("该核销码已使用");
		}else if($order['start_time']<time()){
			$this->error("该核销码已过期");
		}else{
		    $r = $this->order->where('verification_code='.$verification_code)->setField('status',2);
			$this->success('核销成功',U('OrderCheck/index'));
		}
		
	}
	

	    
		
		
		
		
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	