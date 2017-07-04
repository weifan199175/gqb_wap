<?php 
// +----------------------------------------------------------------------
// | 后台订单管理
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014
// +----------------------------------------------------------------------
// | Author: zh  2016-12-5
// +----------------------------------------------------------------------

namespace Jbr_Statistics\Controller;

use Common\Controller\AdminBase;
use Admin\Service\User;

class MoneyReturnController extends AdminBase{
		public $order=null;
		
		public function _initialize(){
		parent::_initialize ();
			
			$this->money_record=M("commissionRecord");
			$this->member=M("member");
			$this->distribution=M("distribution");
		}
		
		/*
		*	列表
		*   添加条件筛选
		*/
		public function index()
		{	
			
		
			//查询起止时间
			$stime = I("starttime", '', 'string') ? " and mr.addtime >= '" .  I("starttime") . "'" : "";
			$etime = I("endtime", '', 'string') ? " and mr.addtime <= '" .  I("endtime") . "'" : "";
			
			if($_POST){
				$this->redirect('index', $_POST);
			}
            
	
			$count = count($this->money_record->alias('mr')->join('jbr_member m on m.id=mr.member_id')->where("mr.consumer_id!=0".$stime.$etime)->group('mr.member_id')->select());	
			$page = $this->page($count, 8);
			$show = $page->show();// 分页显示输出
			
			$periodList=$this->money_record->alias('mr')->join('jbr_member m on m.id=mr.member_id')->where("mr.consumer_id!=0".$stime.$etime)->group('mr.member_id')->field('sum(mr.amount) as t_m,mr.member_id,m.*')->limit($page->firstRow . ',' . $page->listRows)->order('sum(mr.amount) desc')->select();
			
			//echo $this->score_record->getLastSql();die;
			
			$this->assign("stime", I("starttime", '', 'string'));
			$this->assign("etime", I("endtime", '', 'string'));
			
			$param = array("stime"=>I("starttime", '', 'string'),"etime"=>I("endtime", '', 'string'));
	        $show = $this->page_add_param($show, $param);
	        $this->assign("Page", $show);
			
			
			$this->assign("Page", $page->show());
			$this->assign('list',$periodList);
			$this->display();
		}
	



	    //订单详情
		public function detail()
		{
		  $id = I('id');
		  
		  $order=$this->order->where("id='".$id."'")->find();
		  
		 
		
		  $this->assign('menuReturn',array('url'=>"/index.php?g=Jbr_Order&m=Order&menuid=176",'name'=>'返回订单列表'));
		  $this->display();
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
				
				$orderstatu = I("orderstatu", 'all', 'string'); //订单状态
				$ordernum = I("onum"); //订单编号
				$starttime = I("starttime"); //开始日期
				$endtime = I("endtime"); //结束日期
				$mtel = I("mtel"); //电话
	
				$this->assign("orderstatu",$orderstatu);
				$this->assign("ordernum",$ordernum);
				$this->assign("starttime",$starttime);
				$this->assign("endtime",$endtime);
				$this->assign("mtel",$mtel);
				

				if($orderstatu != "all")
				{
					$w1 .=" and order_status='$orderstatu'  ";
				}
				if($ordernum != "")
				{
					$w1 .=" and order_num='$ordernum'  ";
				}
				if($starttime != "" && $endtime != "")
				{
					$w1 .=" and order_time between '$starttime' and '$endtime'  ";
				}
				if($mtel != "")
				{
					$w1 .=" and customer_tel='$mtel' ";
				}
			

			
			$periodList=$this->order->where("1 and o.product_type!=5".$w1)->limit($page->firstRow . ',' . $page->listRows)->order('order_time desc')->select();
			//echo $this->order->getLastSql();
			 foreach($periodList as $k=>$v){
	       
		     switch ($v['order_status']){
				case NO_PAY:
					$periodList[$k]['rstatus'] = '未付款';
					break;
				/*case QX:
					$periodList[$k]['rstatus'] = '已取消';
					break;	
				case YES_SEND:
					$periodList[$k]['rstatus'] = '已发货';
					break;
				case YSH:
					$periodList[$k]['rstatus'] = '已收货';
					break;*/	
				case YES_PAY:
					$periodList[$k]['rstatus'] = '已付款';
					break;
				/*case END:
					$periodList[$k]['rstatus'] = '完成';
					break;	*/
			    }
		   }	
		
			$title = array('order_num' => '订单编号', 'UserName' => '会员用户名', 'customer_tel' => '联系电话','email' => '电子邮箱', 'customer' => '真实姓名', 'order_price' => '订单总价', 'order_time' => '下单时间','rstatus'=>'订单状态');
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
	
	
	
	
	
	
	
	
	
	
	
	
	
	