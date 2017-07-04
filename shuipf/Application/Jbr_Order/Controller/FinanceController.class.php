<?php 
// +----------------------------------------------------------------------
// | 后台提现管理
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2016
// +----------------------------------------------------------------------
// | Author: zh  2015-03-09
// +----------------------------------------------------------------------

namespace Jbr_Order\Controller;

use Common\Controller\AdminBase;
use Admin\Service\User;

class FinanceController extends AdminBase{
		public $record=null;
		
		public function _initialize(){
		parent::_initialize ();
			
			$this->record=M("withdrawals_record");
		}
		
		/*
		*	列表
		*   添加条件筛选
		*/
		public function index()
		{	
			//状态
			
			if(I("status")=='10'){
				$where_s = " and o.status=0";
			}else{
				$where_s = I("status", 0, 'int') ? " and o.status=" . I("status", 0, 'int') : "";
			}
			
			
			//起止时间
			$stime = I("starttime", '', 'string') ? " and o.addtime >= '" .  I("starttime") . "'" : "";
			$etime = I("endtime", '', 'string') ? " and o.addtime <= '" .  I("endtime") . "'" : "";
			
			//服务项目名称
			$where_m = I("mobile", '', 'string') ? " and m.mobile like '%" . I("mobile", '', 'string') . "%'"  : "";
			
			
			if($_POST){
				$this->redirect('index', $_POST);
			}
            
			
			//echo $where_s;die;
			$count = $this->record->alias('o')->join("jbr_member m on o.member_id=m.id")->where("1".$where_s.$stime.$etime.$where_m)->count();	
			$page = $this->page($count, 8);
			$show = $page->show();// 分页显示输出
			
			$periodList=$this->record->alias('o')->join("jbr_member m on o.member_id=m.id")->where("1".$where_s.$stime.$etime.$where_m)->limit($page->firstRow . ',' . $page->listRows)->field('o.*,m.mobile,m.truename')->order('o.status asc,o.addtime desc')->select();
			
			//echo $this->record->getLastSql();die;
			
			$this->assign("status", I("status", 0, 'string'));
			$this->assign("stime", I("starttime", '', 'string'));
			$this->assign("etime", I("endtime", '', 'string'));
			$this->assign("mobile", I("mobile", '', 'string'));
			
			
			$param = array("status" => I("status", 0, 'int'),"stime"=>I("starttime", '', 'string'),"etime"=>I("endtime", '', 'string'),"mobile"=>I("mobile", '', 'string'));
	        $show = $this->page_add_param($show, $param);
	        $this->assign("Page", $show);
			
			//echo $this->record->getLastSql();die;
			//print_r($periodList);die;
			

			foreach($periodList as $k=>$v)
			 {
	         
			 //审核状态
		     switch ($v['status']){
				case 0:
					$periodList[$k]['rstatus'] = '待处理';
					break;
				case 1:
					$periodList[$k]['rstatus'] = '处理中';
					break;	
				case 2:
					$periodList[$k]['rstatus'] = '已拒绝';
					break;
				case 3:
					$periodList[$k]['rstatus'] = '提现成功';
					break;	
			    }
			
		}	
		   
		    //print_r($periodList);die;
			
			
			
			$this->assign("Page", $page->show());
			$this->assign('List',$periodList);
			
			$this->display();
			
		}
		
		
		
		
		
	
		/*
		* 修改申请状态
		*
		*/
		public function edit()
		{
			$id = I('id');			
			if(!empty($_POST))
			{   
				
				$data = $_POST;
				$userInfo = User::getInstance()->getInfo();
				$data['operator'] = $userInfo['nickname'];
				$result = $this->record->where(array('id'=>I('post.id')))->data($data)->save();
				
				$r_info = $this->record->where(array('id'=>I('post.id')))->find();
				
				if($result !==false)
				{   	
				    if($data['status'] == 3){//只有当体现成功时，才会减去相应金额
			        //扣除会员余额
    					$r = M('member')->where('id='.$r_info['member_id'])->setDec('commission',$r_info['amount']);
				    }
					
					$this->success('修改成功',U('Finance/index'));
				}
				else
				{
					 $this->error('修改失败');
				}
			}	
			else
			{	
		       
				$res = $this->record->find($id);
				
				$m = M('member')->find($res['member_id']);
				$this->assign('res',$res);
				$this->assign('m',$m);
				$this->display();
			}
		}
		
	    /********************************/
		/** 导出表格并下载 xr 20140919 **/
		/********************************/
		public function excel()
		{
			require_once("excel/phpexcel/getmyexcel.php");
			
				//查询
				
			if(I("status")=='10'){
				$where_s = " and o.status=0";
			}else{
				$where_s = I("status", 0, 'int') ? " and o.status=" . I("status", 0, 'int') : "";
			}
			
			
			//起止时间
			$stime = I("starttime", '', 'string') ? " and o.addtime >= '" .  I("starttime") . "'" : "";
			$etime = I("endtime", '', 'string') ? " and o.addtime <= '" .  I("endtime") . "'" : "";
			
			//联系方式
			$where_m = I("mobile", '', 'string') ? " and m.mobile like '%" . I("mobile", '', 'string') . "%'"  : "";
			
			
			//带会员的查询
			$periodList=$this->record->alias('o')->join("jbr_member m on o.member_id=m.id")->where("1".$where_s.$stime.$etime.$where_m)->limit($page->firstRow . ',' . $page->listRows)->field('o.*,m.mobile,m.truename')->order('o.status asc,o.addtime desc')->select();
			
			 foreach($periodList as $k=>$v){
	       
		     //审核状态
		     switch ($v['status']){
				case 0:
					$periodList[$k]['rstatus'] = '待处理';
					break;
				case 1:
					$periodList[$k]['rstatus'] = '处理中';
					break;	
				case 2:
					$periodList[$k]['rstatus'] = '已拒绝';
					break;
				case 3:
					$periodList[$k]['rstatus'] = '提现成功';
					break;	
			    }
		   }	
		
			$title = array('truename' => '申请人', 'mobile' => '联系方式','out_way' => '提现方式','account'=>'提现账户','amount' => '提现金额','addtime' => '申请时间','addtime' => '添加时间','rstatus'=>'状态');
			
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
	
	
	
	
	
	
	
	
	
	
	
	
	
	