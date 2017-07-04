<?php

// +----------------------------------------------------------------------
// |股权计算器系统代码
// +----------------------------------------------------------------------


//获取该条记录的最终计算结果
/*
 * @param $data array 计算结果 
 * @param $first_name 第一大股东的名字
 * @param $first 第一大股东股权份额
 * @param $score 结果集的基本分数
 * return $fin_score 最终得分 
 * */
function get_score($data,$first_name,$first,$score,$full_time)
{
    //计算第一项：股东人数减去全职股东人数
    if($data['partner_num']>count($full_time))
    {
        $score -= ($data['partner_num']-count($full_time))*3;
    }

    //第一大股东大于85%　减去２分
    if($first>85)
    {
        $score -= 2 ;
    }
    
    //第一大股东是否为CEO
    if(in_array($data['is_ceo'],$first_name))
    {
        //如果第一大股东是CEO
        $score += 2;
    }else
    {
        //如果第一大股东不是CEO
        $score -= 2;
    }
    
    //第一大股东是否为董事长
    if(in_array($data['is_direct'],$first_name))
    {
        //如果第一大股东是董事长
        $score += 2;
    }else
    {
        //如果第一大股东不是董事长
        $score -= 2;
    }
    
    //有无期权计划
    if($data['is_pool'] == '是')
    {
        //有期权计划
        $score += 2;
    }else
    {
        //无期权计划
        $score -= 2;
    }
    
    //第二大股东 和最小股东差
    $sort = $data['stock_scale'];
    //排序并去重
    asort($sort);
    foreach($sort as $k=> $v)
    {
        if($v == $first)
        {
            //去除其中的最大的元素
            unset($sort[$k]);
        }
    }
    
    //比较差值
    if(count($sort)>1)
    {
        //最大值减最小值
        $dif_score = $sort[count($sort)-1]-$sort[0];
        $score -=floor($dif_score/3);      
    }
    return $score;
}
