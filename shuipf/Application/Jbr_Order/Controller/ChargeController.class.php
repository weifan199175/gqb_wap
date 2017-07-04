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

class ChargeController extends AdminBase{
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
			
			
			//订单起止时间
			$stime = I("starttime", '', 'string') ? " and o.addtime >= '" .  I("starttime") . "'" : "";
			$etime = I("endtime", '', 'string') ? " and o.addtime <= '" .  I("endtime") . "'" : "";
			//姓名
			$where_t = I("truename", '', 'string') ? " and m.truename=" . I("truename", '', 'string') : "";
			//电话
			$where_m = I("mobile", '', 'string') ? " and m.mobile like '%" . I("mobile", '', 'string') . "%'"  : "";
			
			
			if($_POST){
				$this->redirect('index', $_POST);
			}
            
			
			
			$count = $this->order->alias('o')->join("jbr_member m on o.member_id=m.id")->where("1 and o.order_type=2".$where_s.$where_onm.$stime.$etime.$where_t)->count();	
			$page = $this->page($count, 8);
			$show = $page->show();// 分页显示输出
			
			$periodList=$this->order->alias('o')->join("jbr_member m on o.member_id=m.id")->where("1 and o.order_type=2".$where_m.$stime.$etime.$where_t)->limit($page->firstRow . ',' . $page->listRows)->field('o.*,m.mobile,m.truename')->order('o.addtime desc')->select();
			
			//echo $this->order->getLastSql();die;
			
			
			$this->assign("truename", I("truename", '', 'string'));
			$this->assign("stime", I("starttime", '', 'string'));
			$this->assign("etime", I("endtime", '', 'string'));
			$this->assign("mobile", I("mobile", '', 'string'));
			
			
			$param = array("truename" => I("truename", '', 'string'),"stime"=>I("starttime", '', 'string'),"etime"=>I("endtime", '', 'string'),"mobile"=>I("mobile", '', 'string'));
	        $show = $this->page_add_param($show, $param);
	        $this->assign("Page", $show);
			
			//echo $this->order->getLastSql();die;
			//print_r($periodList);die;
			

			foreach($periodList as $k=>$v)
			{
	         
			 //订单状态
		        switch ($v['status']){
				case 0:
					$periodList[$k]['rstatus'] = '未付款';
					break;
				case 1:
				    $periodList[$k]['rstatus'] = '已付款';
					break;
			    }
			
			//支付方式	
    		    switch ($v['pay_type']){
				    case 1:
					$periodList[$k]['rpay_type'] = '在线支付';
					break;
			    }
				
		   }	
		   
		  
			$this->assign("Page", $page->show());
			$this->assign('orderList',$periodList);
			
			$this->display();
		}
	    
		
		
		
	   /********************************/
		/** 导出表格并下载 xr 20140919 **/
		/********************************/
		public function excel()
		{
			require_once("excel/phpexcel/getmyexcel.php");
			
					//查询
				
				//订单起止时间
			$stime = I("starttime", '', 'string') ? " and o.addtime >= '" .  I("starttime") . "'" : "";
			$etime = I("endtime", '', 'string') ? " and o.addtime <= '" .  I("endtime") . "'" : "";
			//姓名
			$where_t = I("truename", '', 'string') ? " and m.truename=" . I("truename", '', 'string') : "";
			//电话
			$where_m = I("mobile", '', 'string') ? " and m.mobile like '%" . I("mobile", '', 'string') . "%'"  : "";
			

			
			$periodList=$this->order->alias('o')->join("jbr_member m on o.member_id=m.id")->where("1 and o.order_type=2".$where_m.$stime.$etime.$where_t)->limit($page->firstRow . ',' . $page->listRows)->field('o.*,m.mobile,m.truename')->order('o.addtime desc')->select();
			//echo $this->order->getLastSql();
			 foreach($periodList as $k=>$v)
			{
	         
			 //订单状态
		        switch ($v['status']){
				case 0:
					$periodList[$k]['rstatus'] = '未付款';
					break;
				case 1:
				    $periodList[$k]['rstatus'] = '已付款';
					break;
			    }
			
			//支付方式	
    		    switch ($v['pay_type']){
				    case 1:
					$periodList[$k]['rpay_type'] = '在线支付';
					break;
			    }
				
		   }	
		
			$title = array('id' => '订单编号', 'truename' => '会员名', 'mobile' => '联系电话','price' => '充值金额', 'addtime' => '充值时间','rpay_type' => '支付方式','rstatus'=>'订单状态');
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
	   

	
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	