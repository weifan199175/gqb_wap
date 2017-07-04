<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" /> -->
    <meta http-equiv=”X-UA-Compatible” content=”IE=Edge,chrome=1″>
    <meta charset="utf-8">
    <title>众筹订单</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
    <script src="http://g.tbcdn.cn/mtb/lib-flexible/0.3.4/??flexible_css.js,flexible.js"></script>
    <script src="/statics/zc/js/payment.min.js"></script>
    <script src="/statics/layer_mobile/layer.js"></script>
    <link rel="stylesheet" href="/statics/zc/css/public.css">
    <link rel="stylesheet" href="/statics/zc/css/ui-box.css">
    <link rel="stylesheet" href="/statics/zc/css/ui-base.css">
    <link rel="stylesheet" href="/statics/zc/css/ui-color.css">
    <link rel="stylesheet" href="/statics/zc/css/appcan.control.css">
    <link rel="stylesheet" href="/statics/zc/css/iconfont/iconfont.css">
    <link rel="stylesheet" href="/statics/zc/css/index.css">
    <link rel="stylesheet" href="/statics/zc/css/common.min.css">
    <link rel="stylesheet" href="/statics/zc/css/payment.min.css">
</head>

<body>
    <!-- 付款人信息 -->
    <div class="peopleInfo">
        <!-- <div class="payTitle">付款人信息</div> -->
        <div class="payName">
            <div>我的姓名：</div>
            <input type="text" id="truename" placeholder="请输入姓名" value="<?php echo $user['truename']?>" maxlength="10">
        </div>
        <div class="error nameError">&nbsp;</div>
        <div class="payMsg">
            <div>给他留言：</div>
            <input type="text" id="message" placeholder="给他留言" value="{$msg}" maxlength="200">
        </div>
        <div class="error msgError">&nbsp;</div>
        <div class="payMoney">
            <div>付款金额：</div>
            <input type="tel" id="pay_Money" placeholder="请输入金额">
        </div>
        <div class="error moneyError">&nbsp;</div>
        <div class="moneyBtn">
            <div data-money="18">18元</div>
            <div data-money="68">68元</div>
            <div data-money="168">168元</div>
            <div data-money="<?php echo $funding['price']-$funding['total_price']<=0?0:$funding['price']-$funding['total_price']; ?>">全部</div>
        </div>
    </div>
    <input type="hidden" value="{$funding['price']}" id="price">
    <input type="hidden" value="{$funding['total_price']}" id="total_price">
    <input type="hidden" value="{$funding['id']}" id="funding_id">
    <!-- 支付方式 -->
    <div class="payMode">
    <?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {?>
            <div class="wx" data-paytype="weixin">
                <i class="myiconfont wxIcon">&#xe606;</i> 微信支付
                <i class="myiconfont choose" style="display: inline;">&#xe634;</i>
            </div>
            <div class="zfb" data-paytype="zhifubao">
                <i class="myiconfont zfbIcon">&#xe63d;</i> 支付宝支付
                <i class="myiconfont choose">&#xe634;</i>
            </div>
    <?php }else {?>
            <div class="zfb" data-paytype="zhifubao">
                <i class="myiconfont zfbIcon">&#xe63d;</i> 支付宝支付
                <i class="myiconfont choose" style="display: inline;">&#xe634;</i>
            </div>
    <?php }?>
    </div>
    <div class="btnDiv">
        <div class="payBtn" id="readytopay">
            确认付款
        </div>
    </div>
    <!-- foote开始 -->
    <template file="Content/new_footer.php"/>
</body>
<script type="text/javascript">
var pay_type = "<?php echo strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false?"weixin":"zhifubao"?>";
var requestParam = null;
//判断是不是正整数
function isPositiveInteger(s){
     var re = /^[0-9]+$/ ;
	if(re.test(s) && s != 0){
		return true;
	}else {
		return false;
	}
 }

function pay(){
    WeixinJSBridge.invoke('getBrandWCPayRequest',{
        "appId": requestParam.appId,
        "timeStamp": requestParam.timeStamp,
        "nonceStr": requestParam.nonceStr,
        "package": requestParam.package,
        "signType": requestParam.signType,
        "paySign": requestParam.paySign
    },function(res){
        if(res.err_msg == "get_brand_wcpay_request:ok" ) {
            alert("支付成功");
            var fid = $("#funding_id").val();
        	window.location.href="http://<?php echo $_SERVER['HTTP_HOST']?>/index.php?m=Funding&a=share&id="+fid;
        }
        else if(res.err_msg == "get_brand_wcpay_request:cancel" )
        {
        }
    });
}
 
</script>
</body>
</html>
