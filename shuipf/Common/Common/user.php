<?php

include_once $_SERVER['DOCUMENT_ROOT']."/application/Common/Common/myftp.php";
include_once $_SERVER['DOCUMENT_ROOT']."/application/Common/Common/baseinfo.php";

	//会员信息
	function get_user_info_index($user_id)
	{
		$user = M('member')->where('id='.$user_id)->find();
		unset($user['login_pass']);//密码不输出
        unset($user['pay_pass']);//密码不输出
		$data['user'] = $user;
		$grade		=	get_user_grade($user['score_total']);
		$data['grade'] = $grade;
		//优惠劵
		$time		=	time();
		$time_now	=	date('Y-m-d H:i:s',$time);
		$time_24	=	date('Y-m-d H:i:s',$time-base_info('paytime')*3600);

		$where_coupons=	" end_time>'{$time_now}' AND user_id={$user_id} AND isuse=0";
		$data['coupons']	=	M('couponsRecord')->where($where_coupons)->count();
		//订单
		$order_sql	=	"SELECT (SELECT COUNT(*) FROM jbr_orders WHERE user_id={$user_id} AND status=0 AND addtime>'{$time_24}' ) dfk,
						 (SELECT COUNT(*) FROM jbr_sub_orders WHERE user_id={$user_id} AND order_status=2 )	dsh,
						 (SELECT COUNT(*) FROM jbr_sub_orders WHERE user_id={$user_id} AND order_status=3 AND commented=0)	dpj,
						 (SELECT COUNT(*) FROM jbr_sub_orders so 
							WHERE so.user_id={$user_id} AND (so.order_status=4 OR so.order_status=5)
						 ) th";
		$data['orders']		=	M('')->query($order_sql);
		return $data;
	}

	//会员等级
	function get_user_grade($total_score)
	{
		$grade		=	M('userGrade')->order('min_score DESC')->select();
		foreach($grade  as $kg=>$vg){
			if( $total_score >= $vg['min_score'] ){
				$grade_c	=	$vg;
				break;
			}
		}
		return $grade_c;
	}
	//验证手机
	function check_mobile($mobile)
	{
		$user	= M('member')->where(array('mobile'=>$mobile))->find();
		//验证手机号码是否被注册
		if(!empty($user['mobile'])){
			return $data['code'] =1;
		}else{
			return $data['code'] =0;
		}
		
	}	
	
	function send_checkcode($mobile)
	{
		//print_r(getSession($mobile));
		//验证手机号
		//$path = $_SERVER['DOCUMENT_ROOT'].'/ThinkPHP/Library/Think/Cache.class.php';
		//print_r(file_get_contents($path));die;
		if(empty($mobile)){
			echo json_encode(array('code'=>3,'msg'=>'手机号码不可为空'));exit;
		}
		//加载发送邮件短信方法
		include_once($_SERVER['DOCUMENT_ROOT'].'/application/Common/Common/SendClass.php');
		//获取短信模板
		$model	= getMessageModelByTag('c_verify_message');
		//模板内容动态替换
		if($model['status'] == 1 ){
			//获取数字
			$num	= getRandStr(6); 
			/*
			setSession($mobile,$num);
			$arr	= array();
			if(!empty($data[$mobile])){
				if($data[$mobile]['time'] > (time()-60)){
				// if(false){
					echo json_encode(array('code'=>false,'msg'=>'短信发送异常，请稍后尝试'));exit;
				}
				$arr 	= $data;
			}else{
				$arr[$mobile] = array('num'=>$num,'time'=>time());		//组装缓存数据
			}*/
			$content= str_replace('******',$num,$model['msg']);
		}else{
			return (array('code'=>false,'msg'=>'短信发送失败'));exit;
		}
		// 组装参数
		$params = array(
				'mobile'	=>	$mobile, 		//'15327763979',
				'content'	=>	$content		//短信内容
			);
		
		// 调用方法发送短信
		// $res = sendMessage($params);
		
		// if($res[0] == '1'){
		if(true){
			//写入缓存
			setSession($mobile,$num);
           // print_r(getSession('13517290730'));	
			//return (array('code'=>1,'msg'=>'短信发送成功,请注意查收'));exit;
			return (array('code'=>1,'msg'=>$num));exit;
		}else{
			return (array('code'=>false,'msg'=>'短信发送失败'));exit;
		}	
	}
	
