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

class MembertypeController extends AdminBase{	
		
		public $linkapply=null;
		
		public function _initialize(){
		parent::_initialize ();
			$this->linkapply=M("MemberClass");
	}
		
		/*
		*列表
		*
		*/
		public function index()
		{
			$lists=$this->linkapply->select();
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
				
				$this->linkapply->class_name=$_POST['typename'];
				$this->linkapply->desc=$_POST['remarks'];
				$result = $this->linkapply->add();
				if($result){
					$this->success('添加成功',U('Membertype/index'));
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
				
				$data['class_name'] = $_POST['class_name'];
				$data['charge_money'] = $_POST['charge_money'];
				$data['desc'] = $_POST['desc'];
				
				//echo $this->linkapply->where('MemberTypeID='.$id);
				$result = $this->linkapply->where('id='.I('get.id'))->data($data)->save();
				if($result !==false)
				{
					$this->success('修改成功',U('Membertype/index'));
				}
				else
				{
					 $this->error('修改失败');
				}
			}	
			else
			{
				$lists = $this->linkapply->find($id);
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
			if ($this->linkapply->delete($id)!==false) {
				$this->success("删除成功！");
			} else {
				$this->error('删除失败！');
			}
		}
		
		/*
		*禁用/启用
		*
		*/
		public function isok()
		{
			$tid = $_POST['tid'];
			$isok = $_POST['isok'];
			if($isok == 0){
				$data['IsOk']=1;				
				$result = $this->linkapply->where("id=".$tid)->data($data)->save();
				echo "1";
			}else{
				$data['IsOk']=0;
				$this->linkapply->where("id=".$tid)->data($data)->save();
				echo "0";
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