<?php
// +----------------------------------------------------------------------
// | ShuipFCMS 网站前台用户注册登录
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: xcp
// | @modify 9-9 session中保存用户登录id以便于使用查询服务（比如订单查询、我的收藏等等） login和loginout方法
// +----------------------------------------------------------------------

namespace Content\Controller;

use Common\Controller\Base;
use Content\Model\ContentModel;
use Common\Controller\SmsApi;

class UserController extends Base {
	public $member = null;
	public $member_class = null;

	public function _initialize() {
		parent::_initialize();
		$this -> member = M("member");
		$this -> member_class = M("member_class");
// 		$_SESSION['userid'] = 4574;
	}

	//注册页面
	public function reg()
	{
		$invitation_code = $_COOKIE['invitation_code'];//个人邀请码
		$invitation_code_createtime = $_COOKIE['invitation_code_createtime'];//个人邀请码创建时间
		
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false){//如果是微信的浏览器
			$tools = new \JsApiPay();
			$openid = $tools->GetOpenid();
			$follow_relation = M("follow_relation")->where("openid='{$openid}'")->find();
			if( !empty($follow_relation) ){//如果关注绑定表有值
		
				if( !empty($invitation_code) ){//如果cookie也有推荐人的邀请码
						
					if( $invitation_code_createtime > strtotime($follow_relation['updatetime']) ){
						//do nothing
					}else {
						$invitation_code = M("member")->where("id={$follow_relation['member_id']}")->getField("invitation_code");
					}
						
				}else {//cookie没有值，就用绑定表里的
					$invitation_code = M("member")->where("id={$follow_relation['member_id']}")->getField("invitation_code");
				}
			}else {
				//do nothing
			}
				
		}
		
		
		$fenbu_code = I('get.fenbu_code');//分部邀请码
		if($invitation_code){
		   $user_invit_me = M('member')->where("invitation_code='{$invitation_code}'")->find();
		 
		  $this->assign('u_i_m',$user_invit_me); 
		}

		if(!empty($fenbu_code)){
		  $this->assign('fenbu_code',$fenbu_code);
		}
		
		//获取当前诊断结果中的公司名和电话号码-s
		$dia_id = $_SESSION['dia_result'];
		if($dia_id)
		{
		    //如果存在诊断结果
		    $diaUserInfo = M('dia_tool')->where('id='.$dia_id)->field('project,mobile')->find();
		    $_SESSION['diaUserInfo'] = $diaUserInfo;
		    $this->assign('dia_mobile',$diaUserInfo['mobile']);
		}
		//获取当前诊断结果中的公司名和电话号码-e
		
		$this->assign('source',I('get.source','WEB','string'));
		
