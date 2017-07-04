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
    <title>股权帮个人中心 签到（签到后）</title>
</head>
<body class="um-vp" style="background: #fff;" onload="showtime()" >
<!--头部-->
<div class="ub ub-ac header">
    <a href="#" class="ub ub-ac headerLeft"><em class="iconfont icon-jiantouzuo"></em></a>
    <div class="ub ub-pc ub-f1 headerMid"><span>签到</span></div>
    <a href="#" class="ub ub-ac headerRig"><em class="iconfont icon-6"></em></a>
</div>
<!--头部-->
<!-- c --> 
<div class="cBox">
    <!-- 签到 签到前 -->
    <div class="pastBox">
        <div class="past ub ub-ver">
            <div class="time ub ub-f1 ubb ubb-d uinn5 tx-c4">签到日期：<i id="show"></i></div>
            <div class="pastClick ub ub-ac ub-pc ub-ver">
                <div class="pastBG pastBG2 ub ub-ac ub-pc">已签到</div>
                <div class="tips ub ub-ac ub-pc tx-c8">您今天已成功签到!</div>
            </div>
            <div class="timeScore ub uinn">
                <div class="tm ub ub-f1 uba ubb-d ub-ac ub-pc umar-r"><span class="tx-cblu iconfont icon-rili"></span><em>签到天数：<i>{$counts}</i></em></div>
                <div class="score ub ub-f1 uba ubb-d ub-ac ub-pc umar-l"><span class="tx-cog2 iconfont icon-jifen2"></span><em>累计积分：<i>{$total_scores}</i></em></div>
            </div>
            <div class="pTips">
                <span class="xhIcon tx-red iconfont icon-xinghao"></span>
                <em class="tx-red">每天签到一次可获取5积分</em>
                <span class="jfIcon tx-cog2 iconfont icon-jifen"></span>
            </div>
        </div>
    </div>
    <!-- /签到前 -->
</div>
<!-- /c -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/statics/default/js/base.js"></script>
    <script>
        function showtime(){
            $.ajax({
                url     : 'http://<?php echo $_SERVER['HTTP_HOST']; ?>/index.php?m=Index&a=getservertime',
                type    : 'get',
                success : function(time){
                    settime(time);
                    return false;
                }
            });
        };
    </script>
<script type="text/javascript">    
</script>

</html>