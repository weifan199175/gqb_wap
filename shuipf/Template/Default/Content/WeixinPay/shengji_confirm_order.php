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
    <title>股权帮个人中心 铁杆社员申请</title>
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
                    var url_success =   '/index.php?m=WeixinPay&a=pay_success&order_num='+<?php echo $order_num; ?>;
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
    
    
    </script>
</head>
<body class="um-vp" style="background: #f4f4f4;">
<!--头部-->
<div class="ub ub-ac header">
    <a href="#" class="ub ub-ac headerLeft"><em class="iconfont icon-jiantouzuo"></em></a>
    <div class="ub ub-pc ub-f1 headerMid"><span>铁杆社员申请</span></div>
    <a href="#" class="ub ub-ac headerRig"><em class="iconfont icon-6"></em></a>
</div>
<!--头部-->
<!-- c -->
<div class="cBox"> 
    <!-- 我的-合伙社员申请 -->
    <div class="ub ub-ver myApplyBox">
        <div class="myApply ub ub-pc ub-ac uinn bgc"><img src="/statics/default/images/logo4.png" alt=""></div>
        <h5 class="title ub ub-ac ub-pc uinn bgc tx-c2">股权帮铁杆社员入社费用</h5>
        <div class="price ub ub-ac ub-pc tx-red bgc">¥ 10000元</div>
        <ul class="joinChose ub-f1 bgc">
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
        <div class="reading umar-a2 ub ub-ac umar-a tx-c4"><span class="tx-red ulev-1 iconfont icon-xinghao"></span>提交即默认同意相关入会协议<a href="#">阅读详情</a></div>
        <a class="btn ub ub-fl umar-b2 uinput" href="javascript:;" Onclick="tijiao();"><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1 tx-cf" type="button" name="" value="确认"></a>        
    </div>
    <!-- /我的-合伙社员申请-->
</div>
<!-- /c -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery.js"></script>

<script>
var order_num = $('#order_num').val();

//订单提交
function tijiao()
{
    var pay_type = $(':radio[name="chose_zf"]:checked').val();
    if(typeof(pay_type)=="undefined"){
        alert("请选择支付方式！");return;
    };
    
    if(pay_type=='1')     //微信支付
    {
        callpay();//window.location.href='/index.php/Content/WeixinPay/pay.html?order_num='+order_num;  
    }
    
}



</script>

</html>