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

class OrderController extends AdminBase{
		public $order=null;
		public $fenbu=null;
		public $member=null;
		
		public function _initialize(){
		parent::_initialize ();
			
			$this->order=M("order");
			$this->member=M("member");
			$this->fenbu=M("fenbu");
			$this->memberClass=M("memberClass");
		}
		
		/*
		*	列表
		*   添加条件筛选
		*/
		public function index()
		{	
			
			//订单状态
			$where_s = I("orderstatu", 0, 'int') ? " and o.status=" . I("orderstatu", 0, 'int') : "";
			//核销码
			$where_onm = I("ordernum", '', 'string') ? " and o.verification_code=" . I("ordernum", '', 'string') : "";
			//订单起止时间
			$stime = I("starttime", '', 'string') ? " and o.addtime >= '" .  I("starttime") . "'" : "";
			$etime = I("endtime", '', 'string') ? " and o.addtime <= '" .  I("endtime") . "'" : "";
			//服务项目类型
			$where_p = I("product_type", 0, 'int') ? " and o.product_type=" . I("product_type", 0, 'int') : "";
			//服务项目名称
			$where_t = I("title", '', 'string') ? " and c.title like '%" . I("title", '', 'string') . "%'"  : "";
			
			
			$fenbu_id = I("fenbu_id",0);//拿到搜索条件中的分部ID，默认为0（全部）
			
			$user = D("user")->where("id={$_SESSION['jbr_admin_id']}")->field("role_id,fenbu_id,nickname,remark")->find();//拿到当前用户的权限和管理分部ID
			
			if(in_array($user['role_id'], array(5,13))){//如果管理员是客服专员，或者客服组长
			    if($user['role_id'] == 5){//客服专员
			        $mem = M("mem_ascrip")->where("ascription='{$user['nickname']}'")->field("memid as mem_id")->select();//找到这个客服旗下的所有用户
			    }else {//客服组长
			        $remark = explode(",",$user['remark']);
			        foreach ($remark as $k=>$r){
			            $remark[$k] = "'".$r."'";
			        }
			        $mem = M("mem_ascrip")->where("ascription in (".implode(",",$remark).")")->field("memid as mem_id")->select();//找到这个客服旗下的所有用户
			    }
			    foreach ($mem as $k=>$m){//格式化
			        $where_mem[]=$m['mem_id'];
			    }
			    if(empty($where_mem)){//如果没有找到该客服下面的用户，则不应该展示任何用户
			        $where_mem = " and o.member_id = 0";
			    }else {//找到了用户，格式化成SQL查询条件
			        $where_mem = " and o.member_id in (".implode(",", $where_mem).") ";//组成搜索条件
			    }
			}else {
			    $where_mem = "";
			}
			
			
			
			if($user['role_id'] != 1 && $user['fenbu_id'] != 0 ){//如果不是超级管理员并且只管一个分部的话
			    $fenbu_id = $user['fenbu_id'];
			    $fenbu = $this->fenbu->where("id={$fenbu_id}")->field("id,name")->select();//用于分社搜索下拉框
			}else {
			    $fenbu = $this->fenbu->field("id,name")->select();//用于分社搜索下拉框
			    array_unshift($fenbu,array("id"=>0,"name"=>"全部"));
			}
			
			
			if($fenbu_id != 0){
			    $dis = M("distribution")->where("fenbu_id={$fenbu_id}")->field("member_id")->select();//拿到所有该分部下的人的会员ID
			    if(!empty($dis)){
			        foreach ($dis as $k=>$d){
			            $where_fenbu[] = $d['member_id'];//获得该分社下每一个客户的ID
			        }
			        $where_fenbu = " and o.member_id in (".implode(",", $where_fenbu).") ";//组成搜索条件
			    }else {//未搜索到该分部下的会员，则无会员信息
			        $where_fenbu = " and o.member_id = 0";
			    }
			}else {//管理所有分部会员，则不设置搜索条件
			    $where_fenbu = "";
			}
			
			if($_POST)
			{
				$this->redirect('index', $_POST);
			}
            
			
			
			$count = $this->order->alias('o')->join("jbr_member m on o.member_id=m.id")->join('LEFT JOIN jbr_courses c on o.product_id=c.id')->where("1".$where_s.$where_onm.$stime.$etime.$where_p.$where_t.$where_fenbu.$where_mem)->count();	
			$page = $this->page($count, 8);
			$show = $page->show();// 分页显示输出
			$periodList=$this->order->alias('o')->join("jbr_member m on o.member_id=m.id")->join('LEFT JOIN jbr_courses c on o.product_id=c.id')->where("1".$where_s.$where_onm.$stime.$etime.$where_p.$where_t.$where_fenbu.$where_mem)->limit($page->firstRow . ',' . $page->listRows)->field('o.*,m.mobile,m.truename,c.title,c.end_time,c.start_time c_start_time')->order('o.addtime desc')->select();
			foreach($periodList as $k=>$v)
			{
				if($v['product_type'] == 16)
				{
					$periodList[$k]['c_start_time'] = '无';
					$periodList[$k]['title'] = '铁杆社员';
				}
				if($v['product_type'] == 4)
				{
					$periodList[$k]['c_start_time'] = '无';
					$periodList[$k]['title'] = '股权诊断器';
				}else if($v['product_type'] == 7){
					$periodList[$k]['c_start_time'] = '无';
					$periodList[$k]['title'] = '9块9微课';
				}
			}
			
			$this->assign("orderstatu", I("orderstatu", 'all', 'string'));
			$this->assign("ordernum", I("ordernum", '', 'string'));
			$this->assign("product_type", I("product_type", 0, 'int'));
			$this->assign("stime", I("starttime", '', 'string'));
			$this->assign("etime", I("endtime", '', 'string'));
			$this->assign("title", I("title", '', 'string'));
			$this->assign('fenbu',$fenbu);//所有分部信息，用于分社搜索下拉框
			$this->assign('fenbu_id',$fenbu_id);//将分部ID传回页面，用于屏蔽与显示"激活"按钮 还有 "所属分社"的查询条件按钮
			
			
			$param = array("orderstatu" => I("orderstatu", 0, 'int'), "ordernum" => I("ordernum", '', 'string'), "product_type" => I("product_type", 0, 'int'),"stime"=>I("starttime", '', 'string'),"etime"=>I("endtime", '', 'string'),"title"=>I("title", '', 'string'));
	        $show = $this->page_add_param($show, $param);
	        $this->assign("Page", $show);
			
			//echo $this->order->getLastSql();die;
			//print_r($periodList);die;
			

			foreach($periodList as $k=>$v){
			    switch ($v['status']) {
			        case 0:
			            $periodList[$k]['rstatus'] = "待支付";
			        break;
			        case 1:
			            $periodList[$k]['rstatus'] = "已支付";
			        break;
			        case 2:
			            $periodList[$k]['rstatus'] = "已使用";
			        break;
			    }
			    
// 	            if($v['product_type']=='1' || $v['product_type']=='5'){//课程订单
// 					 switch($v['status']){//订单状态
// 						case 0:
// 						$periodList[$k]['rstatus'] = '待支付';break;
// 						case 1:
// 						if(time()>$v['end_time']){
// 						    $periodList[$k]['rstatus'] = '已过期';break;
// 						}else{
// 						    $periodList[$k]['rstatus'] = '待使用';break;
// 						}
// 						case 2:
// 						$periodList[$k]['rstatus'] = '已使用';break;
// 					}
// 				}else{
//     				switch($v['status']){
//     					case 0:
//     					$order[$k]['rstatus'] = '待支付';break;
//     					case 1:
//     					$order[$k]['rstatus'] = '已付款';break;					
//     				}
// 				}
			//支付方式	
    		switch ($v['pay_type']){
				case 1:
					$periodList[$k]['rpay_type'] = '在线支付';
					break;
				case 2:
					$periodList[$k]['rpay_type'] = '积分支付';
				    break;
				case 3:
					$periodList[$k]['rpay_type'] = '会员特权';
					break;
				case 5:
					$periodList[$k]['rpay_type'] = '众筹购买';
					break;
			    }
				
		}	
		   
		    //print_r($periodList);die;
			
			//服务类型
			//$order_type = M('category')->where('parentid=7')->select();
			
			$this->assign("Page", $page->show());
			$this->assign('orderList',$periodList);
			$this->assign('order_type',$order_type);
			$this->display();
		}
	



