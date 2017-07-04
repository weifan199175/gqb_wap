<?php 
// +----------------------------------------------------------------------
// | 会员
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014
// +----------------------------------------------------------------------
// | Author: zh
// +----------------------------------------------------------------------

namespace Jbr_Membership\Controller;

use Common\Controller\AdminBase;
use Admin\Service\User;

class MembershipController extends AdminBase{
		private $Config = null;
		private $model = null;
		public $member=null;
		public $membertype=null;		
		public $orders=null;
		public $fenbu=null;
		public function _initialize(){
		parent::_initialize ();
			$this->member=M("member");
			$this->fenbu=M("fenbu");
			$this->membertype=M("memberClass");
			$this->orders=M("order");
		}
		
		/*
		*	列表
		*	20160927 edit by zh 添加条件筛选
		*/
		public function index()
		{
		    $fenbu_id = I("fenbu_id",0);//拿到搜索条件中的分部ID，默认为0（全部）
		    
		    $kefu_id = I("kefu_id","全部");//拿到搜索条件中的客服，默认为全部
		    
		    
		    $user = D("user")->where("id={$_SESSION['jbr_admin_id']}")->field("role_id,fenbu_id,nickname,remark")->find();//拿到当前用户的权限和管理分部ID
		    
	        if(in_array($user['role_id'], array(5,13))){//如果管理员是客服专员，或者客服组长
	            if($user['role_id'] == 5){//客服专员
	            	$kefu[]=$user['nickname'];
    		        $mem = M("mem_ascrip")->where("ascription='{$user['nickname']}'")->field("memid as mem_id")->select();//找到这个客服旗下的所有用户
	            }else {//客服组长
	                $remark = explode(",",$user['remark']);
	                $kefu=$remark;
	                array_unshift($kefu,"全部");
	                foreach ($remark as $k=>$r){
	                    $remark[$k] = "'".$r."'";
	                }
    		        $mem = M("mem_ascrip")->where("ascription in (".implode(",",$remark).")")->field("memid as mem_id")->select();//找到这个客服旗下的所有用户
	            }
		        foreach ($mem as $k=>$m){//格式化
		            $where_mem[]=$m['mem_id'];
		        }
		        if(empty($where_mem)){//如果没有找到该客服下面的用户，则不应该展示任何用户
		            $where_mem = " and jbr_member.id = 0";
		        }else {//找到了用户，格式化成SQL查询条件
    		        $where_mem = " and jbr_member.id in (".implode(",", $where_mem).") ";//组成搜索条件
		        }
		        
			    if($kefu_id != "全部"){
			    	$where_mem.=" AND jbr_mem_ascrip.ascription='{$kefu_id}' ";
			    }
			    $where_mem.=" AND jbr_mem_ascrip.state != '无效'";
		    }else {//如果不是客服账号访问
		    	$kefu=array("全部");
		        $where_mem = "";
		    }
		    $where_mem.=(I("is_need", "", 'string'))?" AND jbr_mem_ascrip.is_need='".I("is_need", "", 'string')."'":"";
		    
		    if($user['role_id'] != 1 && $user['fenbu_id'] != 0 ){//如果不是超级管理员并且只管一个分部的话
		        $fenbu_id = $user['fenbu_id'];
		        $fenbu = $this->fenbu->where("id={$fenbu_id}")->field("id,name")->select();//用于分社搜索下拉框
		    }else {
		        $fenbu = $this->fenbu->field("id,name")->select();//用于分社搜索下拉框
		        array_unshift($fenbu,array("id"=>0,"name"=>"全部"));
		    }
		    
		    foreach ($fenbu as $k=>$f){
		        $useFenBu[$f['id']]=$f['name'];
		    }
		    
		    if($fenbu_id != 0){
		        $dis = M("distribution")->where("fenbu_id={$fenbu_id}")->field("member_id")->select();//拿到所有该分部下的人的会员ID
		        if(!empty($dis)){
    		        foreach ($dis as $k=>$d){
    		            $where_fenbu[] = $d['member_id'];//获得该分社下每一个客户的ID
    		        }
    		        $where_fenbu = " and jbr_member.id in (".implode(",", $where_fenbu).") ";//组成搜索条件
		        }else {//未搜索到该分部下的会员，则无会员信息
		            $where_fenbu = " and jbr_member.id = 0";
		        }
		    }else {//管理所有分部会员，则不设置搜索条件
		        $where_fenbu = "";
		    }
		    
			//会员等级
			$where_MCid = I("member_class", 0, 'int') ? " and jbr_member.member_class=" . I("member_class") : "";
			//关键词
			$where_kwd = (I("keyword_type", '', 'string') && I("keyword", '', 'string')) ? " and jbr_member." . I("keyword_type") . " like '%" . I("keyword") . "%'" : "";
			//注册起止时间
			$stime = I("start_time", '', 'string') ? " and jbr_member.regtime >= '" .  I("start_time") . " 00:00:00'" : "";
			$etime = I("end_time", '', 'string') ? " and jbr_member.regtime <= '" .  I("end_time") . " 23:59:59'" : "";
			//公司名称
			$where_company = I("company","","string")?" AND jbr_member.company LIKE '%".I("company","","string")."%'":"";
			// 会员的注册来源
		
			$source = (I("source")!='')?" and source like '%" . I("source") . "%'":"";
						
			//会员状态
			$islock=I("keyword_status", -1, 'int');
			$status="";
			if($islock>=0)
			{
				$status=" and jbr_member.islock=".$islock;
			}
			if($_POST){
				$this->redirect('index', $_POST);
			}
			
			
			$count = $this->member->join("jbr_member_class on jbr_member.member_class=jbr_member_class.id")->join("left join jbr_mem_ascrip on jbr_mem_ascrip.memid=jbr_member.id")->where("jbr_member.id!=0". $where_MCid. $where_kwd .$stime .$etime.$status.$source.$where_fenbu.$where_mem.$where_company)->count();
			$page = $this->page($count, 15);
			$show = $page->show();// 分页显示输出
			
			
			
			$periodList=$this->member->join("jbr_member_class on jbr_member.member_class=jbr_member_class.id")->join("left join jbr_mem_ascrip on jbr_mem_ascrip.memid=jbr_member.id")->where("jbr_member.id!=0".$where_MCid. $where_kwd.$stime .$etime.$status.$source.$where_fenbu.$where_mem.$where_company)->field('jbr_member.*,jbr_member_class.class_name,jbr_mem_ascrip.state,jbr_mem_ascrip.ascription,jbr_mem_ascrip.is_need')->limit($page->firstRow . ',' . $page->listRows)->order('regtime desc')->select();
			//查询是否有上级
			foreach($periodList as $k=>$v)
			{
			   	$ds = M('distribution')->where('member_id='.$v['id'])->find();
				if(!empty($ds))
				{
    				$periodList[$k]['parent_name'] = $this->member->where("id=".$ds['parent_id'])->getField('truename');
    				$periodList[$k]['fenbu_name'] = $useFenBu[$ds['fenbu_id']];//拿到这个人他所属分社的名字
    				if(empty($periodList[$k]['fenbu_name'])){//老数据没有绑定分社，则无
    				    $periodList[$k]['fenbu_name']="无";
    				}
				}else{//老用户没有关联表数据则无
					$periodList[$k]['parent_name'] = '无';
					$periodList[$k]['fenbu_name'] = '无';
				}
			}
			
			//客服选择下拉框
			$kl = M("user")->where("role_id = 5 OR role_id = 13")->field("distinct nickname")->select();
			foreach ($kl as $k=>$l){
			    $kefu_list[]=$l['nickname'];
			}
			
			//学员意向搜索条件
			$isNeedList=array(
			    "待沟通","高意向","待强化","低意向","无意向"
			);
			
			$classList = $this->membertype->select();
			$this->assign("classList", $classList);
			$this->assign("member_class", I("member_class", 0, 'int'));
			$this->assign("keyword_type", I("keyword_type", '', 'string'));
			$this->assign("keyword", I("keyword", '', 'string'));
			$this->assign("stime", I("start_time", '', 'string'));
			$this->assign("etime", I("end_time", '', 'string'));
			$this->assign('source', I("source", '', 'string'));
			$this->assign('company', I("company", '', 'string'));
			
			$this->assign("keyword_status", $islock);
			$param = array(
			    "member_class" => I("member_class", 0, 'int'), 
			    "keyword_type" => I("keyword_type", '', 'string'), 
			    "keyword" => I("keyword", '', 'string'),
			    "stime"=>I("start_time", '', 'string'),
			    "etime"=>I("end_time", '', 'string'),
			    "islock"=>I("keyword_status", -1, 'int'),
			    "source"=>I("source",'','string'),
			    "company"=>I("company",'','string'),
			    "is_need"=>I("is_need", "", 'string'),
			);
			$show = $this->page_add_param($show, $param);
			$this->assign("Page", $show);
			$this->assign('memberList',$periodList);
			$this->assign('fenbu',$fenbu);//所有分部信息，用于分社搜索下拉框
			$this->assign('kefu',$kefu);//所有客服信息，用于客服搜索下拉框
			$this->assign('fenbu_id',$fenbu_id);//将分部ID传回页面，用于屏蔽与显示"激活"按钮 还有 "所属分社"的查询条件按钮
			$this->assign('kefu_id',$kefu_id);//将客服传回页面，用于 "所属客服"的查询条件按钮
			$this->assign('kefu_list',$kefu_list);//客服列表，用于归属用户
			$this->assign("role_id",$user['role_id']);
			$this->assign("isNeedList",$isNeedList);
			$this->assign("is_need",I("is_need", "", 'string'));
			$this->display();
		}
		
