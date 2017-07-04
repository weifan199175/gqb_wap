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
    <link rel="stylesheet" href="/statics/default/css/swiper.min.css">
    <link rel="stylesheet" href="/statics/default/css/service.css">
    <link rel="stylesheet" href="/statics/default/css/index.css">
    <title><if condition=" isset($SEO['title']) && !empty($SEO['title']) ">{$SEO['title']}</if>{$SEO['site_title']}</title>
</head>
<body class="um-vp" style="background: #fff;">
<!--头部-->

<!--头部-->
<!-- c -->
<div class="sBox"> 
    <!-- 社员服务 -->
    <div class="ub ub-ver UPmemberBox">
        <!-- title -->
            
        <!-- /title -->
        <!-- banner -->
        <div class="banner swiper-container mar-b7">
            <div class="swiper-wrapper">
                <content action="lists" catid="18" order="listorder DESC" moreinfo="1">
				<volist name="data" id="vo">
					<div class="swiper-slide"><img src="{$vo.img}" alt=""></div>
				</volist>
				</content>	
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
        </div>
        <!-- /banner -->



        <!-- nav -->
        <div class="navBox ub ubb ub-cd">
            <div class="nav ub ubr ub-cd uinn">
                <a class="ub ub-f1 ub-ver ub-ac ub-pc" href="{:getCategory(7,'url')}">
                    <span class="ub tx-cblu iconfont icon-zhishichanquanguanli"></span>
                    <div class="ub tx-c2">课程中心</div>
                </a>
            </div>
            <div class="nav ub ubr ub-cd uinn">
                <a class="ub ub-f1 ub-ver ub-ac ub-pc" href="{:getCategory(6,'url')}">
                    <span class="ub tx-cred iconfont icon-wsmp-equityout"></span>
                    <div class="ub tx-c2">学股权</div>
                </a>
            </div>
            <div class="nav ub ubr ub-cd uinn">
                <a class="ub ub-f1 ub-ver ub-ac ub-pc" href="{:getCategory(16,'url')}">
                    <span class="ub tx-cog iconfont icon-huiyuanfuwu"></span>
                    <div class="ub tx-c2">铁杆社员</div>
                </a>
            </div>
            
            
            <if condition="$_SESSION['userid'] neq ''">
                <div class="nav ub ubr ub-cd uinn">
                    <a class="ub ub-f1 ub-ver ub-ac ub-pc" href="/index.php?m=User&a=task">
                        <span class="ub tx-cgn iconfont icon-woderenwu color-bl2"></span>
                        <div class="ub tx-c2">我的任务</div>
                    </a>
                </div>
            <else />
                <div class="nav ub ubr ub-cd uinn">
                    <a class="ub ub-f1 ub-ver ub-ac ub-pc" href="/index.php?m=User&a=index">
                        <span class="ub tx-cgn iconfont icon-zhuce-copy"></span>
                        <div class="ub tx-c2">注册</div>
                    </a>
                </div>
            </if>
        </div>
        <!-- /nav -->










        <!-- 股权博弈（详情） -->
        <div class="classBox">
            <div class="gqbyDtt ub ub-ac ub-pc">{$title}</div>       
            <div class="ub ubt ubb-d ub-f1 uinn5 ulev0">
                <span class="ub ub-ac tx-red iconfont icon-juxing184"></span>
                <em class="tx-c2">讲师介绍</em>
            </div>
            <div class="teacherIt ub ubb ubb-d uinn">
                <div class="phto ub"><img src="{$teacher_img}" alt=""></div>
                <div class="introduction ub ub-ver ub-pc ub-f1">
                    <div class="name ub">{$teacher_info}</div>
                    <div class="itro ub tx-c8">{$teacher}</div>
                </div>
            </div>
            <div class="classIntro ub ub-ver uinn">
                <div class="tit ub ub-f1 ulev0">
                    <span class="ub ub-ac tx-red iconfont icon-juxing184"></span>
                    <em class="tx-c2">课程介绍</em>
                </div>
                <div class="adTime ub ub-ver">
                    <div class="ub time">时间：<i>{$start_time|strtotime|date="Y-m-d",###} 到 {$end_time|strtotime|date="Y-m-d",###}</i></div>
                    <div class="ub">地点：<i>{$city}</i></div>
					<div class="price ub">价    格：<i class="tx-red">￥{$price}</i></div>
					<if condition="$catid eq 13">
					<!-- <div class="price ub">所需积分：<i class="tx-red">{$score} 分</i></div> -->
					</if>
                </div>
                <div class="con uinn tx-c2">
				{$content}
                </div>
                <div class="tit ub ub-f1 ulev0">
                    <span class="ub ub-ac tx-red iconfont icon-juxing184"></span>
                    <em class="tx-c2">适合对象</em>
                </div>
                <div class="con uinn tx-c2">
				  {$description}
					<!--<a Onclick="share_success();" href="javascript:;">asdasdsadasdasdadas</a>-->
                </div>
            </div>
        </div>
        <!-- /股权博弈（详情） -->                               
    </div>
	
    <!-- /社员服务-->
    <!-- 页脚 -->
		<?php
			//查询是否报名
			$res=M('order')->where(array('member_id' =>$_SESSION['userid'] ,'product_id'=>$id ))->find();
        ?>
		
        <div class="ftBtFixed ubt ubb-d">
		<?php  if(time()>strtotime($end_time)){ ?>
            <a class="btn ub uinn" href="javascript:void(0);">
                <div class="click_upOut callbtn ub ub-f1 ub-ac ub-pc tx-cf uc-a3 uinn7 bg-red ulev0">       
                    已结束
                </div>
            </a>
		<?php  }else if(time()>=strtotime($start_time) && time()<=strtotime($end_time)){ ?>
            <a class="btn ub uinn" href="javascript:void(0);">
                <div class="click_upOut callbtn ub ub-f1 ub-ac ub-pc tx-cf uc-a3 uinn7 bg-red ulev0">       
                    进行中
                </div>
            </a>	
		<?php }else if($enter_num >= $max_num){ ?>
		    <a class="btn ub uinn" href="javascript:void(0);" >
                <div class="click_upOut callbtn ub ub-f1 ub-ac ub-pc tx-cf uc-a3 uinn7 bg-red ulev0">                
                    报名人数已满
                </div>
            </a>
        <?php }else if($res['status']=='1'){?>
                <a class="btn ub uinn" href="javascript:void(0);" >
                <div class="click_upOut callbtn ub ub-f1 ub-ac ub-pc tx-cf uc-a3 uinn7 bg-red ulev0">                
                    已报名
                </div>
            </a>
        <?php }else{ ?>
        <!-- 在课程模型中加入了购买权限的设定，只要取出来，转换成数组判断一下就好了 -->
        <?php $buy_power = explode(",",$buy_power);?>
        <?php if(isset($_SESSION['member_class']) && in_array($_SESSION['member_class'], $buy_power)){?>
        <!-- 如果是股权博弈课程，或者是创始会员，铁杆会员，才能购买 -->
			   <a class="btn ub uinn" href="javascript:void(0);" onClick="baoming('<?php echo $id?>');">
                <div class="click_upOut callbtn ub ub-f1 ub-ac ub-pc tx-cf uc-a3 uinn7 bg-red ulev0">                
                    立即报名
                </div>
            </a>
        <?php }else{?>
			   <a class="btn ub uinn" href="tel:4000279828">
                <div class="click_upOut callbtn ub ub-f1 ub-ac ub-pc tx-cf uc-a3 uinn7 bg-red ulev0">                
                    了解咨询
                </div>
            </a>
        <?php }?>
            <!-- 用户必须是登录状态，活动本身是参与众筹的，并且活动时间是正确的，就开放众筹按钮 -->
        <?php if(isset($_SESSION['userid']) && $is_zc == 1 && time()<getOverTime($id)){?>
            <a class="btn ub uinn" href="javascript:void(0);" onClick="zhongchou('<?php echo $id?>');">
            <div class="click_upOut callbtn ub ub-f1 ub-ac ub-pc tx-cf uc-a3 uinn7 bg-red ulev0">                
                众筹参课
            </div>
        </a>
        <?php }?>
		<?php } ?>	
            <!--路演函数 is_applay()-->
            <?php if(!isset($_SESSION['userid'])){?>
            <!--注册按钮-->
            <a class="btn btn2 ub uinn"  
            href="http://<?php echo $_SERVER['HTTP_HOST']?>/index.php?m=User&a=reg" onclick="">
                <div class="callbtn ub ub-f1 ub-ac ub-pc tx-cf uc-a3 uinn7 ulev0 bg-a">                
                    注册股权帮
                </div>
            </a>
            <?php }?>
		
        </div>

        <template file="Content/footer.php"/> 
    <!-- /页脚 -->
</div>
<!-- /c -->

<!--弹出层-->
<div class="PopUp uc-a3">
    <div class="PopUp_box ub ub-ver ub">
       <div class="contUp ub" id="t1">
            您好！请登录后再报名，谢谢！<!--您好，注册会员，请完成资料后再报名，谢谢！-->
       </div>
       <a class="btn ub uinn" href="javascript:void(0);">
            <div class="callbtn ub ub-f1 ub-ac ub-pc tx-cf uc-a3 uinn7 bg-red ulev0" id="t2">                
                登录<!--完善资料-->
            </div>
        </a>
    </div>
</div>
<!--/弹出层-->

<!-- jQuery 遮罩层 -->
<div class="fullbg"></div>
<!-- end jQuery 遮罩层 -->


<input type="hidden" value="{$signature}" id="signature" />
</body>
<script type="text/javascript" src="/statics/default/js/jquery.js"></script>
<script type="text/javascript" src="/statics/default/js/swiper.min.js"></script>
<script type="text/javascript">
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true
    });
