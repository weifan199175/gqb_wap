<?php

// +----------------------------------------------------------------------
// | 众筹系统共用代码2   wifi专用
// +----------------------------------------------------------------------

// zc = 众筹
// error = 错误
// debug = 调试

/**
 * 获取时间距离
 * @param $time int 时间戳
 * @return $d_time 时间差 unknown type 
 * */
function getTime($time)
{
    $d_time = time()-$time;
    if($d_time/60<1)
    {
        $d_time = '刚刚';
        return $d_time;
    }
    else if($d_time/60<60 && $d_time/60>1)
    {
        //如果时间差小于60分钟，且大于1，则显示分钟
        $d_time = ceil($d_time/60).'分钟';
        return $d_time;
    }
    elseif($d_time/3600<24 && $d_time/3600>1)
    {
        //如果时间差小于24小时，则显示小时
        $d_time = ceil($d_time/3600).'小时';
        return $d_time;
    }elseif($d_time/3600>24)
    {
        //如果时间差大于24小时，则显示天
        $d_time = ceil($d_time/86400).'天';
        return $d_time;
    }
}

/*
 * 获取时间差
 * 
 * */
function timediff($begin_time,$end_time)
{
    if($begin_time < $end_time){
        $starttime = $begin_time;
        $endtime = $end_time;
    }
    else{
        $starttime = $end_time;
        $endtime = $begin_time;
    }
    $timediff = $endtime-$starttime;
    echo $timediff;
    $days = intval($timediff/86400);
    echo "<br>";
    echo $days;
    $remain = $timediff%86400;
    echo "<br>";
    echo $days;
    $hours = intval($remain/3600);
    $remain = $remain%3600;
    $mins = intval($remain/60);
    $secs = $remain%60;
    $res = array("day" => $days,"hour" => $hours,"min" => $mins,"sec" => $secs);
    return $res;
} 

/*
 * 获取当日交易批次号
 *
 * */
function get_batch_no(){
    @date_default_timezone_set("PRC");
    while(true){
        //批次号日期
        $order_date = date('Y-m-d');
        //批次号主体（YYYYMMDDHHIISSNNNNNNNN）
        $order_id_main = date('YmdHis').rand(10000000,99999999);
        //批次号主体长度
        $order_id_len = strlen($order_id_main);
        $order_id_sum = 0;
        for($i=0; $i<$order_id_len; $i++){
            $order_id_sum += (int)(substr($order_id_main,$i,1));
        }
        //批次号号码（YYYYMMDDHHIISSNNNNNNNNCC）
        $order_id = $order_id_main.str_pad((100 - $order_id_sum % 100) % 100,2,'0',STR_PAD_LEFT);
        return $order_id;
     }
}

/*
 * 将众筹订单中的支付宝交易号组装成标准格式
 * 
 * */
function get_refund_detail($log_info)
{
    $data_Single = array();
    foreach($log_info as $k=>$v)
    {
        if(ENV =='dev')
        {
            $data_Single[]= $v['transaction_id'].'^0.01^'.'众筹退款';
        }else{
            $data_Single[]= $v['transaction_id'].'^'.$v['money'].'^'.'众筹退款';
        }
    }
    //拼接多笔退款订单
    if(count($data_Single)=='1')
    {
        return $data_Single[0];
    }else
    {
        $data_Multi = implode('#',$data_Single);
        return $data_Multi;
    }
}

/*
 * 将众筹退款订单返回的数据格式，进行转换
 * */
 function change_result_details($result_details,$batch_no)
 {
     if($result_details){
         $result_arr = explode('#',$result_details);
         foreach($result_arr as $k=>$v)
         {
             //单笔数据集合数组
             $one_detail = array();
             $rs = explode('^',$v);
             $one_detail['transaction_id'] =$rs['0'];
             $one_detail['money'] = $rs['1'];
             $one_detail['result'] = $rs['2'];
             $result_arr[$k] =$one_detail;
         }
         return $result_arr;
     }else{
         return false; 
     }
     
 }
 
 /**
  * 修改众筹退款订单状态
  * 
  * */
 function zc_refund_success($transaction_id)
 {
     if($transaction_id)
     {
        //判断订单状态是否已经修改
        $status = M('funding_log')->where("transaction_id=".$transaction_id)->getField('status');
        if($status != '2')
        {
            $o =  M('funding_log')->where("transaction_id=".$transaction_id)->save(array("status"=>2,'updatetime'=>date("Y-m-d H:i:s",time())));
        }else
        {
            return true;
        }           
        if($o)
        {
            return true;
        }else
        {
            return false;
        }
     }
 }