		/**
		 * 学员列表
		 */
		public function student(){
		    
		    $where="jbr_student.id !=0";
		    $where.=(I("stime","","string"))?" AND jbr_student.uptime>='".I("stime","","string")." 00:00:00'":"";
		    $where.=(I("etime","","string"))?" AND jbr_student.uptime<='".I("etime","","string")." 23:59:59'":"";
		    $where.=(I("username","","trim"))?" AND jbr_student.username LIKE '%".I("username","","trim")."%'":"";
		    $where.=(I("mobile","","trim"))?" AND jbr_student.mobile='".I("mobile","","trim")."'":"";
		    $where.=(I("utype","0","string") != "0")?" AND jbr_student.utype='".I("utype","0","string")."'":"";
		    $where.=(I("last_class","0","string") != "0")?" AND jbr_student.course='".I("last_class","0","string")."'":"";
		    $where.=(I("company","","string"))?" AND jbr_student.company LIKE '%".I("company","","string")."%'":"";
		    $where.=(I("state","","string"))?" AND jbr_student.state LIKE '%".I("state","","string")."%'":"";
		    $where.=(I("is_need","","string"))?" AND jbr_student.is_need='".I("is_need","","string")."'":"";
		    $where.=(I("kefu","","string"))?" AND jbr_student.kefu='".I("kefu","","string")."'":"";
		    
		    $is_reg = I("is_reg",0,"int");
		    switch ($is_reg) {
		        case 1://已注册
		            $where.=" AND jbr_student.memid !='00000000000'";
		        break;
		        case 2://未注册
		            $where.=" AND jbr_student.memid ='00000000000'";
		        break;
		    }
		    
		    $user = D("user")->where("id={$_SESSION['jbr_admin_id']}")->field("role_id,fenbu_id,nickname,remark")->find();//拿到当前用户的权限和管理分部ID
		    /**  除了超级管理员，其他人只能看到自己归属的学员 */
		    if($user['role_id'] != 1){//如果不是超级管理员，就需要做限制
		        $where.=" AND jbr_student.state != '无效' ";
    		    if($user['role_id'] == 5){//客服专员，只能看到自己的学员
    		        $where.=" AND jbr_student.kefu='{$user['nickname']}'";
    		    }else if($user['role_id'] == 13){//客服组长，能看到旗下客服的学员
    		        $where.=" AND jbr_student.kefu in "."('".implode("','",explode(",",$user['remark']))."')";
    		    }
		    }
		    /**  除了超级管理员，其他人只能看到自己归属的学员 */
		    
		    
// 		    if(I("is_excal",0,"int")){//如果要导出excal
// 		        require_once("excel/phpexcel/getmyexcel.php");
//     		    $student = M("student")->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
//     		    $title = array('username' => '姓名','mobile' => '手机号','utype'=>'学员等级','uptime'=>'最近一次上课时间','course'=>'最近一次上课课程','memid'=>'会员ID','company' => '公司','state'=>"备注");
//     		    $number = array();//数字类型
//     		    //生成excel
//     		    $filename = getExcel($student, $title, $number);
//     		    $file = fopen($filename, "r"); // 打开文件
//     		    // 输入文件标签
//     		    Header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
//     		    Header("Content-type: application/octet-stream");
//     		    Header("Accept-Ranges: bytes");
//     		    Header("Accept-Length: ".filesize($filename));
//     		    Header("Content-Disposition: attachment; filename=" . basename($filename));
//     		    // 输出文件内容
//     		    echo fread($file, filesize($filename));
//     		    fclose($file);
//     		    //回收临时文件
//     		    unlink($filename);
//     		    exit;
// 		    }
		    
		    
		    

		    $count = M("student")->where($where)->count();
		    $page = $this->page($count, 15);
		    $show = $page->show();//分页显示输出
		    $student = M("student")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order("id DESC")->select();
		    $param = array(
		        "stime"=>I("stime","","string"),
		        "etime"=>I("etime","","string"),
		        "username"=>I("username","","trim"),
		        "mobile"=>I("mobile","","trim"),
		        "utype"=>I("utype","0","string"),
		        "last_class"=>I("last_class","0","string"),
		        "company"=>I("company","","string"),
		        "is_reg"=>$is_reg,
		        "state"=>I("state","","string"),
		        "is_need"=>I("is_need","","string"),
		        "kefu"=>I("kefu","","string"),
		    );
		    $show = $this->page_add_param($show, $param);
		    
		    //学员等级搜索条件
		    $level_utype = M("student")->field('utype')->group('utype')->select();
		    foreach ($level_utype as $k=>$l){
		        $level[]=$l['utype'];
		    }
		    //课程搜索条件
		    $courses = M("student")->field('course')->group('course')->select();
		    foreach ($courses as $k=>$c){
		        $course[]=$c['course'];
		    }
		    
		    //学员意向搜索条件
		    $isNeedList=array(
		        "待沟通","高意向","待强化","低意向","无意向"
		    );
		    //客服选择下拉框
		    $mysql_kefu = M("user")->where("role_id = 5 OR role_id = 13")->field("nickname")->select();
		    foreach ($mysql_kefu as $k=>$l){
		        $kefu_list[]=$l['nickname'];
		    }
		    unset($mysql_kefu);
		    
		    $this->assign("Page", $show);
		    $this->assign("stime",I("stime","","string"));
		    $this->assign("etime",I("etime","","string"));
		    $this->assign("username",I("username","","trim"));
		    $this->assign("mobile",I("mobile","","trim"));
		    $this->assign("level",$level);
		    $this->assign("utype",I("utype","0","string"));
		    $this->assign("course",$course);
		    $this->assign("kefu_list",$kefu_list);
		    $this->assign("kefu",I("kefu","","string"));
		    $this->assign("last_class",I("last_class","0","string"));
		    $this->assign("company",I("company","","string"));
		    $this->assign("is_reg",$is_reg);
		    $this->assign("state",I("state","","string"));
		    $this->assign("role_id",$user['role_id']);
		    $this->assign("is_need",I("is_need","","string"));
		    $this->assign("isNeedList",$isNeedList);
		    $this->assign('student',$student);
		    
			$this->display();
		}
		
		
		/**
		 * 展示从渠道搜集而来的用户
		 */
		public function t_user(){
		    
		    $where="jbr_t_user.id !=0";
		    $where.=I("company","","string")?" AND jbr_t_user.company LIKE '%".I("company","","string")."%'":"";
		    $where.=I("mobile","","string")?" AND jbr_t_user.mobile='".I("mobile","","string")."'":"";
		    $where.=I("job","","string")?" AND jbr_t_user.job LIKE '%".I("job","","string")."%'":"";
		    $where.=I("name","","string")?" AND jbr_t_user.name LIKE '%".I("name","","string")."%'":"";
		    $where.=I("province","","string")?" AND jbr_t_user.province='".I("province","","string")."'":"";
		    $where.=I("way","","string")?" AND jbr_t_user.way='".I("way","","string")."'":"";
		    $where.=I("is_need","","string")?" AND jbr_t_user.is_need='".I("is_need","","string")."'":"";
		    $where.=I("extra","","string")?" AND jbr_t_user.extra LIKE '%".I("extra","","string")."%'":"";
		    $where.=I("kefu","","string")?" AND jbr_t_user.kefu='".I("kefu","","string")."'":"";
		    $where.=I("start_time","","string")?" AND jbr_t_user.datetime>=".strtotime(I("start_time","","string")." 00:00:00"):"";
		    $where.=I("end_time","","string")?" AND jbr_t_user.datetime<=".strtotime(I("end_time","","string")." 23:59:59"):"";
		    
		    /**渠道的搜索条件 —start—*/
		    $source = I("source","");//渠道（多选）
		    if(is_array($source)){
		        $sql=" AND source in (";
    		    foreach ($source as $k=>$s){
    		        $sql.="'".$s."',";
    		    }
    		    $sql=rtrim($sql,",");
    		    $sql.=")";
    		    $where.=$sql;
		    }
		    /**渠道的搜索条件 —end—*/
		    
		    $user = D("user")->where("id={$_SESSION['jbr_admin_id']}")->field("role_id,fenbu_id,nickname,remark")->find();//拿到当前用户的权限和管理分部ID
		    /**  除了超级管理员，其他人只能看到自己归属的学员 */
		    if($user['role_id'] != 1){//如果不是超级管理员，就需要做限制
		        $where.=" AND jbr_t_user.extra != '无效' ";
    		    if($user['role_id'] == 5){//客服专员，只能看到自己的学员
    		        $where.=" AND jbr_t_user.kefu='{$user['nickname']}'";
    		    }else if($user['role_id'] == 13){//客服组长，能看到旗下客服的学员
    		        $where.=" AND jbr_t_user.kefu in "."('".implode("','",explode(",",$user['remark']))."')";
    		    }
		    }
		    /**  除了超级管理员，其他人只能看到自己归属的学员 */
		    /** 导出EXCEL  —start—*/
		    if(I("is_excal",0,"int")){//如果要导出excal
		        require_once("excel/phpexcel/getmyexcel.php");
		        $t_user = M("t_user")->where($where)->field("id,name,mobile,company,job,province,source,way,is_need,kefu,extra,FROM_UNIXTIME(datetime, '%Y-%m-%d') AS datetime")->order("id DESC")->select();
		        $title = array('name'=>'姓名','mobile' => '手机号','company' => '公司名称','datetime'=>'记录时间','job'=>'职位','source'=>'渠道来源','province' => '所属省份','way'=>"方式",'is_need'=>"意向","extra"=>"备注","kefu"=>"所属客服");
		        $number = array();//数字类型
		        //生成excel
		        $filename = getExcel($t_user, $title, $number);
		        $file = fopen($filename, "r"); // 打开文件
		        // 输入文件标签
		        Header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
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
		    /** 导出EXCEL  —end—*/
		    

		    $count = M("t_user")->where($where)->count();
		    $page = $this->page($count, 15);
		    $show = $page->show();//分页显示输出
		    $t_user = M("t_user")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order("id DESC")->select();
		    $param = array(
		        "company"=>I("company","","string"),
		        "mobile"=>I("mobile","","string"),
		        "job"=>I("job","","string"),
		        "name"=>I("name","","string"),
		        "source"=>I("source",""),
		        "province"=>I("province","","string"),
		        "way"=>I("way","","string"),
		        "is_need"=>I("is_need","","string"),
		        "extra"=>I("extra","","string"),
		        "kefu"=>I("kefu","","string"),
		        "start_time"=>I("end_time","","string"),
		        "end_time"=>I("end_time","","string"),
		    );
		    $show = $this->page_add_param($show, $param);
		    
		    //source搜索条件
		    $rs = M("t_user")->field('source')->group('source')->select();
		    foreach ($rs as $k=>$l){
		        if(!empty($l['source'])){
		            $source_list[]=$l['source'];
		        }
		    }
		    unset($rs);
		    
		    //province搜索条件
		    $rs = M("t_user")->field('province')->group('province')->select();
		    foreach ($rs as $k=>$c){
		        if(!empty($c['province'])){
		          $province_list[]=$c['province'];
		        }
		    }
		    unset($rs);
		    
		    //way搜索条件
		    $rs = M("t_user")->field('way')->group('way')->select();
		    foreach ($rs as $k=>$c){
		        if(!empty($c['way'])){
    		        $way_list[]=$c['way'];
		        }
		    }
		    unset($rs);
		    
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
		    
		    $this->assign("Page", $show);
		    $this->assign("t_user",$t_user);
		    $this->assign("company",I("company","","string"));
		    $this->assign("mobile",I("mobile","","string"));
		    $this->assign("job",I("job","","string"));
		    $this->assign("name",I("name","","string"));
		    $this->assign("source",I("source",""));
		    $this->assign("province",I("province","","string"));
		    $this->assign("way",I("way","","string"));
		    $this->assign("is_need",I("is_need","","string"));
		    $this->assign("extra",I("extra","","string"));
		    $this->assign("kefu",I("kefu","","string"));
		    $this->assign("start_time",I("start_time","","string"));
		    $this->assign("end_time",I("end_time","","string"));
		    $this->assign("source_list",$source_list);
		    $this->assign("province_list",$province_list);
		    $this->assign("way_list",$way_list);
		    $this->assign("isNeedList",$isNeedList);
		    $this->assign("kefu_list",$kefu_list);
		    $this->assign("role_id",$user['role_id']);
			$this->display();
		}
		

		/**
		 * 新增渠道用户
		 */
		public function add_t_user(){
	       if(!in_array($_SESSION['jbr_admin_id'], array(1,5))){
	           echo "您无权使用此功能";exit();
	       }
            if (IS_POST) {
                $isExist = M("t_user")->where("mobile='{$_POST['mobile']}'")->count();
                if($isExist > 0 ){//如果重复了
                    $this->error("添加失败，此手机号已存在！");
                }else {
                    $_POST['datetime']=strtotime($_POST['datetime']);
                    if (M("t_user")->add($_POST)) {
                        $this->success("添加成功！", U("Membership/t_user"));
                    } else {
                        $this->error("添加失败！");
                    }
                }
            } else {
                $rs = M("user")->where("role_id = 5 OR role_id = 13")->field("distinct nickname")->select();
                foreach ($rs as $r){
                    $kefu[]=$r['nickname'];
                }
                
                //学员意向搜索条件
                $isNeedList=array(
                    "待沟通","高意向","待强化","低意向","无意向"
                );
                $this->assign("isNeedList",$isNeedList);
                $this->assign("kefu",$kefu);
                $this->display();
            }
    }
		
    /**
     * 编辑渠道用户
     */
    public function edit_t_user(){
        if(!in_array($_SESSION['jbr_admin_id'], array(1,5))){
            echo "您无权使用此功能";exit();
        }   
        if (IS_POST) {
            $_POST['datetime']=strtotime($_POST['datetime']);
            if(M("t_user")->save($_POST)){
                $this->success("编辑成功！", U("Membership/t_user"));
            }else {
                $this->error("编辑失败");
            }
        } else {
            $id = I("id");
            $t_user = M("t_user")->where("id=".$id)->find();
            $rs = M("user")->where("role_id = 5 OR role_id = 13")->field("distinct nickname")->select();
            foreach ($rs as $r){
                $kefu[]=$r['nickname'];
            }
            
            //学员意向搜索条件
            $isNeedList=array(
                "待沟通","高意向","待强化","低意向","无意向"
            );
            $this->assign("isNeedList",$isNeedList);
            $this->assign("kefu",$kefu);
            $this->assign("t_user",$t_user);
            $this->display();
        }
    }
		/********************************/
		/** 导出表格并下载 xr 20140919 **/
		/********************************/
		public function excel()
		{
			require_once("excel/phpexcel/getmyexcel.php");
			
			
			$order=array("regtime" => "desc");
			$time = I('get.time');
			$vip = I('get.vip');
			$dj = I('get.dj');
			$loginnum = I('get.loginnum');
			if($time != '')
			{
				$order=array("regtime" => $time);
			}
			if($vip != '')
			{
				$order=array("vipregtime" => $vip);
			}
			if($dj != '')
			{
				$order=array("vip" => $dj);
			}
			if($loginnum != '')
			{
				$order=array("loginnum" => $loginnum);
			}
			
			//会员ID
			$where_MCid = I("member_class", 0, 'int') ? " and jbr_member.member_class=" . I("member_class") : "";
			//关键词
			$where_kwd = (I("keyword_type", '', 'string') && I("keyword", '', 'string')) ? " and jbr_member." . I("keyword_type") . " like '%" . I("keyword") . "%'" : "";
			//注册起止时间
			$stime = I("start_time", '', 'string') ? " and jbr_member.regtime >= '" .  I("start_time") . "'" : "";
			$etime = I("end_time", '', 'string') ? " and jbr_member.regtime <= '" .  I("end_time") . "'" : "";
			
			
			
			//会员状态
			$islock=I("keyword_status", -1, 'int');
			$status="";
			if($islock>=0)
			{
				$status=" and jbr_member.islock=".$islock;
			}
			
		    $periodList=$this->member->join("jbr_member_class on jbr_member.member_class=jbr_member_class.id")->where("jbr_member.id!=0".$where_MCid. $where_kwd.$stime .$etime.$status)->limit($page->firstRow . ',' . $page->listRows)->order($order)->select();
			//查询是否有上级
			foreach($periodList as $k=>$v)
			{
			   	$ds = M('distribution')->where('member_id='.$v['id'])->find();
				if(!empty($ds))
				{
					$periodList[$k]['parent_name'] = $this->member->where("id=".$ds['parent_id'])->getField('truename');
				}else{
					$periodList[$k]['parent_name'] = '无';
				}
			}
		
			$title = array('truename' => '姓名','mobile' => '手机号','company' => '公司','industry' => '行业','position' => '职位','class_name' => '等级','parent_name'=>'上级', 'regtime' => '注册时间','invitation_code' => '邀请码');
			//数字类型
			
			$number = array();
			
			
			//生成excel
			$filename = getExcel($periodList, $title, $number);
			$file = fopen($filename, "r"); // 打开文件
			// 输入文件标签
			Header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
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
		*添加
		*
		*/
		public function add()
		{			
			if(!empty($_POST)){			
				
				$this->member->MemberTypeID=$_POST['membertype'];
				$this->member->MemberClassID=$_POST['memberclass'];
				
				$this->member->MemberTel=$_POST['membertel'];
				
				if($_POST['yes']!='')//是否禁用
				{
					$this->member->IsEnable=1;
				}
				else
				{
					$this->member->IsEnable=0;
				}
				
				if($_POST['man']!='')//性别
				{
					$this->member->MemberSex=1;
				}
				else
				{
					$this->member->MemberSex=0;
				}
				
				$this->member->MemberName=$_POST['membername'];
				$this->member->MemberPass=md5($_POST['memberpass']);
				$this->member->MemberImage=$_POST['ProductClassImage'];
				$this->member->Email=$_POST['email'];
				$this->member->Margin=$_POST['margin'];
				$this->member->Remarks=$_POST['remarks'];
				$this->member->RegTime=date("y-m-d H:i:s",time());
				
				$result = $this->member->add();
				if($result){
					$this->success('添加成功！',U('member/index'));
				}else{
					 $this->error('添加失败！');
				}
			}else{
				//加载类型 、等级
				$classList = M("membertype")->select();
				$this->assign("classList", $classList);
				
				$this->display();
			}
		}
		
		/*
		*编辑
		*
		*/
		public function edit()
		{
			$id = I('id');		//获取会员类型ID
			$lists = $this->member->find($id);
			
			if(!empty($_POST))
			{
				
				if($_POST['member_class'] != '')
				{
					$data['member_class'] = $_POST['member_class'];
				}
				if($_POST['vipstartime'] != '')
				{
					$data['vipstartime'] = $_POST['vipstartime'];
				}
				if($_POST['vipendtime'] != '')
				{
					$data['vipendtime'] = $_POST['vipendtime'];
				}
				if($_POST['islock'] != '')
				{
					$data['islock'] = $_POST['islock'];
				}
				if($_POST['is_score'] != '')
				{
					$is_score = $_POST['is_score'];
				}
				
				if($_POST['member_class']==4 && $lists['member_class']!=4 && $is_score==1)
				{
					
				     //当前积分
					$my_score = $this->member->where('id='.I('get.id'))->setInc('score',30000 * cache('Config.score_level_0'));
					
					//累计积分
					$my_total_score = $this->member->where('id='.I('get.id'))->setInc('total_score',30000 * cache('Config.score_level_0'));
					
					$score_array_0 = array('member_id'=>I('get.id'),
										   'score'=>30000 * cache('Config.score_level_0'),
										   'score_type'=>'升级铁杆社员',
										   'source'=>'社员升级',
										   'addtime'=>date('Y-m-d H:i:s',time())
										  ); 
					$score_record_0 = M('score_record')->add($score_array_0);	
					
				}
				//升级创始
				if($_POST['member_class']==3 && $lists['member_class']!=3 && $is_score==1)
				{
						
					//当前积分
					$my_score = $this->member->where('id='.I('get.id'))->setInc('score',100000 * cache('Config.score_level_0'));
						
					//累计积分
					$my_total_score = $this->member->where('id='.I('get.id'))->setInc('total_score',100000 * cache('Config.score_level_0'));
						
					$score_array_0 = array('member_id'=>I('get.id'),
							'score'=>100000 * cache('Config.score_level_0'),
							'score_type'=>'升级创始社员',
							'source'=>'社员升级',
							'addtime'=>date('Y-m-d H:i:s',time())
					);
					$score_record_0 = M('score_record')->add($score_array_0);
						
				}
			
				$result = $this->member->where('id='.I('get.id'))->data($data)->save();
				if($result !==false)
				{
					//$this->success('修改成功',U('Membership/index'));
					echo "ok";
				}
				else
				{
					 //$this->error('修改失败');
					echo "error";
				}
			}	
			else
			{
				$memtype=$this->membertype->select();
				$this->assign("memtype",$memtype);
				$this->assign('lists',$lists);
				$this->display();
			}
		}
		
		public function memlist()
		{
			$id = I('id');			//获取会员类型ID
			//$memtype=$this->membertype->select();
				
							
				
			$lists = $this->member->find($id);
			
			$memtype="普通会员";
			switch($lists['member_class'])
			{
				case 1:
				$memtype="普通社员";
				break;
				case 2:
				$memtype="注册社员";
				break;
				case 4:
				$memtype="铁杆社员";
				break;
				
			}
			$isok="激活";
			if($lists['islock']!=0)
			{
				$isok="锁定";
			}
			
	        //查询是否有上级
			$level = M('distribution')->where('member_id='.$id)->find();
			if($level)
			{
				if($lists['source']=='WEB')
				{
				    $lists['source'] = 'WEB（推荐人ID：'.$level['parent_id'].'）';	
				}
			}
			$this->assign('lists',$lists);
			$this->assign("memtype",$memtype);
			$this->assign("isok",$isok);
			$this->display();
		}
		
		/*
		*删除
		*
		*/
		public function del()
		{
			$memberid = I('get.id');
			if (empty($memberid)) {
            $this->error("没有指定删除对象！");
			}
			//执行删除
			if ($this->member->delete($memberid)) {
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
				$data['islock']=1;				
				$result = $this->member->where("id=".$tid)->data($data)->save();
				echo "1";
			}else{
				$data['islock']=0;
				$this->member->where("id=".$tid)->data($data)->save();
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
					$this->member->delete($id);
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
		*验证会员电话是否重复
		*
		*/
		public function chkmembertel()
		{
			$membertel=$_POST["membertel"];
			$result=$this->member->where("MemberTel=".$membertel)->find();
			if($result){
				echo "1";
			}else{
				echo "0";
			}
			
		}
		
		/* ajax 获取会员等级 */
		public function matchMemberClass()
		{
			$price = I('price');
			$memberclasses = M('jp_memberclass')->order("RechargeAmount desc")->select();
			foreach($memberclasses as $k => $v)
			{
				if($price >= $v['RechargeAmount'])
				{
					echo json_encode($v);
					exit;
				}
			}
		}
		/*
		 * 当前管理员拥有的客户
		 */
		public function lst(){
			$info=User::getInstance()->getInfo();//当前管理员的信息
			$memData=$this->member->alias('m')
				->join('left join jbr_mem_user b on m.id=b.mem_id')
				->where("b.user_id=".$info['id'])
				->field('m.*,b.mem_id,user_id')
				->select();
			$this->display();
		}
		
		/**
		 * 保存备注
		 */
		public function saveExtra(){
			$mobile = $_POST['mobile'];
			$extra = $_POST['extra'];
			$tableName= I('post.tableName','mem_ascrip','htmlspecialchars'); // 采用htmlspecialchars方法对表名进行转换,由于有多张表都需要更改备注，所以共用一个方法，根据表明不同进行修改
			switch ($tableName) {
			    case "mem_ascrip"://客服管理客户关系表
        			$data = array("state"=>$extra);
			        $where="mobile='{$mobile}'";
			    break;
			    case "student"://客服组长管理学员表
        			$data = array("state"=>$extra);
			        $where="mobile='{$mobile}'";
			    break;
			    case "t_user"://客服组长管理学员表
        			$data = array("extra"=>$extra);
			        $where="mobile='{$mobile}'";
			    break;
			}
			if(M($tableName)->where($where)->save($data)){
				echo "1";
			}else {
				echo "0";
			}
		}
		
		/**
		 * 保存归属客服
		 */
		public function saveKefu(){
			$id_list = $_POST['id_list'];
			$kefu = $_POST['kefu'];
			$tableName= I('post.tableName','student','htmlspecialchars'); // 采用htmlspecialchars方法对表名进行转换,由于有多张表都需要更改客服，所以共用一个方法，根据表明不同进行修改
			
			$kefulog = array(
			    "tablename"=>$tableName,
			    "new_kefu"=>$kefu,
			    "createtime"=>date("Y-m-d H:i:s"),
			);
			switch ($tableName) {
			    case "student"://未注册学员表
        			$data = array("kefu"=>$kefu);
			        $where="id IN "."(".implode(",", $id_list).")";
			        $name_and_kefu = M($tableName)->where($where)->field("username AS name,kefu")->select();
			    break;
			    case "mem_ascrip"://已注册会员表
        			$data = array("ascription"=>$kefu);
			        $where="memid IN "."(".implode(",", $id_list).")";
			        $name_and_kefu = M($tableName)->where($where)->field("truname AS name,ascription AS kefu")->select();
			    break;
			    case "t_user"://未注册学员表
			        $data = array("kefu"=>$kefu);
			        $where="id IN "."(".implode(",", $id_list).")";
			        $name_and_kefu = M($tableName)->where($where)->field("name,kefu")->select();
			        break;
			}
			
			foreach ($name_and_kefu as $k=>$n){
			    $kefulog['old_kefu'].=$n['kefu'].",";
			    $kefulog['name'].=$n['name'].",";
			}
			$kefulog['old_kefu'] = rtrim($kefulog['old_kefu'],",");
			$kefulog['name'] = rtrim($kefulog['name'],",");
			
			if(M($tableName)->where($where)->save($data)){
    			M("kefu_log")->add($kefulog);
				echo "1";
			}else {
				echo "0";
			}
		}
		
		/**
		 * 保存学员意向
		 */
		public function saveIsNeed(){
		    $is_need = $_POST['is_need'];
		    $mobile = $_POST['mobile'];
			$tableName= I('post.tableName','student','htmlspecialchars'); // 采用htmlspecialchars方法对表名进行转换,由于有多张表都需要更改学员意向，所以共用一个方法，根据表明不同进行修改
			switch ($tableName) {
			    case "student":
        			$data = array("is_need"=>$is_need);
        			$where="mobile=".$mobile;
			    break;
			    case "mem_ascrip":
        			$data = array("is_need"=>$is_need);
        			$where="mobile=".$mobile;
			    break;
			    case "t_user":
			        $data = array("is_need"=>$is_need);
			        $where="mobile=".$mobile;
			        break;
			}
			if(M($tableName)->where($where)->save($data)){
				echo "1";
			}else {
				echo "0";
			}
		}
		
		/**
		 * 修改积分
		 */
		public function changeScore(){
		    if(IS_AJAX){
		        if(isset($_POST['func']) && $_POST['func'] == "selectScore"){//小需求，查询积分
		            $user = M("member")->where("id=".$_POST['userId'])->field("truename,score")->find();
		            echo "用户：".$user['truename']."，拥有积分：".$user['score']."分";exit();
		        }
		        
		        if(empty($_POST['userId']) || empty($_POST['score']) || empty($_POST['reason'])){
                    $this->error("修改失败，请补全必填参数！");
		        }else {
		            $userId = $_POST['userId'];
		            $score = (int)$_POST['score'];
		            $reason = $_POST['reason'];
		            if($score<0){//当要扣除积分的时候，先判断是否有几分可以扣
		                $hasScore = M("member")->where("id=".$userId)->getField("score");
		                if($hasScore<abs($score)){
		                    $this->error("修改失败，用户当前积分不足，无法扣除！");
		                }else {
		                    M("member")->where("id=".$userId)->setDec('score',abs($score));//扣积分
		                    $params = array(
		                        "member_id"=>$userId,
		                        "score"=>$score,
		                        "score_type"=>$reason,
		                        "source"=>$reason,
		                        "addtime"=>date("Y-m-d H:i:s",time()),
		                    );
		                    $params['share_type_id']=empty($_POST['share_type_id'])?null:$_POST['share_type_id'];
		                    $params['consumer_id']=empty($_POST['consumer_id'])?null:$_POST['consumer_id'];
		                    $params['openid']=empty($_POST['openid'])?null:$_POST['openid'];
		                    M("score_record")->add($params);
		                }
		            }else {
                        M("member")->where("id=".$userId)->setInc('score',$score);//加积分
                        M("member")->where("id=".$userId)->setInc('total_score',$score);//加积分
                        $params = array(
                            "member_id"=>$userId,
                            "score"=>$score,
                            "score_type"=>$reason,
                            "source"=>$reason,
                            "addtime"=>date("Y-m-d H:i:s",time()),
                        );
                        $params['share_type_id']=empty($_POST['share_type_id'])?null:$_POST['share_type_id'];
                        $params['consumer_id']=empty($_POST['consumer_id'])?null:$_POST['consumer_id'];
                        $params['openid']=empty($_POST['openid'])?null:$_POST['openid'];
                        M("score_record")->add($params);
		            }
                    $this->success("修改成功，用户最新积分：".(M("member")->where("id=".$userId)->getField("score")));
		        }
            }else {
    		        $this->display();
    	    }
		}
	}