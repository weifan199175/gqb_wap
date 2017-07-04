<?php
namespace Content\Controller;

use Common\Controller\Base;
use Content\Model\ContentModel;

require_once $_SERVER['DOCUMENT_ROOT']."/weixin/lib/WxPay.Api.php";
require_once $_SERVER['DOCUMENT_ROOT']."/weixin/example/WxPay.JsApiPay.php";
require_once $_SERVER['DOCUMENT_ROOT']."/weixin/example/log.php";

class WeixinPayController extends Base {
	
	/**
	 * 处理众筹支付
	 */
	public function confirm_zcorder(){
	    if(IS_AJAX){//处理
	        $data = I("post.");
	        //创建一条众筹记录
	        $log = M("funding_log");
	        $data['member_id']=$_SESSION['userid'];
	        $data['createtime']=time();
	        $data['updatetime']=date("Y-m-d H:i:s",time());
	        $data['verification_code']=get_ordernum();
	        $data['msg_time']=time();
	        $data['status']=0;
	        
	        $insertId = $log->add($data);
	        if($insertId){//记录创建成功
	        //调用支付接口
	        switch ($data['pay_type']) {
	            case "weixin":
	                $tools = new \JsApiPay();
	                $openId = M("member")->where("id={$_SESSION['userid']}")->getField("openId");
	                //②、统一下单
	                $input = new \WxPayUnifiedOrder();
	                $input->SetBody("股权帮众筹活动");
	                $input->SetAttach('众筹');
	                $input->SetOut_trade_no($data['verification_code']);       //$res['crsNo'] 订单号
	                $price = sprintf('%.2f',$data['money'])*100;    //支付金额  单位：分
	                $input->SetTotal_fee($price);                   //订单价格   单位：分   $price
	                $input->SetTime_start(date("YmdHis"));
	                $input->SetTime_expire(date("YmdHis", time() + 600));
	                // $input->SetGoods_tag("test");
	                $input->SetNotify_url("http://".$_SERVER['HTTP_HOST']."/api.php/PayNotify/webchatpay_notify.html");
	                $input->SetTrade_type("JSAPI");
	                $input->SetOpenid($openId);
	                $order = \WxPayApi::unifiedOrder($input);
	                // 			dump($order);die;
	                $jsApiParameters = $tools->GetJsApiParameters($order);
	               echo json_encode(array('code'=>0,'jsApiParameters'=>$jsApiParameters));exit;  //提交失败
	            break;
	            case "zhifubao":
	               echo json_encode(array('code'=>0,'url'=>U("Content/AliPay/confirm",array("order_num"=>$data['verification_code'],'order_type'=>"zc"))));exit;
	            break;
	        }
	            
	        }else {
	            echo json_encode(array('code'=>1,'errormsg'=>"众筹记录创建失败"));exit;  //提交失败
	        }
	        
	        
	        
	    }else {//跳转
    	    // 检测是否登陆
    	    $this->check_islogin();
    	    $funding_id = I("get.funding_id");//拿到众筹活动ID
    	    $funding = M("funding")->where("id={$funding_id}")->field("id,price,total_price")->find();
    	    if(empty($funding)){
    	        showErrorInfo("该活动不存在","http://{$_SERVER['HTTP_HOST']}");
    	    }
    	    $user = M('member')->where("id={$_SESSION['userid']}")->field("id,truename,mobile")->find();
    	    $this->assign("user",$user);
    	    $this->assign("funding",$funding);
    	    $message=array(
    	        "好好学知识，等你学成归来！",
    	        "士别三日必当刮目相待，加油！",
    	        "合伙创造新物种，股权价值无边界！"
    	    );
    	    $msg=$message[array_rand($message,1)];
    	    $this->assign("msg",$msg);
    	    $this->display();
	    }
	}
	
	
	//支付确认页面
	public function confirm_order()
	{
		ini_set('date.timezone','Asia/Shanghai');
		//初始化日志
		$logHandler= new \CLogFileHandler($_SERVER['DOCUMENT_ROOT']."/weixin/logs/".date('Y-m-d').'.log');
		$log = \Log::Init($logHandler, 15);
		
		$order_num = I('get.order_num');
		//获取会员信息
		$user_id = $_SESSION['userid'];
		//$user_id = 1;  //测试用
		$user = M('member')->where('id='.$user_id)->find();
		$order_res = M('order')->where("verification_code='{$order_num}'")->find();
		$price = sprintf('%.2f',$order_res['price'])*100;    //支付金额  单位：分	 
		//铁杆会员页面不显示支付类型
		$product=I('get.product_type');
		if($product){
			$this->assign('product',$product);
		}
		
		//判断是否微信浏览器打开
		  
	   if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false)
	   {
			//①、获取用户openid
			$tools = new \JsApiPay();
			$openId = M("member")->where("id={$_SESSION['userid']}")->getField("openId");
			//②、统一下单
			$input = new \WxPayUnifiedOrder();
			$input->SetBody("股权帮");
			$input->SetAttach('1');
			$input->SetOut_trade_no($order_num);       //$res['crsNo'] 订单号
			$input->SetTotal_fee($price);                   //订单价格   单位：分   $price
			/**   如果是开发环境，则把金额调整为1分钱   -start-*/
			if(ENV == "dev"){
			    $input->SetTotal_fee(1);
			}
			/**   如果是开发环境，则把金额调整为1分钱   -end-*/
			$input->SetTime_start(date("YmdHis"));
			$input->SetTime_expire(date("YmdHis", time() + 600));
			// $input->SetGoods_tag("test");
			$input->SetNotify_url("http://".$_SERVER['HTTP_HOST']."/api.php/PayNotify/webchatpay_notify.html");
			$input->SetTrade_type("JSAPI");
			$input->SetOpenid($openId);
			$order = \WxPayApi::unifiedOrder($input);
// 			dump($order);die;
			$jsApiParameters = $tools->GetJsApiParameters($order);
			
			//获取共享收货地址js函数参数
			$editAddress = $tools->GetEditAddressParameters();
	   }
		
