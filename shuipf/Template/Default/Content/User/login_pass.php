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
    <link rel="stylesheet" href="/statics/default/css/center.css">
    <link rel="stylesheet" href="/statics/default/css/center.css">
    <link rel="stylesheet" href="/statics/default/css/center.css">
    <title>股权帮个人中心 账户安全-修改登录密码</title>
</head>
<body class="um-vp">

<!-- c -->
<div class="cBox">
    <!-- 修改登录密码 -->
    <div class="ub ub-ver safeCount">
        <div class="title ub">
            <a href="{:U('User/safe_index')}" class="ub ub-ac Left"><em class="iconfont icon-jiantouzuo"></em></a>
            <div class="ub ub-ac ub-pc ub-f1 Mid"><span>修改登录密码</span></div>
            <div class="ub uinn5"></div>
        </div>
        <ul class="list ub-f1 ub ubb-d ub-ver ubt ubb-d">
            <li class="ub ub-f1 ub-ac ubb ubb-d uinn5">
                <label class="ub" for="">当前密码</label>
                <div class="ub ub-f1 uinput"><input class="ub-f1 ulev-3" id="oldpass" type="password" name="oldpass" placeholder="请输入您的当前的登录密码"></div>
            </li>
            <li class="ub ub-f1 ub-ac ubb ubb-d uinn5">
                <label class="ub" for="">新密码</label>
                <div class="ub ub-f1 uinput"><input class="ub-f1 ulev-3" id="newpass" type="password" name="newpass" placeholder="请设置新密码"></div>
            </li>
            <li class="ub ub-f1 ub-ac ubb ubb-d uinn5">
                <label class="ub" for="">确认密码</label>
                <div class="ub ub-f1 uinput"><input class="ub-f1 ulev-3" id="c_newpass" type="password" name="c_newpass" placeholder="请确认新密码"></div>                
            </li>
        </ul>
        <a class="click_upOut btn ub ub-fl uinput" Onclick="submit();" href="javascript:;"><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1" type="button" value="确定" name=""></a>  
    </div>
    <!-- /修改登录密码 -->
</div>
<!-- /c -->
<!--弹出层-->
<div class="PopUp3 uc-a3">
    <div class="PopUp_box ub ub-ver ub">
       <div class="contUp ub ub-pc"id="tishi">
            原密码输入错误，请重新输入
       </div>
    </div>
</div>
<!--/弹出层-->

<!-- jQuery 遮罩层 -->
<div class="fullbg"></div>
<!-- end jQuery 遮罩层 -->



</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
<!-- 弹出层 -->
<script src="/statics/default/js/ff.js" type="text/javascript"></script>
<script type="text/javascript">
// $(function(){
    // $(".click_upOut").click(function(){
        // $(".PopUp3").animate({opacity:"show"},300).delay(2000).fadeOut("slow");
        // $(".fullbg").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"block"}).delay(2100).fadeOut("slow");
    // });      
// });

function Zalert(str)
{
	$("#tishi").html(str);
	$(".PopUp3").animate({opacity:"show"},300).delay(2000).fadeOut("slow");
	$(".fullbg").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"block"}).delay(2100).fadeOut("slow");
}
//表单提交
function submit()
{
	var oldpass = $("#oldpass").val();
	var newpass = $("#newpass").val();
	var c_newpass = $("#c_newpass").val();
	if(oldpass=='')
	{
		Zalert("请输入原始密码");
		return;
	}
	if(newpass=='')
	{
		Zalert("请输入新密码");
		return;
	}
	if(c_newpass=='')
	{
		Zalert("请确认新密码");
		return;
	}

    var url = '/index.php?m=User&a=edit_login_pass';
	$.post(url, {'oldpass':oldpass,'newpass':newpass,'c_newpass':c_newpass}, function (r){
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
<!-- /弹出层 -->

</html>