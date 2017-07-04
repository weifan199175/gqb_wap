<?php

// +----------------------------------------------------------------------
// | 分销系统共用代码
// +----------------------------------------------------------------------

// fx = 分销
// error = 错误
// debug = 调试


//购买商品类型
const FX_BUY_COURSE = 1;//购买课程
const FX_BUY_MEMBER = 16;//购买铁杆会员
const FX_BUY_ASK = 17;//购买咨询


//提成者类型，是geren个人还是fenshe分社
//上一级的等级为1，上两级的等级为2，上三级的等级为3
const FX_CATEGORY_PERSON = "geren";//个人
const FX_CATEGORY_BRANCH_OFFICE = "fenshe";//分社


/**
 * 获得某个人的上级与顶级关系（用于分配提成）
 * @param $memberId 花钱的人
 * @return 数组，包括一级父类(parent_id)，二级父类(p_parent_id)，顶级分部(fenbu_id)
 */
function fx_getParentsId($memberId){
    $member = M('distribution')->where("member_id='{$memberId}'")->field(array('parent_id','p_parent_id','fenbu_id'))->find();
    return $member;
}

/**
 * 该方法用于计算提成比例和提成金额（仅计算结果并返回，不做其他操作）
 * @param $level 级别（父类为1级提成最多，父父类为2级提成中等，顶级为3级提成最少）
 * @param $money 本次消费的总金额
 * @param $product_type 购买课程or购买咨询or铁杆会员 （最上方常量有定义）
 * @param $category 提成者类型，是geren个人还是fenshe分社（最上方常量有定义）
 * 由以上4点可得出一个具体的比例和提成金额
 * 结果是一个数组,point是提成比例，commission是提成金额
 */
function fx_getFenchengMoney($level,$money,$product_type,$category){
    switch ($category) {//根据个人计算
        case FX_CATEGORY_PERSON:
            switch ($product_type) {//根据商品类型计算
                case FX_BUY_COURSE://购买课程（判断的数字后续可能会改变）
                    switch ($level) {//根据级别计算，个人最多只到2级
                        case 1:
                            $point = 0.3;//30%
                        break;
                        case 2:
                            $point = 0.1;//10%
                        break;
                    }
                    break;
                case FX_BUY_MEMBER://购买铁杆会员
                    switch ($level) {//根据级别计算，个人最多只到2级
                        case 1:
                            $point = 0.1;//10%
                            break;
                        case 2:
                            $point = 0.03;//3%
                            break;
                    }
                    break;
//                 case FX_BUY_ASK://购买咨询
//                     switch ($level) {//根据级别计算，个人最多只到2级
//                         case 1:
//                             $point = 0.10;//10%
//                             break;
//                         case 2:
//                             $point = 0.05;//5%
//                             break;
//                     }
//                     break;
            }
        break;
        case FX_CATEGORY_BRANCH_OFFICE://根据分社计算
            switch ($product_type) {//根据商品类型计算
                case FX_BUY_COURSE://购买课程（判断的数字后续可能会改变）
                    switch ($level) {//根据级别计算，分社最多只到3级
//                         case 1:
//                             $point = 0.5;//50%
//                         break;
                        case 2:
                            $point = 0.2;//20%
                        break;
                        case 3:
                            $point = 0.2;//20%
                        break;
                    }
                    break;
                case FX_BUY_MEMBER://购买铁杆会员
                    switch ($level) {//根据级别计算，分社最多只到3级
//                         case 1:
//                             $point = 0.3;//30%
//                             break;
                        case 2:
                            $point = 0.27;//27%
                            break;
                        case 3:
                            $point = 0.27;//27%
                            break;
                    }
                    break;
//                 case FX_BUY_ASK://购买咨询
//                     switch ($level) {//根据级别计算，分社最多只到3级
//                         case 1:
//                             $point = 0.2;//20%
//                             break;
//                         case 2:
//                             $point = 0.1;//10%
//                             break;
//                         case 3:
//                             $point = 0.05;//5%
//                             break;
//                     }
//                     break;
            }
        break;
    }
    $result = array(
        "point"=>(strval($point*100))."%",
        "commission"=>floor($money*$point),
    );
    return $result;
}


/**
 * 上一级的个人提成的方法，非分社
 * @param $fromid 分成者
 * @param $toid 提成者
 * @param $money 提成的总金额
 * @param $product_type 购买类型，最上面有常量定义
 * @param $verification_code 订单编号（对应到order表verification_code）
 * 
 */
function fx_getTichengByParent($fromid,$toid,$money,$product_type,$verification_code){
    //第一步计算出此人该有的提成比例和金额
    $ticheng = fx_getFenchengMoney(1, $money, $product_type, FX_CATEGORY_PERSON);
    $point = $ticheng['point'];
    $commission = $ticheng['commission'];
    //第二步进行提成操作并记录日志
    $ticheng_result = fx_doTicheng($fromid, $toid, FX_CATEGORY_PERSON, $point, $commission, $verification_code);
    
    return $ticheng_result;
}

