<?php
// +----------------------------------------------------------------------
// | 股权诊断器
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014
// +----------------------------------------------------------------------
// | Author: wf 2017-4-19
// +----------------------------------------------------------------------
namespace Content\Controller;

use Common\Controller\Base;
use Content\Model\ContentModel;


class DiacrisisToolController extends Base {

  
  //保存提交问题
  public function ajaxSaveQuestion()
  {
      $data = I('post.');
      if(empty($data['member_id']))
      {
          //用户未登录
          echo json_encode(array('code'=>-1,'msg'=>'用户未登录！'));exit;
      }
      
      //判断是否有该条诊断记录
      if(empty($data['dia_id']) )
      {
          //用户非法进入
          echo json_encode(array('code'=>-2,'msg'=>'用户非法进入！'));exit;
      }else
      {
          $res = M('dia_tool')->where('id='.$data['dia_id'])->find();
          if(empty($res))
          {
              echo json_encode(array('code'=>-3,'msg'=>'没有该条记录！'));exit;
          }else
          {
              if($res['member_id'] !== $data['member_id'])
              {
                  echo json_encode(array('code'=>-4,'msg'=>'您不是该条记录的所有人！'));exit;
              }
          }
      }
      $data['createtime'] = time();
      //将数据提交到数据库中
      $r  = M('question')->add($data);
      if($r)
      {
          echo json_encode(array('code'=>1,'msg'=>'提交成功！'));exit;
      }else
      {
          echo json_encode(array('code'=>-5,'msg'=>'提交失败，请稍后再试！'));exit;
      }
  }
  //免费咨询
  public function free_ask()
  {
      //判断是否登录
      $this->check_islogin();
      $userid = $_SESSION['userid'];
      $this->assign('userid',$userid);
      //获取当条诊断结果
      $id = I('get.id');
      if($id)
      {
          $this->assign('id',$id);
      }
      $this->display();
  }
  
  //wk成功显示地址
  public function pay_wk_success()
  {
      $this->display();exit;
      $this->check_islogin();
      //获取订单号
      $order_num = I('get.order_num');
      if($order_num)
      {
          //查找该条订单是否已经支付过
          $res = M('order')->where('verification_code='.$order_num)->find();
          if($res['status'] == '1')
          {
              $this->display();
          }else{
              echo "<script>alert('您还未支付过！');window.location.href='/index.php/content/WeixinPay/EquityOrder?id=".$res['id']."'</script>";
          }
      }else
      {
          //非法进入
          redirect('/index.php/content/DiacrisisTool/diacrisisTool');exit;
      }
      
  }
  
  public function DiaResult()
  {
            header("Content-type:text/html;charset=utf-8");
            //获取类型
	        $id = I('get.id');//获取诊断结果ID
	        //获取别人的邀请码
	        $other_invitation_code = I('get.invitation_code');
	        if($other_invitation_code)
	        {
	            //通过别人的邀请码链接进来的
	            //将邀请码放入到cookie中，
	            setcookie('invitation_code',$other_invitation_code,time()+1800);//缓存别人的邀请码（用于注册）
	            setcookie('invitation_code_createtime',time(),time()+1800);//缓存别人的邀请码的生成时间（用于注册）
	        }

//  	        $this->wx_auto_login();
	        //获取当前登录的id
	        $userid = $_SESSION['userid'];
	        if($userid)
	        {
	            /****增加代码，将计算结果的id从缓存中提取出来-start****/
	            $dia_id = $_SESSION['dia_result'];
	            if(isset($dia_id) && !empty($dia_id))
	            {
	                //如果缓存存在计算结果，则将缓存数据存入数据库中
	                M('dia_tool')->where('id='.$dia_id)->save(array('member_id'=>$userid));
	                unset($_SESSION['dia_result']);
	            }
	            //获取当前登录用户的邀请码
	            $invitation_code = M('member')->where('id='.$userid)->getField('invitation_code');
	            $this->assign('invitation_code',$invitation_code);
	            $this->assign('userid',$userid);
	        }else{//没登录
	            $_SESSION['redirectUrl'] = "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];//获得他要跳转回去的页面，存入缓存
	        }
	        //判断是否
	        if($id)
	        {
	            //将计算结果提取出来
	            $result = M('dia_tool')->where('id='.$id)->field('id,status,star,style,score,name,job,member_id,mobile')->find();
	            
	            //判断计算报告中手机是否注册过
	            $is_reg = M('member')->where('mobile='.$result['mobile'])->find();
	            if(!empty($is_reg))
	            {
	                //如果诊断记录中的号码已被注册过，
	                $this->assign('is_reg',1);
	            }else
	            {
	                $this->assign('is_reg',0);
	            }
	        }

	        if(empty($result)){
	            //如果取出来的都是空值，则非法进入，跳转
	            redirect('/index.php/content/diacrisisTool/diacrisisTool');
	        }

	        if(empty($_SESSION['userid']) || !isset($_SESSION['userid']))
	        {
	            $_SESSION['userurl'] = $_SERVER['REQUEST_URI'];
	        }	       
	        //微信分享相关参数
	        $time = time();
	        //如果存在邀请码，则分享链接上加上邀请码
	        $share_url = 'http://'.$_SERVER['HTTP_HOST'].'/index.php/Content/diacrisisTool/ShareDiaResult?id='.$id.'&invitation_code='.$invitation_code.'&type=share';
// 	        $share_url = 'http://'.$_SERVER['HTTP_HOST'].'/index.php/Content/diacrisisTool/diacrisisTool';
	        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	        $signature = sha1('jsapi_ticket='.$_SESSION['jsapi_ticket'].'&noncestr=BogLeUnion&timestamp='.$time.'&url='.$url); //现在代码
	        $this->assign('appid', $this->getAppid());
	        $this->assign('time', $time);
	        $this->assign('share_url', $share_url);
	        $this->assign('signature', $signature);
	        $this->assign('jsapi_ticket', $_SESSION['jsapi_ticket']);
	        $this->assign('dia_res',$result);
	        $this->display();
  }

