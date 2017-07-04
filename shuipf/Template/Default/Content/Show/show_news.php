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
    <!-- 学股权-文章详情 -->
    <div class="ub ub-ver learnStkBox">
    <if condition="$catid neq 17">   
        <template file="Content/guquan_header.php"/>
   </if>
        <div class="learnDetailes ub ub-ver uinn bgc">
            <div class="title ub tx-c4">
			         {$title}
            </div>
            <div class="info ub uinn">
                <div class="name ub"><span class="tx-c4 iconfont icon-ren1"></span><i>股权帮</i></div>
                <div class="time ub"><span class="tx-c4 iconfont icon-shijian"></span><i class="tx-c8">{$updatetime|substr="###",0,10}</i></div>
                <div class="number ub ub-f1 ub-ac"><span class="ub-ac tx-c4 iconfont icon-yanjing1"></span><i class="ub ub-ac tx-c8">{:hits($catid,$id)}</i></div>
            </div>
            <div class="con">
			         {$content}
            </div>
			<div class="dhBtn ub ub-pc ub-ac">
                <a class="ub jf ub-pc ub-ac" href="{:getCategory(17,'url')}"><i class="icon"></i>积分兑换咨询</a>
                <a class="ub by ub-pc ub-ac" href="{:getCategory(13,'url')}"><i class="icon"></i>股权博弈</a>
            </div>

            <div class="page ub ub-ver">
                <div class="prevpg ub">
                  <span class="ub">[上一篇]：</span>
                  <a class="ub ub-f1 title_zh_p" href="<pre catid='$catid' id='$id' field='url' target='1' msg='' />"><pre catid='$catid' id='$id' field='title' target='1' msg='没有了' /></a>
                </div>
                <div class="nextpg ub">
                  <span class="ub">[下一篇]：</span>
                  <a class="ub ub-f1 title_zh_n" href="<next catid='$catid' id='$id' field='url' target='1' msg='' />"><next catid="$catid" id="$id" field="title" target="1" msg="没有了" /></a>
                </div>
            </div>                       
        </div>                        
    </div>
    <!-- /学股权-文章详情-->
  
  <template file="Content/footer.php"/> 
<input type="hidden" value="{$signature}" id="signature" />
<input type="hidden" value="{$description}" id="description" />
</div>
<!-- /c -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery.js"></script>
<script type="text/javascript">
$(function(){
  //文章点击数
  $.get("{$Config.siteurl}api.php?m=Hits&catid={$catid}&id={$id}", function (data) {
      $("#hits").html(data.views);
  }, "json");
 
  //上一篇下一篇标题
  if($(".title_zh_p").html()==''){
	  $(".title_zh_p").html('已经没有了');
  }
  if($(".title_zh_n").html()==''){
	  $(".title_zh_n").html('已经没有了');
  }
});
</script>

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
	//console.log(url);
	//console.log(123);
	var signature = $("#signature").val();
	
	var s_title = '{$title}';     //分享标题
	var s_link = url;  //分享链接
	var s_desc = $("#description").val();//分享描述
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
	
	data['share_type'] = 5;   // 分享观点
	
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