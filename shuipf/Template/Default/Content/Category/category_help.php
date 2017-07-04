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
    <link rel="stylesheet" href="/statics/default/css/help.css">
    <title>帮助中心</title>
</head>
<body class="um-vp" style="background: #f4f4f4;">


<!-- c -->
<div class="cBox"> 
    <!-- 帮助中心 -->
    <div class="ub ub-ver helpBox">
        <div class="helpList ub ub-ver">
            <ul class="ub ub-ver ub-f1">
                <li class="ub uinn5 ubb ubt ubb-d bgc">
                    <a class="ub ub-ac ub-f1" href="{:getCategory(9,'url')}">
                       <span class="ub tx-cblu iconfont icon-huiyuanziliao"></span>
                       <div class="tit ub tx-c2">会员介绍</div>
                       <div class="go ub ub-f1 ub-pe tx-a iconfont icon-jiantou"></div>
                    </a>
                </li>
                <li class="ub uinn5 ubb ubt ubb-d bgc">
                    <a class="ub ub-ac ub-f1" href="{:getCategory(10,'url')}">
                       <span class="ub tx-cog iconfont icon-jifen2"></span>
                       <div class="tit ub tx-c2">积分规则</div>
                       <div class="go ub ub-f1 ub-pe tx-a iconfont icon-jiantou"></div>
                    </a>
                </li>
                <!--<li class="ub uinn5 ubb ubt ubb-d bgc">
                    <a class="ub ub-ac ub-f1" href="{:getCategory(11,'url')}">
                       <span class="ub tx-cred iconfont icon-xiaoshou"></span>
                       <div class="tit ub tx-c2">代销规则</div>
                       <div class="go ub ub-f1 ub-pe tx-a iconfont icon-jiantou"></div>
                    </a>
                </li>-->
                <li class="ub uinn5 ubb ubt ubb-d bgc">
                    <a class="ub ub-ac ub-f1" href="{:getCategory(12,'url')}">
                       <span class="ub tx-cgn2 iconfont icon-data"></span>
                       <div class="tit ub tx-c2">社群数据申请</div>
                       <div class="go ub ub-f1 ub-pe tx-a iconfont icon-jiantou"></div>
                    </a>
                </li>
            </ul>            
        </div>              
    </div>
    <!-- /帮助中心-->
    <!-- 页脚 -->
    <div class="ftBtFixed ubt ubb-d">
       
		<a class="btn ub uinn" href="tel:{:cache('Config.tel_1')}">
            <div class="callbtn ub ub-f1 ub-ac ub-pc tx-cf uc-a3 uinn7 bg-red ulev0">
                <span class="iconfont icon-dianhua"></span>
                电话咨询
            </div>
        </a>
    </div>
	<template file="Content/footer.php"/> 
    <!-- /页脚 -->

</div>
<!-- /c -->

</body>
<script type="text/javascript" src="/statics/default/js/jquery.js"></script>

</html>