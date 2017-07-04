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
    <title>账户安全-设置支付密码</title>
</head>
<body class="um-vp">

<!-- c -->
<div class="cBox">
    <!-- 设置支付密码 -->
    <div class="ub ub-ver safeCount">
        <div class="title ub">
            <a href="{:U('User/safe_index')}" class="ub ub-ac Left"><em class="iconfont icon-jiantouzuo"></em></a>
            <div class="ub ub-ac ub-pc ub-f1 Mid"><span>设置支付密码</span></div>
            <div class="ub uinn5"></div>
        </div>
        <ul class="list ub-f1 ub ub-ver ubt ubb-d">
            <li class="ub ub-f1 ub-ac ubb ubb-d uinn">
                <label class="ub" for="">支付密码</label>
                <div class="ub ub-f1 uinput"><input class="ub-f1 ulev-3" id="pay_pass" type="password"  name="" placeholder="请输入6位数字支付密码"></div>
            </li>
            <li class="ub ub-f1 ub-ac ubb ubb-d uinn">
                <label class="ub" for="">确认密码</label>
                <div class="ub ub-f1 uinput"><input class="ub-f1 ulev-3" id="c_pay_pass" type="password"  name="" placeholder="请确认支付密码"></div>
            </li>
            <li class="ub ub-f1 ub-ac ubb ubb-d uinn">
                <label class="ub" for="">验证码</label>
                <div class="ub ub-f1 uinput"><input class="ub-f1 ulev-3" id="yzm" type="text" name="" placeholder="请输入验证码"></div>  
                <div class="ybtn ub umar-l nav-btn uc-a3 ulev-1 uinput"><input style="" type="button" class="" value="获取验证码"  onclick="sendMessage();"  /></div>                   
            </li>
			<input type="hidden" id="mobile" value="{$mobile}"  />
        </ul>
        <a class="btn ub ub-fl uinput" href="javascript:;" Onclick="submit();"><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1" type="button" value="确定" name=""></a>
        <a class="changePhone click_upOut ub ub-fl ub-ac ub-pc uinn5" href="javascript:;">手机已更换,无法收到验证码</a>  
    </div>
    <!-- /设置支付密码 -->
</div>
<!-- /c -->
<!--弹出层-->
<div class="PopUp4 uc-a3">
    <div class="PopUp_box ub ub-ver ub">
       <div class="contUp ub ub-f1 ub-ver ub-ac ub-pc">
            <b class="ub ub-ac ub-pc">股权帮客服电话</b>
            <span class="ub ub-ac ub-pc">{:cache('Config.tel_1')}</span>
            <a class="call ub ub-ac ub-pc" href="tel:{:cache('Config.tel_1')}">拨打客服电话</a>
            <div class="cancle ub ub-ac ub-pc">取消</div>
       </div>
    </div>
</div>
<!--/弹出层-->

<!-- jQuery 遮罩层 -->
<div class="fullbg"></div>
<!-- end jQuery 遮罩层 -->
<!--弹出层-->
<div class="PopUp3 uc-a3">
    <div class="PopUp_box ub ub-ver ub">
       <div class="contUp ub ub-pc"id="tishi">
            提示信息
       </div>
    </div>
</div>
<!--/弹出层-->
</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
<script src="/statics/default/js/ff.js" type="text/javascript"></script>
<script type="text/javascript">
//读秒
var timer = 60;
function numRoll(){
    
    if(timer <= 0){
        $('.ybtn').css('background-color','#e60012').attr('onclick','sendMessage();').text("重新发送");
        timer   =   60;
    }else if(timer > 0){
        timer--;
        $('.ybtn').css('background-color','#AAA').attr('onclick','').text("("+timer+")已发送");
        setTimeout("numRoll()",1000);
    }
}

//弹窗提示
function Zalert(str)
{
	$("#tishi").html(str);
	$(".PopUp3").animate({opacity:"show"},300).delay(2000).fadeOut("slow");
	$(".fullbg").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"block"}).delay(2100).fadeOut("slow");
}

function sendMessage()
{
    //获取验证码
    var mobile = $("#mobile").val();
   
        var url = '/index.php?m=User&a=safe_code';
        $.post(url, {'mobile':mobile,'type':1}, function (r){
            if(r.code==0){
                Zalert('验证码已发送至您的手机，请注意查收！');
				numRoll();
            }else{
                Zalert(r.msg);
            }   
        },'json');

}

//表单提交
function submit()
{
	var pay_pass = $("#pay_pass").val();
	var c_pay_pass = $("#c_pay_pass").val();
	var yzm = $("#yzm").val();
    var num = /^[0-9]{6}$/; 
    if(pay_pass==''){
        Zalert('请填输入支付密码！');
        return false;
    }
	else if(!num.test(pay_pass))
	{
		Zalert('请输入6位数字的支付密码！');
		return false;
    }		

    if(c_pay_pass==''){
        Zalert('请填输入支付密码！');
        return false;
    }
	else if(!num.test(c_pay_pass))
	{
		Zalert('请输入6位数字的支付密码！');
		return false;
    }else if(pay_pass!=c_pay_pass)
	{
		Zalert('两次密码输入不一致！');
        return false;
	}	
	
	if(yzm=='' || yzm=='请输入验证码')
	{
		Zalert("请输入验证码");
		return;
	}
	
    var url = '/index.php?m=User&a=set_pay_pass';
	$.post(url, {'pay_pass':pay_pass,'c_pay_pass':c_pay_pass,'yzm':yzm}, function (r){
		if(r.code==0){
			Zalert(r.msg);
			setTimeout(function(){
               window.location.href="/index.php?m=User&a=safe_index";   
            },3000);
			
		}else{
			Zalert(r.msg);
		}   
	},'json');
	
}


</script>

<!-- 弹出层 -->

<script type="text/javascript">
$(function(){
    $(".click_upOut").click(function(){
        $(".PopUp4").animate({opacity:"show"},300);
        $(".fullbg").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"block"});
    });      

    $(".fullbg").click(function(){
        $(".PopUp4").animate({opacity:"hide"},100);
        $(".fullbg").hide();
    });
});
</script>
<!-- /弹出层 -->
</html>