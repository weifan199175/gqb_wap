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
    <title>微信用户关联</title>
</head>
<body class="um-vp">
<!-- c -->
<div class="cBox">
    <!-- 注册 -->
    <div class="ub ub-ver lrBox">
        <div class="lgPic ub ub-pc ub-ac umar-t uinn"><img src="{$json_info.headimgurl}" alt=""></div>
        <div class="ub ub-ver uinn2">
            <div class="wname ub ub-ac">亲爱的微信用户：<i>{$json_info.nickname}</i></div>
            <div class="tps ub ub-ac">为了给您提供更好的服务，请绑定手机号！</div>
            <div class="choseBt ub ub-ver">           
                <span class="nozh ub">还没有账号？</span>
                <a class="go-chose btn ub ub-fl uinput ub-ac ub-pc ulev-3 uc-a1" href="/index.php?m=User&a=reg&openid={$json_info.openid}&nickname={$json_info.nickname}&userimg={$json_info.headimgurl}">免费注册</a>
            </div>
            <div class="choseBt ub ub-ver">           
                <span class="nozh ub">已有账号</span>
                <a class="go-chose btn ub ub-fl uinput ub-ac ub-pc ulev-3 uc-a1" href="/index.php?m=User&a=login&openid={$json_info.openid}&nickname={$json_info.nickname}&userimg={$json_info.headimgurl}">立即关联</a>
            </div>        
            
        </div>
              
    </div>
    <!-- /注册 -->
</div>
<!-- /c -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">    
</script>

</html>