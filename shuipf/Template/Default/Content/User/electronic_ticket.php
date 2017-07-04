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
    <title>股权帮个人中心 电子门票</title>
</head>
<body class="um-vp" style="background: #f4f4f4;">
<!-- c -->
<div class="cBox"> 
    <!-- 电子门票 -->
    <div class="ub ub-ver EticketBox">
        <ul class="ub ub-ver">
            <volist name="data" id="vo">
                <li class="ub">
                    <a class="ub etckList" href="javascript:;">
                        <div class="etImg"><img src="/statics/default/images/Eticket.png" alt=""></div>
                        <div class="fl money tx-red"><span>¥</span><i>{$vo.price}</i></div>
                        <div class="info ub ub-ver ub-f1 tx-c4">
                            <h5 class="ub ulev0">{$vo.title|str_cut=###,10}</h5>
                            <div class="ifota ub">
                                时间：<i>{$vo.start_time|date="Y-m-d",###}</i>
                            </div>
                            <div class="ifota ub">
                                地点：<i>{$vo.address_info}</i>
                            </div>
                            <div class="ifota ub">
                                核销码：<i>{$vo.verification_code}</i>
                            </div>
                        </div>
                    </a>
                </li>
            </volist>   
        </ul>
            
    </div>
    <!-- /电子门票-->
</div>
<!-- /c -->
<!-- 页脚 -->
    
        <template file="Content/footer.php"/> 
     
    <!-- /页脚 -->

</body>
<script type="text/javascript" src="/statics/default/js/jquery.js"></script>

</html>