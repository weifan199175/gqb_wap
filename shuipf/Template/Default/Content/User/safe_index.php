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
    <title>账户安全-账户安全</title>
</head>
<body class="um-vp" style="background: #f4f4f4;">

<!-- c -->
<div class="cBox">
    <!-- 账户安全 -->
    <div class="ub ub-ver safeCount">
        <div class="title ub">
            <a href="#" class="ub ub-ac Left"><em class="iconfont icon-jiantouzuo"></em></a>
            <div class="ub ub-ac ub-pc ub-f1 Mid"><span>账户安全</span></div>
            <div class="ub uinn5"></div>
        </div>
        <ul class="list ub-f1 ub ub-ver ubt ubb-d">
            <li class="ub ub-f1 ubb ubb-d uinn5">
                <a class="ub ub-f1 ub-ac" href="{:U('User/login_pass')}">
                    <div class="ub ub-ver ub-f1">
                        <b class="ub">登录密码</b>
                        <p class="ub">建议定期更换密码以保护账户安全</p>
                    </div>
                    <span class="ub iconfont icon-jiantou"></span>   
                </a>
            </li>
            <li class="ub ub-f1 ubb ubb-d uinn5">
                <a class="ub ub-f1 ub-ac" href="{:U('User/safe_mobile')}">
                    <div class="ub ub-ver ub-f1">
                        <b class="ub">手机绑定</b>
                        <p class="ub">若您的绑定手机已丢失或停用，请立即修改更换</p>
                    </div>
                    <span class="ub iconfont icon-jiantou"></span>   
                </a>
            </li>
            <li class="ub ub-f1 ubb ubb-d uinn5">
                <a class="ub ub-f1 ub-ac" href="{:U('User/pay_pass')}">
                    <div class="ub ub-ver ub-f1">
                        <b class="ub">支付密码</b>
                        <p class="ub">账户提现及余额支付等服务时，用户验证</p>
                    </div>
                    <span class="ub iconfont icon-jiantou"></span>   
                </a>
            </li>
            <li class="quit ub ub-f1 ubt ubb ubb-d uinn5">
                <a class="ub ub-f1 ub-ac ub-pc" href="{:U('User/login_out')}">
                    <em>退出当前账号</em>
                </a>
            </li>
        </ul> 
		
		<a class="changePhone ub ub-fl ub-ac ub-pc uinn5" href="{:U('User/change_user')}">切换账号</a>  
    </div>
    <!-- /账户安全 -->
</div>
<!-- /c -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">    
</script>

</html>