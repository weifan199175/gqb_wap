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

class ZixunController extends AdminBase{
		public $order=null;
		
		public function _initialize(){
		parent::_initialize ();
			
			$this->order=M("order");
			$this->zixun=M("zixun");
			
		}
		
		/*
		*	列表
		*   添加条件筛选
		*/
		public function index_order()
		{	
			
			//订单起止时间
			$stime = I("starttime", '', 'string') ? " and o.addtime >= '" .  I("starttime") . "'" : "";
			$etime = I("endtime", '', 'string') ? " and o.addtime <= '" .  I("endtime") . "'" : "";
			//服务项目类型
			
			if($_POST){
				$this->redirect('index_order', $_POST);
			}
            
			
			
			$count = $this->order->alias('o')->join("jbr_member m on o.member_id=m.id")->join('jbr_courses c on o.product_id=c.id')->where("1 and o.product_type=5".$stime.$etime)->count();	
			$page = $this->page($count, 8);
			$show = $page->show();// 分页显示输出
			
			$periodList=$this->order->alias('o')->join("jbr_member m on o.member_id=m.id")->join('jbr_courses c on o.product_id=c.id')->where("1 and o.product_type=5".$stime.$etime)->limit($page->firstRow . ',' . $page->listRows)->field('o.*,m.mobile,m.truename,c.title,c.start_time')->order('o.addtime desc')->select();
			
			//echo $this->order->getLastSql();die;
			
			
			$this->assign("stime", I("starttime", '', 'string'));
			$this->assign("etime", I("endtime", '', 'string'));
			
			$param = array("product_type" => 5,"stime"=>I("starttime", '', 'string'),"etime"=>I("endtime", '', 'string'));
	        $show = $this->page_add_param($show, $param);
	        $this->assign("Page", $show);
			
			//echo $this->order->getLastSql();die;
			//print_r($periodList);die;
		
		   
		    //print_r($periodList);die;
			
			
			$this->assign("Page", $page->show());
			$this->assign('orderList',$periodList);
			
			$this->display();
		}
	


        //股权咨询申请列表
		
	    public function index_message()
		{	
		
			if($_POST){
				$this->redirect('index', $_POST);
			}
			
			$count = $this->zixun->count();	
			$page = $this->page($count, 8);
			$show = $page->show();// 分页显示输出
			
			$periodList=$this->zixun->order('addtime desc')->select();
			
			
			$param = array();
	        $show = $this->page_add_param($show, $param);
	        $this->assign("Page", $show);
		
			$this->assign("Page", $page->show());
			$this->assign('orderList',$periodList);
			
			$this->display();
		}
		
	   
	    /********************************/
		/** 导出表格并下载 zh 20161206 **/
		/********************************/
		public function excel()
		{
			require_once("excel/phpexcel/getmyexcel.php");
			
			//查询
				
			//订单起止时间
			$stime = I("starttime", '', 'string') ? " and o.addtime >= '" .  I("starttime") . "'" : "";
			$etime = I("endtime", '', 'string') ? " and o.addtime <= '" .  I("endtime") . "'" : "";
	
			
			$this->assign("stime", I("starttime", '', 'string'));
			$this->assign("etime", I("endtime", '', 'string'));
			
			
			$periodList=$this->order->alias('o')->join("jbr_member m on o.member_id=m.id")->join('jbr_courses c on o.product_id=c.id')->where("1 and o.product_type=5".$stime.$etime)->field('o.*,m.mobile,m.truename,c.title,c.start_time')->order('o.addtime desc')->select();
			
			//echo $this->order->getLastSql();
			
			$title = array('truename' => '会员姓名', 'mobile' => '电话','title' => '项目', 'addtime' => '下单时间', 'score' => '支付积分', 'rpay_type' => '支付方式');
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
	
	
	
	
	
	
	
	
	
	
	
	
	
	