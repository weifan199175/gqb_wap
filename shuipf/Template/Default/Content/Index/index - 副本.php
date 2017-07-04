<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta name="baidu-site-verification" content="E9w6WQ9xWg" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>微信分享测试</title>
<meta name="description" content="{$SEO['description']}" />
<meta name="keywords" content="{$SEO['keyword']}" />

</head>

<body>
	<h1>微信分享测试</h1>
	<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>  
    <script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>  
    <script type="text/javascript">
	var time = <?php echo $time; ?>;
   
   // var jsapi_ticket = '<?php echo $_SESSION['jsapi_ticket']; ?>';
	
	//string1=jsapi_ticket+'&noncestr=BogLeUnion&timestamp='+time+'&url='+window.location.href;
	
	//var url = window.location.href;
	
	signature = '<?php echo sha1('jsapi_ticket='.$_SESSION['jsapi_ticket'].'&noncestr=BogLeUnion&timestamp='.$time.'&url=http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>'
	// alert(url);
	// alert(time);
	// alert(jsapi_ticket);
	// alert(signature);
    	wx.config({
		debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
		appId: 'wx245ceeacd691162a', // 必填，公众号的唯一标识
		timestamp: time, // 必填，生成签名的时间戳
		nonceStr: 'BogLeUnion', // 必填，生成签名的随机串
		signature: signature,// 必填，签名，见附录1
		jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareWeibo','onMenuShareQZone'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
   });
   
   //分享到朋友圈
   wx.onMenuShareTimeline({
    title: '微信分享测试', // 分享标题
    link: window.location.href, // 分享链接
    imgUrl: '', // 分享图标
    success: function () { 
        // 用户确认分享后执行的回调函数
		alert(111);
    },
    cancel: function () { 
        // 用户取消分享后执行的回调函数
		alert(222);
    }
   });
   
   //分享给朋友
   wx.onMenuShareAppMessage({
    title: '', // 分享标题
    desc: '', // 分享描述
    link: '', // 分享链接
    imgUrl: '', // 分享图标
    type: '', // 分享类型,music、video或link，不填默认为link
    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
    success: function () { 
        // 用户确认分享后执行的回调函数
    },
    cancel: function () { 
        // 用户取消分享后执行的回调函数
    }
});

    </script>
</body>
</html>
