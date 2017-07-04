<?php

// +----------------------------------------------------------------------
// | 股权诊断器系统共用代码
// +----------------------------------------------------------------------

/**
 * 股权诊断器支付成功方法（更新状态）
 * @param $verification_code 诊断器记录唯一订单号
 * @param varchar $pay_channel 支付渠道（weixin，zhifubao）
 */
function pay_zdq_success($verification_code,$pay_channel=""){
    M('order')->where("verification_code='{$verification_code}'")->data(array('status'=>1,'pay_time'=>date('Y-m-d H:i:s',time()),'pay_channel'=>$pay_channel))->save();//订单表更新支付状态
    return M("dia_tool")->where("verification_code='{$verification_code}'")->data(array('status'=>1))->save();//更新状态为已付款
}

/**
 * 获得我的诊断器结果列表
 * @param $userid
 */
function get_my_zdq_List($userid){
    return M("dia_tool")->where("member_id=".$userid)->select();
}