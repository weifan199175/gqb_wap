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
    <?php 
        
		//判断是否微信浏览器打开
		  
	   if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false)
	   {
     
	?>
	<script type="text/javascript">
	
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest', 
			<?php echo $jsApiParameters; ?>,
			function(res){
				WeixinJSBridge.log(res.err_msg);
				//alert(res.err_code+res.err_desc+res.err_msg);
				 if(res.err_msg == "get_brand_wcpay_request:ok"){
					var url_success	=	'/index.php?m=WeixinPay&a=pay_success&order_num='+<?php echo $order_num; ?>;
					alert('支付成功');
				    window.location.href = url_success;
				}else{
				   //返回跳转到订单列表页面
				   alert('支付失败');
				   window.location.href="/index.php?m=User&a=order";	 
			   }
			   /*
			   WeixinJSBridge.log(res.err_msg);
			   alert("支付成功");
			   window.location.href = '/index.php?m=WeixinPay&a=pay_success&order_num='+<?php echo $order_num; ?>;
			   */
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	
	
	</script>
	
	<?php } ?>
</head>
<body class="um-vp">

<div class="cBox"> 
    <!-- 微信混合支付 -->
    <div class="ub ub-ver confirmOrderBox">
        <ul class="joinChose ub-f1 bgc">
            <li class="number ub ubb ubb-d uinn5">
                <div class="ub ub-ac">商品名称</div>
                <div class="money ub ub-f1 ub-ac ub-pe tx-c2">{$course.title}</div>
            </li>
            <li class="number ub ubb ubb-d uinn5">
                <div class="ub ub-ac">商品总计</div>
                <div class="money ub ub-f1 ub-ac ub-pe tx-red"><i>¥{$order.price}</i> 元</div>
            </li>
        </ul>        
        <a class="btSubmit btn ub ub-fl uinput" href="javascript:;" Onclick="pay();"><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1 tx-cf" type="button" name="" value="立即支付"></a>        
    </div>
    <!-- /微信混合支付-->
</div>

</div>
<!--/弹出层-->

<!-- jQuery 遮罩层 -->
<div class="fullbg2"></div>
    

<input type="hidden" value="{$order_num}" id="order_num" />
</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
<!-- 弹出层 -->
<script src="/statics/default/js/ff.js" type="text/javascript"></script>
<script type="text/javascript">
function pay()
{
	callpay();
}
</script>
<!-- /弹出层 -->

</html>