/**
 * 上两级的个人提成的方法，非分社
 * @param $fromid 分成者
 * @param $toid 提成者
 * @param $money 提成的总金额
 * @param $product_type 购买类型，最上面有常量定义
 * @param $verification_code 订单编号（对应到order表verification_code）
 *
 */
function fx_getTichengByP_Parent($fromid,$toid,$money,$product_type,$verification_code){
    //第一步计算出此人该有的提成比例和金额
    $ticheng = fx_getFenchengMoney(2, $money, $product_type, FX_CATEGORY_PERSON);
    $point = $ticheng['point'];
    $commission = $ticheng['commission'];
    //第二步进行提成操作并记录日志
    $ticheng_result = fx_doTicheng($fromid, $toid, FX_CATEGORY_PERSON, $point, $commission, $verification_code);
    
    return $ticheng_result;
}

/**
 * 顶级的分社提成的方法，非个人
 * @param $parentid 上一级提成者ID（可为空）
 * @param $p_parentid 上两级提成者ID（可为空）
 * @param $fromid 分成者
 * @param $toid 提成分社ID
 * @param $money 提成的总金额
 * @param $product_type 购买类型，最上面有常量定义
 * @param $verification_code 订单编号（对应到order表verification_code）
 *
 */
function fx_getTichengByTopOffice($parentid,$p_parentid,$fromid,$toid,$money,$product_type,$verification_code){
//     if(empty($parentid) && empty($p_parentid)){//既没有上一级，也没有上上级，只有分社，则level为1（现在分社为1级时不能享受提成）
//         $level = 1;
//     }else 
    if(!empty($parentid) && empty($p_parentid)){//只有上一级，没有上上级，则level为2
        $level = 2;
    }else if(!empty($parentid) && !empty($p_parentid)){//上一级和上上级都有，则level为3
        $level = 3;
    }else {//此处为有问题的情况，没有上一级，却有上上级，写错误日志
//         exit("the Commission is Error");
        return false;
    }
    
    //第一步计算出此分社该有的提成比例和金额
    $ticheng = fx_getFenchengMoney($level, $money, $product_type, FX_CATEGORY_BRANCH_OFFICE);
    $point = $ticheng['point'];
    $commission = $ticheng['commission'];
    //第二步进行提成操作并记录日志
    $ticheng_result = fx_doTicheng($fromid, $toid, FX_CATEGORY_BRANCH_OFFICE, $point, $commission, $verification_code);
    return $ticheng_result;
}

/**
 * 提成的方法（既负责拿提成，又负责记录日志）
 * @param $fromid 分成者
 * @param $toid 提成者
 * @param $category 提成类型，上面的常量定义了，分为个人提成和分社提成
 * @param $point 提成比例，例如：20%
 * @param $money 提成的金额
 * @param $verification_code 订单编号（对应到order表的verification_code）
 */
function fx_doTicheng($fromid,$toid,$category,$point,$money,$verification_code){
    switch ($category) {
        case FX_CATEGORY_PERSON://个人提成
            $moneyRet = M("member")->where("id={$toid}")->setInc('commission',(int)$money);//给他加上相应的金额
            $logRet = fx_createTichengLog($fromid,$toid,$category,$point,$money,$verification_code);//提成记录的完成状态
            if($moneyRet && $logRet['ret'] == "success"){
                $result = true;//提成成功
            }else {
                $result = false;
            }
        break;
        case FX_CATEGORY_BRANCH_OFFICE://分社提成
            $moneyRet1 = M("fenbu")->where("id={$toid}")->setInc('price',$money);//给分社加上相应的金额
            $moneyRet2 = M("fenbu")->where("id={$toid}")->setInc('total_price',$money);//给分社加上相应的金额
            $logRet = fx_createTichengLog($fromid,$toid,$category,$point,$money,$verification_code);//提成记录的完成状态
            if($moneyRet1 && $moneyRet2 && $logRet['ret'] == "success"){
                $result = true;//提成成功
            }else {
                $result = false;
            }
        break;
        return $result;
    }
}

/**
 * 记录提成日志的方法（该方法只用来做提成记录用）
 * @param $fromid 分成者
 * @param $toid 提成者
 * @param $category 提成类型，上面的常量定义了，分为个人提成和分社提成
 * @param $point 提成比例，例如：20%
 * @param $money 提成的金额
 * @param $verification_code 订单编号（对应到order表的verification_code）
 */
function fx_createTichengLog($fromid,$toid,$category,$point,$money,$verification_code){
    if(empty($fromid) || empty($toid) || !in_array($category, array(FX_CATEGORY_PERSON,FX_CATEGORY_BRANCH_OFFICE)) || empty($point) || empty($money) || empty($verification_code)){
        $result = array("ret"=>"fail");
        return $result;
    }
    $log = M("fenxiaolog");
    $data = array(
        "fromid"=>$fromid,
        "toid"=>$toid,
        "category"=>$category,
        "point"=>$point,
        "money"=>$money,
        "verification_code"=>$verification_code,
        "datetime"=>date("Y-m-d H:i:s",time()),
    );
    $insertId=$log->add($data);
    if($insertId){
        $result = array("ret"=>"success","logid"=>$insertId);
    }else {
        $result = array("ret"=>"fail");
    }
    return $result;
}