//注册
function  register($data)
{
		// print_r($data);
		if(empty($data['mobile']) || empty($data['password']) || empty($data['check_code'])){
			return (array('code'=>1,'msg'=>'必传参数为空'));exit;
		}
		//验证验证码
		// echo $data['verify'];die;
		//验证手机号
		$reg	= '/^1\d{10}$/';
		$res	= preg_match($reg,$data['mobile']);
		if(!$reg){
			return  (array('code'=>1,'msg'=>'请填写正确的手机号'));exit;
		}
		//验证手机校验码

        $cacheData 	= getSession($data['mobile']);

		// print_r($cache_data);die;
		if(empty($cacheData) || $cacheData != $data['check_code'] ){
			return (array('code'=>3,'msg'=>'请填写正确的手机校验码'));exit;
		}
		
		//组装保存数据
		$param	= array(
					'mobile'	=>	$data['mobile'],
					'mobile_check'=>1,
					'login_pass'=>	md5($data['password']),
					'reg_date'	=>	date('Y-m-d H:i:s'),
					'sex'		=>	0,
					'score'		=>	0,
					'score_total'=>	0,
					'reg_source' => 2,
					'alias'		=>	'京穗会员',
					'amount'	=>	0,
					'isok'		=>	1,
					'is_deleted'=>	0
				);
		
		$user	= M('member')->where(array('mobile'=>$data['mobile']))->find();
		//验证手机号码是否被注册
		if(!empty($user['mobile'])){
			return (array('code'=>1,'msg'=>'该手机号已被注册'));exit;
		}
		$res 	= M('member')->add($param);
		if(!$res){
			return  (array('code'=>4,'msg'=>'注册失败'));exit;
		}
	
		$userNew 	=	M('member')->where('id='.$res)->find();

		M('member')->query("call user_login('".$data['mobile']."','".md5($data['password'])."')");
		unset($userNew['login_pass']);
        unset($userNew['pay_pass']);
		$userNew['session_tag'] = md5($userNew['session_tag']);
	
		return (array('code'=>5,'msg'=>'注册成功','data'=>$userNew));exit;	
}	
    
	//找回密码
    function  findpass($data)
    {
	    
		//print_r($data);
		if(empty($data['mobile']) || empty($data['password']) || empty($data['check_code'])){
			return (array('code'=>1,'msg'=>'必传参数为空'));exit;
		}
		
		//验证手机号
		$reg	= '/^1\d{10}$/';
		$res	= preg_match($reg,$data['mobile']);
		if(!$reg){
			return  (array('code'=>1,'msg'=>'请填写正确的手机号'));exit;
		}
		
		//验证手机校验码
        $cacheData 	= getSession($data['mobile']);
       
		
		if(empty($cacheData) || $cacheData != $data['check_code'] ){
			return (array('code'=>3,'msg'=>'请填写正确的手机校验码'));exit;
		}
		
		$res 	= 	M('member')
					->where(array('mobile'=>$data['mobile']))
					->save(array('login_pass'=>md5($data['password'])));
		// echo M('member')->getLastsql();die;
		if(!$res){
			return array('code'=>4,'msg'=>'密码重置失败');exit;
		}
		
		return array('code'=>5,'msg'=>'密码重置成功');exit;
    }	
	
	
	
	/*
	*   获取实物订单 
	*   zh  2015-11-09
	*/
	function getb2corders($pars)
	{
		if($pars['page']=='')
		{
			$pars['page'] = 1;
		}
		$start = ($pars['page'] - 1) * $pars['size'];
		$size  =  $pars['size'];
		
        if( $pars['type'] == 'online' )  //------------在线支付订单
		{
			//基础订单信息sql
            $sql_order=     "SELECT o4.* FROM
							(SELECT o1.id,o1.order_num,o1.is_cod,o1.addtime add_time,o1.receive_name,o1.status,o1.deal_price,o1.over_pay_price
							FROM jbr_orders o1 
							WHERE o1.status=0 AND o1.is_cod=0 AND o1.user_id={$pars['id']}
							UNION All
							SELECT o2.id,o2.sub_order_num order_num,o2.is_cod,o2.add_time,o3.receive_name,o2.order_status status,o2.deal_price,o2.over_pay_price 
							FROM jbr_sub_orders o2 
							INNER JOIN jbr_orders o3 ON o3.id=o2.p_order_id 
							WHERE o2.order_status>0 AND o2.is_cod=0 AND o2.user_id={$pars['id']} ) o4
							ORDER BY o4.add_time DESC
							LIMIT {$start},{$size}";
			//总数sql
			$sql_count	=	"SELECT COUNT(*) num FROM
							(SELECT o1.id,o1.order_num,o1.is_cod,o1.addtime add_time,o1.receive_name,o1.status,o1.deal_price,o1.over_pay_price 
							FROM jbr_orders o1 
							WHERE o1.status=0 AND o1.is_cod=0 AND o1.user_id={$pars['id']}
							UNION All
							SELECT o2.id,o2.sub_order_num order_num,o2.is_cod,o2.add_time,o3.receive_name,o2.order_status status,o2.deal_price,o2.over_pay_price  
							FROM jbr_sub_orders o2 
							INNER JOIN jbr_orders o3 ON o3.id=o2.p_order_id 
							WHERE o2.order_status>0 AND o2.is_cod=0 AND o2.user_id={$pars['id']} ) o4";
							
		}else if( $pars['type'] == 'cod' ){         //--货到付款
			
			//基础订单信息sql
            $sql_order=     "SELECT o4.* FROM
							(SELECT o1.id,o1.order_num,o1.is_cod,o1.addtime add_time,o1.receive_name,o1.status,o1.deal_price,o1.over_pay_price
							FROM jbr_orders o1 
							WHERE o1.status=0 AND o1.is_cod=1 AND o1.user_id={$pars['id']}
							UNION All
							SELECT o2.id,o2.sub_order_num order_num,o2.is_cod,o2.add_time,o3.receive_name,o2.order_status status,o2.deal_price,o2.over_pay_price 
							FROM jbr_sub_orders o2 
							INNER JOIN jbr_orders o3 ON o3.id=o2.p_order_id 
							WHERE o2.order_status>0 AND o2.is_cod=1 AND o2.user_id={$pars['id']} ) o4
							ORDER BY o4.add_time DESC
							LIMIT {$start},{$size}";
			//总数sql
			$sql_count	=	"SELECT COUNT(*) num FROM
							(SELECT o1.id,o1.order_num,o1.is_cod,o1.addtime add_time,o1.receive_name,o1.status,o1.deal_price,o1.over_pay_price 
							FROM jbr_orders o1 
							WHERE o1.status=0 AND o1.is_cod=1 AND o1.user_id={$pars['id']}
							UNION All
							SELECT o2.id,o2.sub_order_num order_num,o2.is_cod,o2.add_time,o3.receive_name,o2.order_status status,o2.deal_price,o2.over_pay_price  
							FROM jbr_sub_orders o2 
							INNER JOIN jbr_orders o3 ON o3.id=o2.p_order_id 
							WHERE o2.order_status>0 AND o2.is_cod=1 AND o2.user_id={$pars['id']} ) o4";
			
			
		}else if($pars['type'] == '0'){
			//基础订单信息sql
			$sql_order	=	"SELECT o1.id,o1.order_num,o1.addtime add_time,o1.receive_name,o1.status,
							o1.deal_price,o1.over_pay_price 
							FROM jbr_orders o1 
							WHERE o1.status=0 AND o1.user_id={$pars['id']}
							ORDER BY o1.addtime DESC
							LIMIT {$start},{$size}";
			//总数sql
			$sql_count	=	"SELECT COUNT(*) num
							FROM jbr_orders o1 
							WHERE o1.status=0 AND o1.user_id={$pars['id']} AND o1.addtime>'{$time_24}'";
		}else{
			$commented	=	'';
			if($pars['type'] == '3')	$commented	=	'AND o2.commented=0 ';
			//基础订单信息sql
			$sql_order	=	"SELECT o2.id,o2.sub_order_num order_num,o2.add_time,o3.receive_name,
							o2.order_status status,o2.deal_price,o2.over_pay_price 
							FROM jbr_sub_orders o2 
							INNER JOIN jbr_orders o3 ON o3.id=o2.p_order_id 
							WHERE o2.order_status='{$pars['type']}' AND o2.user_id={$pars['id']} {$commented}
							ORDER BY o2.add_time DESC
							LIMIT {$start},{$size}";
			//总数sql
			$sql_count	=	"SELECT COUNT(*) num 
							FROM jbr_sub_orders o2 
							INNER JOIN jbr_orders o3 ON o3.id=o2.p_order_id 
							WHERE o2.order_status='{$pars['type']}' AND o2.user_id={$pars['id']} {$commented}";
		}
		// echo $sql_order;die;
		$orders		=	M('')->query($sql_order);
		$count		=	M('')->query($sql_count);
		$orders_p	=	getOrderProducts($orders);
		foreach($orders_p as $k=>$v)
		{
			switch($v['status'])
			{
			    case 0:
 			    $orders_p[$k]['status_name'] = '待付款';
				$orders_p[$k]['categroy'] = '<a href="javascript:void();">去支付</a><a href="javascript:void();">详情</a>';
				break;
				case 1:
 			    $orders_p[$k]['status_name'] = '待发货';
				$orders_p[$k]['categroy'] = '<a href="javascript:void();">取消订单</a><a href="javascript:void();">详情</a>';
				break;
				case 2:
 			    $orders_p[$k]['status_name'] = '待收货';
				$orders_p[$k]['categroy'] = '<a href="javascript:void();">确认收货</a>';
				break;
				case 3:
 			    $orders_p[$k]['status_name'] = '已完成';
				$orders_p[$k]['categroy'] = '<a href="javascript:void();">去评价</a>';
				break;
				case 4:
 			    $orders_p[$k]['status_name'] = '退换货';
				$orders_p[$k]['categroy'] = '';
				break;
				case 6:
 			    $orders_p[$k]['status_name'] = '已取消';
				$orders_p[$k]['categroy'] = '';
				break;
			}
		}
        return array('total' => $count, 'rows' => $orders_p);
 		
	}
		//获取商品详细信息
	function getOrderProducts($orders){
		//获取详细店铺、商品信息
		foreach($orders as $k=>$v){
			if($v['status'] == '0'){
				//结算链接
				$price = sprintf ('%.2f',($v['deal_price'] - $v['over_pay_price']));
				$key	=	md5(md5($v['order_num'].$price.'1'));
				
				$url	=	U('PChome/Pay/payment',array('ordernum'=>$v['order_num'],'key'=>$key,'order_type'=>1));
				$orders[$k]['pay_url']	=	$url;
				// echo $url;die;
				//查询店铺和子订单
				$sub_order_info	=	M('subOrders')->alias('so')
									->where('so.p_order_id='.$v['id'].' AND so.order_status=0')
									->select();
				// print_r($sub_order_info);die;
				//查询相关商品信息
				$i = 0;		//控制变量
				$products	=	array();
				foreach($sub_order_info as $ksoi=>$vsoi){
					$sub_orders		=	M('ordersInfo')->where('sub_order_id='.$vsoi['id'])->select();
					//具体商品信息
					foreach($sub_orders as $kso=>$vso){
						$products[$i]	=	$vso;
						if($vso['product_type'] == '0' ){
							$products[$i]['product'] = 	M('products')
														->field('product_title,default_pic')
														->where('id='.$vso['product_id'])
														->find();
							
						}else{
							$products[$i]['product'] =	M('sub_orders_info')->alias('soi')
														->field('soi.*,p.default_pic')
														->join('jbr_products p ON p.id=soi.product_id')
														->where('soi.order_info_id='.$vso['id'])
														->select();
						}
						$i++;
					}
				}
				// print_r($products);die;
				$orders[$k]['shops']=	$products;
			}else{
				//查询店铺
				$order_shop		=	M('subOrders')->alias('so')
									->field('so.shop_id,s.shop_name,s.isofficial,so.commented,s.qq')
									->join('jbr_shop s ON s.id=so.shop_id')
									->where('so.id='.$v['id'])
									->find(); 
				$qq_arr		=	explode(',',$order_shop['qq']);
				$qq_index	=	mt_rand(0,(count($qq_arr)-1));
				$order_shop['qq']	=	$qq_arr[$qq_index];
				// dump($order_shop);die;
				//查询相关商品信息
				$sub_orders		=	M('ordersInfo')->where('sub_order_id='.$v['id'])->select();
				//具体商品信息
				$zh = array();
				foreach($sub_orders as $kso=>$vso){
					if($vso['product_type'] == '0' ){
						$sub_orders[$kso]['product'] = 	M('products')
													->field('product_title,default_pic')
													->where('id='.$vso['product_id'])
													->find();
						// echo 	$v['user_id'].'--'.$vso['product_id'].'--'.$v['id'];die;				
						 $comment=	M('user_comment')
								    ->where("order_id={$v['id']} AND product_id={$vso['product_id']}")
								    ->find();
						//echo M('user_comment')->getLastsql();die;					
						if(empty($zh[$sub_orders[$kso]['product']['id']])){
							$sub_orders[$kso]['product']['commented']		=	empty($comment)	? 0 : 1;
							/*$p['deal_price']	=	$voi['deal_price'];
							$p['quantity']		=	$voi['quantity'];
							$product[$p['id']]	=	$p;*/
						}							
					}else{
						$sub_orders[$kso]['product']	=	M('sub_orders_info')->alias('soi')
															->field('soi.*,p.default_pic')
															->join('jbr_products p ON p.id=soi.product_id')
															->where('soi.order_info_id='.$vso['id'])
															->select();
						//$tz = $sub_orders[$kso]['product'];									
						foreach($sub_orders[$kso]['product'] as $kp=>$vp){
						
						$comment=	M('user_comment')
									->where("order_id={$v['id']} AND product_id={$vp['product_id']} ")
								    ->find();
						//echo M('user_comment')->getLastsql();die;							
						if(empty($zh[$vp['id']])){
							$sub_orders[$kso]['product'][$kp]['commented']		=	empty($comment)	? 0 : 1;
							/*$vp['deal_price']	=	$voi['deal_price'];
							$vp['quantity']		=	$voi['quantity'];
							$product[$vp['id']]	=	$vp;*/
						}
					}									
						// dump($sub_orders[$kso]['product']);die;AND shop_id={$v['shop_id']}
					}
				}
				// dump($sub_orders);die;
				$order_shop['product']	=	$sub_orders;
				$orders[$k]['shops'][0]	=	$order_shop;
			}
		}
		return $orders;
	}

	//用户预定的电影票订单座位  hy 2015-11-11
	function get_film_order($data)
	{

		$sql ="user_id = {$data['user_id']} and planid={$data['planid']} and status = 1";
		$res = M("orders_film")->where($sql)->select();
		//echo time();
		//echo '<br/>';
		//echo strtotime($res['order_time']);
		//echo $flag;
		
		$temp_arr = array();

		foreach($res as $k=>$v)
		{
			$flag = 10*60-(time()-strtotime($v['order_time']));
				if($flag >0)
				{
					$temp = explode(',',$v['seat_ids']);
					foreach($temp as $kk=>$vv)
					{
						$temp_arr[] = $vv;
					}
				}

		}

		
		return $temp_arr;
	}

	
    //确认收货
	function getProduct($id,$user_id){
		
		if($id == ''){
			return array('code'=>false,'msg'=>'确认收货失败，请稍后尝试！');
			exit;
		}

		$param	=	array(
						'id'			=>	$id,
						'user_id'		=>	$user_id,
						'order_status'	=>	3,
						'commented'		=>	0,
						'end_time'		=>	date('Y-m-d H:i:s',time())
					);
		$orders	=	M('sub_orders');
		// $orders->startTrans();
		$save	=	$orders->save($param);
		if(!$save){
			return array('code'=>false,'msg'=>'确认收货失败，请稍后尝试！');
			exit;
		}
		
		return array('code'=>true,'msg'=>'确认收货成功！');
	}
	
	/**
	*   获取电影票订单
	*   zh 2015-11-11
	*/
    function getmovieorders($pars)
	{
		if($pars['page']=='')
		{
			$pars['page'] = 1;
		}
		
		$start = ($pars['page'] - 1) * $pars['size'];
		$size  =  $pars['size'];
	    
		$rows = M('orders_film')->alias('o')->join('jbr_product_film as p on o.movieId=p.film_id')->field('o.*,p.poster,p.duration')->where('o.user_id='.$pars['user_id'])->order('o.last_update desc')->limit((($pars['page'] - 1) * $pars['size']) . "," . $pars['size'])->select();
	  
	    $count = M('orders_film')->alias('o')->join('jbr_product_film as p on o.movieId=p.film_id')->field('o.*,p.poster,p.duration')->where('o.user_id='.$pars['user_id'])->count();
		
		foreach($rows as $k=>$v)
		{
			if($v['pay_time']=='')                  //未付款
			{
				if((time()-strtotime($v['order_time'])) < 60*10)      //当前距下单时间小余10分钟
				{
					$rows[$k]['show_status'] = 0;   //可支付
				}
				else
				{
					$rows[$k]['show_status'] = 1;   //不可支付
				}	
			}
			else
			{
				if((strtotime($v['planbegintime']) + 60*$v['duration'])< time())      //电影放映结束
				{
					$rows[$k]['show_status'] = 2;
				}
				else                                                                 //电影未放映结束
				{
					$rows[$k]['show_status'] = 3;
				}	
			}	
		}
		
		
		return array('total' => $count, 'rows' => $rows);
	
	}
	

	
	/**
	*    获取酒店订单
	*    zh 2015-11-11
	*/
	function gethotelorders($pars)
	{
		if($pars['page']=='')
		{
			$pars['page'] = 1;
		}
		$start = ($pars['page'] - 1) * $pars['size'];
		$size  =  $pars['size'];
	    
		$rows = M('orders_hotel')->alias('o')->join('jbr_sub_shops as s on o.sub_shop_id=s.id')->field('o.*,s.sub_name')->where('o.user_id='.$pars['user_id'])->order('o.addtime desc')->limit((($pars['page'] - 1) * $pars['size']) . "," . $pars['size'])->select();
	
	    $count =  M('orders_hotel')->alias('o')->join('jbr_sub_shops as s on o.sub_shop_id=s.id')->field('o.*,s.sub_name')->where('o.user_id='.$pars['user_id'])->count();
		
		foreach($rows as $k=>$v)
		{
			switch($v['order_status']){
			/*case -1 : 	//$status_new = 	11;
						//$status_msg	=	'已取消';
						break;
			case 0 : 	$status_new = 	12;
						$status_msg	=	'待付款';
						break;*/
			case 1 : 	if($v['use_status'] == 1){
							//$status_new = 	13;
							$rows[$k]['status_msg']	=	'已消费';
						}else if($v['use_status'] == 0 && time() < strtotime($v['validdate']) ){
							//$status_new = 	14;
							$rows[$k]['status_msg']	=	'未消费';
						}else if($v['use_status'] == 0 && time() > strtotime($v['validdate'])){
							//$status_new = 	15;
							$rows[$k]['status_msg']	=	'已过期';
						}
						break;
		/*	case 2 : 	$status_new = 	16;
						$status_msg	=	'退款中';
						break;*/
		   }
		}
		
		
		return array('total' => $count, 'rows' => $rows);
	}
	
   //浏览记录存cookie	
	function setcookies($id)
	{
		//$id = $pars['id'];	
		if($id)
		{  
			$product_ids	=	cookie('xgjs_products');	//获取cookie
			$products_arr	=	unserialize($product_ids);
			// print_r($products_arr);die;
			$time_now		=	time();						//当前时间	
		
			$products_arr[$id]	=	$time_now;

			$products_array	=	array();
			$time_15		=	time_now-3600*24*15;
			foreach($products_arr as $k=>$v){
				//保存没超过15天的数据
				if( $v > $time_15 ){
					$products_array[$k]	=	$v;
				}	
			}
			// arsort($products_array);
			$products_str	=	serialize ($products_array);
			cookie('xgjs_products',$products_str,3600*24*15);
			 return array('code'=>1);
		}
		else
		{
	          return array('code'=>0);
		}	  
	}
	
	//获取浏览记录
	function getcookies($page)
	{
		if($page=='')
		{
			$page = 1;
		}	
		$size = 6;
	    $product_ids=	cookie('xgjs_products');
		$c_p_list	=	array();
		if($product_ids){
		$product_arr	=	unserialize($product_ids);
		$in_sql			=	' id IN (';
		 //echo $product_ids.'</br>';dump($product_arr);die;
		foreach($product_arr as $k=>$v){
			$in_sql		.=	"{$k},";
		}
		$sql			=	substr($in_sql,0,-1);
		$sql	 		.=	') ';
		// echo $sql;die;
		$c_products		=	M('products')->where($sql)->select();
		$pro_arr		=	array();
		foreach($c_products as $kp=>$vp){
			$pro_arr[$product_arr[$vp['id']]]	=	$vp;
		}
		krsort($pro_arr);
		$c_p_list			= 	array_slice($pro_arr,($page-1)*$size,$page*$size);	
	   } 
	   
	   return array('rows' => $c_p_list);
	   
	}
		
	//收藏商品、店铺
	function setcollection($id,$user_id,$type)
	{

		//组装参数
		$param['user_id']	=	$user_id;
		if($type == 1){
			$param['product_id']	=	$id;
			
		}else if( $type == 2){
			$param['shop_id']		=	$id;
		}
		$param['type']			=	$type;
		$userfav		=	M('userFavorite')->where($param)->find();
		// print_r($param);die;
		if(!empty($userfav)){
			return array('code'=>2,'msg'=>'该商品已收藏');//该商品已收藏
		}
		$param['create_time']	=	date('Y-m-d H:i:s',time());
		// print_r($param);die;
		$res	=	M('userFavorite')->add($param);
		if(!$res){
			return array('code'=>3,'msg'=>'收藏失败');	//收藏失败
		}
		return array('code'=>1,'msg'=>'添加收藏成功');	//添加收藏成功
	}
	
	//获取收藏的商品、店铺
	function getcollection($user_id,$type,$page=1,$size=6)
	{
		if($page=='')
		{
			$page = 1;
		}
		
		if($type=='product')
		{
		   	$rows	=	M('userFavorite')->alias('uf')
						->field('p.*,uf.id fid')
						->join('jbr_products AS p ON p.id=uf.product_id')
						->where(array('uf.user_id'=>$user_id,'uf.type'=>1))
						->order('uf.id desc')
						->limit(($page - 1) * $size,$size)
						->select();
		    $count		=	M('userFavorite')->alias('uf')
						->join('jbr_products AS p ON p.id=uf.product_id')
						->where(array('uf.user_id'=>$user_id,'uf.type'=>1))
						->count();
		}
        else
        {
			$rows	=	M('userFavorite')->alias('uf')
						->field('s.id,s.shop_name,s.shop_img,uf.type,uf.shop_id')
						->join('jbr_shop AS s ON s.id=uf.shop_id')
						->where(array('uf.user_id'=>$user_id,'uf.type'=>2))
						->order('uf.id desc')
						->limit(($page - 1) * $size,$size)
						->select();	
			$count	=	M('userFavorite')->alias('uf')
						->field('s.id,s.shop_name,s.shop_img,uf.type,uf.shop_id')
						->join('jbr_shop AS s ON s.id=uf.shop_id')
						->where(array('uf.user_id'=>$user_id,'uf.type'=>2))
						->count();
            			
			foreach($rows as $k=>$v)
			{
				if($v['type']==2)
				{
					$rows[$k]['attention_count'] = M('user_favorite')->where(array('shop_id'=>$v['shop_id']))->count();    //关注度
				}	
			}
		}	
		
		return array('count'=>$count,'rows'=>$rows);
	}
     
	
    //获取会员安全等级
    function getusergrade($user_id)
    {
	    $user_info = M('member')->where(array('id'=>$user_id))->find();
		
		$num	=	0;
		if($user['mobile_check']== '1' ){
			$num++;
		}
		if($user['email_check']== '1' ){
			$num++;
		}
		if( !empty($user['pay_pass']) ){
			$num++;
		}
		switch($num){
			case 0 :  $grade = '<font style="color:red;">"低"</font>';break;
			case 1 :  $grade = '<font style="color:red;">"低"</font>';break;
			case 2 :  $grade = '"中"';break;			
			case 3 :  $grade = '<font style="color:green;">"高"</font>';break;
		}
	   
	   return $grade;
	}	
	 
	 
	//获取会员积分记录
    function getpoints($user_id,$page=1,$size=6)
	{
		$rows		=	M('score_list')                                 //会员积分记录
						->where('user_id='.$user_id.' AND score<>0 ')
						->order('score_time DESC')
						->page($page,$size)
						->select();
		
		$count		=	M('score_list')
						->where('user_id='.$user_id)
						->count();
        
		$user_info  =  M('member')                                        //会员信息
                       ->where('id='.$user_id)	    
		               ->find();
		
		$grade		=  M('userGrade')
		               ->order('min_score DESC')
					   ->select();			   
		$grade_c	=	array();
		
		foreach($grade  as $kg=>$vg){                                   //会员等级信息
			if( $user_info['score_total'] >= $vg['min_score'] ){
				$grade_c	=	$vg;
				break;
			}
		}			   
					   
        return array('count'=>$count,'rows'=>$rows,'user_info'=>$user_info,'grade'=>$grade_c);
		
	}
	
	
	/** 获取商品评论
	 *  $comment_type 1 b2c商品 2 酒店商品 3 电影票 
	*/ 
	function getcomment($order_id,$product_id,$comment_type)
	{
		if($product_type==1)
		{
			$comment = M('user_comment')->where(array('product_id'=>$product_id,'order_id'=>$order_id))->find();
		}
		
		return $comment;
	}
	 
	 
	/**
     *   提交评论
     *	 param   B2C{order_id   子订单ID   shop_id 店铺ID          comment_type 评价类型    product_id   商品ID   user_id  用户ID
	                 content    评价内容   product_score 商品评分  express_score  物流评分  imgs  图片（String）}
				 酒店{}
				 影院{}
	**/ 
	 
	function addcomment($pars)
    {
		if($pars['comment_type']==1)
		{
			//评价图片处理
			if($pars['imgs']!='')
			{
			    $img_arr = explode(',',$pars['imgs']);
                foreach($img_arr as $k=>$v)
				{
					$arr_img[] = myput($_SERVER['DOCUMENT_ROOT'].$v,'comment_b2c');
				}				
			}
			
			$data = array('order_id'      =>$pars['order_id'],
			              'shop_id'       =>$pars['shop_id'],
			              'product_id'    =>$pars['order_id'],
						  'content'       =>$pars['content'],
						  'product_score' =>$pars['product_score'],
						  'express_score' =>$pars['express_score'],
						  'user_id'       =>$pars['user_id'],
						  'imgs'          =>implode(',',$arr_img),
						  'comment_time'  =>date('Y-m-d H:i:s',time())
			         );
			$r = M('user_comment')->data($data)->add();
            if($r)
			{
				  //根据订单id查询所有未评论的商品
				  $products = get_b2c_products($pars['order_id'],$pars['user_id']);
				  if(empty($products))       //没有未评价的商品
				  {
					  $s = M('subOrders')->where(array('id'=>$pars['order_id']))->setField('commented',1);     //更新订单评论状态为1
				  } 
			      
				 return 1;
			}
            else
            {
				return 0;
			}				
			
		}
		else if($pars['comment_type']==2)     //酒店评论
        {
			//评价图片处理
			if($pars['imgs']!='')
			{
			    $img_arr = explode(',',$pars['imgs']);
                foreach($img_arr as $k=>$v)
				{
					$arr_img[] = myput($_SERVER['DOCUMENT_ROOT'].$v,'comment_hotel');
				}				
			}
			
			$data = array('order_num'     =>$pars['order_num'],
			              'sub_shop_id'   =>$pars['sub_shop_id'],
						  'content'       =>$pars['content'],
						  'product_score' =>$pars['product_score'],
						  'user_id'       =>$pars['user_id'],
						  'imgs'          =>implode(',',$arr_img)
			         );
			$r = M('sub_shops_review')->data($data)->add();
			if($r)
			{
				$s = M('orders_hotel')->where(array('order_num'=>$pars['order_num']))->setField('commented',1);
				return 1;
			}
			else
			{
				return 0;
			}
			
		}
        else if($pars['comment_type']==3)
        {
			//评价图片处理
			if($pars['imgs']!='')
			{
			    $img_arr = explode(',',$pars['imgs']);
                foreach($img_arr as $k=>$v)
				{
					$arr_img[] = myput($_SERVER['DOCUMENT_ROOT'].$v,'comment_film');
				}				
			}
			//根据影院ID查询店铺ID
			$shop_id = M('cinemaInfo')->where(array('cinema_id'=>$pars['cinema_id']))->getField('shop_id');
			
			$data = array('channelOrderNo'=>$pars['order_num'],
			              'shop_id'       =>$pars['shop_id'],
						  'content'       =>$pars['content'],
						  'product_score' =>$pars['product_score'],
						  'user_id'       =>$pars['user_id'],
						  'imgs'          =>implode(',',$arr_img)
			         );
			$r = M('shops_review')->data($data)->add();
			if($r)
			{
				$s = M('orders_film')->where(array('channelOrderNo'=>$pars['order_num']))->setField('commented',1);
				return 1;
			}
			else
			{
				return 0;
			}
		}			
		
		
	}	
	 
	//根据订单id查询所有未评论的商品
	function get_b2c_products($id,$user_id){
		$orders_info	=	M('orders_info')->alias('oi')
							->field('oi.*,so.add_time,so.shop_id')
							->join('jbr_sub_orders so ON so.id=oi.sub_order_id')
							->where('oi.sub_order_id='.$id)
							->select();
		// print_r($orders_info);die;
		$products	=	array();
		//搜索商品,保存未评论的商品
		foreach($orders_info as $k=>$v){
			if($v['product_type'] == '0'){
				if( !empty($products[$v['product_id']]) ){
					continue;
				}
				$product	=	M('products')->field('thumb_pic')->where('id='.$v['product_id'])->find();
				$comment	=	M('user_comment')
								->where("user_id={$user_id} AND product_id={$v['product_id']} AND order_id={$v['sub_order_id']}")
								->find();
				if(empty($comment) ){					
					$products[$v['product_id']]	=	array(
														'id'			=>	$v['product_id'],
														'product_title'	=>	$v['product_title'],
														'deal_price'	=>	$v['deal_price'],
														'add_time'		=>	$v['add_time'],
														'thumb_pic'		=>	$product['thumb_pic'],
														'order_id'		=>	$v['sub_order_id'],
														'shop_id'		=>	$v['shop_id']
													);
				}
				// print_r($products);die;
			}else{
				$sub_order_info	=	M('sub_orders_info')->where('order_info_id='.$v['id'])->select();
				foreach($sub_order_info as $ksoi=>$vsoi){
					if( !empty($products[$vsoi['product_id']]) ){
						continue;
					}
					$product	=	M('products')->field('thumb_pic')->where('id='.$vsoi['product_id'])->find();
					$comment	=	M('user_comment')
									->where("user_id={$user_id} AND product_id={$vsoi['product_id']} AND order_id={$v['sub_order_id']}")
									->find();
					if(empty($comment)){
						$products[]	=	array(
											'id'			=>	$vsoi['product_id'],
											'product_title'	=>	$vsoi['product_title'],
											'deal_price'	=>	$vsoi['deal_price'],
											'add_time'		=>	$v['add_time'],
											'thumb_pic'		=>	$product['thumb_pic'],
											'order_id'		=>	$v['sub_order_id'],
											'shop_id'		=>	$v['shop_id']
										);
					}
					// print_r($products);die;
				}
			}
		}
		// print_r($products);die;
		return $products;
	} 
	 
	//new get_order  b2c
	  #by lxf

     function get_b2corder( $pars  ){
		 
		$page		=	''==$pars['page']? 1 : $pars['page'];
		$rows		=	4;
		$start		=	($page-1)*$rows;
		$type		=	''==$pars['type'] ? "all" : $pars['type'];
		$keyword	=	''==I('get.keyword') ? '' : I('get.keyword');
		
		$time		=	time();
		$time_24	=	date('Y-m-d H:i:s',$time-base_info('paytime')*3600);
		
		/* $this->keyword=	$keyword;
		//关键字搜索
		if($keyword != ''){
			$data 	= 	$this->b2c_search($keyword);
			// print_r($data);die;
			$type	=	"all";	
		} */
		$str_payed 		= 	empty($keyword) ? '' : ' AND ('.$data['payed'].')';
		$str_nopay		=	empty($keyword) ? '' : ' AND ('.$data['nopay'].')';
		// echo $str_payed.'-'.$str_nopay;die;
		if($type == 'all'){
			//基础订单信息sql
			$sql_order	=	"SELECT o4.* FROM
							(SELECT o1.id,o1.id p_order_id,o1.order_num,o1.addtime add_time,o1.receive_name,o1.status,o1.deal_price,o1.over_pay_price,o1.is_check
							FROM jbr_orders o1 
							WHERE o1.is_cod=0 AND o1.status=0 AND o1.user_id={$pars['id']} {$str_nopay}
							UNION All
							SELECT o2.id,o2.p_order_id,o2.sub_order_num order_num,o2.add_time,o3.receive_name,o2.order_status status,o2.deal_price,o2.over_pay_price,o2.is_check 
							FROM jbr_sub_orders o2 
							INNER JOIN jbr_orders o3 ON o3.id=o2.p_order_id 
							WHERE o2.is_cod=0 AND o2.order_status>0 AND o2.user_id={$pars['id']} {$str_payed} ) o4
							ORDER BY o4.add_time DESC
							LIMIT {$start},{$rows}";
			//总数sql
			$sql_count	=	"SELECT COUNT(*) num FROM
							(SELECT o1.id,o1.order_num,o1.addtime add_time,o1.receive_name,o1.status,o1.deal_price,o1.over_pay_price,o1.is_check 
							FROM jbr_orders o1 
							WHERE o1.is_cod=0 AND o1.status=0 AND o1.user_id={$pars['id']} {$str_nopay}
							UNION All
							SELECT o2.id,o2.sub_order_num order_num,o2.add_time,o3.receive_name,o2.order_status status,o2.deal_price,o2.over_pay_price,o2.is_check 
							FROM jbr_sub_orders o2 
							INNER JOIN jbr_orders o3 ON o3.id=o2.p_order_id 
							WHERE o2.is_cod=0 AND o2.order_status>0 AND o2.user_id={$pars['id']} {$str_payed} ) o4";
		}else if($type == '0'){
			//基础订单信息sql
			$sql_order	=	"SELECT o1.id,o1.order_num,o1.addtime add_time,o1.receive_name,o1.status,
							o1.deal_price,o1.over_pay_price,o1.is_check,o1.id p_order_id 
							FROM jbr_orders o1 
							WHERE o1.is_cod=0 AND o1.status=0 AND o1.user_id={$pars['id']} AND o1.addtime>'{$time_24}'
							ORDER BY o1.addtime DESC
							LIMIT {$start},{$rows}";
			//总数sql
			$sql_count	=	"SELECT COUNT(*) num
							FROM jbr_orders o1 
							WHERE o1.is_cod=0 AND o1.status=0 AND o1.user_id={$pars['id']} AND o1.addtime>'{$time_24}'";
		}else{
			$commented	=	'';
			if($type == '3')	$commented	=	'AND o2.commented=0 ';
			//基础订单信息sql
			$sql_order	=	"SELECT o2.id,o2.sub_order_num order_num,o2.add_time,o3.receive_name,
							o2.order_status status,o2.deal_price,o2.over_pay_price,o2.is_check,o2.p_order_id
							FROM jbr_sub_orders o2 
							INNER JOIN jbr_orders o3 ON o3.id=o2.p_order_id 
							WHERE o2.is_cod=0 AND o2.order_status={$type} AND o2.user_id={$pars['id']} {$commented}
							ORDER BY o2.add_time DESC
							LIMIT {$start},{$rows}";
			//总数sql
			$sql_count	=	"SELECT COUNT(*) num 
							FROM jbr_sub_orders o2 
							INNER JOIN jbr_orders o3 ON o3.id=o2.p_order_id 
							WHERE o2.is_cod=0 AND o2.order_status={$type} AND o2.user_id={$pars['id']} {$commented}";
		}
       //echo $sql_order;exit;
		$orders		=	M('')->query($sql_order);
		$count		=	M('')->query($sql_count);
		$list		=	array();
		$orders_p	=	getOrderProducts($orders);
		
		//$num	=	$this->b2c_num();
		
		//print_r( $orders_p );exit;

		foreach($orders_p as $k=>$v)
		{
			switch($v['status'])
			{
			    case 0:
 			    $orders_p[$k]['status_name'] = '待付款';
				$orders_p[$k]['categroy'] = '<a href="/weixin/index.php/User/OrderInfo/order_details.html?id='.$v['p_order_id'].'">详情</a>' . ( 1 == $orders_p[$k]['is_check'] ? '<a href="/weixin/index.php/Pay/WeixinPay/pay.html?ordernum='.$v['order_num'].'&order_type=1">去支付</a>' : '');
				break;
				case 1:
 			    $orders_p[$k]['status_name'] = '待发货';
				$orders_p[$k]['categroy'] = '<a href="/weixin/index.php/User/OrderInfo/order_details.html?id='.$v['p_order_id'].'">详情</a>';
				break;
				case 2:
 			    $orders_p[$k]['status_name'] = '待收货';
				$orders_p[$k]['categroy'] = '<a href="/weixin/index.php/User/OrderInfo/order_details.html?id='.$v['p_order_id'].'">详情</a><a href="javascript:void();" onclick="getProduct(0,'.$v['id'].')">确认收货</a>';
				break;
				case 3:
				if( empty( $v['shops'][0]['commented']) ){
					
					 $orders_p[$k]['status_name'] = '待评价';
					 
					 $orders_p[$k]['categroy'] = '<a href="/weixin/index.php/User/OrderInfo/order_details.html?id='.$v['p_order_id'].'">详情</a><a href="/weixin/index.php/User/Orders/commentlist.html?order_id='.$v['id'].'">去评价</a>';
					 
				}else{
					
					$orders_p[$k]['status_name'] = '已完成';
					$orders_p[$k]['categroy'] = '<a href="/weixin/index.php/User/OrderInfo/order_details.html?id='.$v['p_order_id'].'">详情</a>';
				}
 			   
				
				break;
				case 4:
 			    $orders_p[$k]['status_name'] = '退换货';
				$orders_p[$k]['categroy'] = '';
				break;
				case 6:
 			    $orders_p[$k]['status_name'] = '已取消';
				$orders_p[$k]['categroy'] = '<a href="/weixin/index.php/User/OrderInfo/order_details.html?id='.$v['p_order_id'].'">详情</a>';
				break;
			}
		}
        return array('total' => $count, 'rows' => $orders_p);
		 
	 }	
	 
	 //获得cod 订单
	 
	 function get_codorder( $pars ){
		 
		$page		=	''==$pars['page']? 1 : $pars['page'];
		$rows		=	8;
		$start		=	($page-1)*$rows;
		$type		=	''==$pars['type'] ? "all" : $pars['type'];
		$keyword	=	''==I('get.keyword') ? '' : I('get.keyword');
		
		$time		=	time();
		$time_24	=	date('Y-m-d H:i:s',$time-base_info('paytime')*3600);
		
/* 		$this->keyword=	$keyword;
		//关键字搜索
		if($keyword != ''){
			$data 	= 	$this->cod_search($keyword);
			$type	=	"all";	
		} */
		$str_payed 		= 	empty($keyword) ? '' : ' AND ('.$data['payed'].')';
		$str_nopay		=	empty($keyword) ? '' : ' AND ('.$data['nopay'].')';

		if($type == 'all'){
			//基础订单信息sql
			$sql_order	=	"SELECT o4.* FROM
							(SELECT o1.id,o1.id p_order_id,o1.order_num,o1.addtime add_time,o1.receive_name,o1.status,o1.deal_price,o1.over_pay_price,o1.is_check
							FROM jbr_orders o1 
							WHERE o1.is_cod=1 AND o1.status=0 AND o1.user_id={$pars['id']} {$str_nopay}
							UNION All
							SELECT o2.id,o2.p_order_id,o2.sub_order_num order_num,o2.add_time,o3.receive_name,o2.order_status status,o2.deal_price,o2.over_pay_price,o2.is_check 
							FROM jbr_sub_orders o2 
							INNER JOIN jbr_orders o3 ON o3.id=o2.p_order_id 
							WHERE o2.is_cod=1 AND o2.order_status>0 AND o2.user_id={$pars['id']} {$str_payed} ) o4
							ORDER BY o4.add_time DESC
							LIMIT {$start},{$rows}";
			//总数sql
			$sql_count	=	"SELECT COUNT(*) num FROM
							(SELECT o1.id,o1.order_num,o1.addtime add_time,o1.receive_name,o1.status,o1.deal_price,o1.over_pay_price,o1.is_check 
							FROM jbr_orders o1 
							WHERE o1.is_cod=1 AND o1.status=0 AND o1.user_id={$pars['id']} {$str_nopay}
							UNION All
							SELECT o2.id,o2.sub_order_num order_num,o2.add_time,o3.receive_name,o2.order_status status,o2.deal_price,o2.over_pay_price,o2.is_check 
							FROM jbr_sub_orders o2 
							INNER JOIN jbr_orders o3 ON o3.id=o2.p_order_id 
							WHERE o2.is_cod=1 AND o2.order_status>0 AND o2.user_id={$pars['id']} {$str_payed} ) o4";
		}else if($type == '0'){
			//基础订单信息sql
			$sql_order	=	"SELECT o1.id,o1.order_num,o1.addtime add_time,o1.receive_name,o1.status,
							o1.deal_price,o1.over_pay_price,o1.is_check,o1.id p_order_id 
							FROM jbr_orders o1 
							WHERE o1.is_cod=1 AND o1.status=0 AND o1.user_id={$pars['id']} AND o1.addtime>'{$time_24}'
							ORDER BY o1.addtime DESC
							LIMIT {$start},{$rows}";
			//总数sql
			$sql_count	=	"SELECT COUNT(*) num
							FROM jbr_orders o1 
							WHERE o1.is_cod=1 AND o1.status=0 AND o1.user_id={$pars['id']} AND o1.addtime>'{$time_24}'";
		}else{
			$commented	=	'';
			if($type == '3')	$commented	=	'AND o2.commented=0 ';
			//基础订单信息sql
			$sql_order	=	"SELECT o2.id,o2.sub_order_num order_num,o2.add_time,o3.receive_name,
							o2.order_status status,o2.deal_price,o2.over_pay_price,o2.is_check,o2.p_order_id
							FROM jbr_sub_orders o2 
							INNER JOIN jbr_orders o3 ON o3.id=o2.p_order_id 
							WHERE o2.is_cod=1 AND o2.order_status={$type} AND o2.user_id={$pars['id']} {$commented}
							ORDER BY o2.add_time DESC
							LIMIT {$start},{$rows}";
			//总数sql
			$sql_count	=	"SELECT COUNT(*) num 
							FROM jbr_sub_orders o2 
							INNER JOIN jbr_orders o3 ON o3.id=o2.p_order_id 
							WHERE o2.is_cod=1 AND o2.order_status={$type} AND o2.user_id={$pars['id']} {$commented}";
		}
		// echo $sql_order;die;
		$orders		=	M('')->query($sql_order);
		$count		=	M('')->query($sql_count);
		$list		=	array();
		$orders_p	=	getOrderProducts($orders);
		// print_r($count);die;
		//$num	=	$this->cod_num();
		
		foreach($orders_p as $k=>$v)
		{
			switch($v['status'])
			{
			    case 0:
 			    $orders_p[$k]['status_name'] = '待付款';
				$orders_p[$k]['categroy'] = '<a href="/weixin/index.php/User/OrderInfo/order_details.html?id='.$v['p_order_id'].'">详情</a><a href="/weixin/index.php/Pay/WeixinPay/pay.html?ordernum='.$v['order_num'].'&order_type=1">去支付</a>';
				break;
				case 1:
 			    $orders_p[$k]['status_name'] = '待发货';
				$orders_p[$k]['categroy'] = '<a style="margin-left:0.3rem;" href="/weixin/index.php/User/OrderInfo/order_details.html?id='.$v['p_order_id'].'">详情</a>';
				break;
				case 2:
 			    $orders_p[$k]['status_name'] = '待收货';
				$orders_p[$k]['categroy'] = '<a style="margin-left:0.3rem;" href="/weixin/index.php/User/OrderInfo/order_details.html?id='.$v['p_order_id'].'">详情</a><a href="javascript:void();" onclick="getProduct(1,'.$v['id'].')">确认收货</a>';
				break;
				case 3:
 			    if( empty( $v['shops'][0]['commented']) ){
					
					 $orders_p[$k]['status_name'] = '待评价';
					 
					 $orders_p[$k]['categroy'] = '<a style="margin-left:0.3rem;" href="/weixin/index.php/User/OrderInfo/order_details.html?id='.$v['p_order_id'].'">详情</a><a href="/weixin/index.php/User/Orders/commentlist.html?order_id='.$v['id'].'">去评价</a>';
					 
				}else{
					
					$orders_p[$k]['status_name'] = '已完成';
					$orders_p[$k]['categroy'] = '<a style="margin-left:0.3rem;" href="/weixin/index.php/User/OrderInfo/order_details.html?id='.$v['p_order_id'].'">详情</a>';
				}
				break;
				case 4:
 			    $orders_p[$k]['status_name'] = '退换货';
				$orders_p[$k]['categroy'] = '';
				break;
				case 6:
 			    $orders_p[$k]['status_name'] = '已取消';
				$orders_p[$k]['categroy'] = '<a style="margin-left:0.3rem;" href="/weixin/index.php/User/OrderInfo/order_details.html?id='.$v['p_order_id'].'">详情</a>';
				break;
			}
		}
        return array('total' => $count, 'rows' => $orders_p);
		 
	 }
	 
	 
/***
*$string 加密字符串 ，$operation E 加密，D 解密 $key='密钥'
*
*/
function encrypt($string,$operation,$key=''){
    $key=md5($key);
    $key_length=strlen($key);
    $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string;
    $string_length=strlen($string);
    $rndkey=$box=array();
    $result='';
    for($i=0;$i<=255;$i++){
           $rndkey[$i]=ord($key[$i%$key_length]);
        $box[$i]=$i;
    }
    for($j=$i=0;$i<256;$i++){
        $j=($j+$box[$i]+$rndkey[$i])%256;
        $tmp=$box[$i];
        $box[$i]=$box[$j];
        $box[$j]=$tmp;
    }
    for($a=$j=$i=0;$i<$string_length;$i++){
        $a=($a+1)%256;
        $j=($j+$box[$a])%256;
        $tmp=$box[$a];
        $box[$a]=$box[$j];
        $box[$j]=$tmp;
        $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
    }
    if($operation=='D'){
        if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8)){
            return substr($result,8);
        }else{
            return'';
        }
    }else{
        return str_replace('=','',base64_encode($result));
    }
} 	 
?>