	    //订单详情
		public function detail()
		{
		  $id = I('id');
		  
		  $order=$this->order->where("id='".$id."'")->find();
		  switch ($order['product_type']) {
		      case 4://股权诊断器
		          $dia=M("dia_tool")->where("verification_code='{$order['verification_code']}'")->find();
		          $dia['is_pool'] = $dia['is_pool'] == 1?"有":"没有";
		          $dia['datetime'] = date("Y-m-d H:i:s",$dia['datetime']);
		          $dia['status'] = $dia['status'] == 1?"已支付":"待支付";
        		  $this->assign('res',$dia);
        		  $this->display("dia_tool");
		      break;
		      default://默认
        		  $this->assign('res',$order);
        		  $this->assign('menuReturn',array('url'=>"/index.php?g=Jbr_Order&m=Order&menuid=176",'name'=>'返回订单列表'));
        		  $this->display();
		      break;
		  }
		}
	
		/*
		*编辑
		*
		*/
		public function edit()
		{
			$id = I('id');			//获取订单ID
			
			if(!empty($_POST))
			{
               
				$data['product_id'] =$_POST['product_id'];
				
				$result = $this->order->where('id='.I('get.id'))->data($data)->save();
				
				if($result !==false)
				{   		
					$this->success('修改成功',U('Order/index'));
				}
				else
				{
					 $this->error('修改失败');
				}
			}	
			else
			{	
				$lists = $this->order->find($id);
				
				$kc = M('courses')->where('id='.$lists['product_id'])->find();
				$course = M('courses')->where('catid='.$lists['product_type'].' and start_time>'.time())->select();
				//echo M('courses')->getLastSql();die;
				
				$this->assign('lists',$lists);
				$this->assign('kc',$kc);
				$this->assign('course',$course);
				$this->assign('menuReturn',array('url'=>"/index.php?g=Jbr_Order&m=Order&menuid=193",'name'=>'返回订单列表'));
				$this->display();
			}
		}
		
