<!DOCTYPE html>
<html class="um landscape min-width-240px min-width-320px min-width-480px min-width-768px min-width-1024px">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <script type="text/javascript" src="/statics/default/js/jquery-1.9.1.min.js"></script> 
    <title>支付订单</title>
    <link rel="stylesheet" type="text/css"  href="/statics/default/css/public.css">
    <link rel="stylesheet" type="text/css"  href="/statics/default/css/ui-box.css">
    <link rel="stylesheet" type="text/css"  href="/statics/default/css/css.css">
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
				   window.location.href="/index.php?m=User&a=my_yuejian";	 
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
	
	/*
	//获取共享地址
	function editAddress()
	{
		WeixinJSBridge.invoke(
			'editAddress',
			<?php echo $editAddress; ?>,
			function(res){
				var value1 = res.proviceFirstStageName;
				var value2 = res.addressCitySecondStageName;
				var value3 = res.addressCountiesThirdStageName;
				var value4 = res.addressDetailInfo;
				var tel = res.telNumber;
				
				alert(value1 + value2 + value3 + value4 + ":" + tel);
			}
		);
	}
	
	window.onload = function(){
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', editAddress, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', editAddress); 
		        document.attachEvent('onWeixinJSBridgeReady', editAddress);
		    }
		}else{
			editAddress();
		}
        
	};
	*/
	</script>
</head>
<body style="background-color: #dcdcdc;">


<div class="ub ub-ver ub-pc payMes">
   <p><span class="ulev-2 text-color6">订单编号：<?php echo $order_num; ?></span></p>
   <p><span class="ulev-2 text-color6">订单总金额：<b class="text-color1">¥<?php echo $total_price; ?></b></span></p>
   <p><span class="ulev-2 text-color6">在线支付金额：<b class="text-color1">¥<?php echo $price; ?></b></span></p>
</div>
<div class="payTit"><span class="ulev-2">选择支付方式</span></div>
<div class="payList">
    <ul>
        <li class="ub ub-ac">
            <div class="payIcon"><img src="/statics/default/images/weixinlogo.png" /> </div>
            <div class="ub-f1 payTxt">
                <p class="ub ub-ac paydt"><span class="ulev-1">微信支付</span><i><img src="/statics/default/images/tuij.png"/></i></p>
                <p><span class="ulev-2 text-color6">亿万用户的选择，更快更安全</span></p>
            </div>
            <div class="payxzBtn"><span class="on"></span></div>
        </li>
    </ul>
</div>

<div class="payBtn2" onclick="callpay()"><input type="button" value="立即支付"  /> </div>

<!--contain结束-->

</body>

<script type="text/javascript">

</script>
</html>