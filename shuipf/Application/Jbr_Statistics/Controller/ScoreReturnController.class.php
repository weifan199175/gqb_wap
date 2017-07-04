<?php 
// +----------------------------------------------------------------------
// | 后台订单管理
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014
// +----------------------------------------------------------------------
// | Author: zh  2016-10-10
// +----------------------------------------------------------------------

namespace Jbr_Statistics\Controller;

use Common\Controller\AdminBase;
use Admin\Service\User;

class ScoreReturnController extends AdminBase{
		public $order=null;
		
		public function _initialize(){
		parent::_initialize ();
			
			$this->score_record=M("scoreRecord");
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
			$stime = I("starttime", '', 'string') ? " and sr.addtime >= '" .  I("starttime") . "'" : "";
			$etime = I("endtime", '', 'string') ? " and sr.addtime <= '" .  I("endtime") . "'" : "";
			
			if($_POST){
				$this->redirect('index', $_POST);
			}
            
	
			// $count = count($this->score_record->alias('sr')->join('jbr_member m on m.id=sr.member_id')->where("sr.consumer_id!=0".$stime.$etime)->group('sr.member_id')->select());	
			// $page = $this->page($count, 8);
			// $show = $page->show();// 分页显示输出
			
			// $periodList=$this->score_record->alias('sr')->join('jbr_member m on m.id=sr.member_id')->where("sr.consumer_id!=0".$stime.$etime)->group('sr.member_id')->field('sum(sr.score) as t_s,sr.member_id,m.*')->limit($page->firstRow . ',' . $page->listRows)->order('sum(sr.score) desc')->select();
			$count = M('member')->where('islock=0')->count();
			$page = $this->page($count, 8);
			$show = $page->show();// 分页显示输出
			
			$periodList = M('member')->alias('m')->join('jbr_member_class mc on mc.id=m.member_class')->where('m.islock=0')->limit($page->firstRow . ',' . $page->listRows)->field('m.id,m.mobile,m.truename,m.total_score,m.score,mc.class_name')->order('total_score desc')->select();
			
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
	



	    /********************************/
		/** 导出表格并下载 xr 20140919 **/
		/********************************/
		public function excel()
		{
			require_once("excel/phpexcel/getmyexcel.php");
			
			$periodList = M('member')->alias('m')->join('jbr_member_class mc on mc.id=m.member_class')->where('m.islock=0')->limit($page->firstRow . ',' . $page->listRows)->field('m.id,m.mobile,m.truename,m.total_score,m.score,mc.class_name')->order('total_score desc')->select();
		
			$title = array('id' => '会员ID','truename' => '会员名', 'mobile' => '手机号','class_name'=>'会员等级','total_score' => '总积分', 'score' => '可用积分');
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
	
	
	
	
	
	
	
	
	
	
	
	
	
	