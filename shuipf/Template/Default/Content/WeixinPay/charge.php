<!DOCTYPE html>
<html class="um landscape min-width-240px min-width-320px min-width-480px min-width-768px min-width-1024px">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="/statics/default/css/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="/statics/default/css/public.css">
    <link rel="stylesheet" href="/statics/default/css/ui-box.css">
    <link rel="stylesheet" href="/statics/default/css/ui-base.css">
    <link rel="stylesheet" href="/statics/default/css/ui-color.css">
    <link rel="stylesheet" href="/statics/default/css/appcan.control.css">
    <link rel="stylesheet" href="/statics/default/css/iconfont/iconfont.css">
    <link rel="stylesheet" href="/statics/default/css/service.css">
    <title>积分充值</title>
</head>
<body class="um-vp" style="background: #f4f4f4;">

<!-- c -->
<div class="cBox"> 
    <!-- 积分充值 -->
    <div class="ub ub-ver jfresetBox">
      
	    <div class="jfBox ub ub-ver tx-cf">
            <div class="tt ub ub-ac ub-pc uinn">剩余积分</div>
            <div class="number ub ub-ac ub-pc">{$user.score}</div>
        </div>
        <div class="jfreset ub ub-ac mar-b7 ubb ubb-d uinn5 bgc">
            <div class="tt ub">请输入充值金额</div>
            <div class="number ub ub-f1 ub-pe uinput"><input type="text" id="money" placeholder="请输入充值金额"></div>
        </div>
		<!--
        <ul class="joinChose ub-f1 bgc">
            <li class="ub ubb ubt ubb-d uinn5">
                请选择支付方式        
            </li>
            <li class="chose ub ub-ver ubb ubb-d">
                <div class="ub ub-f1 uinn5 ub-ac ubb ubb-d">
                    <div class="ub zfImg"><img src="../images/zf1.png" alt=""></div>
                    <div class="con ub ub-ver ub-f1">
                        <h5 class="ub uof tx-c4">微信支付</h5>
                        <span class="ub tx-c8">推荐安装微信5.0及以上版本的使用</span>
                    </div>
                    <div class="ub radiobox">
                        <input type="radio" name="chose-zf"/>
                    </div>
                </div>
                <div class="ub ub-f1 uinn5 ub-ac ubb ubb-d">
                    <div class="ub zfImg"><img src="../images/zf2.png" alt=""></div>
                    <div class="con ub ub-ver ub-f1">
                        <h5 class="ub uof tx-c4">银联支付</h5>
                        <span class="ub tx-c8">支持工行、建行、农行、招行等银行大额支付</span>
                    </div>
                    <div class="ub radiobox">
                        <input type="radio" name="chose-zf"/>
                    </div>
                </div>
                <div class="ub ub-f1 uinn5 ub-ac">
                    <div class="ub zfImg"><img src="../images/zf3.png" alt=""></div>
                    <div class="con ub ub-ver ub-f1">
                        <h5 class="ub uof tx-c4">支付宝支付</h5>
                        <span class="ub tx-c8">推荐有支付宝账号用户使用</span>
                    </div>
                    <div class="ub radiobox">
                        <input type="radio" name="chose-zf"/>
                    </div>
                </div>
            </li>
        </ul>
		-->
        <div class="reading ub ub-ac umar-a2 tx-red ulev-1"><span class="czinco ub ub-ac iconfont icon-tishi"></span>您所充值的金额将兑换成积分（1元=1积分）</div>
        <a class="btn ub ub-fl umar-b2 uinput" href="javascript:;" Onclick="charge();"><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1 tx-cf" type="button" name="" value="确认"></a>        
    </div>
    <!-- /积分充值-->
</div>
<!-- /c -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery.js"></script>
<script>
//积分充值
function charge()
{
	var ex = /^\d+$/;
	var money = parseInt($("#money").val());
    if (!ex.test(money))
	{
      alert("请输入正确的金额！");
	  $("#money").val('');
	  return;
    }
    
    if(money>100000)
	{
	   alert("超出最大限制金额！");return;	
	}    
	
	var data = new Object();
	data['pay_type'] = 1; //在线支付
	data['product_type'] = 2;   //在线充值
	
	data['price'] = money;
	data['score'] = 0;
	data['product_id'] = 0;
	data['product_name'] = "在线充值";
	
	data['truename'] = '<?php echo $user['truename']; ?>'; 
	data['mobile'] = '<?php echo $user['mobile']; ?>'; 
	
	var url = '/index.php?m=Order&a=addorder';
	$.post(url, data, function (r){
		if(r.code=='0')
		{
			 window.location.href='/index.php/Content/WeixinPay/confirm_order.html?order_num='+r.order_num+'&money='+money;	
		}else{
			alert("提交失败！");return;
		}
		
			
		   
	},'json');
	return;
	
}

</script>
</html>