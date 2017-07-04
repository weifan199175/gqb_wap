<?php 
// +----------------------------------------------------------------------
// | 会员类型
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014
// +----------------------------------------------------------------------
// | Author: wyg
// +----------------------------------------------------------------------

namespace Jbr_Membership\Controller;

use Common\Controller\AdminBase;

class ScoreRulesController extends AdminBase{	
		
		public $linkapply=null;
		
		public function _initialize(){
		parent::_initialize ();
			$this->rule=M("scoreRules");
	}
		
		/*
		*列表
		*
		*/
		public function index()
		{
			//echo 1111;die;
			$lists=$this->rule->select();
			$this->assign('lists',$lists);			
			$this->display();
		}
		
		/*
		*添加
		*
		*/
		public function add()
		{
			if(!empty($_POST)){			
				
				
				$result = $this->rule->add($_POST);
				
				if($result){
					$this->success('添加成功',U('ScoreRules/index'));
				}else{
					 $this->error('添加失败');
				}
			}
			else
			{
				$this->display();
			}
		}
		
		/*
		*编辑
		*
		*/
		public function edit()
		{
			$id = I('id');			//获取会员类型ID
			
			if(!empty($_POST))
			{
				
				$data = $_POST;
				//echo $this->linkapply->where('MemberTypeID='.$id);
				$result = $this->rule->where('id='.I('get.id'))->data($data)->save();
				
				if($result !==false)
				{
					$this->success('修改成功',U('ScoreRules/index'));
				}
				else
				{
					 $this->error('修改失败');
				}
			}	
			else
			{
				$lists = $this->rule->find($id);
				$this->assign('lists',$lists);
				$this->display();
			}
		}
		
		/*
		*删除
		*
		*/
		public function del()
		{
			$id = I('get.id');
			if (empty($id)) {
            $this->error("没有指定删除对象！");
			}
			//执行删除
			if ($this->linkapply->delete($id)) {
				$this->success("删除成功！");
			} else {
				$this->error('删除失败！');
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
					$this->linkapply->delete($id);
				}
				$this->success('删除成功！');
			}
		}
		
		/*
		*排序
		*
		*/
		public function order()
		{}
		
		/*
		*ajax判断会员类型名称是否重复
		*
		*/
		public function chkmembertypte()
		{
			$membertypename=$_POST["membertypename"];
			$result=$this->linkapply->where('typename="'.$membertypename.'"')->find();
			if($result){
				echo "1";
			}else{
				echo "0";
			}
		}
	
	}