		$this->price			=	$order_res['price'];
		$this->total_price		=	$order_res['price'];
		
		
		
		$this->order_num		=	$order_num;
		$this->editAddress		=	$editAddress;
		$this->jsApiParameters	=	$jsApiParameters;
		
		if($order_num)
		{
			$order_res = M('order')->where("verification_code='{$order_num}'")->find();
			
			$course = M('courses')->where('id='.$order_res['product_id'])->find();
			
			$member = M('member')->where('id='.$_SESSION['userid'])->find();
			
		}
		
		
		
		$this->assign('course',$course);
		$this->assign('member',$member);
		$this->assign('order',$order_res);
		$this->display();
	
	}
	//微信混合支付页面
	public function confirm(){
		ini_set('date.timezone','Asia/Shanghai');
		//初始化日志
		$logHandler= new \CLogFileHandler($_SERVER['DOCUMENT_ROOT']."/weixin/logs/".date('Y-m-d').'.log');
		$log = \Log::Init($logHandler, 15);
		
		$order_num = I('get.order_num');
		$order_res = M('order')->where("verification_code='{$order_num}'")->find();
		$course = M('courses')->where('id='.$order_res['product_id'])->find();
		$price = sprintf('%.2f',$order_res['price'])*100;    //支付金额  单位：分
		//判断是否微信浏览器打开
		
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false)
		{
			//①、获取用户openid
			$tools = new \JsApiPay();
			$openId = $tools->GetOpenid();
			//②、统一下单
			$input = new \WxPayUnifiedOrder();
			$input->SetBody("股权帮");
			$input->SetAttach('1');
			$input->SetOut_trade_no($order_num.'mix');       //$res['crsNo'] 订单号
			$input->SetTotal_fee($price);                   //订单价格   单位：分   $price
			$input->SetTime_start(date("YmdHis"));
			$input->SetTime_expire(date("YmdHis", time() + 600));
			$input->SetNotify_url("http://".$_SERVER['HTTP_HOST']."/api.php/PayNotify/webchatpay_notify.html");
			$input->SetTrade_type("JSAPI");
			$input->SetOpenid($openId);
			$order = \WxPayApi::unifiedOrder($input);
			//dump($order);exit;
			$jsApiParameters = $tools->GetJsApiParameters($order);
				//dump($jsApiParameters);exit;
			//获取共享收货地址js函数参数
			$editAddress = $tools->GetEditAddressParameters();
		}
		$this->price			=	$order_res['price'];
		$this->total_price		=	$order_res['price'];
		
		
		
		$this->order_num		=	$order_num;
		$this->editAddress		=	$editAddress;
		$this->jsApiParameters	=	$jsApiParameters;
		
		$this->assign('order',$order_res);
		$this->assign('course',$course);
		$this->display();
	}
	//现金支付AJAX（当用微信支付，并且全额支付时 ，会调用此接口）
	public function cash_pay(){
		$type=I('get.type');//支付渠道，1-微信支付，3-支付宝支付
		$order_num=I('get.order_num');//订单号
		$courses_id=I('get.course_id');//商品ID
		$data=M('order')->where("verification_code=$order_num")->find();//找到这笔订单
		//课程支付
		if($courses_id){//如果商品ID存在
			$coursesData=M('courses')->find($courses_id);//找到这个商品
			$data['pay_type']=$type;//1 金额支付 2 积分支付 3 社员特权
			$data['price']=$coursesData['price'];//这个商品本身的价格
			$data['score']=0;//积分
		}
		//其他支付
		if(M('order')->where("verification_code=$order_num")->save($data)!==false){
		    //这个接口的目的就是确定支付渠道和支付方式
			echo json_encode(true);
		}else{
			echo json_encode(false);
		}
	}
	//混合支付AJAX（混合就是 积分+金额）
	public function mix_pay(){
		$type=I('get.type');//4 积分+金额的方式
		$order_num=I('get.order_num');//订单号
		$courses_id=I('get.course_id');//商品ID
		$data=M('order')->where("verification_code=$order_num")->find();//找到这笔订单
		$coursesData=M('courses')->find($courses_id);//找到这个商品
		$data['pay_type']=$type;//4 积分+金额的方式
		$data['price']=$coursesData['mix_price'];//混合支付时需要的金额
		$data['score']=$coursesData['mix_score'];//混合支付时需要的积分
		if(M('order')->where("verification_code=$order_num")->save($data)!==false){//确定订单的支付方式和渠道
			echo json_encode(true);
		}else{
			echo json_encode(false);
		}
	}	
	//订单支付成功页面
	public function pay_success()
	{

		$data = I('get.');
		//修改订单状态
		$order_num = $data['order_num'];
		$o = M('order')->where("verification_code='{$order_num}'")->find();
		if($o['pay_type']==3){//社员特权购买时
			$save = array('status'=>1,
			    'pay_time'=>date('Y-m-d H:i:s',time())
			);
		    $r = M('order')->where("verification_code='{$order_num}'")->save($save);

		    //购买课程增加该课程的已报名人数  
		    M('courses')->where('id='.$o['product_id'])->setInc('enter_num');
	
		}
		
		$this->display();
	}
    
    //积分兑换课程
	public function pay_order_score()
	{   
		if(IS_AJAX)
		{
		   $order_num = I('post.order_num');
           $member_score = M('member')->where('id='.$_SESSION['userid'])->getField('score');	
		   $o = M('order')->where("verification_code='{$order_num}'")->find();
		   $p = M('courses')->where('id='.$o['product_id'])->find();
		   
           if((int)$p['score']>(int)$member_score)
		   {
			   echo 1;exit;//积分不足   
		   }else{
			    //更新订单
			    $save = array('status'=>1,
				              'pay_type'=>2,
		                      'pay_time'=>date('Y-m-d H:i:s',time())
						      );
				$r = M('order')->where("verification_code='{$order_num}'")->save($save);
				//扣除会员积分
				
				$cut_score = M('member')->where('id='.$_SESSION['userid'])->setDec('score',$p['score']);
				
                //积分兑换记录
				$score_array = array('member_id'=>$_SESSION['userid'],
		                             'score'=>-$p['score'],
		                             'score_type'=>'积分兑换消费',
							         'source'=>$p['title']
		                            ); 
		        $score_record = add_score_record($score_array);
				
				//购买课程增加该课程的已报名人数
				 M('courses')->where('id='.$o['product_id'])->setInc('enter_num');
				 
				echo 0;exit;
		   
		   }    		   
		}else{
			echo 2;exit;//数据非法
		}
	}
     	

	//积分充值
	public function charge()
	{
		//$_SESSION['userid'] = 1;
		
		$user = M('member')->where('id='.$_SESSION['userid'])->find();
		
		$this->assign('user',$user);
		$this->display();
	}
	
	/**
	 * 生成股权诊断器的订单
	 */
	public function EquityOrder(){
	    if(IS_AJAX){
	        //判断是否登录
	        $userid =  $_SESSION['userid'];
	        if($userid == '')
	        {
	            echo json_encode(array('code'=>-2,'msg'=>'请先登录！'));exit();
	        }	            	        
	        $price = 9.9;//股权诊断器1块钱
	        $r = add_order(0,7,1,$price,0,$userid,null,null);//生成订单 product_type:7 是9.9微课类型
	        if(ENV =='dev')
	        {
	            $price = 0.01;
	        }
	        if($r)
	        {
	          $verification_code = M('order')->where("id=".$r)->getField("verification_code");
	        }	       	        
	        if(!empty($verification_code)){//订单生成成功
	            if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false){//在微信的环境里
	                //①、获取用户openid
// 	                $openId = M("member")->where("id={$_SESSION['userid']}")->getField("openId");
                    
 	                $tools = new \JsApiPay();
 	                if(empty($_SESSION['openid']))
 	                {
 	                    $openId = M("member")->where("id={$_SESSION['userid']}")->getField("openId");
 	                }else{
 	                    $openId = $_SESSION['openid'];
 	                    
 	                }
	                //②、统一下单
	                $input = new \WxPayUnifiedOrder();
	                $input->SetBody("微课");
	                $input->SetAttach('微课');
	                $input->SetOut_trade_no($verification_code);       //$res['crsNo'] 订单号
	                $input->SetTotal_fee($price*100);                   //订单价格   单位：分   $price
	                $input->SetTime_start(date("YmdHis"));
	                $input->SetTime_expire(date("YmdHis", time() + 1200));
	                // $input->SetGoods_tag("test");
	                $input->SetNotify_url("http://".$_SERVER['HTTP_HOST']."/api.php/PayNotify/webchatpay_notify.html");
	                $input->SetTrade_type("JSAPI");
	                $input->SetOpenid($openId);
	                $order = \WxPayApi::unifiedOrder($input);
	                // 			dump($order);die;
	                $jsApiParameters = $tools->GetJsApiParameters($order);
	                echo json_encode(array('code'=>0,'jsApiParameters'=>$jsApiParameters,'order_num'=>$verification_code));exit;  //提交成功
	            }else {
	                echo json_encode(array('code'=>-1,'msg'=>'请在微信客户端中使用微信支付！'));exit;  //提交失败
	            }
	        }else {
                 echo json_encode(array('code'=>-1,'msg'=>'订单创建失败，请稍后再试！'));exit;
	        }
	    }else {
	       //
            //检查是否登录
            $a = $this ->check_islogin();
            $userid = $_SESSION['userid'];
            //获取其openid 
            $openid = $this->get_openid();
            /****增加代码，将将计算结果的id从缓存中提取出来-start****/
            if($userid){
                $dia_id = $_SESSION['dia_result'];
                if(isset($dia_id) && !empty($dia_id))
                {
                    //如果缓存存在计算结果，则将缓存数据存入数据库中
            
                    M('dia_tool')->where('id='.$dia_id)->save(array('member_id'=>$userid));
                    unset($_SESSION['dia_result']);
                }
            }
//             //查看其是否有关联过openid
//             $openid = M('member')->where('id='.$userid)->getField('openId');
//                 //如果openid是空的，则跳转到关联页面
//             if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false)
// 		    {
// 			   if(empty($openid))
// 		       {
// 		         $_SESSION['redirectUrl'] = "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];//获得他要跳转回去的页面，存入缓存
// 				 redirect('/index.php?m=Wxbind&a=wx_index');
// 			   }
// 		    }
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
            $this->assign('member_id',$userid);
	        $this->display("WeixinPay/diacrisis_result");
	    }
	}
}