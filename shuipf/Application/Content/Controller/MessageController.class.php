<?php

// +-------------------------------------------
// | 后台首页
// +-------------------------------------------
// | Copyright (c) 2012-2014 
// +-------------------------------------------
// | Author:  jie
// +-------------------------------------------

namespace Content\Controller;


use Common\Controller\Base;
use Common\Controller\SmsApi;


class MessageController extends Base {


  

    
   
    // public function test_sms()
	// {
		// $r = $this->send_sms("【股权帮】您的验证码是9999。如非本人操作，请忽略本短信。","13517290730");
		// print_r($r);
		// exit;
	// }
	
	//短信发送
	// function send_sms($content,$mobile)
	// {
		// $clapi  = new SmsApi();
		// $result = $clapi->sendSMS($mobile, $content,'true');
		// $result = $clapi->execResult($result);
		// return $result;
		
	// }
	
	//微信分享测试
	// public function index() 
	// {   
	
	   // $this->assign('time', time());
       // $this->display();
	// }
   
    // public function index2() 
	// {   
	   // $time = time();
	   // $signature = sha1('jsapi_ticket='.$_SESSION['jsapi_ticket'].'&noncestr=BogLeUnion&timestamp='.$time.'&url=http://test3.jbr.net.cn/index.php?m=Message&a=index');
	   //echo $signature;
	   // $this->assign('time', $time);
	   // $this->assign('signature', $signature);
	   // $this->assign('jsapi_ticket', $_SESSION['jsapi_ticket']);
	   // $this->display();
	// }

	//股权咨询表单
	public function zixun_form(){
		$this->display();
	}
    
    public function addzixun_form()
	{
	
    	$data['name']=I('name');
    	$data['mobile']=I('mobile');
    	$data['company']=I('company');
    	$data['industry']=I('industry');
    	$data['content']=I('content');
    	$data['addtime']=date('Y-m-d',time());
    	$r=M('zixun')->add($data);
       
	    $is = M('zixun')->where('mobile="'.$data['mobile'].'"')->find();
		//echo M('zixun')->getLastsql();die;
	   if($is){
		   echo 2;exit; //已咨询过该产品
	   }
    	if($r){
    		echo 0;exit;
    	}else{
    		echo 1;exit;
    	}
    }
	
	
	//判断是否有兑换资格
	public function check_pay()
	{
		$data = I('post.');
		// $_SESSION['userid'] = 149;
		if(IS_AJAX)
		{
			$is = M('order')->where('product_id='.$data['product_id'].' and product_type=5 and member_id='.$_SESSION['userid'])->find();
			
			if($is){
				echo json_encode(array('code'=>2,'msg'=>'您已经兑换过该咨询产品！'));exit;
			}
			
			$user=M('member')->where('id='.$_SESSION['userid'])->find();
			
			if((int)$user['score']<(int)$data['score']){
				echo json_encode(array('code'=>3,'msg'=>'您的积分不足！'));exit;
			}
			
			echo json_encode(array('code'=>0));exit; //可进行兑换
		}
	}
	
	
	//验证支付密码
	public function check_pay_pass()
	{
		// $_SESSION['userid'] = 149;
		$data = I('post.');
		
		if(IS_AJAX)
		{
		    $pay_pass = M('member')->where('id='.$_SESSION['userid'])->getField('pay_pass');
           
            if($pay_pass=='')
			{
				echo json_encode(array('code'=>1,'msg'=>'未设置支付密码！'));exit;
			}
            
			if($pay_pass!=md5($data['pay_pass']))
			{
				echo json_encode(array('code'=>2,'msg'=>'支付密码错误！'));exit;
			}
			
			if($pay_pass==md5($data['pay_pass']))
			{
				echo json_encode(array('code'=>0,'msg'=>'支付密码正确！'));exit;
			}
			
                			
		}
	}
	
	
	//积分兑换股权咨询
	public function addorder()
	{
		$data = I('post.');
		
		//$_SESSION['userid'] = 1;
		if(IS_AJAX){
			
			
			$r = add_order($data['product_id'],$data['product_type'],$data['pay_type'],$data['price'],$data['score'],$_SESSION['userid'],$data['mobile'],$data['truename']);
			
			$e = M('order')->where('id='.$r)->setField('status',1);
			
			if($r)
			{
                $p = M('courses')->where('id='.$data['product_id'])->find();
				//扣除会员积分
				$cut_score = M('member')->where('id='.$_SESSION['userid'])->setDec('score',$p['score']);
				
				$score_array = array('member_id'=>$_SESSION['userid'],
		                             'score'=>-$data['score'],
		                             'score_type'=>'积分兑换消费',
							         'source'=>$p['title']
		                            ); 
		        $score_record = add_score_record($score_array);
				//支付方式
				$e = M('order')->where("id=".$r)->setField('pay_type',2);	
				
			   echo json_encode(array('code'=>0));exit; //提交成功
			}else{
			   echo json_encode(array('code'=>1));exit;  //提交失败
			}
		}	
		
	}
	
	
	//多图上传
	function upload()
	{
		$upload_dir  = './d/upload/';
		$preview_dir = '/d/upload/';
		
		$save        = array();
		$preview     = array();
		
		foreach($_FILES as $k => $v)
		{
			if(is_array($v['error']))	//支持 html5 多文件上传
			{
				for($i = 0; $i < count($v['error']); $i++)
				{
					if($v['error'][$i])
					{
						echo json_encode(array('tag' => false, 'msg' => '上传失败！2'));exit;
					}
					$arr = explode('/', $v['type'][$i]);
					if('image' != $arr[0])
					{
						echo json_encode(array('tag' => false, 'msg' => '上传文件类型错误！'));exit;
					}
					$tarr = explode('.', $_FILES[$k]['name'][$i]);
					$save_name =  date("Ymd_His", time()) . "_" . rand(100, 999) . "." . $tarr[count($tarr) - 1];
					//echo $upload_dir . $save_name;die;
					if(!move_uploaded_file($_FILES[$k]["tmp_name"][$i], $upload_dir . $save_name))
					{
						echo json_encode(array('tag' => false, 'msg' => '移动文件失败！'));exit;
					}
					else
					{
						$save[]    = $upload_dir . $save_name;
						$preview[] = $preview_dir . $save_name;
					}
				}
			}
			else	//不支持 html5 多文件上传
			{
				if($v['error'])
				{
					echo json_encode(array('tag' => false, 'msg' => '上传失败！1'));exit;
				}
				$arr = explode('/', $v['type']);
				if('image' != $arr[0])
				{
					echo json_encode(array('tag' => false, 'msg' => '上传文件类型错误！'));exit;
				}
				$tarr = explode('.', $_FILES[$k]['name']);
				$save_name =  date("Ymd_His", time()) . "_" . rand(100, 999) . "." . $tarr[count($tarr) - 1];
				if(!move_uploaded_file($_FILES[$k]["tmp_name"], $upload_dir . $save_name))
				{
					echo json_encode(array('tag' => false, 'msg' => $_FILES[$k]["tmp_name"] . ';' . $upload_dir . $save_name . ';' .'移动文件失败！'));exit;
				}
				else
				{
					$save[]    = $upload_dir . $save_name;
					$preview[] = $preview_dir . $save_name;
				}
			}
		}
		echo json_encode(array('tag' => true, 'save' => $save, 'preview' => $preview));
		exit;
	}

	
   
}
