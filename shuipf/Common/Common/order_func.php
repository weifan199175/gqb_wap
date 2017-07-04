<?php

/**
 * 生成订单
 * @param mixed $product_type 商品类型 
 * @param mixed $pay_type 支付方式 1 在线支付  2积分支付 3 特权支付 4积分+金额 5 众筹
 * @return mixed
 */
function add_order($product_id,$product_type,$pay_type,$price,$score,$member_id,$mobile,$truename)
{
	if($pay_type=='3'){
		$status = 1;
	}else{
		$status = 0;
	}
	$param = array('product_id'=>$product_id,
	               'product_type'=>$product_type,
				   'pay_type'=>$pay_type,
				   'price'=>$price,
				   'score'=>$score,
				   'member_id'=>$member_id,
				   'truename'=>$truename,
				   'mobile'=>$mobile,
				   'verification_code'=>get_ordernum(),    //订单号=核销码
				   'status'=>$status,
				   'addtime'=>date('Y-m-d H:i:s',time())
	               );
				   
	$r = M('order')->add($param);		

    return $r;	//返回订单id
	
}


//获取订单号
function get_ordernum()
{
	return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}

/**
 * 支付成功
 * @param mixed $product_type 商品类型 
 * @param mixed $pay_type 支付方式 1 在线支付  2积分支付 4混合支付
 * @param varchar $pay_channel 支付渠道（weixin，zhifubao）
 * @return mixed
 */