  //分享页面
  public function ShareDiaResult()
  {
      header("Content-type:text/html;charset=utf-8");
      //获取类型
      $id = I('get.id');//获取诊断结果ID
      //获取别人的邀请码
      $other_invitation_code = I('get.invitation_code');
      if($other_invitation_code)
      {
          //通过别人的邀请码链接进来的
          //将邀请码放入到cookie中，
          setcookie('invitation_code',$other_invitation_code,time()+1800);//缓存别人的邀请码（用于注册）
          setcookie('invitation_code_createtime',time(),time()+1800);//缓存别人的邀请码的生成时间（用于注册）
      }
      //判断是否
      if($id)
      {
          //将计算结果提取出来
          $result = M('dia_tool')->where('id='.$id)->field('id,status,star,style,score,name,job,member_id,mobile')->find();
           
          //判断计算报告中手机是否注册过
          $is_reg = M('member')->where('mobile='.$result['mobile'])->find();
          if(!empty($is_reg))
          {
              //如果诊断记录中的号码已被注册过，
              $this->assign('is_reg',1);
          }else
          {
              $this->assign('is_reg',0);
          }
      }  
      if(empty($result)){
          //如果取出来的都是空值，则非法进入，跳转
          redirect('/index.php/content/diacrisisTool/diacrisisTool');
      } 
      if(empty($_SESSION['userid']) || !isset($_SESSION['userid']))
      {
          $_SESSION['userurl'] = $_SERVER['REQUEST_URI'];
      }    
      $this->assign('dia_res',$result);
      $this->display();
  }
  
  public function diacrisisTool()
  {
	  die;
//       $this->wx_auto_login();
      $userid = $_SESSION['userid'];
      if($userid)
      {
          $memberInfo = M('member')->where('id='.$userid)->find();
      }
      $this->assign('memberInfo',$memberInfo);
      $this->assign('member_id',$userid);
      $this->display();
  }
  
  public function ajaxSave()
  {
      $data = I('post.');
      $data['is_direct_mem'] = implode(',',$data['is_direct_mem']);
      $data['is_full_time']  = implode(',',$data['is_full_time']);
      foreach($data['money_scale'] as $k=>$v)
      {
          $data['money_scale'][$k] = '第'.($k+1).'股东:'.$v;
      }
      $data['money_scale'] = implode(',',$data['money_scale']);
      $data['relationship'] = implode(',',$data['relationship']);
      foreach($data['stock_scale'] as $k=>$v)
      {
          
          $data['stock_scale'][$k] = '第'.($k+1).'股东:'.$v;
      }
      echo json_encode($data['stock_scale']);die;
      $data['stock_scale'] = implode(',',$data['stock_scale']);
      //处理时间获取填写网页花费时间
      $data['cost_time'] = time() - $data['datetime'];
      $res = M('diacrisis')->add($data);
      if($res)
      {
          echo 1;
      }else{
          echo 0;
      }
  }
  
