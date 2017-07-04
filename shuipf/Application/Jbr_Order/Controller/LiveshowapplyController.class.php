<?php 
// +----------------------------------------------------------------------
// | 后台订单管理
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014
// +----------------------------------------------------------------------
// | Author: zh  2016-11-17
// +----------------------------------------------------------------------

namespace Jbr_Order\Controller;

use Common\Controller\AdminBase;
use Admin\Service\User;

class LiveshowapplyController extends AdminBase{
		public $liveshowapply=null;
		
		public function _initialize(){
		parent::_initialize ();
			
			$this->liveshowapply=M("Liveshowapply");
			$this->member = M('member');
			
		}
		
		/*
		*	列表
		*   添加条件筛选
		*/
		public function index()
		{	
			$sql = '1';
			//订单起止时间
			$sql.= I("starttime", '', 'string') ? " and o.apply_time >= '" .  I("starttime") . "'" : "";
			$sql.= I("endtime", '', 'string') ? " and o.apply_time <= '" .  I("endtime") . "'" : "";
			$sql.= " and o.truename like '%".I('truename')."%'";
			$sql.= " and o.mobile like '%".I('mobile')."%'";
			$sql.= " and o.project_title like '%".I('project_title')."%'";
			if($_POST){
				$this->redirect('index', $_POST);
			}
            
			
			
			$count = $this->liveshowapply->alias('o')->join("jbr_member m on o.member_id=m.id")->where($sql)->count();	
			$page = $this->page($count, 8);
			$show = $page->show();// 分页显示输出
			
			$periodList= $this->liveshowapply->alias('o')->join("jbr_member m on o.member_id=m.id")->where($sql)->limit($page->firstRow . ',' . $page->listRows)->field('o.*,o.truename as username')->order('o.apply_time desc')->select();
			
			//echo $this->order->getLastSql();die;
			
			
			$this->assign("stime", I("starttime", '', 'string'));
			$this->assign("etime", I("endtime", '', 'string'));
			$this->assign("truename", I("truename","",'string'));
			$this->assign("project_title", I("project_title","",'string'));
			$this->assign("mobile", I("mobile","",'string'));
			
			
			$param = array("product_type" => 5,"stime"=>I("starttime", '', 'string'),"etime"=>I("endtime", '', 'string'),"truename"=>I("truename", '', 'string'),"mobile"=>I("mobile","","string"),"project_title"=>I("project_title","","string"));
	        $show = $this->page_add_param($show, $param);
	        $this->assign("Page", $show);
			
			$this->assign("Page", $page->show());
			$this->assign('orderList',$periodList);
			
			$this->display();
		}
	


    public function review(){
       
   		$id = I('get.id');
   		if(empty($id)){
   			$this->error('您访问的信息不存在');
   		}else{
   			$data = M('liveshowapply')->find($id);
   			if(empty($data)){
   				$this->error('您访问的信息不存在');
   			}else{
   				$this->assign('data',$data);
   				$this->display();
   			}
   		}
    }
	
	
}
	
	
	
	
	
	
	
	
	
	
	
	
	
	