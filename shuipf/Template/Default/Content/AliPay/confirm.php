 <!DOCTYPE html>
<html class="um landscape min-width-240px min-width-320px min-width-480px min-width-768px min-width-1024px">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="/statics/default/css/public.css">
    <link rel="stylesheet" href="/statics/default/css/ui-box.css">
    <link rel="stylesheet" href="/statics/default/css/ui-base.css">
    <link rel="stylesheet" href="/statics/default/css/ui-color.css">
    <link rel="stylesheet" href="/statics/default/css/appcan.control.css">
    <link rel="stylesheet" href="/statics/default/css/iconfont/iconfont.css">
    <link rel="stylesheet" href="/statics/default/css/center.css">
    <title>股权帮个人中心 我的订单-订单支付提示</title>
</head>
<body class="um-vp">
<?php 
  $user_agent = $_SERVER['HTTP_USER_AGENT'];
	if (strpos($user_agent, 'MicroMessenger') === false) {
		// 非微信浏览器
 ?>
<div class="cBox"> 
    <!-- 支付宝支付 -->
    <div class="ub ub-ver confirmOrderBox">
        <ul class="joinChose ub-f1 bgc">
            <li class="number ub ubb ubb-d uinn5">
                <div class="ub ub-ac">商品名称</div>
                <div class="money ub ub-f1 ub-ac ub-pe tx-c2">{$order.title}</div>
            </li>
            <li class="number ub ubb ubb-d uinn5">
                <div class="ub ub-ac">商品总计</div>
                <div class="money ub ub-f1 ub-ac ub-pe tx-red"><i>¥{$order.price}</i> 元</div>
            </li>
        </ul>        
        <a class="btSubmit btn ub ub-fl uinput" href="javascript:;" Onclick="pay();"><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1 tx-cf" type="button" name="" value="立即支付"></a>        
    </div>
    <!-- /支付宝支付-->
</div>
<?php 
   }else{
?>
<!-- c -->
<div class="cBox">

    <!-- 我的订单-订单支付提示 -->
    <div class="ub ub-ver paySuccessBox">
        <div class="ub ub-ac ub-pc iconfont icon-chenggong"></div>
        <div class="succeedd ub ub-ac ub-pc uinn tx-c2">支付信息加载成功</div> 
        <div class="tips ub ub-ac tx-c uinn tx-red">因微信无法处理支付宝请求，请您按照以下步骤继续完成支付!</div> 
        <div class="steps ub ub-ver ubt ubb-d">
            <div class="stp ub">
               一、点击微信客户端右上角（三个小点）<br> <i class="click_upOut2 tx-red">点击查看如何操作；</i>
            </div>
            <div class="stp ub">二、选择在其他浏览器中打开。苹果系统选择“在Safari中打开”，安卓系统选择“在浏览器中打开”即可；</div>
            <div class="stp ub">三、在外住浏览器打开后继续完成支付，然后支付成功返回此页面刷新，即可看到订单状态。</div>
        </div>   
        
    </div>
    <!-- /我的订单-订单支付提示 -->
</div>
<!-- /c -->
<!--弹出层-->
<div class="PopUp2 uc-a3">
    <div class="PopUp_box ub ub-ver ub">
       <div class="contUp2 ub">
            <div class="shareFD ub ub-f1 ub-ver">
                <div class="shareFDimg ub ub-ac ub-pe"><img src="/statics/default/images/shareFD.png" alt=""></div>
                <div class="shareFDtit ub ub-ac tx-c">
                    请点击右上角<br>
                    选择在浏览器中打开<br>
                    继续完成支付
                </div>
            </div>
       </div>       
    </div>
</div>
<!--/弹出层-->

<!-- jQuery 遮罩层 -->
<div class="fullbg2"></div>
    
<?php  } ?>
<input type="hidden" value="{$order_num}" id="order_num" />
<input type="hidden" value="{$order_type}" id="order_type" />
</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
<!-- 弹出层 -->
<script src="/statics/default/js/ff.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
    $(".click_upOut2").click(function(){
        $(".PopUp2").animate({opacity:"show"},300);
        $(".fullbg2").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"block"});
    });      

    $(".fullbg2").click(function(){
        $(".PopUp2").animate({opacity:"hide"},100);
        $(".fullbg2").hide();
    });
});
function pay()
{
	window.location.href='/index.php/Content/AliPay/pay.html?order_num='+$("#order_num").val()+'&order_type='+$("#order_type").val();
}
</script>
<!-- /弹出层 -->

</html>