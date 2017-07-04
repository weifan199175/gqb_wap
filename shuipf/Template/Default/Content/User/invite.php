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
    <title>股权帮个人中心 邀请二维码</title>
</head>
<body class="um-vp">
<!-- c -->
<div class="cBox">
    <!-- 邀请二维码 -->
    <div class="ub ub-ver uinn5 ewmBox">
        <div class="ub info ub-ac">        
            <div class="phto ub ub-ac umar-r"><img <if condition="$user['userimg'] eq ''">src="/statics/default/images/logo1.png"<else />src="{$user['userimg']}"</if> alt=""></div>
            <div class="name ub ub-ver">
                <div class="nm ub umar-b ulev0">{$user['nickname']}<span class="ub umar-l iconfont icon-ren"></span></div>
                <div class="address ub ulev-1">{$user['address']}</div>
            </div>            
        </div>
		<div class="ub ub-f1 ub-ac ub-pc intro-img"><img class="ub" src="/statics/default/images/tqbg-img.jpg" alt=""></div>
        <div class="ewmImg ub ub-ac ub-pc" id="code">
            
        </div>
		
        <div class="ewmtit ub ub-ac ub-pc ulev0">用微信扫二维码，加入股权帮</div>
        <a class="click_upOut go-share uba ub ub-fl ub-ac ub-pc ulev-3 uc-a1" href="#"><span class="iconfont icon-xiaolvdashiicon02"></span>点击分享到朋友圈</a>        
    </div>
    <!-- /邀请二维码 -->
</div>
<!-- /c -->
<!--弹出层-->
<div class="PopUp2 uc-a3">
    <div class="PopUp_box ub ub-ver ub">
       <div class="contUp2 ub">
            <div class="shareFD ub ub-f1 ub-ver">
                <div class="shareFDimg ub ub-ac ub-pe"><img src="/statics/default/images/shareFD.png" alt=""></div>
                <div class="shareFDtit ub ub-ac tx-c">
                    请点击右上角<br>
                    将它发送给指定朋友<br>
                    或分享到朋友圈
                </div>
            </div>
       </div>       
    </div>
</div>
<!--/弹出层-->

<!-- jQuery 遮罩层 -->
<div class="fullbg2"></div>
<!-- end jQuery 遮罩层 -->

<!-- 页脚 -->
    
        <template file="Content/footer.php"/> 
     
    <!-- /页脚 -->
<input type="hidden" value="{$signature}" id="signature" />
<input type="hidden" value="{$user['invitation_code']}" id="invitation_code" />
</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/statics/default/js/jquery1.js"></script> 
<script type="text/javascript" src="/statics/default/js/jquery.qrcode.min.js"></script>
<!-- 弹出层 -->
<script src="/statics/default/js/ff.js" type="text/javascript"></script>
<script type="text/javascript">
var invitation_code = $("#invitation_code").val();
//alert(invitation_code);
$('#code').qrcode("http://<?php echo $_SERVER['HTTP_HOST']?>/index.php?a=shows&catid=13&id=26&invitation_code="+invitation_code); //任意字符串

$(function(){
    $(".click_upOut").click(function(){
        $(".PopUp2").animate({opacity:"show"},300);
        $(".fullbg2").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"block"});
    });      

    $(".fullbg2").click(function(){
        $(".PopUp2").animate({opacity:"hide"},100);
        $(".fullbg2").hide();
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
    
    
    var signature = $("#signature").val();
    
    var s_title = '新物种合伙人社群股权帮邀请您学股权,玩社群,连接合伙人';     //分享标题
//    var s_link = "http://guquanbang.com/index.php?m=User&a=reg&invitation_code="+invitation_code;  //分享链接 直接跳转的注册页面
    var s_link = "http://<?php echo $_SERVER['HTTP_HOST']?>/index.php?a=shows&catid=13&id=26&invitation_code="+invitation_code;  //分享链接 直接相关课程页面
    var s_desc = '学股权,做路演,连接合伙人,找牛人,找资本,找资源';//分享描述
    var s_imgUrl = "http://<?php echo $_SERVER['HTTP_HOST']?>/statics/default/images/logo1.png";//分享图标
     //console.info(s_link);
     //console.info(time);
     //console.info(jsapi_ticket);
     //console.info(signature);
        wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: '<?php echo $appid;?>', // 必填，公众号的唯一标识
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
    
    data['share_type'] = 6;   // 分享股权帮
    
    
    var url = '/index.php?m=User&a=share_success';
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