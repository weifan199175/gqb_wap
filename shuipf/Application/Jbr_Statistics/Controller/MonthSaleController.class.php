<?php 
// +----------------------------------------------------------------------
// | 平台月销售报表
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014
// +----------------------------------------------------------------------
// | Author: zh  2016-12-05
// +----------------------------------------------------------------------

namespace Jbr_Statistics\Controller;

use Common\Controller\AdminBase;
use Admin\Service\User;

class MonthSaleController extends AdminBase{
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
			$year = I("year", '', 'string');
			$month = I("month", '', 'string');
			
			if($month!='')
			{
				$d=date('j',mktime(0,0,1,($month==12?1:$month+1),1,($month==12?$year+1:$year))-24*3600);
				$t_s = $year.'-'.$month.'-01';
				$t_e = $year.'-'.$month.'-'.$d.' 23:59:59';
				
			}
			else
			{
				$t_s = date('Y-m-d',time());
				$t_e = date('Y-m-d 23:59:59',time());
				$year = date('Y',time());
				$month = date('m',time());
			}
			
			$where_t = " and addtime>='{$t_s}' and addtime<='{$t_e}'";
			//echo $where_t;die;
			if($_POST){
				$this->redirect('index', $_POST);
			}
            
			//课程购买  status >=1    pay_type = 1
			    $course_count = $this->order->where('product_type=1 and status>=1 and pay_type=1'.$where_t)->count();
				//echo $this->order->getLastSql();die;
		        $course_sale = 	$this->order->where('product_type=1 and status>=1 and pay_type=1'.$where_t)->field('sum(price) as c_s')->select();
			//铁杆社员 status =1
			    $tg_count = $this->order->where('product_type=16 and status=1'.$where_t)->count();
		        $tg_sale = 	$this->order->where('product_type=16 and status=1'.$where_t)->field('sum(price) as t_s')->select();
			
			//积分充值 status =1
			   $charge_count = $this->order->where('product_type=2 and status=1'.$where_t)->count();
		       $charge_sale = $this->order->where('product_type=2 and status=1'.$where_t)->field('sum(price) as ch_s')->select();
			
			//echo $this->order->getLastSql();die;
			
			
			$this->assign("year", $year);
			$this->assign("month", $month);
			$this->assign("course_count", $course_count);
			$this->assign("course_sale", $course_sale[0]['c_s']);
			$this->assign("tg_count", $tg_count);
			$this->assign("tg_sale", $tg_sale[0]['t_s']);
			$this->assign("charge_count", $charge_count);
			$this->assign("charge_sale", $charge_sale[0]['ch_s']);
			
		
			$this->display();
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
	
	
	
	
	
	
	
	
	
	
	
	
	
	