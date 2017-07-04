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
    <title>账户安全-验证支付密码</title>
</head>
<body class="um-vp">

<!-- c -->
<div class="cBox">
    <!-- 修改支付密码 -->
    <div class="ub ub-ver safeCount">
        <div class="title ub">
            <a href="{:U('User/safe_index')}" class="ub ub-ac Left"><em class="iconfont icon-jiantouzuo"></em></a>
            <div class="ub ub-ac ub-pc ub-f1 Mid"><span>验证支付密码</span></div>
            <div class="ub uinn5"></div>
        </div>
        <ul class="list ub-f1 ub ub-ver ubt ubb-d">
            <li class="ub ub-f1 ub-ac ubb ubb-d uinn">
                <label class="ub" for="">当前密码</label>
                <div class="ub ub-f1 uinput"><input class="ub-f1 ulev-3" id="pay_pass" type="password"  name="" placeholder="请输入6位数字支付密码"></div>
            </li>
        </ul>
        <a class="btn ub ub-fl uinput" href="javascript:;" Onclick="submit();"><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1" type="submit" value="下一步" name=""></a>
    </div>
    <!-- /修改支付密码 -->
</div>
<!-- /c -->


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
<script>
//表单提交
function submit()
{
	var pay_pass = $("#pay_pass").val();
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
	
    var url = '/index.php?m=User&a=check_old_pay_pass';
	$.post(url, {'pay_pass':pay_pass}, function (r){
		if(r.code==0){
			Zalert(r.msg);
			setTimeout(function(){
               window.location.href="/index.php?m=User&a=pay_pass&type=1"; 
            },3000);
			
		}else{
			Zalert(r.msg);
		}   
	},'json');
	
}
//弹窗提示
function Zalert(str)
{
	$("#tishi").html(str);
	$(".PopUp3").animate({opacity:"show"},300).delay(2000).fadeOut("slow");
	$(".fullbg").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"block"}).delay(2100).fadeOut("slow");
}

</script>
</html>