</script>

<script src="/statics/default/js/ff.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
    /*$(".click_upOut").click(function(){
        $(".PopUp").animate({opacity:"show"},300);
        $(".fullbg").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"block"});
    });   */   

    $(".fullbg").click(function(){
        $(".PopUp").animate({opacity:"hide"},100);
        $(".fullbg").hide();
    });
	
	
});


//立即报名
function baoming(course_id)
{
	//alert(course_id);return;
	var memberid = '<?php echo $_SESSION['userid']; ?>';
	
	var memberclass = '<?php echo $_SESSION['member_class']; ?>';   
    	
	
	if(memberid=='')
	{
		$(".PopUp").animate({opacity:"show"},300);
        $(".fullbg").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"block"});
		
		$("#t2").click(function(){
			window.location.href='/index.php?m=User&a=index';
		})
		
	}
	else if(memberclass=='1')
	{
	   	$("#t1").html("您好，注册会员以上才能报名课程，请完成资料后再报名，谢谢！");
		$("#t2").html("完善资料");
		$(".PopUp").animate({opacity:"show"},300);
        $(".fullbg").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"block"});
		$("#t2").click(function(){
			window.location.href='/index.php?m=User&a=perfect_information';
		})
		
		return;
	}else{
		window.location.href='/index.php?m=Order&a=create_order&id='+course_id;
	}
	
	
}

