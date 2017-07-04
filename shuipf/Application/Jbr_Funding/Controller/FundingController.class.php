<?php
// +----------------------------------------------------------------------
// | 后台众筹管理
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014
// +----------------------------------------------------------------------
// | Author: zh 2016-10-10
// +----------------------------------------------------------------------
namespace Jbr_Funding\Controller;

use Common\Controller\AdminBase;
use Admin\Service\User;

class FundingController extends AdminBase {

    public $funding = null;
    public $fundinglog = null;

    public function _initialize() {
        parent::_initialize();
        
        $this->funding = M("funding");
        $this->fundinglog = M("funding_log");
    }

    /*
     * 众筹活动列表
     * 添加条件筛选
     */
    public function index(){
        $where = "jbr_funding.id <> 0";
        $where.=(I("truename","","string"))?" AND jbr_funding.truename='".I("truename","","string")."'":"";//活动发起人
        $where.=(I("mobile","","string"))?" AND jbr_funding.mobile='".I("mobile","","string")."'":"";//手机号
        $where.=(I("courses_id","","int"))?" AND jbr_funding.product_id=".I("courses_id","","int"):"";//众筹课程
        $where.=(I("status","all","string") != "all")?" AND jbr_funding.status=".I("status","all","string"):"";//状态
        
        $count = $this->funding->join("LEFT JOIN jbr_courses ON jbr_funding.product_id = jbr_courses.id")->where($where)->count();
        $page = $this->page($count, 8);
        $show = $page->show();// 分页显示输出
        $fundinglist = $this->funding->join("LEFT JOIN jbr_courses ON jbr_funding.product_id = jbr_courses.id")->where($where)->limit($page->firstRow . ',' . $page->listRows)->field("jbr_funding.*,jbr_courses.title")->order('jbr_funding.id desc')->select();
        foreach ($fundinglist as $k=>$f){
            switch ($f['status']) {
                case 0:
                    $fundinglist[$k]['status'] = "进行中";
                break;
                case 1:
                    $fundinglist[$k]['status'] = "已完成";
                break;
                case -1:
                    $fundinglist[$k]['status'] = "已过期";
                break;
            }
            $fundinglist[$k]['title']=mb_substr($f['title'],0,12,'utf-8').(strlen($f['title'])>12?"...":"");
            $fundinglist[$k]['end_time']=date("Y-m-d H:i:s",$f['end_time']);
            $fundinglist[$k]['updatetime']=date("Y-m-d H:i:s",$f['updatetime']);
            $fundinglist[$k]['create_time']=date("Y-m-d H:i:s",$f['create_time']);
        }
        
        $courses=M("courses")->where()->field("id,title")->order("id desc")->select();//课程，用于搜索框下拉列表
        $this->assign('truename',I("truename","","string"));
        $this->assign('mobile',I("mobile","","string"));
        $this->assign('courses_id',I("courses_id","","int"));
        $this->assign("status", I("status", 'all', 'string'));
        $this->assign("courses",$courses);
        $this->assign('funding',$fundinglist);
        $param = array("truename" => I("truename","","string"), "mobile" => I("mobile","","string"), "courses_id" => I("courses_id","","int"),"status"=>I("status","all","string"));
        $show = $this->page_add_param($show, $param);
        $this->assign("Page", $show);
        $this->display();
    }
    
    public function order(){
        $where = "jbr_funding_log.id != 0";
        $where.=(I("status","all","string") != 'all')? " AND jbr_funding_log.status=".I("status","all","string"):"";
        $where.=(I("verification_code","","string"))? " AND jbr_funding_log.verification_code=".I("verification_code","","string"):"";
        $where.=(I("pay_type","all","string") != 'all')? " AND jbr_funding_log.pay_type='".I("pay_type","","string")."'":"";
        $where .= (I("fid","",'int')) ? " AND jbr_funding_log.fid=".I("fid"):"";//活动ID
        
        
        $count = $this->fundinglog->where($where)->count();
        $page = $this->page($count, 8);
        $show = $page->show();// 分页显示输出
        $fundinglog = $this->fundinglog->join("LEFT JOIN jbr_member ON jbr_member.id=jbr_funding_log.member_id")->join("LEFT JOIN jbr_funding ON jbr_funding.id=jbr_funding_log.fid")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order('jbr_funding_log.id desc')->field("jbr_funding_log.*,jbr_member.nickname,jbr_member.userimg,jbr_funding.truename AS faqiren")->select();
//         echo $this->fundinglog->getLastSql();exit();
        foreach ($fundinglog as $k=>$f){
            switch ($f['status']) {
                case 0:
                    $fundinglog[$k]['status']="未支付";
                break;
                case 1:
                    $fundinglog[$k]['status']="已付款";
                break;
                case 2:
                    $fundinglog[$k]['status']="已退款";
                break;
            }
            $fundinglog[$k]['createtime']=date("Y-m-d H:i:s",$f['createtime']);
            switch ($f['pay_type']) {
                case "weixin":
                    $fundinglog[$k]['pay_type']="微信";
                break;
                case "zhifubao":
                    $fundinglog[$k]['pay_type']="支付宝";
                break;
            }
        }
        
        $this->assign("fid", I("fid","",'int'));
        $this->assign("status", I("status","all","string"));
        $this->assign("verification_code", I("verification_code","","string"));
        $this->assign("pay_type", I("pay_type","all","string"));
        
        $param = array("status" => I("status","all","string"), "verification_code" => I("verification_code","","string"), "pay_type" => I("pay_type","all","string"),"fid"=>I("fid","",'int'));
        $show = $this->page_add_param($show, $param);
        $this->assign("Page", $show);
        
        
        $this->assign("fundinglog",$fundinglog);
        $this->display();
    }

    
    public function log(){
        
    }
    
    //添加分社
    public function add(){
        
    }
    
    /**
     * 编辑
     */
    public function edit(){
        
    }
    
    /**
     * 删除
     */
    public function del(){
        
    }
}