		/*
		*删除已经取消的订单
		*
		*/
		public function del()
		{
			$id = I('get.id');
			if(empty($id)) {
            $this->error("没有指定删除对象！");
			}
			//执行删除
			$statu = $this->order->find($id);
			if($statu['order_status'] == "QX"){
			  if ($this->order->delete($id)) {
				$this->success("删除成功！");
			} else {
				$this->error('删除失败！');
			}
		  }else{
		        $this->error('订单未完成，无法删除！');
		  }	
		}
		
		/*
		*多选删除
		*
		*/
		public function deleteall()
		{
			if(IS_POST){
				if (empty($_POST['tagid'])){
					$this->error('没有信息被选中！');
				}
				foreach ($_POST['tagid'] as $id) {
					$this->member->delete($id);
				}
				$this->success('删除成功！');
			}
		}
	   

	   /********************************/
		/** 导出表格并下载 xr 20140919 **/
		/********************************/
		public function excel()
		{
			require_once("excel/phpexcel/getmyexcel.php");
			
				//查询
				
				//订单状态
				$where_s = I("orderstatu", 0, 'int') ? " and o.status=" . I("orderstatu", 0, 'int') : "";
				//核销码
				$where_onm = I("ordernum", '', 'string') ? " and o.verification_code=" . I("ordernum", '', 'string') : "";
				//订单起止时间
				$stime = I("starttime", '', 'string') ? " and o.addtime >= '" .  I("starttime") . "'" : "";
				$etime = I("endtime", '', 'string') ? " and o.addtime <= '" .  I("endtime") . "'" : "";
				//服务项目类型
				$where_p = I("product_type", 0, 'int') ? " and o.product_type=" . I("product_type", 0, 'int') : "";
				//服务项目名称
				$where_t = I("title", '', 'string') ? " and c.title like '%" . I("title", '', 'string') . "%'"  : "";
	
				$this->assign("orderstatu", I("orderstatu", 'all', 'string'));
				$this->assign("ordernum", I("ordernum", '', 'string'));
				$this->assign("product_type", I("product_type", 0, 'int'));
				$this->assign("stime", I("starttime", '', 'string'));
				$this->assign("etime", I("endtime", '', 'string'));
				$this->assign("title", I("title", '', 'string'));
				
			
			$periodList=$this->order->alias('o')->join("jbr_member m on o.member_id=m.id")->join('jbr_courses c on o.product_id=c.id')->where("1 and o.product_type!=5".$where_s.$where_onm.$stime.$etime.$where_p.$where_t)->field('o.*,m.mobile,m.truename,c.title,c.end_time,c.start_time')->order('o.addtime desc')->select();
			//echo $this->order->getLastSql();
			foreach($periodList as $k=>$v)
			 {
	            if($v['product_type']=='1' || $v['product_type']=='5')     //课程订单
		        {
					 //订单状态
					 switch($v['status'])
					{
						case 0:
						$periodList[$k]['rstatus'] = '待支付';break;
						case 1:
						if(time()>$v['end_time'])
						{
                              $periodList[$k]['rstatus'] = '已过期';break;
						}
						else
						{
                              $periodList[$k]['rstatus'] = '待使用';break;
						}
						case 2:
						$periodList[$k]['rstatus'] = '已使用';break;

					}
				}
				else
				{
					switch($v['status'])
					{
						case 0:
						$order[$k]['rstatus'] = '待支付';break;
						case 1:
						$order[$k]['rstatus'] = '已付款';break;					
					}
				}
				//支付方式	
				switch ($v['pay_type']){
					case 1:
						$periodList[$k]['rpay_type'] = '在线支付';
						break;
					case 2:
						$periodList[$k]['rpay_type'] = '积分支付';
						break;
					case 3:
						$periodList[$k]['rpay_type'] = '会员特权';
						break;
					}
				
		    }	
		
			$title = array('truename' => '会员名', 'mobile' => '电话','title' => '项目', 'addtime' => '下单时间', 'price' => '订单总价', 'rpay_type' => '支付方式','rstatus'=>'订单状态');
			//数字类型
			$number = array();
			
			
			//生成excel
			$filename = getExcel($periodList, $title, $number);
			$file = fopen($filename, "r"); // 打开文件
			// 输入文件标签
			Header("Content-type: application/octet-stream");
			Header("Accept-Ranges: bytes");
			Header("Accept-Length: ".filesize($filename));
			Header("Content-Disposition: attachment; filename=" . basename($filename));
			// 输出文件内容
			echo fread($file, filesize($filename));
			fclose($file);
			//回收临时文件
			unlink($filename);
			exit;
		}
	
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	