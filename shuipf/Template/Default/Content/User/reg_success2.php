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
    <title>股权帮个人中心 社员注册成功</title>
</head>
<body class="um-vp">
<!-- c -->
<div class="cBox">
    <!-- 注册 -->
    <div class="ub ub-ver lrBox">
        <a class="goIn ub uabs-r uba uc-a3 ulev-1" href="/index.php?m=User&a=rushe">我要入社</a>
        <div class="lgPic ub ub-pc ub-ac uinn"><img <if condition="$_SESSION['userimg'] eq null">src="/statics/default/images/logo1.png"<else />src="{$_SESSION['userimg']}"</if> alt=""></div>
        <h5 class="ub ub-ac- ub-pc uinn ulev2">{$_SESSION['nickname']}</h5>
        <div class="succeedd ub ub-ac ub-pc uinn">恭喜您已注册成功！</div>        
        <a class="go-login btn ub ub-fl uinput ub-ac ub-pc ulev-3 uc-a1" href="/index.php?m=User&a=index">立即登录</a>        
    </div>
    <!-- /注册 -->
</div>
<!-- /c -->
    <!-- 页脚 -->
    
        <template file="Content/footer.php"/> 
     
    <!-- /页脚 -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">    
</script>

</html>