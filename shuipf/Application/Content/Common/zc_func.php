<?php

// +----------------------------------------------------------------------
// | 众筹系统共用代码
// +----------------------------------------------------------------------

// zc = 众筹
// error = 错误
// debug = 调试

/**
 * 获得某个课程的过期时间（是开课时间的前一天0点， 例如3月23号9点开课，过期时间则是3月22号0点）
 * @param $course_id 课程ID
 * 返回时间戳
 */
function getOverTime($course_id){
    $start_time = M("courses")->where("id={$course_id}")->getField("start_time");//获得开课时间
    $start_time = date("Y-m-d", $start_time);//格式化时间
    return strtotime($start_time);
}

/**
 * 创建一个众筹活动的方法（新增记录到funding表）
 * @param $member_id 会员ID（谁发起的活动）
 * @param $order_code 订单号（对应到order表的verification_code）
 * @param $product_id 众筹商品id（对应course的id）
 * @param $price 众筹实际需要的金额
 * @param $truename 姓名
 * @param $mobile 电话
 */
function createFunding($member_id,$order_code,$product_id,$price,$truename,$mobile){
    $data=array(
//         "share"=>"自己说点什么",
        "member_id"=>$member_id,
        "order_code"=>$order_code,
//         "num"=>0,
        "create_time"=>time(),
        "end_time"=>getOverTime($product_id),
        "updatetime"=>time(),
        "status"=>0,
        "price"=>$price,
        "total_price"=>0,
        "product_id"=>$product_id,
        "truename"=>$truename,
        "mobile"=>$mobile
    );
    $funding = M("funding");
    $insertId=$funding->add($data);
    if($insertId){
        $result = array("ret"=>"success","funding_id"=>$insertId);
    }else {
        $result = array("ret"=>"fail","error_msg"=>$funding->getLastSql());
    }
    return $result;
}

/**
 * 众筹支付成功
 * @param $verification_code 众筹记录唯一订单号
 * @param $transaction_id 商户订单号（支付宝or微信自己生成的）
 */
function pay_zc_success($verification_code,$transaction_id){
    $funding_log = M('funding_log');
    $log = $funding_log->where("verification_code='".$verification_code."'")->find();//找到众筹记录
    if(isset($log['status']) && $log['status'] == 0){//若状态还未改变
        //修改众筹记录状态
        $funding_log->where("verification_code='".$verification_code."'")->data(array('transaction_id'=>$transaction_id,'status'=>1,'updatetime'=>date('Y-m-d H:i:s',time())))->save();//更新状态为已付款
        //修改众筹活动累计金额
        $moneyRet = M("funding")->where("id={$log['fid']}")->setInc('total_price',$log['money']);//增加众筹活动累计金额
        
        //更新众筹活动参与人数（废弃功能）
//         $num = M("funding_log")->where("fid={$log['fid']} AND status=1")->count("distinct member_id");
//         M("funding")->where("id={$log['fid']}")->data(array('num'=>$num,'updatetime'=>time()))->save();

        /**   发送模板消息  ——start——*/
        $rs=M("funding")->join("LEFT JOIN jbr_member ON jbr_member.id=jbr_funding.member_id")->join("LEFT JOIN jbr_courses ON jbr_courses.id=jbr_funding.product_id")->where("jbr_funding.id={$log['fid']}")->field("jbr_courses.title,jbr_member.openid")->find();
        $openid=$rs['openid'];
        if(!empty($openid)){
            $first = "您的众筹活动收到一笔支持款";
            $title=$rs['title'];
            $name=$log['truename'];
            $money=$log['money'];
            $time= date("Y-m-d H:i");
            $remark="对方留言：".$log['message']."（点击'详情'回复）";
            $url="http://".$_SERVER['HTTP_HOST']."/index.php?m=Funding&a=share&id={$log['fid']}";
            sendTplFundingPartner($openid, $first, $title, $name, $money, $time, $remark,$url);
        }
        /**   发送模板消息  ——end——*/
        
        //判断众筹活动是否完成
        $funding = M("funding")->where("id={$log['fid']}")->find();//找到众筹活动
        if($funding['total_price'] >= $funding['price']){//众筹成功，金额已经满足了
            M("funding")->where("id={$log['fid']}")->data(array('status'=>1,'updatetime'=>time()))->save();
            pay_success($funding['order_code']);
        }
    }
}

/**
 * 查询我的众筹活动列表
 * @param $userid 用户ID
 * @param $status 状态，若为空表示查全部
 */
function get_my_funding($userid,$status="all"){
    
    $w_s = $status!='all'?' and f.status='.$status:''; 
	$funding = M('funding')->alias('f')->join('LEFT JOIN jbr_courses c on f.product_id=c.id')->where('f.member_id='.$userid.$w_s)->field('f.id,f.num,f.status,f.price,f.total_price,c.title,c.thumb')->select();
	return $funding;
	}