//众筹参课
function zhongchou(course_id){
	//order_type，订单类型，zhongchou = 众筹
	window.location.href='/index.php?m=Order&a=create_order&order_type=zc&id='+course_id;
}

// 是否可以申请直播路演的项目
function is_apply(){
    // 先判断是否登陆
    var memberid = '<?php echo $_SESSION['userid']; ?>';
    
    var memberclass = '<?php echo $_SESSION['member_class']; ?>';   
        
    
    if(memberid=='')
    {
        $(".PopUp").animate({opacity:"show"},300);
        $(".fullbg").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"block"});
        
        $("#t2").click(function(){
            window.location.href='/index.php?m=User&a=index';
        })
        return false;
        
    }
    else if(memberclass=='1')
    {
        $("#t1").html("您好，注册会员以上才能报名课程，请完成资料后再报名，谢谢！");
        $("#t2").html("完善资料");
        $(".PopUp").animate({opacity:"show"},300);
        $(".fullbg").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"block"});
        $("#t2").click(function(){
            window.location.href='/index.php?m=User&a=perfect_information';
        })
        
        return false;
    }else{
        
        // 异步请求,会员是否购买相应的报股权博弈课程就可以，
        // 或者他是铁杆社员级别以上也可以报名直播
        $.ajax({
            url:"{:U('Liveshowapply/check_apply')}",
            type:'post',
            data: {'id':1},
            success:function(msg){
                if(msg==1){
                    window.location.href='/index.php?m=Liveshowapply&a=apply';
                }else{
                    $("#t1").html("由于您可能没有“股权博弈”课程，或者不是铁杆社员以上级别的会员，故无法申请直播路演哦！");
                    $("#t2").html("关闭");
                    $(".PopUp").animate({opacity:"show"},300);
                    $(".fullbg").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"block"});
                    $("#t2").click(function(){
                        $(".PopUp").animate({opacity:"hide"},300);
                        $(".fullbg").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"none"});
                   
                        // window.location.href='/index.php?m=Index&a=index';
                    })
                }
               
            }
        });
      
        
    }
}

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
	
	var signature = $("#signature").val();
	
	var s_title = '{$title}';     //分享标题
	var s_link = '{$share_url}';  //分享链接
	var s_desc = '{$description}';              //分享描述
	var s_imgUrl = '{$thumb}';//分享图标
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
	
	data['share_type'] = 4;   // 分享课程
	
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