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
    <title>股权帮个人中心 电子门票-门票信息</title>
</head>
<body class="um-vp">
<!-- c --> 
<div class="cBox">
    <!-- 门票信息 -->
    <div class="ub ub-ver ticketBox">
        <div class="titcket ub ubb ubb-d ub-ac ub-pc uinn">门票信息</div>
        <div class="ticketImg ub ub-ac ub-pc uinn7 uof">
            <img src="{$_GET['thumb']}" alt="">
        </div>
        <h5 class="nametit ub ub-ac ub-pc">{$_GET['title']}</h5>
        <div class="ticketcon ub ub-ver ubb ubt ubb-d umar-a">
            <div class="ticketList ub">
                <span class="iconfont icon-dian tx-red"></span>
                <b>讲师：</b>
                <i>{$_GET['teacher']}</i>
            </div>
            <div class="ticketList ub">
                <span class="iconfont icon-dian tx-red"></span>
                <b>时间：</b>
                <i>{$_GET['start_time']|date="Y-m-d",###}</i>
            </div>
            <div class="ticketList ub">
                <span class="iconfont icon-dian tx-red"></span>
                <b>地点：</b>
                <i>{$_GET['address_info']}</i>
            </div>
        </div>
        <a class="go-chose btn ub umar-a uinput ub-ac ub-pc ulev-3 uc-a1 bg-red tx-cf" href="#">立即报到</a>       
    </div>
    <!-- /门票信息 -->
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