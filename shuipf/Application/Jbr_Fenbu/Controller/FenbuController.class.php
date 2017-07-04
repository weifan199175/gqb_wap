<?php
// +----------------------------------------------------------------------
// | 后台分社管理
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014
// +----------------------------------------------------------------------
// | Author: zh 2016-10-10
// +----------------------------------------------------------------------
namespace Jbr_Fenbu\Controller;

use Common\Controller\AdminBase;
use Admin\Service\User;

class FenbuController extends AdminBase {

    public $fenbu = null;
    public $fenxiaolog = null;

    public function _initialize() {
        parent::_initialize();
        
        $this->fenbu = M("fenbu");
        $this->fenxiaolog = M("fenxiaolog");
    }

    /*
     * 列表
     * 添加条件筛选
     */
    public function index(){
        $admin = D("user")->where("id={$_SESSION['jbr_admin_id']}")->field("role_id,fenbu_id")->find();//拿到当前用户的权限和管理分部ID
        if($admin['role_id'] != 1 || $admin['fenbu_id'] != 0){//只要他不是超级管理员，或者无法管理全部的分部，就需要根据分部ID来查对应的分部
                $where_fenbu = " and jbr_fenbu.id={$admin['fenbu_id']}";//组成搜索条件
        }else {
            $where_fenbu = "";
        }
        
        
        $count = $this->fenbu->where("jbr_fenbu.id != 0".$where_fenbu)->count();
        $page = $this->page($count, 8);
        $fenbulist = $this->fenbu->where("jbr_fenbu.id != 0".$where_fenbu)->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->assign('fenbulist',$fenbulist);
        $param = array();
        $this->assign("Page", $page->show());
        $this->display();
    }
    
    /**
     * 分社金额日志
     */
    public function log(){
        $fenbu_id = I("fenbu_id",0);//拿到搜索条件中的分部ID，默认为0（全部）
        $admin = D("user")->where("id={$_SESSION['jbr_admin_id']}")->field("role_id,fenbu_id")->find();//拿到当前用户的权限和管理分部ID
        
        if($admin['role_id'] != 1 && $admin['fenbu_id'] != 0 ){//如果不是超级管理员并且只管一个分部的话
            $fenbu_id = $admin['fenbu_id'];
            $fenbu = $this->fenbu->where("id={$fenbu_id}")->field("id,name")->select();//用于分社搜索下拉框
        }else {
            $fenbu = $this->fenbu->field("id,name")->select();//用于分社搜索下拉框
            array_unshift($fenbu,array("id"=>0,"name"=>"全部"));
        }
        
        if($fenbu_id != 0){
            $where_fenbu = " and jbr_fenxiaolog.toid={$fenbu_id}";//组成搜索条件
        }else {//不设置搜索条件
            $where_fenbu = "";
        }
        $count = $this->fenxiaolog->join("left join jbr_fenbu on jbr_fenbu.id=jbr_fenxiaolog.toid")->join("left join jbr_member on jbr_member.id=jbr_fenxiaolog.fromid")->where("jbr_fenxiaolog.category='fenshe'".$where_fenbu)->count();
        $page = $this->page($count, 10);
        $show = $page->show();// 分页显示输出
        
        $fenxiaolog = $this->fenxiaolog->join("left join jbr_fenbu on jbr_fenbu.id=jbr_fenxiaolog.toid")->join("left join jbr_member on jbr_member.id=jbr_fenxiaolog.fromid")->where("jbr_fenxiaolog.category='fenshe'".$where_fenbu)->field('jbr_fenxiaolog.*,jbr_fenbu.name,jbr_member.truename')->limit($page->firstRow . ',' . $page->listRows)->order('datetime desc')->select();
        $this->assign('fenxiaolog',$fenxiaolog);
        $this->assign('fenbu',$fenbu);
        $this->assign('fenbu_id',$fenbu_id);
		$param = array("fenbu_id" => $fenbu_id);
		$show = $this->page_add_param($show, $param);
		$this->assign("Page", $show);
        $this->display();
    }
    
    //添加分社
    public function add() {
        if (IS_POST) {
            if (D("Admin/Fenbu")->create()) {
                $_POST['datetime']=date("Y-m-d H:i:s",time());
                $_POST['updatetime']=date("Y-m-d H:i:s",time());
                if (D("Admin/Fenbu")->add($_POST)) {
                    $this->success("添加角色成功！", U("Fenbu/index"));
                } else {
                    $this->error("添加失败！");
                }
            } else {
                $error = D("Admin/Fenbu")->getError();
                $this->error($error ? $error : '添加失败！');
            }
        } else {
            $this->display();
        }
    }
    
    /**
     * 编辑分社
     */
    public function edit(){
        $id = I('id');		//获取分社ID
        $fenbu=$this->fenbu->where("id={$id}")->find();
        if (IS_POST) {
            $_POST['updatetime']=date("Y-m-d H:i:s",time());
            $result = $this->fenbu->where("id=".$id)->data($_POST)->save();
            if ($result) {
                $this->success("修改成功！", U("Fenbu/index"));
            } else {
                $error = D("Admin/Fenbu")->getError();
                $this->error($error ? $error : '修改失败！');
            }
        }else {
        	$this->assign('id',$id);
        	$this->assign('fenbu',$fenbu);
        	$this->display();
        }
    }
    
    /**
     * 删除
     */
    public function del()
    {
        $id = I('get.id');
        if (empty($id)) {
            $this->error("没有指定删除对象！");
        }
        //执行删除
        if ($this->fenbu->delete($id)) {
            $this->success("删除成功！");
        } else {
            $this->error('删除失败！');
        }
    }
}