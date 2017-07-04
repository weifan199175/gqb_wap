<?php
// +----------------------------------------------------------------------
// | 后台股权诊断器管理
// +----------------------------------------------------------------------
namespace Jbr_Zdq\Controller;

use Common\Controller\AdminBase;
use Admin\Service\User;

class ZdqController extends AdminBase {
    public $dia_tool = null;
    public $question = null;

 
    public function _initialize() {
        parent::_initialize();
        $this->dia_tool = M("dia_tool");
        $this->question = M("question");
    }

    public function index(){
        $where="jbr_dia_tool.id <> 0 ";
        $count = $this->dia_tool->where($where)->count();
        $page = $this->page($count, 8);
	    $show = $page->show();//分页显示输出
        $data= M("dia_tool")
        ->join("LEFT JOIN jbr_mem_ascrip ON jbr_mem_ascrip.memid=jbr_dia_tool.member_id")
        ->join("LEFT JOIN jbr_member ON jbr_member.id=jbr_dia_tool.member_id")
        ->where($where)->limit($page->firstRow . ',' . $page->listRows)
        ->order("jbr_dia_tool.id DESC")->field("jbr_dia_tool.*,jbr_member.truename,jbr_mem_ascrip.state,jbr_mem_ascrip.is_need,jbr_mem_ascrip.ascription")
        ->select();
        
        //学员意向搜索条件
        $isNeedList=array(
            "待沟通","高意向","待强化","低意向","无意向"
        );
        
        //客服选择下拉框
        $rs = M("user")->where("role_id = 5 OR role_id = 13")->field("nickname")->select();
        foreach ($rs as $k=>$l){
            $kefu_list[]=$l['nickname'];
        }
        unset($rs);
        
        $param = array();
        $show = $this->page_add_param($show, $param);
        $this->assign('data',$data);
        $this->assign("isNeedList",$isNeedList);
        $this->assign("kefu_list",$kefu_list);
        $this->assign("Page", $page->show());
        $this->display();
    }
    
    public function question(){
        $where="jbr_question.id <> 0 ";
        $count = $this->question->where($where)->count();
        $page = $this->page($count, 10);
        $show = $page->show();//分页显示输出
        $data = $this->question
        ->join("LEFT JOIN jbr_member ON jbr_member.id=jbr_question.member_id")
        ->join("LEFT JOIN jbr_mem_ascrip ON jbr_mem_ascrip.memid=jbr_question.member_id")
        ->where($where)->limit($page->firstRow . ',' . $page->listRows)
        ->order("jbr_question.id DESC")->field("jbr_question.*,jbr_member.truename,jbr_member.mobile,jbr_mem_ascrip.state,jbr_mem_ascrip.is_need,jbr_mem_ascrip.ascription")
        ->select();
        
        //学员意向搜索条件
        $isNeedList=array(
            "待沟通","高意向","待强化","低意向","无意向"
        );
        //客服选择下拉框
        $rs = M("user")->where("role_id = 5 OR role_id = 13")->field("nickname")->select();
        foreach ($rs as $k=>$l){
            $kefu_list[]=$l['nickname'];
        }
        unset($rs);
        
        $param = array();
        $show = $this->page_add_param($show, $param);
        $this->assign('data',$data);
        $this->assign("isNeedList",$isNeedList);
        $this->assign("kefu_list",$kefu_list);
        $this->assign("Page", $page->show());
        $this->display();
    }
    
}