  public function analyse()
  {
      $data = I('post.');
      //组装$where 查询条件
      if($data['partner_num'] == '1'){
          $where['partner_num'] = array('eq',$data['partner_num']);
      }else if($data['partner_num']<7 && $data['partner_num']>1)
      {
          $where['partner_num'] = array('eq','2-6');
      }
    
      //获取谁是第一大股东的股份额度
      $arr = $data['stock_scale'];
      $first = max($arr);
      //获取下标 （$k 数组）
      $k = array_keys($arr,$first);
      //第一大股东
      foreach($k as $v)
      {
          $first_name[] = '第'.($v+1).'股东';  
      }
      if($first<34){
          $where['scale'] = array('EQ',34);
      }else if($first>=67)
      {
          $where['scale'] = array('EQ',67);
      }else if($first<51 && $first>=34)
      {
          $where['scale'] = array('EQ','34-51');
      }else if($first<67 && $first>=51)
      {
          $where['scale'] = array('EQ','51-67');
      }
      
      //第一大股东是否为CEO
      
      //期权是否设置
      if($data['is_pool'] == '是')
      {
          //期权选择是
          $where['is_Option_Pool'] =array('EQ','1');
      }else{
          $where['is_Option_Pool'] = array('EQ','0');
      }
      
      //代表第一大股东全职数量
      $flag = 0; 
      foreach($first_name as $v1)
      {
          foreach($data['is_full_time'] as $v2 )
          {
              if($v1 == $v2)
              {
                  //第一大股东在全职列表中
                  $flag++; 
              }         
          }         
      }
      if($flag >0)
      {
          //第一大股东至少有一个全职状态
          $where['is_full_time'] = array('EQ','1');
      }else
      {
          //第一大股东不是全职
          $where['is_full_time'] = array('EQ','0');
      }

      //判断其他股东是否有全职的状态
      $differ = array_diff($data['is_full_time'],$first_name); //array_diff 判断第一大股东合集与全职股东合集求差
     
      if(!empty($differ))
      {
          //不为空，其他股东有全职
          $where['is_other'] = array('EQ','1');
      }else
      {
          //为空，其他股东都是兼职
          $where['is_other'] = array('EQ','0');
      }
//       echo json_encode($where['is_other']);die;
      
      //判断第一大股东是否为CEO
      if(in_array($data['is_ceo'],$first_name))
      {
          //第一大股东是CEO
          $where['is_ceo'] =array('EQ','1');
      }else
      {
          $where['is_ceo'] = array('EQ','0');
      }
      
      //查询符合条件的数据
      $res = M('dia_result')->field('star,style,score')->where($where)->find();
      if($res)
      {
          //计算所得分数
          $score = get_score($data,$first_name,$first,$res['score'],$data['is_full_time']);
          
      }
      
      //转换格式；
      foreach($data['stock_scale'] as $k=>$v)
      {
          $data['stock_scale'][$k] ='第'.($k+1).'股东:'.$v;
      }
      if($data['is_pool'] == '是')
      {
          $data['is_pool'] = 1;
      }else
      {
          $data['is_pool'] = 0;
      }
      $data['stock_scale'] = implode(',',$data['stock_scale']);
      $data['is_full_time']  = implode(',',$data['is_full_time']);
      //处理时间获取填写网页花费时间
      $data['cost_time'] = time() - $data['datetime'];
      $data['style'] = $res['style'];
      $data['star']  = $res['star'];
      $data['score'] = $score;
      $data['member_id'] = $_SESSION['userid'];
      //将结果存入数据库中
      $o = M('dia_tool')->add($data);
      if($o)
      {
        if(isset($_SESSION['userid']) && !empty($_SESSION['userid'])){
          echo json_encode(array('code'=>'0','msg'=>'用户登录了','id'=>$o));exit;
        }else{
          //用户未登录，将计算结果存入数据后，将计算结果id 缓存
          $_SESSION['dia_result'] = $o;
          echo json_encode(array('code'=>'1','msg'=>'用户未登录,计算结果已存入','id'=>$o));exit; 
        }
      }else{
        echo json_encode(array('code'=>'3','msg'=>'计算数据失败，请重新计算！'));exit;
      }       
  }
  
  
  //最后资料显示页
  function diacrisis_success()
  {      
      //检查是否登录
      $this ->check_islogin(); 
      $userid = $_SESSION['userid'];
      //获取诊断结果类型     
      $style = I('get.style');
      //获取详情诊断信息
      $id = I('get.id');
	 
      if($id)
      {
          $res = M('dia_tool')->field('member_id')->where('id='.$id)->find();
      }else
      {
          $this->redirect("DiacrisisTool/diacrisisTool");
      }
      //判断此条记录是是不是登录者所建立的
      if($userid != $res['member_id'])
      {
          //当前登录者不是此条记录的创建者跳转
          $this->redirect("DiacrisisTool/diacrisisTool");
      }
      $this->assign('id',$id);
      $this->assign('style',$style);
      $this->display();
  }
  
