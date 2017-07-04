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
    <title>股权帮个人中心 电子门票-门票信息(报到失败)</title>
</head>
<body class="um-vp">
<!-- c --> 
<div class="cBox">
    <!-- 门票信息 -->
    <div class="ub ub-ver ticketBox">
        <div class="titcket ub ubb ubb-d ub-ac ub-pc uinn">门票信息</div>
        <div class="ticketImg ub ub-ac ub-pc uinn7 uof">
            <img src="{$res['thumb']}" alt="">
        </div>
        <h5 class="nametit ub ub-ac ub-pc">{$res.title}</h5>
        <div class="ticketcon ub ub-ver ubb ubt ubb-d umar-a">
            <div class="ticketList ub">
                <span class="iconfont icon-dian tx-red"></span>
                <b>讲师：</b>
                <i>{$res.teacher}</i>
            </div>
            <div class="ticketList ub">
                <span class="iconfont icon-dian tx-red"></span>
                <b>时间：</b>
                <i>{$res.start_time|date="Y-m-d",###}</i>
            </div>
            <div class="ticketList ub">
                <span class="iconfont icon-dian tx-red"></span>
                <b>地点：</b>
                <i>{$res.address_info}</i>
            </div>
        </div>
        <a class="go-chose btn ub umar-a uinput ub-ac ub-pc ulev-3 uc-a1 bg-red tx-cf" href="javascript:void(0);" onclick="baodao();
        " >立即报到</a>       
    </div>
    <!-- /门票信息 -->
</div>
<!-- /c -->
        <input type="hidden" name="id" id="id" value="{$res['id']}" />
        <input type="hidden" name="openid" id="openid" value="{$openid}" />
<!--弹出层-->
<div class="PopUp uc-a3">
    <div class="PopUp_box ub ub-ver ub">
       <div class="contUp ub">
            您好，您还没有购买此课程，请立即购买
以便及时参加课程，谢谢！
       </div>
       <a class="btn ub uinn" href="/index.php?a=shows&catid={$res.catid}&id={$res.id}">
            <div class="callbtn ub ub-f1 ub-ac ub-pc tx-cf uc-a3 uinn7 bg-red ulev0">                
                立即报名
            </div>
        </a>
    </div>
</div>
<!--/弹出层-->

<!-- jQuery 遮罩层 -->
<div class="fullbg"></div>
<!-- end jQuery 遮罩层 -->


</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
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

<script type="text/javascript">
    function baodao(){
        //alert(111);exit;
        var id=$("#id").val();
        var openid=$("#openid").val();
        var url = '/index.php?m=Saoma&a=chaxun';
        var data = new Object();
        data['id'] = id;
        data['openid'] = openid;
        $.post(url, data, function (r){
        if(r==0){
                if(confirm('是否需要核销')){
                //alert(1);
                var id=$("#id").val();
                var openid=$("#openid").val();
                var data = new Object();
                data['id']=id;
                data['openid']=openid;
                var url = '/index.php?m=Saoma&a=hexiao';
                $.post(url, data, function (r){
                if(r==0){
                        alert('核销成功');
                        window.location.href="/index.php?m=Saoma&a=saoma_success&id="+id+"&openid="+openid;
                    }else if(r==1){
                        alert('核销失败');return;
                }
            
            },'json');
                }else{
                    return false;
            }
        }else if(r==1){
            //没有购买该课程
            $(".PopUp").animate({opacity:"show"},300);
            $(".fullbg").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"block"});
            $(".fullbg").click(function(){
				$(".PopUp").animate({opacity:"hide"},100);
				$(".fullbg").hide();
			});
            
        }else if(r==3){
			alert('您已经报过到了，请勿重复操作');return;
		}else if(r==2){
            alert('您还不是股权帮的会员');return;
        }   
    },'json');
    }
</script>


</html>