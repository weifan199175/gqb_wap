<?php




//会员签到

function sign($userid)
{
   	if($userid)
	{
	   $r =  M('sign_record')->where(array('member_id'=>$userid,'sign_date'=>date('Y-m-d',time())))->find();	
	   
	   if($r)
	   {            
		   return 1;    //今日已经签到
	   }
	   else
	   {
		  $res =  M('sign_record')->data(array('member_id'=>$userid,'sign_date'=>date('Y-m-d',time())))->add();  
		  if($res)
		  {
			  //获取签到积分规则
					$r=M('score_rules')->where('id=2')->find();
					//签到积分+5
					M('member')->where('id='.$userid)->setInc('score',$r['get_score']);
					M('member')->where('id='.$userid)->setInc('total_score',$r['get_score']);
					//签到添加积分记录
					$param = array('member_id'=>$userid,
								   'score'=>$r['get_score'],
								   'score_type'=>'签到',
								   'source'=>'签到',
								   'addtime'=>date('Y-m-d H:i:s',time())
								   );
					M('score_record')->add($param);
	  
			  return 0;   //签到成功  
		  }
		  else
		  {
			  return 3;  //签到失败
		  }
	   }
	}
	else
	{
		return 2;  //参数错误
	}
}



//我的下线
	function get_my_members($memberid)
	{
		//我的一级下线
		$member_1= M()->query("select * from jbr_member where id in(select member_id from jbr_distribution where parent_id=".$memberid.")");
		
		if($member_1)
		{
			$member_info_1 =  member_info($member_1,'我的朋友'); 
		}
		
	    //我的二级下线
		$member_2= M()->query("select * from jbr_member where id in(select member_id from jbr_distribution where p_parent_id=".$memberid.")");
		
		if($member_2)
		{
			$member_info_2 =  member_info($member_2,'我朋友的朋友'); 
		}
      
        //数组合并
		if(!empty($member_info_1) && !empty($member_info_2))
		{
          $my_members = array_merge($member_info_1,$member_info_2);
		}
		else if(empty($member_info_1))
		{
		   $my_members = $member_info_2;
		}else if(empty($member_info_2))
		{
			$my_members = $member_info_1;
		}
		
		
        return  $my_members;
		 
    }
	
	
   //我的下线详情获取
   function member_info($arr,$type)
   {
	  foreach($arr as $k=>$v)
	 {
	   //成员等级名称
	   switch($v['member_class'])
	   {
		   case 1:
		   $arr[$k]['class_name'] = '普通社员';break;
		   case 2:
		   $arr[$k]['class_name'] = '注册社员';break;
		   // case 3:
		   // $arr[$k]['class_name'] = '铁杆社员';break;
		   case 4:
		   $arr[$k]['class_name'] = '铁杆社员';break;
	   }
	   //下线属性
	     
		$arr[$k]['level'] = $type;  
	 
	   //成员下线数量
	   $arr[$k]['member_count'] = M('distribution')->where('parent_id='.$v['id'].' or p_parent_id='.$v['id'])->count();
	   
	 }
   
      return $arr;
   
   } 


 //会员中心我的订单
function get_my_order($userid,$type)
{
    $w_s = $type!='all'?' and status='.$type:''; 
	
	$order = M('order')->where('member_id='.$userid.$w_s)->select();
	
    foreach($order as $k=>$v)
	{
		if($v['product_type']=='1' || $v['product_type']=='5')     //课程订单
		{
			//课程信息
		    $order[$k]['course'] = M('courses')->where('id='.$v['product_id'])->find(); 
            //支付方式
            switch($v['pay_type'])
			{
				case 1:
				$order[$k]['pay_name'] = '在线支付';break;
				case 2:
				$order[$k]['pay_name'] = '积分兑换';break;
				case 3:
				$order[$k]['pay_name'] = '特权支付';break;
			}	

			//订单状态
				if($v['product_type']=='1')    
				{
					switch($v['status'])
					{
						case 0:
						$order[$k]['rstatus'] = $v['pay_type']==5?'众筹中':'待支付';break;
						case 1:
						if(time()>$order[$k]['course']['end_time']){
                              $order[$k]['rstatus'] = '已过期';break;
						}else{
                              $order[$k]['rstatus'] = '待使用';break;
						}
						
						case 2:
						$order[$k]['rstatus'] = '已使用';break;
						case -1:
						$order[$k]['rstatus'] = '已过期';break;

					}
				}	
           
		}
		else if($v['product_type']=='2')    //充值订单
		{
			$order[$k]['course']['title'] ='积分充值';  //标题
            $order[$k]['course']['thumb'] ='/statics/default/images/jfcz.jpg';  //图片	
            //订单状态
			
			switch($v['status'])
			{
				case 0:
				$order[$k]['rstatus'] = '待支付';break;
				case 1:
                $order[$k]['rstatus'] = '已付款';break;					
			}
					
		}
		else if($v['product_type']=='16')    //社员升级订单
		{
			$order[$k]['course']['title'] ='社员升级';  //标题
            $order[$k]['course']['thumb'] ='/statics/default/images/logo1.png';  //图片	
            //订单状态
			
			switch($v['status'])
			{
				case 0:
				$order[$k]['rstatus'] = '待支付';break;
				case 1:
                $order[$k]['rstatus'] = '已付款';break;					
			}
				
		}
	}
		
	
	return $order;
}












