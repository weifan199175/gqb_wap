<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="http://g.tbcdn.cn/mtb/lib-flexible/0.3.4/??flexible_css.js,flexible.js"></script>
<meta http-equiv=”X-UA-Compatible” content=”IE=Edge,chrome=1″>
<title>股权博弈课程</title>
<meta name="description" content="">
<meta name="keywords" content="">
<link rel="stylesheet" href="/statics/default/css/fonts/font-awesome.min.css">
<link rel="stylesheet" href="/statics/default/css/public.css">
<link rel="stylesheet" href="/statics/default/css/ui-box.css">
<link rel="stylesheet" href="/statics/default/css/ui-base.css">
<link rel="stylesheet" href="/statics/default/css/ui-color.css">
<link rel="stylesheet" href="/statics/default/css/appcan.control.css">
<link rel="stylesheet" href="/statics/default/css/iconfont/iconfont.css">
<link rel="stylesheet" href="/statics/default/css/center.css">
<link href="/statics/Theme/css/reset.css" rel="stylesheet">
<link rel="stylesheet" href="/statics/Theme/css/swiper.min.css">
<link href="/statics/Theme/css/introduce.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
<script src="/statics/Theme/js/swiper.jquery.min.js"></script>
<script src="/statics/Theme/js/main.js"></script>
</head>

<body>
<div class="banner">
<img src="/statics/Theme/images/banner.jpg" alt="">
</div>
<div class="talk">
<div>
王石：“不是不想做，一是运气不好，二是华润作为单一大股东比较敏感，我也没怎么去想管理层权益的问题。”日前，王石在接受采访时，坦承自己在股权设计方面的失责。
</div>
<div>
徐小平：创业的基础就是团队和股权结构，公司股权结构不合理一定做不成，不以股份为目的的创业都是耍流氓。
</div>
</div>
<div class="video">
<iframe frameborder="0" src="http://yuntv.letv.com/bcloud.html?uu=hnutk64ysa&vu=6612140376&pu=8fd938fb49&auto_play=0&width=100%&height=100%&lang=zh_CN" allowfullscreen></iframe>
</div>

<div class="title1">
<img src="/statics/Theme/images/title1.png" alt="">
</div>
<div class="title1Info">
<img src="/statics/Theme/images/LEAME.png" alt="">
</div>
<div class="boss">
<img src="/statics/Theme/images/boss.png" alt="">
</div>
<div class="flag1">
4月21日到23日线下集训，带着问题来，带着答案走
</div>
<div class="info">
<img src="/statics/Theme/images/info.jpg" alt="">
</div>
<div class="flag1">
《股权博弈》课程主要解决以下四个问题
</div>
<div class="que">
<img src="/statics/Theme/images/q.jpg" alt="">
</div>
<div class="prince">
<img src="/statics/Theme/images/prince.jpg" alt="">
</div>
<div class="joinBtn">
<a href="/index.php?a=shows&catid=13&id=26&invitation_code=<?php echo $other_inviti_code;?>">
<img src="/statics/Theme/images/btn.jpg" alt="">
</a>
<input type="hidden" value="{$signature}" id="signature" />
<input type="hidden" value="{$user['invitation_code']}" id="invitation_code" />
</div>
<div class="contact">
<p>如有疑问欢迎勾搭课程顾问</p>
<p>李灿: Tel/微信 18610127110</p>
<p>小明: Tel/微信 18610127119</p>
</div>
<div class="swiper-container">
<div class="swiper-wrapper">
<div class="swiper-slide">
<img src="/statics/Theme/images/pic1.jpg" alt="">
</div>
<div class="swiper-slide">
<img src="/statics/Theme/images/pic3.jpg" alt="">
</div>
<div class="swiper-slide">
<img src="/statics/Theme/images/pic4.jpg" alt="">
</div>
</div>

</div>


<!-- 页脚 -->
    
        <template file="Content/footer.php"/> 
     
    <!-- /页脚 -->     
<script>
var W = $(".video iframe").width();
var H = W / 1.7;
$(".video iframe").height(H);
var mySwiper = new Swiper('.swiper-container', {
    direction: 'horizontal',
    loop: true,
})
</script>
<!--微信分享-->
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>  
<script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>  
<script type="text/javascript">
   var time = <?php echo $time; ?>;
   
   var jsapi_ticket = '<?php echo $jsapi_ticket; ?>';
	
	//string1=jsapi_ticket+'&noncestr=BogLeUnion&timestamp='+time+'&url='+window.location.href;
	
	var url = window.location.href;
	
	var signature = $("#signature").val();
	
	var s_title = '{$title}';     //分享标题
	var s_link = '{$share_url}';  //分享链接
	var s_desc = '';              //分享描述
	var s_imgUrl = 'http://m.guquanbang.com{$thumb}';//分享图标
	// console.info(url);
	// console.info(jsapi_ticket);
	// console.info(signature);
    	wx.config({
		debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
		appId: '<?php echo $appid?>', // 必填，公众号的唯一标识
		timestamp: time, // 必填，生成签名的时间戳
		nonceStr: 'BogLeUnion', // 必填，生成签名的随机串
		signature: signature,// 必填，签名，见附录1
		jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareWeibo','onMenuShareQZone'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
   });

wx.ready(function () {
	
	
	//分享到朋友圈
   wx.onMenuShareTimeline({
    title: s_title, // 分享标题
    link: s_link, // 分享链接
    imgUrl: s_imgUrl, // 分享图标
    success: function () { 
        share_success()
    },
    cancel: function () { 
        // 用户取消分享后执行的回调函数
		alert("您已取消分享！");
    }
   });
   
   //分享给朋友
   wx.onMenuShareAppMessage({
    title: s_title, // 分享标题
    desc: s_desc, // 分享描述
    link: s_link, // 分享链接
    imgUrl: s_imgUrl, // 分享图标
    type: '', // 分享类型,music、video或link，不填默认为link
    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
    success: function () { 
        share_success()
    },
    cancel: function () { 
        // 用户取消分享后执行的回调函数
		alert("您已取消分享！");
    }
	
	
   });
 </script>
</body>

</html>