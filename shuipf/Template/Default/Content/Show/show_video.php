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
<body class="um-vp" style="background: #f4f4f4;">
<!-- c -->
<div class="cBox"> 
    <!-- 学股权-股权视频 （详情） -->
    <div class="ub ub-ver videokBox">
        
        <template file="Content/guquan_header.php"/>

        <div class="videoDetailes ub ub-ver">
            <div class="ub ub-ac ub-pc ub-f1">
                
				<if condition="$is_live eq 1">
				<div class="vdBox ub ub-f1">
					<div id="player" style="width:100%;height:450px;">
					<script type="text/javascript" charset="utf-8" src="http://yuntv.letv.com/player/live/blive.js"></script>
					<script> 
					 {$video_code}
					</script>
                    </div> 
				</div>	
				<else /> 
				<div class="img ub ub-f1">
					<a href="{$video_code}"><img class="" src="{$thumb}" alt="">
                    <div class="bgup ub ub-ac ub-pc">
                        <span class="ub iconfont icon-shipin"></span>
                    </div>
                    </a>
				</div>	
				</if>
                
                
            </div>
            <div class="vdtInfo ub ub-ver ub-f1 uinn">
				<if condition="$is_live eq 1">
					<h5 class="title ub"><b>【直播】：</b>{$title}</h5>
					<div class="timeing ub">直播开始时间：<i>{$start_time}</i></div>
				<else />
					<h5 class="title ub"><b>【视频】：</b>{$title}</h5>
				</if>			
                <!--<div class="tips ub">10积分（铁杆/合伙社员免费）</div>-->
                <div class="number ub tx-c8">播放：<i>{:hits($catid,$id)}</i>次</div>
                <div class="auther ub tx-c8">作者：<i>股权帮</i></div>
                <div class="time ub tx-c8">发布时间：<i>{$updatetime|date="Y-m-d H:i:s",###}</i></div>
                <div class="tit ub">详细介绍</div>
                <div class="detailes ub">
                    {$description}
                </div>
            </div>                            
        </div>              
    </div>
    <!-- /学股权-股权视频（详情）-->
     <!-- 页脚 -->
        <template file="Content/footer.php"/>      
     <!-- /页脚 -->

</div>
<!-- /c -->

<!--弹出层-->
<div class="PopUp uc-a3">
    <div class="PopUp_box ub ub-ver ub">
       <div class="contUp ub">
            您好，您没有权限观看此视频，请升级社员等级后再观看，谢谢！
            <!-- 您好，您的可用积分不足以观看此视频，
请立即充值积分以便观看，谢谢！ （弹出信息2)     -->
       </div>
       <a class="btn ub uinn" href="javascript:void(0);">
            <div class="callbtn ub ub-f1 ub-ac ub-pc tx-cf uc-a3 uinn7 bg-red ulev0">                
                社员升级
                <!-- 立即充值    (弹出信息2) -->
            </div>
        </a>
    </div>
</div>
<!--/弹出层-->
<input type="hidden" value="{$signature}" id="signature" />
<!-- jQuery 遮罩层 -->
<div class="fullbg"></div>
<!-- end jQuery 遮罩层 -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery.js"></script>

<script type="text/javascript">
$(function(){
  //文章点击数
  $.get("{$Config.siteurl}api.php?m=Hits&catid={$catid}&id={$id}", function (data) {
      $("#hits").html(data.views);
  }, "json");
});
</script>

<!-- 弹出层 -->
<script src="/statics/default/js/ff.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
    $(".click_upOut").click(function(){
        $(".PopUp").animate({opacity:"show"},300);
        $(".fullbg").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"block"});
    });      

    $(".fullbg").click(function(){
        $(".PopUp").animate({opacity:"hide"},100);
        $(".fullbg").hide();
    });
});
</script>
<!-- /弹出层 -->
<!--微信分享-->
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>  
<script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">

   var time = <?php echo $time; ?>;
   
   var jsapi_ticket = '<?php echo $jsapi_ticket; ?>';
	
	//string1=jsapi_ticket+'&noncestr=BogLeUnion&timestamp='+time+'&url='+window.location.href;
	
	var url = window.location.href;
	var invitation_code = "<?php echo isset($invitation_code)?$invitation_code:""?>";
    if(invitation_code){
        url=url+"&invitation_code="+invitation_code;
    }
	
	var signature = $("#signature").val();
	
	var s_title = '{$title}';     //分享标题
	var s_link = url;  //分享链接
	var s_desc = '{$description}';//分享描述
	var s_imgUrl = '{$thumb}';//分享图标
	// console.info(url);
	// console.info(time);
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
   //分享到QQ
   wx.onMenuShareQQ({
    title: s_title, // 分享标题
    desc: s_desc, // 分享描述
    link: s_link, // 分享链接
    imgUrl: s_imgUrl, // 分享图标
    success: function () { 
       share_success()
    },
    cancel: function () { 
       alert("您已取消分享！");
    }
});
   //分享到腾讯微博
   wx.onMenuShareWeibo({
    title: s_title, // 分享标题
    desc: s_desc, // 分享描述
    link: s_link, // 分享链接
    imgUrl: s_imgUrl, // 分享图标
    success: function () { 
       share_success()
    },
    cancel: function () { 
       alert("您已取消分享！");
    }
});
   //分享到QQ空间
   wx.onMenuShareQZone({
    title: s_title, // 分享标题
    desc: s_desc, // 分享描述
    link: s_link, // 分享链接
    imgUrl: s_imgUrl, // 分享图标
    success: function (){ 
       share_success()
    },
    cancel: function (){ 
        alert("您已取消分享！");
    }

  });
   
})

//分享成功回调
function share_success()
{
	var data = new Object();
	
	data['share_type'] = 3;   // 分享视频
	
	data['id'] = {$id};
	
   	var url = '/index.php?a=share_success';
	$.post(url, data, function (r){
		if(r.code=='1'){
		   alert(r.msg);
		}else{
		   alert("分享成功！");	
		}
         
	},'json');
	return;
	
}
</script>
</html>