function pay_success($order_num,$pay_channel="")
{
    $o = M('order')->where("verification_code='".$order_num."'")->find();
	//修改会员等级,算出vip开通时间和结束时间
		if($o['product_type']=='15'){
			$data = array(
						'member_class'=>'3',
			            'vipstartime'=>date('Y-m-d H:i:s',time()),
			            'vipendtime'=>date('Y-m-d H:i:s',strtotime("+1 year"))
					);
			$r = M('member')->where('id='.$o['member_id'])->save($data);
		     unset($_SESSION['member_class']);
			 $_SESSION['member_class'] = 3;
			}else if ($o['product_type']=='16'){
				$data = array(
							'member_class'=>'4',
							'vipstartime'=>date('Y-m-d H:i:s',time()),
							'vipendtime'=>date('Y-m-d H:i:s',strtotime("+1 year"))
						);
				$r = M('member')->where('id='.$o['member_id'])->save($data);
				unset($_SESSION['member_class']);
			    $_SESSION['member_class'] = 4;
			}
	
	//商品类型
	switch($o['product_type'])
	{
		case 1:
		$score_type = '课程购买';
		$source = '课程购买';
		break;
		case 2:
		$score_type = '在线充值';
		$source = '在线充值';
		break;
		case 15:
		$score_type = '升级已被废弃的铁杆社员';
		$source = '社员升级';
		break;
		case 16:
		$score_type = '升级铁杆社员';
		$source = '社员升级';
		break;

	}
	
		
	//若是在线充值，给会员增加相应积分 1分=1元
	if($o['product_type']=='2')
	{
	    $add_score = M('member')->where('id='.$o['member_id'])->setInc('score',(int)$o['price']);
		$add_score = M('member')->where('id='.$o['member_id'])->setInc('total_score',(int)$o['price']);
		
		//积分记录
		$record = array('member_id'=>$o['member_id'],
						 'score'=>$o['price'],
						 'score_type'=>$score_type,
						 'source'=>'积分充值'
						 ); 
		$score_record = add_score_record($record);	
			
	}
	
	
	//修改订单状态
	$r = M('order')->where('id='.$o['id'])->data(array('status'=>1,'pay_time'=>date('Y-m-d H:i:s',time()),'pay_channel'=>$pay_channel))->save();
	/** ——————享受提成——start————————————————————————————*/
        //如果不是用社员特权购买的，不是用积分购买的，也不是用积分+金额混合支付的方式
        //并且购买的要么是课程，要么是铁杆社员，才可以享受提成
    if(!in_array($o['pay_type'], array(2,3,4)) && in_array($o['product_type'], array(1,16))){
	    $parent_info = fx_getParentsId($o['member_id']);
	    if(isset($parent_info['parent_id']) && $parent_info['parent_id']){//第一个人的提成
	        /** 新增判断，此人必须满足铁杆会员or创始会员or分社股东，才能享受提成——start */
	        $dis = fx_getParentsId($parent_info['parent_id']);
	        $member_class = M("member")->where("id={$parent_info['parent_id']}")->getField("member_class");
	        if(in_array($member_class, array("4","3")) || (empty($dis['parent_id']) && empty($dis['p_parent_id']) && !empty($dis['fenbu_id']))){
    	        fx_getTichengByParent($o['member_id'], $parent_info['parent_id'], $o['price'], $o['product_type'], $o['verification_code']);
	        }
	        /** 新增判断，此人必须满足铁杆会员or创始会员or分社股东，才能享受提成——end */
	    }
	    
	    if(isset($parent_info['p_parent_id']) && $parent_info['p_parent_id']){//第二个人的提成
	        /** 新增判断，此人必须满足铁杆会员or创始会员or分社股东，才能享受提成——start */
	        $dis = fx_getParentsId($parent_info['p_parent_id']);
	        $member_class = M("member")->where("id={$parent_info['p_parent_id']}")->getField("member_class");
	        if(in_array($member_class, array("4","3")) || (empty($dis['parent_id']) && empty($dis['p_parent_id']) && !empty($dis['fenbu_id']))){
    	        fx_getTichengByP_Parent($o['member_id'], $parent_info['p_parent_id'], $o['price'], $o['product_type'], $o['verification_code']);
	        }
	        /** 新增判断，此人必须满足铁杆会员or创始会员or分社股东，才能享受提成——end */
	    }
	    
	    if(isset($parent_info['parent_id']) && $parent_info['parent_id'] && isset($parent_info['fenbu_id']) && $parent_info['fenbu_id']){//分社的提成（现在分社不能享受1级提成，必须还要有1或2个上级提成者）
	        fx_getTichengByTopOffice($parent_info['parent_id'],$parent_info['p_parent_id'],$o['member_id'], $parent_info['fenbu_id'], $o['price'], $o['product_type'], $o['verification_code']);
	    }
	}
	/** ——————享受提成——end————————————————————————————*/
	
	
	
	
	//扣除会员积分，现金支付下score=0；
	//$member_score = M('member')->where("id={$o['member_id']}")->getField('score');
	$p = M('courses')->where('id='.$o['product_id'])->find();
	if($o['score']!=0){
		//扣除会员积分
		$member=M('member')->find($o['member_id']);
		$member['score']=(int)$member['score']-(int)$o['score'];
		$row=M('member')->where("id=".$o['member_id'])->data(array('score'=>$member['score']))->save();
		//echo M('member')->getLastSql();exit;
		//dump($row);exit;
		if($row!==false){
			//积分兑换记录
			$score_array = array('member_id'=>$o['member_id'],
					'score'=>-$o['score'],
					'score_type'=>'积分兑换课程',
					'source'=>$p['title']
			);
			$score_record = add_score_record($score_array);
		}else{
			M('order')->where('id='.$o['id'])->data(array('mobile'=>404))->save();
		}
	}
	
	//积分充值不返本人积分
	if($o['product_type']!=2)
	{
		//当前积分
		$my_score = M('member')->where('id='.$o['member_id'])->setInc('score',$o['price'] * cache('Config.score_level_0'));
		//累计积分
		$my_total_score = M('member')->where('id='.$o['member_id'])->setInc('total_score',$o['price'] * cache('Config.score_level_0'));
		
		$score_array_0 = array('member_id'=>$o['member_id'],
		                     'score'=>$o['price'] * cache('Config.score_level_0'),
							 'score_type'=>$score_type,
							 'source'=>$source
		                     ); 
		$score_record_0 = add_score_record($score_array_0);
    }
	    
	    
	    //是否存在上级代理
		$level = M('distribution')->where('member_id='.$o['member_id'])->find();
		
	    if($level['parent_id']!='')
		{
		    $level_1 = M('member')->where('id='.$level['parent_id'])->find();
			//一级上线返积分	
		    $add_score_1 = M('member')->where('id='.$level['parent_id'])->setInc('score',$o['price'] * cache('Config.score_level_1'));
		    $add_total_score_1 = M('member')->where('id='.$level['parent_id'])->setInc('total_score',$o['price'] * cache('Config.score_level_1'));
			
			$score_array_1 = array('member_id'=>$level['parent_id'],
		                     'score'=>$o['price'] * cache('Config.score_level_1'),
							 'score_type'=>'下级消费',
							 'consumer_id'=>$o['member_id'],  //下级id
							 'source'=>$source
		                     ); 
		    $score_record_1 = add_score_record($score_array_1);	
            //铁杆社员返佣金	
            if($level_1['member_class']==4 && $o['product_type']!=16)
			{
				$add_commission =  M('member')->where('id='.$level['parent_id'])->setInc('commission',$o['price'] * cache('Config.money_level_1'));
			   
			    $record_array = array('member_id'=>$level['parent_id'],
				                      'amount'=>$o['price'] * cache('Config.money_level_1'),
									  'order_id'=>$o['id'],
									  'consumer_id'=>$o['member_id'],
									  'score_type'=>'下级消费',
									  'source'=>$source
				                      );
                $commission_record =  add_commission_record($record_array);				
				
			}			
		}
		
		if($level['p_parent_id']!='')
		{
			$level_2 = M('member')->where('id='.$level['p_parent_id'])->find();
			//二级上线返积分
			$add_score_2 = M('member')->where('id='.$level['p_parent_id'])->setInc('score',$o['price'] * cache('Config.score_level_2'));
			$add_total_score_2 = M('member')->where('id='.$level['p_parent_id'])->setInc('total_score',$o['price'] * cache('Config.score_level_2'));
			
			$score_array_2 = array('member_id'=>$level['p_parent_id'],
		                     'score'=>$o['price'] * cache('Config.score_level_2'),
							 'score_type'=>'下级消费',
							 'consumer_id'=>$o['member_id'],  //下级id
							 'source'=>$source
		                     ); 
		    $score_record_2 = add_score_record($score_array_2);	
		}
		
		/**   全部处理完了以后，开始准备发购买成功的消息模板  ——start——   */
		$member = M("member")->where("id=".$o['member_id'])->field("openid,vipstartime,vipendtime")->find();
		if($member['openid']){//有openid的情况下才发购买成功的模板消息
		    if($o['product_type'] == "16"){//购买铁杆社员
		        $goodsInfo="股权帮《铁杆社员》";
		        $remark = "会员有效期是：".date("Y年m月d日 H点i分",$member['vipstartime'])." - ".date("Y年m月d日 H点i分",$member['vipendtime'])."请您及时使用";
		        $url = $_SERVER['HTTP_HOST']."/index.php?m=User&a=index";//跳转到个人中心页面
		    }else {//购买课程
		        $goodsInfo=$p['title'];
		        $remark = "主讲老师：".$p['teacher']."老师\\n课程时间：".date("Y年m月d",$p['start_time'])." - ".date("d日",$p['end_time'])."\\n课程地址：".$p['city']."\\n联系电话：18610127110（李老师）";
		        $url = $_SERVER['HTTP_HOST']."/index.php?m=User&a=order&status=1";//跳转到我的订单（已支付）
		    }
		    sendTplPaySuccess($member['openid'], $goodsInfo, $remark,$url);
		}
		/**   全部处理完了以后，开始准备发购买成功的消息模板  ——end——   */
}

//添加积分记录
function add_score_record($param)
{
	if(!empty($param))
	{
	    $param['addtime'] = date('Y-m-d H:i:s',time());
		
		$r = M('score_record')->add($param);
		if($r){
		    return 1;
		}
	}
	return 0;
}


//添加佣金记录
function add_commission_record($param)
{
	if(!empty($param))
	{
	    $param['addtime'] = date('Y-m-d H:i:s',time());
        
		$r = M('commission_record')->add($param);
	}
}








