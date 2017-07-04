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
    <title><if condition=" isset($SEO['title']) && !empty($SEO['title']) ">{$SEO['title']}</if>{$SEO['site_title']}</title>
</head>
<body class="um-vp" style="background: #fff;">

<!-- c -->
<div class="cBox"> 
    <!-- 帮助中心-社员介绍 -->
    <div class="ub ub-ver helpBox">
        <div class="helpIntroduction ub ub-ver uinn">
             <div class="title ub ub-pc ub-ac">{$title}</div>  
             <div class="con">
			 {$content}
             </div>       
        </div>              
    </div>
    <!-- /帮助中心-社员介绍-->
</div>
<!-- /c -->
<template file="Content/footer.php"/> 
</body>
<script type="text/javascript" src="/statics/default/js/jquery.js"></script>

</html>