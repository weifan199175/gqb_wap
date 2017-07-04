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
    <title>股权帮个人中心 电子门票-扫码</title>
</head>
<body class="um-vp" style="background: #f4f4f4;">
<!-- c -->
<div class="cBox"> 
    <!-- 电子门票-扫码 -->
    <div class="ub ub-ver Eticket_sBox">
        <ul class="ub ub-ver uinn">
            <li style="display:none;"><em>课程封面图：</em><i><img src="{$res.thumb}"></i></li>
            <li class="ub"><em>课程名称：</em><i>{$res.title}</i></li>
            <li class="ub"><em>讲师：</em><i>{$res.teacher}</i></li>
            <li class="ub"><em>时间：</em><i>{$res.start_time|date="Y-m-d",###}</i></li>
            <li class="ub"><em>地点：</em><i>{$res.address_info}</i></li>
        </ul>
        <div class="sEwm ub ub-ac ub-pc">
            <div class="sewmBG ub ub-ac ub-pc" id="code">

            </div>
        </div>
        <!--<div class="title ub ub-ac ub-pc">将二维码放入框内，自动扫描</div>-->
    </div>
    <!-- /电子门票-扫码-->
</div>
<!-- /c -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery.js"></script>
<script type="text/javascript" src="/statics/default/js/jquery.qrcode.min.js"></script>
<script type="text/javascript">
    $('#code').qrcode("http://guquanbang.com/index.php?m=Saoma&a=saoma_baodao&id={$res['id']}"); //任意字符串
</script>

</html>