		$this->display();
	}


    public function userreg()
	{	
    	if(IS_AJAX){
			//验证手机号和验证码
			$truename        = I('truename','','string');
			$mobile          = I('mobile','','string');
			$password        = I('password','','string');
			$yzm             = I('yzm','','string');
			$source          = I('source','WEB','string');
			$invitation_code = I('invitation_code','','string');
			$fenbu_code = I('fenbu_code','','string');
			// 判断信息是否填写
			if($truename==''){
				echo json_encode(array('info'=>'请填写您的姓名','error'=>1));
				exit;
			}elseif($mobile==''){
				echo json_encode(array('info'=>'请填写您的手机号','error'=>1));
				exit;
			}elseif($password==''){
				echo json_encode(array('info'=>'请填写您的密码','error'=>1));
				exit;
			}elseif($yzm==''){
				echo json_encode(array('info'=>'请填写验证码','error'=>1));
				exit;
			}else{
				// 判断用户的手机号是否注册
				$is_reg = M('member')->where("mobile='".$mobile."'")->find();
				if(!empty($is_reg)){
					// 手机号已经注册
					echo json_encode(array('info'=>'该手机号已经注册，请更换手机号','error'=>1));
					exit;
				}else{
					// 手机号没有注册，判断填写的手机号是否和验证码对应
					if($_SESSION['zcyzm']==$yzm&&$_SESSION['mobile']==$mobile){
						// 信息填写正确
						// 开启事物
						M('member')->startTrans();
						M('score_record')->startTrans();
						M('distribution')->startTrans();
						if(!empty($_SESSION['json_info_wx'])){
							$data['openId'] = $_SESSION['json_info_wx']['openid'];
							$data['nickname'] = $_SESSION['json_info_wx']['nickname'];
							$data['userimg'] = $_SESSION['json_info_wx']['headimgurl'];
						}
						//给注册会员生成邀请码
						$data['invitation_code']=generate_invitecode();
						
						$data['truename']=I('truename');
						$data['mobile']=I('mobile');
						$data['password']=MD5(I('password'));
						$data['regtime']=date('Y-m-d H:i:s',time());
						$data['member_class']=1;
						$data['source']=$source;
						/****给股权诊断器用户直接插入用户职位信息-s****/
						$data['position'] = I('job');
						
						/****给股权诊断器用户直接插入用户职位信息-e****/
						//获取注册积分规则
						$score_info=M('score_rules')->where('id=1')->find();
						//注册成功股权帮加积分
						$data['score'] = $score_info['get_score'];
						$data['total_score'] = $score_info['get_score'];
						
						$res = M('member')->add($data);
						
						/** 若存在推荐人且是铁杆，则分配给李自冬，否则分配给乔帅峰 —start— */
						$inviter = M("member")->where("invitation_code='".$invitation_code."'")->field("member_class,truename")->find();
						if(in_array($inviter['member_class'], array(3,4))){
						    M('mem_ascrip')->add(array(
						        "memid"=>$res,
						        "mobile"=>$data['mobile'],
						        "ascription"=>"李自冬",
						        "disn_id"=>$inviter['truename'],
						        "state"=>"无",
						        "regtime"=>date('Y-m-d H:i:s',time()),
						        "truname"=>$data['truename'],
						        "uptime"=>date('Y-m-d H:i:s',time()),
						    ));
						}else {
						    M('mem_ascrip')->add(array(
						        "memid"=>$res,
						        "mobile"=>$data['mobile'],
						        "ascription"=>"乔帅峰",
						        "disn_id"=>$inviter['truename'],
						        "state"=>"无",
						        "regtime"=>date('Y-m-d H:i:s',time()),
						        "truname"=>$data['truename'],
						        "uptime"=>date('Y-m-d H:i:s',time()),
						    ));
						}
						/** 若存在推荐人且是铁杆，则分配给李自冬，否则分配给乔帅峰 —end— */
						
						//会员注册成功添加积分记录
						$m_param = array('member_id'=>$res,
									    'score'=>$score_info['get_score'],
									    'score_type'=>'一次注册',
									    'source'=>'一次注册',
									    'addtime'=>date('Y-m-d H:i:s',time())
									   );
						$score_record=add_score_record($m_param);
                        
						// 该会员是通过邀请进来的，会给上级返积分
						if($invitation_code!=''){
							// 获取上级会员信息
							$parent_member=M('member')->where("invitation_code='{$invitation_code}'")->find();
							if(!empty($parent_member)){
							    if($parent_member['openid']){//如果他的上一级有openid，就发模板消息
							        sendTplInviteFriend($parent_member['openid'], "您好，您邀请了一位新成员加入《股权帮》", I('truename'), date("Y-m-d"), "","http://".$_SERVER['HTTP_HOST']."/index.php?m=User&a=my_member");
							    }
							    
								$level=M('distribution')->where('member_id='.$parent_member['id'])->find();
								if(!empty($level)){
									// 二级上线存在
									$distr['p_parent_id']=$level['parent_id'];
									$distr['parent_id']=$parent_member['id'];
									
									/** 新加代码  如果上一级有归属分社，则此人也归属与此分社   start */
									if(!empty($level['fenbu_id'])){
    									$distr['fenbu_id']=$level['fenbu_id'];
									}
									/** 新加代码  如果上一级有归属分社，则此人也归属与此分社   end */
									
									$level_2 = M('member')->where('id='.$level['parent_id'])->find();
									if(!empty($level_2)){//如果推荐人也有上一级
    									//二级上线返积分
    									$data_ascore['score'] = $score_info['get_score'] * 0.5 + $level_2['score'];
    									$data_ascore['total_score'] = $score_info['get_score'] * 0.5 + $level_2['total_score'];
    									$score_2 = M('member')->where('id='.$level['parent_id'])->save($data_ascore);
									}else {
									    $score_2 = 1;
									}
									
									$score_array_2 = array('member_id'=>$level['parent_id'],
													 'score'=>$score_info['get_score'] * 0.5,
													 'score_type'=>'拉新(二级注册)',
													 'source'=>'拉新(二级注册)',
													 'consumer_id'=>$res
													 ); 
									$score_record_2 = add_score_record($score_array_2);	

								}else {//有邀请人member表信息，但是没有他distribution表信息时
								    $score_1 = 1;
								    $score_2 = 1;
								    $score_record_1 = 1;
								    $score_record_2 = 1;
								    $isadd_distr = 1;
								}
								
								// 一级上线
								$distr['parent_id']=$parent_member['id'];
								$distr['member_id']=$res;
								
								
								
								$isadd_distr = M('distribution')->add($distr);
								// 关系绑定结束
								$level_1 = M('member')->where('id='.$parent_member['id'])->find();
								//一级上线返积分
								$ascore_1['score'] = $score_info['get_score'] + $parent_member['score'];
								$ascore_1['total_score'] = $score_info['get_score'] + $parent_member['total_score'];	
								$score_1 = M('member')->where('id='.$parent_member['id'])->save($ascore_1);
								
								$score_array_1 = array('member_id'=>$parent_member['id'],
												 'score'=>$score_info['get_score'],
												 'score_type'=>'拉新(一级注册)',
												 'source'=>'拉新(一级注册)',
												 'consumer_id'=>$res
												 ); 
								$score_record_1 = add_score_record($score_array_1);	
							}else{
								$score_1 = 1;
								$score_2 = 1;
								$score_record_1 = 1;
								$score_record_2 = 1;
								$isadd_distr = 1;
							}
						   
						}else{
						    /** 新增代码  没有人邀请（即使没人邀请，关联表也要有一条记录）    start */
						    $distribution_data=array();
						    $distribution_data['member_id']=$res;
						    if(!empty($fenbu_code)){//如果是分社邀请进来的
						        $fenbu = M("fenbu")->where('invitation_code="'.$fenbu_code.'"')->find();
						        if(!empty($fenbu)){
        						    $distribution_data['fenbu_id']=$fenbu['id'];
						        }
						    }
						    $t = M('distribution')->add($distribution_data);
						    /** 新增代码  没有人邀请（即使没人邀请，关联表也要有一条记录）    end */
							$score_1 = 1;
							$score_2 = 1;
							$score_record_1 = 1;
							$score_record_2 = 1;
							$isadd_distr = 1;
						}
						if($res!==false && $isadd_distr!==false && $score_1!==false && $score_2!==false && $score_record!==false && $score_record_1!==false && $score_record_2!==false){
							M('member')->commit();
							M('score_record')->commit();
							M('distribution')->commit();
							$_SESSION['userid'] = $res;
							$_SESSION['member_class'] = $data['member_class'];
							echo json_encode(array('info'=>'注册成功','error'=>0));
							exit;
						}else{
							M('member')->rollback();
							M('score_record')->rollback();
							M('distribution')->rollback();
							echo json_encode(array('info'=>'注册失败','error'=>1));
							exit;
						}

					}else{
						echo json_encode(array('info'=>'该手机号和验证码匹配不一致','error'=>1));
						exit;
					}
				}
			}	
		}
    }

    //获取验证码
    public function regcode() {
		$mobile = I('mobile');
		$reg = M('member')->where("mobile='".$mobile."'")->find();
		if($reg){
			echo 1;exit;
		}
		$yzm = rand(111111,999999);
		$_SESSION['mobile'] = $mobile;
		$_SESSION['zcyzm'] = $yzm;
		$str = $this->send_sms("【股权帮】您的验证码是".$yzm."。如非本人操作，请忽略本短信。",$mobile);
		//print_r($str);exit;
		//$this->assign('yzm',$yzm);
		
		echo 0;exit;
	
	
    }
	

	
	
	
    //完善资料，地区选择
	public function area_choose(){
	

	    $area = M('area')->where('pid=0')->select();
	    foreach ($area as $k => $v) {
	    	$area[$k]['city_name'] = M('area')->where('pid='.$v['id'])->select();
	    }
		//print_r($area);exit;
		$this->assign("area", $area);
		$this->assign('back', I('back', 0));
		$this->display();
	}

	

	//行业选择
	public function industry_choose(){

		$data = M('industry')->where('pid=0')->order('sorts asc')->select();
        
        if(!empty($data)){

            foreach ($data as $k => $v) {
                $where['pid'] = $v['id'];
                $data[$k]['sub'] = M('industry')->where($where)->order('sorts asc')->select();
				
            }
        }
       //print_r($data);exit;
        $this->assign('back', I('back', 0));
        $this->assign('data',$data);
		$this->display();
	}


	//职位选择
	public function position_choose(){
		
		//如果已经完善过资料了，查询当前用户的职位
		$user_position = M('member')->where('id='.$_SESSION['userid'])->find();
		if($user_position['position']!=''){
			$user_position = $user_position['position'];
		}
		$this->assign('user_position', $user_position);
		$this->assign('back', I('back', 0));
		$this->display();
	}

	//完善资料页面
	public function perfect_information(){
		// 检测是否登陆
// 		$this->check_islogin();
		if($this->is_Weixin()){
    		$tools = new \JsApiPay();
    		$openid = $tools->GetOpenid();
    		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$this->getAccessToken()}&openid={$openid}&lang=zh_CN";
    		$userinfo = $this->http($url);
    		$userinfo = json_decode($userinfo,true);
    		if(isset($userinfo['subscribe']) && $userinfo['subscribe'] == 1){
    			$param = array('openId'=>$userinfo['openid'],
    					'userimg'=>$userinfo['headimgurl'],
    					'nickname'=>$userinfo['nickname']
    			);
    			$r = M('member')->where('id='.$_SESSION['userid'])->save($param);
    		}
		}
		$member = M('member')->field('invitation_code,source')->where('id='.$_SESSION['userid'])->find();
		//如果session中有诊断结果中的公司名称
		$diaUserInfo = $_SESSION['diaUserInfo'];
		if($diaUserInfo)
		{
		    //存在
		    $company = $diaUserInfo['project'];
		}
		$this->assign('company',$company);
		$this->assign('member',$member);
		$this->display();
		
	}

	public function userperfect_information(){

		// 检测是否登陆
		//$this->check_islogin();

		$data['company']=I('post.company');
		$data['position']=I('post.position');
		$data['industry']=I('post.industry');
		
		
		
		
		
		
		
		
		$data['city_name']=I('post.city_name');
		$data['reason']=I('post.reason');
		// $data['source']=I('post.source');
		$data['reason']=implode(",",$data['reason']);
		//dump($data['reason']);exit;
		$where['id']=$_SESSION['userid'];
		//var_dump($data);exit;
		$r=M('member')->where($where)->save($data);
		//echo M('member')->getLastSql();exit;
		if($r){
			$data1['member_class']=2;
			$res=M('member')->where($where)->save($data1);
			$_SESSION['member_class']=2;
			//查询当前用户是否有完善资料积分记录
			$counts = M('score_record')->where(array('member_id'=>$_SESSION['userid'],'source'=>'完善资料'))->count();
			//print_r($is);exit;
			if($counts==0){
				//获取完善资料积分规则
				$r=M('score_rules')->where('id=7')->find();
				//完善资料加积分
				M('member')->where('id='.$_SESSION['userid'])->setInc('score',$r['get_score']);
				//echo M('member')->getLastSql();exit;
				M('member')->where('id='.$_SESSION['userid'])->setInc('total_score',$r['get_score']);
				//完善注册加积分记录	
				$param = array('member_id'=>$_SESSION['userid'],
							   'score'=>$r['get_score'],
							   'score_type'=>'完善注册',
							   'source'=>'完善资料',
							   'addtime'=>date('Y-m-d H:i:s',time())
							   );
				$r=add_score_record($param);
			
					//是否存在上级代理
					$level = M('distribution')->where('member_id='.$_SESSION['userid'])->find();
					if($level['parent_id']!=''){
						$level_1 = M('member')->where('id='.$level['parent_id'])->find();
						//一级下线返积分
						//获取完善资料积分规则
						$wanshan_score=M('score_rules')->where('id=7')->find();
						//var_dump($r);					
						$add_score_1 = M('member')->where('id='.$level['parent_id'])->setInc('score',$wanshan_score['get_score']);
						$add_total_score_1 = M('member')->where('id='.$level['parent_id'])->setInc('total_score',$wanshan_score['get_score']);
						
						$score_array_1 = array('member_id'=>$level['parent_id'],
										 'score'=>$wanshan_score['get_score'],
										 'score_type'=>'拉新(一级下线完善资料)',
										 'source'=>'拉新(一级下线完善资料)',
										 'consumer_id'=>$_SESSION['userid']
										 ); 
						$score_record_1 = add_score_record($score_array_1);				
					}
					
					if($level['p_parent_id']!='')
					{
						$level_2 = M('member')->where('id='.$level['p_parent_id'])->find();
						//二级上线返积分
						//获取完善资料积分规则
						$wanshan_score=M('score_rules')->where('id=7')->find();
						//var_dump($r);
						$add_score_2 = M('member')->where('id='.$level['p_parent_id'])->setInc('score',$wanshan_score['get_score']  * 0.5);
						$add_total_score_2 = M('member')->where('id='.$level['p_parent_id'])->setInc('total_score',$wanshan_score['get_score'] * 0.5);
						
						$score_array_2 = array('member_id'=>$level['p_parent_id'],
										 'score'=>$wanshan_score['get_score'] * 0.5,
										 'score_type'=>'拉新(二级下线完善资料)',
										 'source'=>'拉新(二级下线完善资料)',
										 'consumer_id'=>$_SESSION['userid']
										 ); 
						$score_record_2 = add_score_record($score_array_2);	
					}
			
			}
			echo json_encode(array("code"=>0,"url"=>$_SESSION['redirectUrl']));exit;
// 			echo 0;exit;
		}
	}

	//注册成功页面
	public function reg_success(){
		// 检测是否登陆
		$appid = $this->getAppid();
		$timestamp = time();
		$nonceStr="BogLeUnion";
		$url = "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		$signature = sha1('jsapi_ticket='.$_SESSION['jsapi_ticket'].'&noncestr=BogLeUnion&timestamp='.$timestamp.'&url='.$url); //现在代码
		$js_list=array('appId'=>$appid,'timestamp'=>$timestamp,'nonceStr'=>$nonceStr,'signature'=>$signature);
		$this->assign("js_list",$js_list);
		$this->display();
	}
	
	//会员中心首页
	public function index()
	{
		if(!empty($_SESSION['userid']))
		{
			
			$res=M('member')->alias('m')->join('jbr_member_class c on m.member_class=c.id')->where("m.id='".$_SESSION['userid']."'")->field('m.*,c.class_name')->find();
            //dump($res);exit;
		   //判断是否微信浏览器打开
		  
	       if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false)
		   {
			   if(empty($res['openId']))
				{
					redirect('/index.php?m=Wxbind&a=wx_index');
				}
		   }
			
			
			
			//查询会员的vip到期时间
			if(!empty($res['vipendtime']))
			{
				if(strtotime($res['vipendtime'])<time() && $res['member_class']>2)
				{
					//更新会员的等级
					M('member')->where('id='.$res['id'])->setField('member_class',2);
					$_SESSION['member_class']=2;
				}
			}
			//会员中心我的成员
			$my_members_count =M('distribution')->where("parent_id=".$_SESSION['userid'].' or p_parent_id='.$res['id'])->count();
			
			//会员中心我的订单数量
			//待付款
			$count1=M('order')->where(array('member_id' =>$_SESSION['userid'] ,'status'=>0,'product_type'=>array("neq","4")))->count();
			//待使用
			$count2=M('order')->where(array('member_id' =>$_SESSION['userid'] ,'status'=>1,'product_type'=>array("neq","4")))->count();
			//已使用
			$count3=M('order')->where(array('member_id' =>$_SESSION['userid'] ,'status'=>2,'product_type'=>array("neq","4")))->count();
	
			$this->assign('my_members',$my_members_count);
			$this->assign('res',$res);
			$this->assign('count1',$count1);
			$this->assign('count2',$count2);
			$this->assign('count3',$count3);
			$this->display();
			
		}else{
		   
		 
			//判断是否微信浏览器打开
		  
	       if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false)
		   {
	
			    $tools = new \JsApiPay();
				$openid = $tools->GetOpenid(); 
			    //var_dump($tools);die;
				$u=M('member')->alias('m')->join('jbr_member_class c on m.member_class=c.id')->where("m.openId='".$openid."'")->field('m.*,c.class_name')->find();
				//echo M('member')->getLastSql();
				//print_r($u);
				if(!empty($u))
				{
					$_SESSION['userid'] = $u['id'];
					$_SESSION['member_class'] = $u['member_class'];
					
					redirect('/index.php?m=User&a=index');
				}
				else
				{
					redirect('/index.php?m=Wxbind&a=wx_index');
				} 
		   }
		   else
		   {
		
			   redirect('/index.php?m=User&a=login');
		   }
		}
	}
	
	/**
	 * 我的众筹活动列表
	 */
	public function zc(){
		// 检测是否登陆
		$this->check_islogin();
		$res = get_my_funding($_SESSION['userid']);
		foreach ($res as $k=>$r){
		    switch ($r['status']) {
		        case 0:
		            $data['doing'][]=$r;//进行中的活动
		        break;
		        case 1:
		            $data['done'][]=$r;//已完成的活动
		        break;
		        case -1:
		            $data['late'][]=$r;//已过期的活动
		        break;
		    }
		}
		$this->assign('data',$data);
		$this->display();
	}
	
	/**
	 * 我的股权诊断器列表
	 */
	public function zdq(){
	    $this->check_islogin();
	    $userid = $_SESSION['userid'];
	    $data = get_my_zdq_List($userid);
		$this->assign('data',$data);
	    $this->display();
	}
	
	//会员基本资料
	public function information(){
		// 检测是否登陆
		$this->check_islogin();
		$user = M('member')->where('id='.$_SESSION['userid'])->find();
		//print_r($user);exit;
		$user['mobile']=str_replace(substr($user['mobile'],3,4),"****",$user['mobile']);
		$this->assign('user',$user);
		$this->display();
	}
	
	//修改会员资料
	public function userinformation(){
		// 检测是否登陆
		$this->check_islogin();
		$data['userimg'] = I('post.userimg');
		$data['truename'] = trim(I('post.truename'));
		$data['company'] = trim(I('post.company'));
		$data['position'] = I('post.position');
		$data['industry'] = I('post.industry');
		$data['province_name'] = I('post.province_name');
		$data['city_name'] = I('post.city_name');
		setcookie('truename','');
		setcookie('company','');
		setcookie('position','');
		setcookie('industry','');
		setcookie('province_name','');
		setcookie('city_name','');
		//var_dump($data);exit;
		$where['id'] = $_SESSION['userid'];
		$r=M('member')->where($where)->save($data);
		//echo M('member')->getLastsql();exit;
		if($r!==false){
			//查询当前用户是否有完善资料积分记录
			$is = M('score_record')->where(array('member_id'=>$_SESSION['userid'],'source'=>'完善资料'))->find();
			
			//print_r($is);exit;
			if(empty($is)){
				
				//获取完善资料积分规则
				$r=M('score_rules')->where('id=7')->find();
				//var_dump($r);
				//完善资料加积分
				M('member')->where('id='.$_SESSION['userid'])->setInc('score',$r['get_score']);
				//echo M('member')->getLastSql();exit;
				M('member')->where('id='.$_SESSION['userid'])->setInc('total_score',$r['get_score']);
						//完善注册加积分记录	
						$param = array('member_id'=>$_SESSION['userid'],
									   'score'=>$r['get_score'],
									   'score_type'=>'完善注册',
									   'source'=>'完善资料',
									   'addtime'=>date('Y-m-d H:i:s',time())
									   );
						$r=add_score_record($param);
				
				
				//$invitation_code=I('post.invitation_code');
				//邀请注册返积分
				//if($invitation_code!=''){
					
					//$invitation_code=I('post.invitation_code');
					//是否存在上级代理
					$level = M('distribution')->where('member_id='.$_SESSION['userid'])->find();
					if($level['parent_id']!=''){
						$level_1 = M('member')->where('id='.$level['parent_id'])->find();
						//一级下线返积分
						//获取完善资料积分规则
						$wanshan_score=M('score_rules')->where('id=7')->find();
						//var_dump($r);					
						$add_score_1 = M('member')->where('id='.$level['parent_id'])->setInc('score',$wanshan_score['get_score']);
						$add_total_score_1 = M('member')->where('id='.$level['parent_id'])->setInc('total_score',$wanshan_score['get_score']);
						
						$score_array_1 = array('member_id'=>$level['parent_id'],
										 'score'=>$wanshan_score['get_score'],
										 'score_type'=>'拉新(一级下线完善资料)',
										 'source'=>'拉新(一级下线完善资料)'
										 ); 
						$score_record_1 = add_score_record($score_array_1);				
					}
					
					if($level['p_parent_id']!='')
					{
						$level_2 = M('member')->where('id='.$level['p_parent_id'])->find();
						//二级上线返积分
						//获取完善资料积分规则
						$wanshan_score=M('score_rules')->where('id=7')->find();
						//var_dump($r);
						$add_score_2 = M('member')->where('id='.$level['p_parent_id'])->setInc('score',$wanshan_score['get_score']  * 0.5);
						$add_total_score_2 = M('member')->where('id='.$level['p_parent_id'])->setInc('total_score',$wanshan_score['get_score'] * '0.5');
						
						$score_array_2 = array('member_id'=>$level['p_parent_id'],
											   'score'=>$wanshan_score['get_score'] * 0.5,
											   'score_type'=>'拉新(二级下线完善资料)',
											   'source'=>'拉新(二级下线完善资料)'
										      ); 
						$score_record_2 = add_score_record($score_array_2);	
					}
				//}
			}
			
			echo 0;exit;
			
		}else{
			echo 1;exit;
		}
	}

	//签到前
	public function sign(){
		// 检测是否登陆
		$this->check_islogin();
		$where['member_id']=$_SESSION['userid'];
		$counts=M('sign_record')->where($where)->count();
		$total_scores=M('member')->where('id='.$_SESSION['userid'])->getField('total_score');
		//var_dump($total_scores);exit;
		//var_dump($counts);exit;
		$this->assign('counts',$counts);
		$this->assign('total_scores',$total_scores);
		$this->display();
	}

	//签到
	public function sign_before(){
		// 检测是否登陆
		$this->check_islogin();
		$where['member_id']=$_SESSION['userid'];
		$r =  M('sign_record')->where(array('member_id'=>$_SESSION['userid'],'sign_date'=>date('Y-m-d',time())))->find();
		//var_dump($r);exit;
		$counts=M('sign_record')->where($where)->count();
		$total_scores=M('member')->where('id='.$_SESSION['userid'])->getField('total_score');
		$sign_score=M('ScoreRules')->where("name='签到'")->find();
		//var_dump($total_scores);exit;
		$this->assign('r',$r);
		$this->assign('counts',$counts);
		$this->assign('total_scores',$total_scores);
		$this->assign('sign_score',$sign_score);
		$this->display();
	}

	//签到
	public function usersign(){
		// 检测是否登陆
		$this->check_islogin();
		$member_id=I('member_id');
		$r = sign($member_id);
		//print_r($res);exit;
		if($r==0){
				
			echo 0;exit;
		}elseif($r==1){
			echo 1;exit;
		}
		elseif($r==2){
			echo 2;exit;
		}
		elseif($r==3){
			echo 3;exit;
		}
			
			
	}


	//会员中心我的下线
	public function my_member(){
		// 检测是否登陆
		$this->check_islogin();
		//$_SESSION['userid']=10;
		$memberid=$_SESSION['userid'];
		$my_members=get_my_members($memberid);
		//var_dump($my_members);exit;
		$this->assign('my_members',$my_members);
		$this->display();
	}

	//邀请社员页面
	public function invite_members(){
		// 检测是否登陆
		$this->check_islogin();
		$this->display();
	}

	public function userinvite_members(){
		// 检测是否登陆
		$this->check_islogin();
		//验证手机号和验证码
		$truename = I('truename');
		$mobile = I('mobile');
		//手机查询
		$reg = M('member')->where("mobile='".$mobile."' and password='".$password."'")->find();
		if($reg){
			echo 2;exit;
		}else{
			$yzm = I('yzm');
			if($_SESSION['zcyzm']==$yzm&&$_SESSION['mobile']==$mobile){
				unset($_SESSION['zcyzm']);
				//存进会员表
				$data['truename']=I('truename');
		    	$data['mobile']=I('mobile');
		    	$data['password']=MD5(I('password'));
		    	$data['regtime']=date('Y-m-d H:i:s',time());
		    	$data['member_class']=4;

		    	$res = M('member')->add($data);
		    	unset($_SESSION['openId']);

		    	  $_SESSION['userid']=$res;
				  // $_SESSION['openId']=$data['openId'];
				  // $_SESSION['nickname']=$data['nickname'];
				  // $_SESSION['userimg']=$data['userimg'];
		    	//var_dump($res);exit;
				echo 0;exit;
			}else{
				echo 1;exit;
			}
		}
	}

	//会员登陆页面
    public function login()
	{
	    
// 	    $login_type = I('get.type'); // 获取登录过来的方式
// 	    if($login_type == 'zdq')
// 	    {
// 	        $this->display();exit;
// 	    }
	    
	    $url = isset($_SESSION['redirectUrl'])?$_SESSION['redirectUrl']:"http://". $_SERVER['HTTP_HOST'] . "/index.php?m=User&a=index";//记录跳转过来的地址
		if(strpos($url,'Wxbind') || strpos($url,'reg') || strpos($url,'login')){//用户关联界面或注册界面过来即跳转到个人中心
			$url='http://' . $_SERVER['HTTP_HOST'] . '/index.php?m=User&a=index';
		}
		if(!empty($_SESSION['json_info_wx']))
		{ //从Wxbind（微信关联）页面跳转过来的
			$member = M('member')->where("openId='".$_SESSION['json_info_wx']['openid']."'")->find();
			if(!empty($member)){
				header("location:".$url);exit;//已关联
			}else{
				//未关联
				if(!empty($_SESSION['userid'])){
					$param = array('openId'=>$_SESSION['json_info_wx']['openid'],
				                  'userimg'=>$_SESSION['json_info_wx']['headimgurl'],
							      'nickname'=>$_SESSION['json_info_wx']['nickname']
							  );
					$r = M('member')->where('id='.$_SESSION['userid'])->save($param);					
					header("location:".$url);exit;
				}else{
					$this->display();
				}
			}
		}else{
			//判断是否微信浏览器打开
	       if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false)
		   {
// 		        M('test')->add(array('content'=>"微信浏览器打开用户登录前面的url是3：".$url));
				$tools = new \JsApiPay();
				$openid = $tools->GetOpenid();
				$member1 = M('member')->where("openId='".$openid."'")->find();
				if(!empty($member1))
				{
					$_SESSION['userid'] = $member1['id']; 
					$_SESSION['member_class'] = $member1['member_class']; 
// 					$this->redirect('User/task');//跳到赚积分页面
// 					$this->redirect($url);//跳到个人中心页面	
// 					M('test')->add(array('content'=>"微信浏览器打开用户登录前面的url是4：".$url));
					header("location:".$url);exit;					
				}else{
					$this->display();
				}
		   }
		   else
		   {
				$this->display();//未登录
		   }
			
			
		}
	}

	//登录
	public function userlogin()
	{
		if(IS_AJAX)
		{
		    $data = I('post.');	
			/*$mobile = I('mobile');
			$password = md5(I('password'));*/

			$user = M('member')->where("mobile='".$data['mobile']."'")->find();
			if(!$user)
			{
			    echo json_encode(array("code"=>1,"msg"=>"手机号错误"));exit;
// 				echo 1;exit;    //手机号不存在
			}

			if($user['password']!=md5($data['password']))
			{
			    echo json_encode(array("code"=>2,"msg"=>"密码错误"));exit;
// 				echo 2;exit;    //密码错误
			}
			
			if($user['islock']=='1')
			{
			    echo json_encode(array("code"=>3,"msg"=>"该账号已被锁定,不允许登录"));exit;
// 				echo 3;exit;   //用户被锁定
			}
			
			if($_SESSION['json_info_wx'])           //判断是否微信绑定
			{
				$param = array('openId'=>$_SESSION['json_info_wx']['openid'],
				               'userimg'=>$_SESSION['json_info_wx']['headimgurl'],
							   'nickname'=>$_SESSION['json_info_wx']['nickname']
							  );
		        
				$r = M('member')->where('id='.$user['id'])->save($param);
				
				$_SESSION['openId'] = $_SESSION['json_info_wx']['openid'];
			}
		
			$_SESSION['userid']=$user['id'];
			$_SESSION['member_class']=$user['member_class'];			
			echo json_encode(array("code"=>0,"url"=>$_SESSION['redirectUrl']));exit;
// 			echo 0;exit;
			
		}
	
	}

	
	//找回密码页面1
	public function find_password1(){
		$this->display();
	}

	//找回密码1
	public function find_pass1(){
		$mobile = I('mobile');
		//手机查询
		$reg = M('member')->where("mobile='".$mobile."'")->find();
		if($reg){
			$yzm = I('yzm');
			if($_SESSION['zcyzm']==$yzm&&$_SESSION['mobile']==$mobile){
				unset($_SESSION['zcyzm']);
				echo 0;exit;
			}else{
				echo 1;exit;
			}
		}else{
			echo 2;exit;
		}
	}

	//找回密码页面2
	public function find_password2(){
		if(empty($_SESSION['mobile'])){
			header("Location: /index.php?m=User&a=find_password1");exit;
		}
		$this->display();
	}

	//找回密码2
	public function find_pass2()
	{
		if(empty($_SESSION['mobile'])){
			header("Location: /index.php?m=User&a=find_password1");exit;
		}
		$mobile = $_SESSION['mobile'];
		//var_dump(I('password'));exit;
		$password = MD5(I('password'));
		$res = M('member')->where("mobile='".$mobile."'")->data('password='.$password)->save();
		if($res){
			unset($_SESSION['zcyzm']);
			unset($_SESSION['mobile']);
			echo 0;exit;
		}else{
			echo 1;exit;
		}
	}

	//找回密码页面3
	public function find_password3(){
		$this->display();
	}



	/*
	 **删除空格
	 */
	function trimall($str) {
		$qian = array(" ", "　", "\t", "\n", "\r");
		$hou = array("", "", "", "", "");
		return str_replace($qian, $hou, $str);
	}

	//我要入社
	public function rushe(){
		$this->check_islogin();
		
		$this->display();
	}


	//会员中心积分明细
	public function score_detail(){
		// 检测是否登陆
		$this->check_islogin();
		
		//会员信息
		$u = M('member')->where('id='.$_SESSION['userid'])->find();
		
		//积分明细
		$list = M('score_record')->alias('sr')->join('jbr_member m on m.id=sr.member_id')->join('jbr_member_class mc on mc.id=m.member_class')->where('sr.member_id='.$_SESSION['userid'])->field('sr.*,m.truename,mc.class_name')->order('sr.addtime desc')->select();
		
		foreach($list as $k=>$v)
		{
			$list[$k]['score_type'] = $this->replace($v['score_type']);
			$list[$k]['source'] = $this->replace($v['source']);
		}
		
		$this->assign('list',$list);
		$this->assign('u',$u);
		$this->display();
	}
	//会员中心积分兑换
	public function exchange(){
		// 检测是否登陆
		$this->check_islogin();
		//会员信息
		$u = M('member')->where('id='.$_SESSION['userid'])->find();
		$catid = I('get.catid', 0, 'intval');
		//dump($data);exit;
		$this->assign('u',$u);
		$this->display();
	}
	
	/***字符串替换***/
	function replace($str)
	{
		$str1 = str_replace("一级下线","我的朋友",$str);
		$str2 = str_replace("一级","我的朋友",$str1);
		$str3 = str_replace("二级下线","我朋友的朋友",$str2);
		$str4 = str_replace("二级","我朋友的朋友",$str3);
		
		return $str4;
		
	}
	
	
	
	
	//时间范围查询积分明细
	public function chaxun(){
		// 检测是否登陆
		$this->check_islogin();
		$beginTime = I('beginTime').' 00:00:00';
		$endTime = I('endTime').' 23:59:59';
		$where = 'member_id='.$_SESSION['userid'].' and addtime>="'.$beginTime.'" and addtime<="'.$endTime.'"';
		//查询时间范围内的积分明细
		$res = M('score_record')->join('jbr_member on jbr_score_record.member_id=jbr_member.id')->join('jbr_member_class on jbr_member.member_class=jbr_member_class.id')->where($where)->field('jbr_score_record.source,jbr_member.truename,jbr_member_class.class_name,jbr_score_record.addtime,jbr_score_record.score,jbr_score_record.score_type')->select();
		//echo M('score_record')->getlastsql();exit;
		foreach($res as $k=>$v)
		{
			$res[$k]['score_type'] = $this->replace($v['score_type']);
			$res[$k]['source'] = $this->replace($v['source']);
		}
		
		echo json_encode($res);exit;
	}

	//会员中心我的任务
	public function task()
	{
		// 检测是否登陆
		$this->check_islogin();
		//会员信息
		$u=M('member')->where('id='.$_SESSION['userid'])->find();
		
		//日常任务
		//1.签到
		$sign=M('sign_record')->where(array('member_id'=>$_SESSION['userid'],'sign_date'=>date("Y-m-d",time())))->find();
		//print_r($sign);exit;
		//2.分享视频
		$video=M('score_record')->where('member_id='.$_SESSION['userid'].' and share_type_id =3 and addtime>="' . date('Y-m-d 00:00:00', time()) . '" and addtime<="' . date('Y-m-d 23:59:59"'))->count();
		//print_r($video);exit;
		//3.分享课程
		$course=M('score_record')->where('member_id='.$_SESSION['userid'].' and share_type_id =4 and addtime>="' . date('Y-m-d 00:00:00', time()) . '" and addtime<="' . date('Y-m-d 23:59:59"'))->count();
		//4.分享观点
		$guandian=M('score_record')->where('member_id='.$_SESSION['userid'].' and share_type_id =5 and addtime>="' . date('Y-m-d 00:00:00', time()) . '" and addtime<="' . date('Y-m-d 23:59:59"'))->count();
		//5.分享股权帮
		$guquanbang=M('score_record')->where('member_id='.$_SESSION['userid'].' and share_type_id =6 and addtime>="' . date('Y-m-d 00:00:00', time()) . '" and addtime<="' . date('Y-m-d 23:59:59"'))->count();
		
		$this->assign('u',$u);
		$this->assign('score',$score);
		$this->assign('sign',$sign);
		$this->assign('video',$video);
		$this->assign('course',$course);
		$this->assign('guandian',$guandian);
		$this->assign('guquanbang',$guquanbang);
		$this->display();
	}


	//积分排行
	public function score_ranking(){
		// 检测是否登陆
		$this->check_islogin();
		/*********总排名**********/
		//会员信息
		$u=M('member')->where('id='.$_SESSION['userid'])->find();
		//除内部员工之外的所有会员
		$data2=M('member')->alias('m')->join('jbr_member_class c on m.member_class=c.id')->field('m.id,m.userimg,m.nickname,m.truename,c.class_name,m.total_score')->order('m.total_score desc')->where("m.id not in(1164,147,153,152,150,151,146,154,156,158,159,160,161,162,171,220,221,267,877,880,881,882,883,884,889,921,940,988,1410,1428,1823,278)")->limit(200)->select();
		$data=M('member')->alias('m')->join('jbr_member_class c on m.member_class=c.id')->field('m.id,m.userimg,m.nickname,m.truename,c.class_name,m.total_score')->order('m.total_score desc')->where("m.id not in(1164,147,153,152,150,151,146,154,156,158,159,160,161,162,171,220,221,267,877,880,881,882,883,884,889,921,940,988,1410,1428,1823,278)")->limit(5)->select();
		//所有会员
		//$data1=M('member')->alias('m')->join('jbr_member_class c on m.member_class=c.id')->field('m.id,m.userimg,m.nickname,c.class_name,m.total_score')->order('m.total_score desc')->select();
		//echo M('member')->getLastSql();exit;
		//var_dump($data);exit;
		foreach ($data2 as $k=>$v){
			if($v['id']==$_SESSION['userid']){
				$u['paiming']=$k+1;
			}
		}
		/*************日排名****************/
		$yesterday=date('Y-m-d H:i:s',strtotime(date('Y-m-d',time())));//今日0点时间
		$tomorrow=date('Y-m-d H:i:s',strtotime(date('Y-m-d',time()+60*60*24)));
		$dsql="select *,sum(score) total_score from
			(select a.nickname,a.id,a.truename,a.userimg,b.score,c.class_name from jbr_member a
			left join jbr_score_record b on a.id=b.member_id 
			left join jbr_member_class c on a.member_class=c.id
			where b.addtime between '{$yesterday}' and '{$tomorrow}')
			as total where id not in(1164,147,153,152,150,151,146,154,156,158,159,160,161,162,171,220,221,267,877,880,881,882,883,884,889,921,940,988,1410,1428,1823,278)
			group by total.id order by total_score desc limit 3;";
		$ddata=M('member')->query($dsql);
		/*************周排名****************/
		$monday=date('Y-m-d H:i:s',strtotime('last monday'));//本周一0点时间
		$sunday=date('Y-m-d H:i:s',strtotime('next sunday'));//本周日0点时间
		$wsql="select *,sum(score) total_score from
			(select a.nickname,a.id,a.truename,a.userimg,b.score,c.class_name from jbr_member a
			left join jbr_score_record b on a.id=b.member_id 
			left join jbr_member_class c on a.member_class=c.id
			where b.addtime between '{$monday}' and '{$sunday}')
			as total where id not in(1164,147,153,152,150,151,146,154,156,158,159,160,161,162,171,220,221,267,877,880,881,882,883,884,889,921,940,988,1410,1428,1823,278)
			group by total.id order by total_score desc limit 3;";
		$wdata=M('member')->query($wsql);
		/*************月排名****************/
		$month_start=date('Y-m-01 H:i:s', strtotime(date("Y-m-d")));
		$month_end=date('Y-m-d', strtotime("$month_start +1 month -1 day"));
		$msql="select *,sum(score) total_score from
			(select a.nickname,a.id,a.truename,a.userimg,b.score,c.class_name from jbr_member a
			left join jbr_score_record b on a.id=b.member_id 
			left join jbr_member_class c on a.member_class=c.id
			where b.addtime between '{$month_start}' and '{$month_end}')
			as total where id not in(1164,147,153,152,150,151,146,154,156,158,159,160,161,162,171,220,221,267,877,880,881,882,883,884,889,921,940,988,1410,1428,1823,278)
			group by total.id order by total_score desc limit 3;";
		$mdata=M('member')->query($msql);
		//dump($u);exit;
		$this->assign('ddata',$ddata);
		$this->assign('wdata',$wdata);
		$this->assign('mdata',$mdata);
		$this->assign('u',$u);
		$this->assign('data',$data);
		$this->display();
	}
	//积分兑换
	public function score_exchange(){
		// 检测是否登陆
		$this->check_islogin();
		//会员信息
		$u=M('member')->where('id='.$_SESSION['userid'])->find();
		$video=M('video')->select();
		$this->assign('u',$u);//用户信息
		$this->assign('data',$video);//视频信息
		$this->display();
	}

	//订单
	public function order(){
		// 检测是否登陆
		$this->check_islogin();
	//var_dump($_GET);
		
		if(isset($_GET['status'])){
			$type=$_GET['status'];
		}else{
			$type='all';
		}
		$userid=$_SESSION['userid'];
	
		$data = get_my_order($userid,$type);
		
		foreach ($data as $k=>$d){
		    if($d['product_type'] == 4){
		        unset($data[$k]);
		    }
		}
		//dump($data);exit;
		
		$this->assign('data',$data);
		$this->display();
	}

	//取消订单
	public function userquxiao(){
		// 检测是否登陆
		$this->check_islogin();
		$where['id']=I('id');
		$r=M('order')->where($where)->delete();
		if($r){
			echo 0;exit;
		}else{
			echo 1;exit;
		}
	}

	//订单详情
	public function orderdetails()
	{
		// 检测是否登陆
		$this->check_islogin();
		$id=I('get.id');
		
		$res=M('order')->alias('o')->join('LEFT JOIN jbr_courses c on o.product_id=c.id')->where('o.id='.$id)->field('o.*,c.title,c.teacher,c.city,c.start_time,c.thumb,c.description')->find();
		
		if($res['product_type']=='2')
		{
			//$res['price'] = $res['score'];
			$res['title'] = '积分充值';
			$res['thumb'] ='/statics/default/images/jfcz.jpg';  //图片	 
		}
		
		if($res['product_type'] == '5')    //股权咨询产品
		{
			$res['price'] = $res['score'];
		}
		
		if($res['product_type'] == '16')
		{
		    $res['title'] = '社员升级';
            $res['thumb'] ='/statics/default/images/logo1.png';  //图片	 			
		}
		
		if($res['mobile']=='')
		{
			$res['mobile'] = M('member')->where('id='.$res['memeber_id'])->getField('mobile');
		}
		
		
// 		print_r($res);
		$this->res=$res;
		$this->display();
	}

	//发票信息
	public function invoice(){
		// 检测是否登陆
		$this->check_islogin();
		$this->display();
	}

	//提交发票
	public function tjinvoice(){
		// 检测是否登陆
		$this->check_islogin();
		$data['header']=I('header');
		$data['content']=I('content');
		$data['addressee']=I('addressee');
		$data['tel']=I('tel');
		$data['area']=I('area');
		$data['address']=I('address');
		$where['verification_code']=I('verification_code');
		$r=M('order')->where($where)->find();
		if($r){
			echo 2;exit;
		}else{
			$res=M('order')->where($where)->data($data)->save();
			//echo M('order')->getLastSql();exit;
			if($res){
				echo 0;exit;
			}else{
				echo 1;exit;
			}
		}
		$this->display();
	}

	//我的钱包
	public function purse()
	{
		// 检测是否登陆
		$this->check_islogin();
		$where['id']=$_SESSION['userid'];
		//总收入
		//$where['id']=10;
		$purse=M('member')->where($where)->getField('commission');
		//var_dump($purse);exit;
		//提现记录
		//$where['member_id']=10;
		$amount=M('withdrawals_record')->where('member_id='.$_SESSION['userid'])->getField('amount',true);
		$num = 0;
		foreach ($amount as $k =>$v) {
			$num = $num+$v;
		}
		//var_dump($num);exit;
		$this->assign('purse',$purse);
		$this->assign('num',$num);
		$this->display();
	}

	//余额提现
	public function tixian()
	{
		// 检测是否登陆
		$this->check_islogin();
		$u = M('member')->where('id='.$_SESSION['userid'])->find();
		$this->assign('u',$u);
		$this->display();
	}

	//
	public function usertixian()
	{
		// 检测是否登陆
		$this->check_islogin();
		$data['member_id']=$_SESSION['userid'];
		$data['out_way']=I('out_way');
		$data['account']=I('account');
		$data['amount']=I('amount');
		$data['beizhu']=I('beizhu');
		$data['addtime']=date('Y-m-d H:i:s',time());
		$data['status']=0;
		
		$u = M('member')->where('id='.$_SESSION['userid'])->find();
		
		if((int)$u['commission']<$data['amount'])
		{
			echo json_encode(array('code'=>1,'msg'=>'提现金额大于可提现金额！'));exit;
		}
		
		$res=M('withdrawals_record')->data($data)->add();
		if($res){
			echo json_encode(array('code'=>0,'msg'=>'提现成功！'));exit;
		}else{
			echo json_encode(array('code'=>2,'msg'=>'提现失败！'));exit;
		}
	
	}

	//提现明细
	public function Present_detail(){
		// 检测是否登陆
		$this->check_islogin();
		$where['member_id']=$_SESSION['userid'];
		//$where['member_id']=10;
		$data=M('withdrawals_record')->where($where)->order('addtime desc')->select();
		
		foreach($data as $k=>$v)
			 {
	         
			 //提现状态
		     switch ($v['status']){
				case 0:
					$data[$k]['rstatus'] = '待审核';
					break;
				case 1:
						$data[$k]['rstatus'] = '处理中';
						break;
				case 2:
					$data[$k]['rstatus'] = '已拒绝';
					break;
				case 3:
					$data[$k]['rstatus'] = '提现成功';
					break;
			    }
			
			}
		$this->assign('data',$data);
		$this->display();
	}

	//提现成功
	public function success()
	{
		// 检测是否登陆
		$this->check_islogin();
		$id = I('get.id');
		$r = M('withdrawals_record')->alias('wr')->join('jbr_member m on m.id=wr.member_id')->where('wr.id='.$id)->field('wr.*,m.truename')->find();
		
		$this->assign('r',$r);
		$this->display();
	}

	//提现失败
	public function fail()
	{
		// 检测是否登陆
		$this->check_islogin();
		$id = I('get.id');
		$r = M('withdrawals_record')->alias('wr')->join('jbr_member m on m.id=wr.member_id')->where('wr.id='.$id)->field('wr.*,m.truename')->find();
		
		$this->assign('r',$r);
		$this->display();
	}

	//提现审核中
	public function review()
	{
		// 检测是否登陆
		$this->check_islogin();
		$id = I('get.id');
		$r = M('withdrawals_record')->alias('wr')->join('jbr_member m on m.id=wr.member_id')->where('wr.id='.$id)->field('wr.*,m.truename')->find();
		
		$this->assign('r',$r);
		$this->display();
	}

	//提现处理中
	public function processing()
	{
		// 检测是否登陆
		$this->check_islogin();
		$id = I('get.id');
		$r = M('withdrawals_record')->alias('wr')->join('jbr_member m on m.id=wr.member_id')->where('wr.id='.$id)->field('wr.*,m.truename')->find();
		
		$this->assign('r',$r);
		$this->display();
	}

	//代理申请
	public function apply_agent(){
		$this->display();
	}

	//申请加入合伙社员
	public function hhsy(){
		$this->display();
	}

	//提交合伙社员订单
	public function userhhsy(){
		$data['member_id']=$_SESSION['userid'];
		$r=M('member')->where('id='.$_SESSION['userid'])->getField('member_class',true);
		//var_dump($r);exit;
		if($r=4){
			echo 2;exit;
		}
		$data['product_type']="加入合伙社员订单";
		$data['pay_type']=I('pay_type');
		$data['addtime']=date('Y-m-d H:i:s',time());
		$data['pay_time']=date('Y-m-d H:i:s',time());
		$res=M('order')->data($data)->add();
		if($res){
			echo 0;exit;
		}else{
			echo 1;exit;
		}
		$this->display();
	}

	//邀请二维码
	public function invite()
	{
		if(empty($_SESSION['userid']))
		{

			/*  if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) 
			 { 
				 redirect('/index.php?m=Wxbind&a=wx_index');
			 }
			 else
			 {
			 } */
				redirect('/index.php?m=User&a=login');
		}
	    //用户信息
		if($_SESSION['userid'])
		{
			$user = M('member')->where('id='.$_SESSION['userid'])->find();
			$this->assign('user', $user);
		}
		
		//微信分享相关参数
	    $time = time();
	    $share_url = 'http://'.$_SERVER['HTTP_HOST'].'/index.php?m=User&a=invite';
//            dump($share_url);
	    $signature = sha1('jsapi_ticket='.$_SESSION['jsapi_ticket'].'&noncestr=BogLeUnion&timestamp='.$time.'&url='.$share_url);
//            dump($_SESSION['jsapi_ticket']);
	    $this->assign('time', $time);
	    $this->assign('share_url', $share_url);
	    $this->assign('signature', $signature);
	    $this->assign('jsapi_ticket', $_SESSION['jsapi_ticket']);
	    $this->assign('appid', $this->getAppid());
	    $this->display();
	}

	//电子门票
	public function electronic_ticket(){
		$where['member_id']=$_SESSION['userid'];
		$where['jbr_order.status']=1;
		$where['jbr_order.product_type']=1;
		$data=M('order')->join('jbr_courses on jbr_order.product_id=jbr_courses.id')->where($where)->field('jbr_courses.thumb,jbr_courses.teacher,jbr_order.price,jbr_order.verification_code,jbr_courses.title,jbr_courses.start_time,jbr_courses.address_info,jbr_order.status,jbr_order.verification_code')->select();
		//echo M('order')->getLastSql();
		//var_dump($data);exit;
		$this->assign('data',$data);
		$this->display();
	}

	//电子门票信息
	public function ticket_information(){
		$this->display();
	}

	//微信分享成功回调处理
	public function share_success()
	{
		if(IS_AJAX){
			
			$data = I('post.');
			//$_SESSION['userid'] = 1;
		    if($_SESSION['userid']=='')
			{
			   echo json_encode(array('code'=>1,'msg'=>'尚未登录，登录后分享可获得积分！'));exit;	
			}
			//查询积分规则和每日最多获取积分次数
			$rule = M('score_rules')->where('id='.$data['share_type'])->find();
			//查询当前用户当日分享记录
			$rec = M('score_record')->where('member_id='.$_SESSION['userid'].' and share_type_id ='.$data['share_type'].' and addtime>="' . date('Y-m-d 00:00:00', time()) . '" and addtime<="' . date('Y-m-d 23:59:59"'))->select();
			
			//echo M('score_record')->getLastsql();die;
			
			if((int)count($rec)<(int)$rule['max_num_day'] && $_SESSION['userid'])  //未超过每日最大获得积分数   
			{
				$param = array('member_id'=>$_SESSION['userid'],
				               'score'=>$rule['get_score'],
							   'score_type'=>'分享奖励',
							   'source'=>$rule['name'],
							   'share_type_id'=>$data['share_type'],
							   'addtime'=>date('Y-m-d H:i:s',time())
							   );
				//添加积分记录
                $r = M('score_record')->add($param);
                //增加会员积分
				if($r)
				{ 
			        //可用积分
				   	M('member')->where('id='.$_SESSION['userid'])->setInc('score',$rule['get_score']);
					//累计积分
					M('member')->where('id='.$_SESSION['userid'])->setInc('total_score',$rule['get_score']);
				}
				
			}
			
			echo  json_encode(array('code'=>0,'share_num'=>count($rec)));exit;
		}
		
	}
    
	
	/**************************************************************/
	/***************************账户安全部分***********************/
    /************************2016-11-30   by zh *******************/ 
	
	
	
	
	
	//账户安全--首页
	public function safe_index()
	{
		$this->check_islogin();
		$user = M('member')->where('id='.$_SESSION['userid'])->find();
		
		$this->assign('user',$user);
		$this->display();
	}
	
	
	//账户安全--登录密码
	public function login_pass()
	{
	    $this->check_islogin();
		
		
		$this->display();
	}
	
	//账户安全--修改登录密码
	public function edit_login_pass()
	{
		if(IS_AJAX)
		{
		   $data = I('post.');
		   
		   $u = M('member')->where('id='.$_SESSION['userid'])->find();
		 
		   if(md5($data['oldpass'])!=$u['password'])
		   {
			  echo json_encode(array('code'=>1,'msg'=>'原密码输入错误'));exit;
		   }
		   
		   if($data['newpass']!=$data['c_newpass'])
		   {
			  echo json_encode(array('code'=>2,'msg'=>'两次新密码输入不一致！'));exit;   
		   }
		   
		   $r = M('member')->where('id='.$_SESSION['userid'])->setField('password',md5($data['newpass']));
		   
		   echo json_encode(array('code'=>0,'msg'=>'密码修改成功！'));exit; 
		}
	}
	
	
	//账户安全--验证原手机号
	public function safe_mobile()
	{
		$this->check_islogin();
		
		$u = M('member')->where('id='.$_SESSION['userid'])->find();
		$mobile = substr($u['mobile'] ,0,3).'***'.substr($u['mobile'],-4);
		$this->assign('mobile',$mobile);
		$this->assign('t_mobile',$u['mobile']);
		$this->display();
	}
	
	//账户安全--验证原手机号
	public function check_old_mobile()
	{
		if(IS_AJAX)
		{
			$data = I('post.');
			
			if($data['yzm']!=$_SESSION['yzm'])
			{
				echo json_encode(array('code'=>1,'msg'=>'验证码错误'));exit; 
			}
			
			
			echo json_encode(array('code'=>0,'msg'=>'验证成功'));exit; 
		}
	}
	 
	//账户安全--绑定新手机号
	public function new_mobile()
	{
	   $this->check_islogin();
	   
	   $this->display();
	}
      
    //账户安全--绑定新手机号
	public function set_new_mobile()
	{
	   if(IS_AJAX)
	   {
		   $data = I('post.');
		   $u = M('member')->where('id='.$_SESSION['userid'])->find();
		   if($data['mobile'] == $u['mobile'])
		   {
			   echo json_encode(array('code'=>1,'msg'=>'号码与原手机号码重复！'));exit;    
		   }
		   
		   if($data['mobile']!=$_SESSION['mobile'])
		   {
			   echo json_encode(array('code'=>2,'msg'=>'号码与接收短信的号码不一致！'));exit;   
		   }
		   
		   if($data['yzm']!=$_SESSION['yzm'])
		   {
			   echo json_encode(array('code'=>3,'msg'=>'验证码错误！'));exit;   
		   }
		   
		   $r = M('member')->where('id='.$_SESSION['userid'])->setField('mobile',$data['mobile']);
		   
		   echo json_encode(array('code'=>0,'msg'=>'绑定成功！'));exit;  
	   }
	}
    
    //账户安全--支付密码
    public function pay_pass()
	{
		$this->check_islogin();
	    $u = M('member')->where('id='.$_SESSION['userid'])->find();
		if($u['pay_pass']!='' && I('get.type')!=1)
		{
			redirect('/index.php?m=User&a=old_pay_pass');  //存在支付密码先验证支付密码
		}
	  
  	    $this->assign('mobile',$u['mobile']); 
	    $this->display();
	}


    //账户安全--当前支付密码
	public function old_pay_pass()
	{
		$this->check_islogin();
	    
	    $this->display();
	}

    //账户安全--验证当前支付密码
	public function check_old_pay_pass()
	{
		if(IS_AJAX)
		{
			$data = I('post.');
			$u = M('member')->where('id='.$_SESSION['userid'])->find();
			 
			if(md5($data['pay_pass'])!=$u['pay_pass'])
			{
			    echo json_encode(array('code'=>1,'msg'=>'支付密码输入错误！'));exit;  
			}
			
			echo json_encode(array('code'=>0,'msg'=>'验证成功！'));exit; 
		}
	}

    //账户安全--设置新支付密码
    public function set_pay_pass()
	{
	   if(IS_AJAX)
	   {
		   $data = I('post.');
		   $u = M('member')->where('id='.$_SESSION['userid'])->find();
		   
		   if(md5($data['pay_pass'])==$u['pay_pass'])
		   {
			  echo json_encode(array('code'=>1,'msg'=>'请输入新的支付密码'));exit;
		   }
		   
		   if($data['pay_pass']!=$data['c_pay_pass'])
		   {
			  echo json_encode(array('code'=>2,'msg'=>'两次密码输入不一致！'));exit;   
		   }
		   
		   if($data['yzm']!=$_SESSION['yzm'])
		   {
			   echo json_encode(array('code'=>3,'msg'=>'验证码错误！'));exit;
		   }
		   
		   $r = M('member')->where('id='.$_SESSION['userid'])->setField('pay_pass',md5($data['pay_pass']));
		  
		   echo json_encode(array('code'=>0,'msg'=>'支付密码设置成功！'));exit; 
	   }
	}
	
	//账户安全--退出登录
	public function login_out()
	{
		//清空所有session
		session_destroy();
		unset($_SESSION['userid']);
		unset($_SESSION['member_class']);
		//跳转首页
		redirect('/index.php');
	}
	
	//账户安全--切换账号
	public function change_user()
	{
		//清除当前账号的openId
		$r = M('member')->where('id='.$_SESSION['userid'])->setField('openId','');
		//清除当前session 
		session_destroy();
		unset($_SESSION['userid']);
		unset($_SESSION['member_class']);
		//跳转到登录页面
		redirect('/index.php?m=User&a=login');
	}
	
    
	//获取验证手机获取验证码
    public function safe_code()
	{
		if(IS_AJAX)
		{
			$mobile = I('mobile');
		   
		
			$u = M('member')->where("mobile='{$mobile}' and id!=".$_SESSION['userid'])->find();
			
			if($u)
			{
				echo json_encode(array('code'=>1,'msg'=>'该手机号已被存在！'));exit; //更改手机号查重
			}
		
		
			$yzm = rand(111111,999999);
			
			$r = $this->send_sms("【股权帮】您的验证码是".$yzm."。如非本人操作，请忽略本短信。",$mobile);
			
			if($r[1]==0)
			{
				$_SESSION['mobile'] = $mobile;
				$_SESSION['yzm'] = $yzm;
				
				echo json_encode(array('code'=>0,'msg'=>'验证码发送成功！'));exit; 
			}else{
				print_r($r);
			}

		}
	
    }
	
	 //找回密码获取验证码
    public function find_pass_code() 
	{
		$mobile = I('mobile');
		$reg = M('member')->where("mobile='".$mobile."'")->find();
		if(!$reg){
			echo json_encode(array('code'=>1,'msg'=>'手机号不存在'));exit; 
		}
		$yzm = rand(111111,999999);
		$_SESSION['mobile'] = $mobile;
		$_SESSION['zcyzm'] = $yzm;

		$str = $this->send_sms("【股权帮】您的验证码是".$yzm."。如非本人操作，请忽略本短信。",$mobile);
		//print_r($str);exit;
		//$this->assign('yzm',$yzm);
		
		if($r[1]==0)
		{
			echo json_encode(array('code'=>0,'msg'=>'验证码发送成功！'));exit; 
		}else{
			print_r($r);
		}

	
    }
    
    //专题分享页
    public function shareGqby()
    {
        //get方式获得邀请人的邀请码
        $other_inviti_code = I('get.invitation_code');
        //dump($other_inviti_code);
        if($other_inviti_code)
        {
            //如果别人的邀请码存在，存入到cookie中
            setcookie('invitation_code',$other_inviti_code,time()+1800);
        }
        
        //获取当前登陆者的邀请码
        if(!empty($_SESSION['userid']))
        {
            $userid = $_SESSION['userid'];
            $invitationData =M('member')->field('invitation_code')->find($userid);
            $invitation_code = $invitationData['invitation_code'];
        
            $this->assign('invitation_code',$invitation_code);//传递自己的邀请码，用于分享
              
        }
        //echo "当前登录者的邀请码{$invitation_code}";
        //微信分享相关参数
        $time = time();
        $share_url = 'http://'.$_SERVER['HTTP_HOST'].'/index.php?m=User&a=shareGqby';
        //            dump($share_url);
        if($invitation_code)
        {
            //拼接邀请码字符串
            $share_url .= '&invitation_code='.$invitation_code;
        }
        $signature = sha1('jsapi_ticket='.$_SESSION['jsapi_ticket'].'&noncestr=BogLeUnion&timestamp='.$time.'&url='.$share_url);
        //            dump($_SESSION['jsapi_ticket']);
        $this->assign('time', $time);
        $this->assign('share_url', $share_url);
        $this->assign('signature', $signature);
        $this->assign('other_inviti_code', $other_inviti_code);
        $this->assign('jsapi_ticket', $_SESSION['jsapi_ticket']);
        $this->assign('appid', $this->getAppid());
        $this->display();
    }
	
    //发送密码给用户
    public function sendPwd()
    {
        $mobile = I('mobile');
        $pwd = I('password');
        $str = $this->send_sms("【股权帮】已帮您自动注册，你的初始密码是:".$pwd."。为了账户安全，请您登录后修改初始密码。如非本人操作，请忽略本短信。",$mobile);
        echo 0;exit;      
    }

}
?>