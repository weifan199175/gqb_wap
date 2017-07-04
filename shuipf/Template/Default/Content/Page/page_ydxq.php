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
    <link rel="stylesheet" href="/statics/default/css/learn.css">
    <title><if condition=" isset($SEO['title']) && !empty($SEO['title']) ">{$SEO['title']}</if>{$SEO['site_title']}</title>
</head>
<body class="um-vp" style="background: #fff;">
<!-- c -->
<div class="cBox"> 
    <!-- 学股权-阅读详情 -->
    <div class="ub ub-ver learnStkBox">
	 <if condition="$catid eq 29">
		<template file="Content/hehuo_header.php"/>
	 <if />
        <div class="learnDetailes ub ub-ver uinn bgc">
		<get sql="SELECT * FROM jbr_page  WHERE catid=$catid">
			<volist name="data" id="vo">
				<div class="title ub tx-c4">
				{$vo.title}
				</div>
				<div class="con">
					{$vo.content}
				</div>
			</volist>
		</get>
        </div>                        
    </div>
    <!-- /学股权-阅读详情-->
     <!-- 页脚 -->
			<template file="Content/footer.php"/>
    <!-- /页脚 -->

</div>
<!-- /c -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery.js"></script>

</html>