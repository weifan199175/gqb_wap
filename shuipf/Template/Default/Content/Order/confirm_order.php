<!DOCTYPE html>
<html class="um landscape min-width-240px min-width-320px min-width-480px min-width-768px min-width-1024px">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="/statics/default/css/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="/statics/default/css/express-area.css">
    <link rel="stylesheet" href="/statics/default/css/public.css">
    <link rel="stylesheet" href="/statics/default/css/ui-box.css">
    <link rel="stylesheet" href="/statics/default/css/ui-base.css">
    <link rel="stylesheet" href="/statics/default/css/ui-color.css">
    <link rel="stylesheet" href="/statics/default/css/appcan.control.css">
    <link rel="stylesheet" href="/statics/default/css/iconfont/iconfont.css">
    <link rel="stylesheet" href="/statics/default/css/center.css">
    <title>股权帮个人中心 确认订单</title>
</head>
<body class="um-vp" style="background: #f4f4f4;">
<!--头部-->

<!--头部-->
<!-- c -->
<div class="cBox"> 
    <!-- 确认订单 -->
    <div class="ub ub-ver confirmOrderBox">
    <if condition="{$course} neq null">
        <ul class="classList">
            <li class="ub ubb ubb-d uinn bgc">
                <a class="ub ub-f1" href="{$course.url}">
                    <div class="img ub ub-ac uof"><img src="{$course.thumb}" alt=""></div>
                    <div class="con ub ub-f1 ub-ver">
                        <h5 class="ub umar-b tx-c2 uof">{$course.title}</h5>
                        <div class="info ub tx-red">
                            <span class="ub ub-ac iconfont icon-boshimao-copy"></span>
                            <em class="ub ub-ac">讲师：<i>{$course.title}</i></em>
                        </div> 
                        <div class="info ub">
                            <span class="ub tx-c4 iconfont icon-shijian"></span>
                            <em class="ub ub-ac tx-c8">时间：<i>{$course.start_time|date="Y-m-d",###}</i></em>
                        </div>
                        <div class="info ub">
                            <span class="ub tx-c4 iconfont icon-xiao31"></span>
                            <em class="ub tx-c8 ub-ac">地点：<i>{$course.city}</i></em>
                        </div>
                        <div class="price ub ub-ac tx-red">
                            <i>¥</i>
                            <span>{$course.price}</span>
                        </div>
                    </div>
                </a>
            </li>            
        </ul>
        </if>
        <ul class="joinChose ub-f1 bgc">
            <li class="number ub ubb ubt ubb-d uinn5">
                <div class="ub ub-ac">订单号</div>
                <div class="nm ub ub-f1 ub-ac ub-pe tx-c8">{$order.verification_code}</div>
            </li>
            <li class="number ub ubb ubb-d uinn5">
                <div class="ub ub-ac">商品总计</div>
                <div class="money ub ub-f1 ub-ac ub-pe tx-red"><i>¥{$order.price}</i> 元</div>
            </li>
            <li class="ub ubb ubb-d uinn5">
                请选择支付方式        
            </li>
            <li class="chose ub ub-ver ubb ubb-d">
                <div class="ub ub-f1 uinn5 ub-ac ubb ubb-d">
                    <div class="ub zfImg"><img src="/statics/default/images/zf1.png" alt=""></div>
                    <div class="con ub ub-ver ub-f1">
                        <h5 class="ub uof tx-c4">微信支付</h5>
                        <span class="ub tx-c8">推荐安装微信5.0及以上版本的使用</span>
                    </div>
                    <div class="ub radiobox">
                        <input type="radio" value="1" name="chose_zf"/>
                    </div>
                </div>
                <div class="ub ub-f1 uinn5 ub-ac ubb ubb-d">
                    <div class="ub zfImg"><img src="/statics/default/images/zf2.png" alt=""></div>
                    <div class="con ub ub-ver ub-f1">
                        <h5 class="ub uof tx-c4">银联支付</h5>
                        <span class="ub tx-c8">支持工行、建行、农行、招行等银行大额支付</span>
                    </div>
                    <div class="ub radiobox">
                        <input type="radio" value="2" name="chose_zf"/>
                    </div>
                </div>
                <div class="ub ub-f1 uinn5 ub-ac">
                    <div class="ub zfImg"><img src="/statics/default/images/zf3.png" alt=""></div>
                    <div class="con ub ub-ver ub-f1">
                        <h5 class="ub uof tx-c4">支付宝支付</h5>
                        <span class="ub tx-c8">推荐有支付宝账号用户使用</span>
                    </div>
                    <div class="ub radiobox">
                        <input type="radio" value="3" name="chose_zf"/>
                    </div>
                </div>
            </li>
        </ul>        
        <a class="btExchange btn ub ub-fl umar-b2 uinput" href="javascript:;" Onclick="jifen();"><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1 tx-cf" type="button" value="积分兑换"></a>
        <a class="btSubmit btn ub ub-fl uinput" href="javascript:;" Onclick="tijiao();"><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1 tx-cf" type="button" value="提交订单"></a>        
    </div>
    <!-- /确认订单-->
</div>
<!-- /c -->
<input type="hidden" id="order_num" value="{$order.verification_code}" />
<input type="hidden" value="{$member.score}"  id="member_score" />
<input type="hidden" value="{$course.score}"  id="course_score" />
</body>
<script type="text/javascript" src="/statics/default/js/jquery.js"></script>
<script>
var order_num = $('#order_num').val();
//积分支付
function jifen()
{
	if(parseInt($("#member_score").val())>=parseInt($("#course_score").val()))
	{
		alert("恭喜，兑换成功！");
	    window.location.href='/index.php/Content/WeixinPay/pay_success.html?order_num='+order_num+'&pay_type=2';	
	}else{
	   alert("您的积分不足！");return;
	}
}

//订单提交
function tijiao()
{
	var pay_type = $(':radio[name="chose_zf"]:checked').val();
	if(typeof(pay_type)=="undefined"){
		alert("请选择支付方式！");return;
	};
	
	if(pay_type=='1')     //微信支付
	{
	    window.location.href='/index.php/Content/WeixinPay/pay.html?order_num='+order_num;	
	}
	
}



</script>
</html>