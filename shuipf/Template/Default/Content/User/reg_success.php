<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" /> -->
    <meta http-equiv=”X-UA-Compatible” content=”IE=Edge,chrome=1″>
    <meta charset="utf-8">
    <title>社员注册成功</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
    <script src="http://g.tbcdn.cn/mtb/lib-flexible/0.3.4/??flexible_css.js,flexible.js"></script>
    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script type="text/javascript" src="/statics/regSuccess/fastclick.min.js"></script>
    <link rel="stylesheet" href="/statics/zc/css/ui-box.css">
    <link rel="stylesheet" href="/statics/zc/css/public.css">
    <link rel="stylesheet" href="/statics/zc/css/ui-box.css">
    <link rel="stylesheet" href="/statics/zc/css/ui-base.css">
    <link rel="stylesheet" href="/statics/zc/css/ui-color.css">
    <link rel="stylesheet" href="/statics/zc/css/appcan.control.css">
    <link rel="stylesheet" href="/statics/zc/css/iconfont/iconfont.css">
    <link rel="stylesheet" href="/statics/zc/css/index.css">
    <link rel="stylesheet" href="/statics/regSuccess/common.min.css">
    <link rel="stylesheet" href="/statics/regSuccess/regSuccess.min.css">
</head>

<body>
    <!-- 注册成功列表 -->
    <div class="processPic">
        <img src="/statics/regSuccess/regSuccess.jpg">
    </div>
    <div class="successTitle">
        <p>恭喜你注册成功</p>
    </div>
    <ul class="regSuccessList">
        <li>
            <div class="successMsg">
                你可以分享给好友共同学习股权知识
            </div>
            <div class="msgPic">
                <img src="/statics/regSuccess/1.jpg">
            </div>
            <div class="btn">
                <a href="javascript:void(0)">我要分享</a>    
            </div>
        </li>
        <li>
            <div class="successMsg">
                你也可以购买课程，学习股权知识
            </div>
            <div class="msgPic">
                <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/index.php?a=lists&catid=7"><img src="/statics/regSuccess/2.png"></a>
            </div>
            <div class="btn">
                <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/index.php?a=lists&catid=7">参课学习</a>
            </div>
        </li>
    </ul>

    <!-- foote开始 -->
    <template file="Content/new_footer.php"/>
</body>
<script type="text/javascript">
wx.config({
	appId: "<?php echo $js_list['appId']?>",
	timestamp: "<?php echo $js_list['timestamp']?>",
	nonceStr: "<?php echo $js_list['nonceStr']?>",
	signature: "<?php echo $js_list['signature']?>",
	jsApiList: ['closeWindow']
	});

$(function() {
	$(".regSuccessList li").first().find(".btn").click(function(){
		$(".processPic").show();
	});
		
	 $(".processPic").on("click", function() {
		$(this).hide();//马上让它不能点击
	    $('.footer a').css('pointer-events', 'none');
	    wx.closeWindow();
	 　　 //因为click事件需要300ms响应，所以我们时间定义350ms,时间一过又可以正常点击了
	 setTimeout(function() { $('.footer a').css('pointer-events', 'all') }, 350);
	})
});

	
		
</script>
</html>