  //谈古论今页面
  public function history_now()
  {
     //获取类型
     $type  = I('get.type');
     $style = I('get.style');
     $this ->assign('type',$type);
     $this ->assign('style',$style);
     $this ->display(); 
  }
  
  //诊断报告页面
  public function diacrisis_result()
  {
      //检查是否登录
      $this ->check_islogin();
      $userid = $_SESSION['userid'];
      //获取详情诊断信息
      $id = I('get.id');
      if($id)
      {
          $res = M('dia_tool')->where('id='.$id)->find();
      }else
      {
          $this->redirect("DiacrisisTool/diacrisisTool");
      }
      //判断此条记录是是不是登录者所建立的
      if($userid != $res['member_id'])
      {
          //当前登录者不是此条记录的创建者跳转
          $this->redirect("DiacrisisTool/diacrisisTool");
      }
      
      //将股权比例格式化
      $scale =explode(',',$res['stock_scale']);
      foreach($scale as $k=>$v)
      {
          $scale[$k] = explode(':',$v);
      }
      
      //将非全职取出来
      $all = array();
      for($i=1;$i<=$res['partner_num'];$i++)
      {
          $all[] ='第'.$i.'股东'; 
      }
      $some = explode(',',$res['is_full_time']);
      $other_full = array_diff($all,$some);
      $other_full = implode(',',$other_full);
      $this->assign('other_full',$other_full);
      $this->assign('scale',$scale);
      $this->assign('res',$res);
      $this->display();
  }
  
  //判断用户是否购买过，
  public function ajaxGetStatus()
  {
      if(IS_AJAX)
      {
          $userid = I('userid');
          $res = M('order')->where(array(
              'product_type'=>array('eq','7'),
              'member_id'=>array('eq',$userid),
              'status'=>array('eq',1)
          ))->find();
          if(!empty($res))
          {
              //用户已经购买过了微课，
              echo json_encode(array('code'=>-1,'msg'=>'您已经购买过了课程！','order_num'=>$res['verification_code']));exit;
          }
          
          echo json_encode(array('code'=>1));exit;
          
      }
  }
  
  //提交问题成功页面
  public function askSuccess()
  {
      //获取类型显示成功模板类型
      $type = I('get.type');
      if($type)
      {
          $this->assign('type',$type);
          //获得诊断报告id
          $id = I('get.id');         
          if($id)
          {
              $this->assign('id',$id);
          }
          $this->display();
      }
      
  }
  
  //下载demo
  function down_email()
  {
      if(IS_AJAX)
      {
          $getInfo = I('POST.');
          if($getInfo['member_id'] == '' )
          {
              //用户未登录
              echo json_encode(array('code'=>'-1','msg'=>'请先登录！'));exit;
          }
          //模板配置信息
          $arr = [
              '1'=>'XX有限公司股东投资合作协议',
              '2'=>'股权代持协议(模板)',
              '3'=>'XX管理公司增资扩股协议(模板)',
              '4'=>'XX管理公司之股权转让协议',
              '5'=>'XX有限公司章程_模板',
              '6'=>'一致行动人协议(模板)',
          ];
          foreach($getInfo['info'] as $k=>$v)
          {
              $data['download_sm'][] = $arr[$v];
          }
          //分割为字符串
          $data['download_sm'] = implode('|',$data['download_sm']);
          $data['createtime'] = time();
          $data['email'] = $getInfo['email'];
          $data['member_id'] = $getInfo['member_id'];
          $r = M('email_download')->add($data);
          if($r)
          {
              echo json_encode(array('code'=>'1','msg'=>'提交成功！'));exit;
          }else{
              echo json_encode(array('code'=>'-2','msg'=>'提交失败，请稍后再试！'));exit;
          }
          
      }else
      {
          //检查用户是否登录
          $dia_id = I('get.id');
          $this->check_islogin();
          $userid = $_SESSION['userid'];
          if(empty($dia_id))
          {
              redirect('/index.php/content/diacrisisTool/diacrisisTool');
          }
          $this->assign('id',$dia_id);
          $this->assign('member_id',$userid);
          $this->display();
          
      }

  }
}