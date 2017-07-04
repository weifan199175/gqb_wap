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
    <title>股权帮个人中心 完善资料-选择职位</title>
</head>
<style>
.careerBox .uinput input {
    background: #20C1E0;
    padding: 0.6em 0;
}

.career li.cur {
    background: #20C1E0;
}
</style>
<body class="um-vp" style="background: #f4f4f4;">
<!-- c -->
<div class="cBox"> 
    <!-- 选择职位 -->
        <div class="careerBox ub ub-ver">
            <ul class="career ub ub-ver">
                <li class="<if condition="$user_position eq '创始人'">cur</if> ub ub-ac ub-pc ubb ubb-d uinn5 ulev0"><a class="ub tx-c2" href="#">创始人</a></li>
                <li class="<if condition="$user_position eq '合伙人/股东/董事'">cur</if> ub ub-ac ub-pc ubb ubb-d uinn5 ulev0"><a class="ub tx-c2" href="#">合伙人/股东/董事</a></li>
                <li class="<if condition="$user_position eq '投资人'">cur</if> current ub ub-ac ub-pc ubb ubb-d uinn5 ulev0"><a class="ub tx-c2" href="#">投资人</a></li>
                <li class="<if condition="$user_position eq '高管'">cur</if> ub ub-ac ub-pc ubb ubb-d uinn5 ulev0"><a class="ub tx-c2" href="#">高管</a></li>
                <li class="ub ub-ac ub-pc ubb ubb-d uinn5 ulev0"><a class="ub tx-c2" href="#">其他</a></li>
                <input type="hidden" name="company" id="company" value="{$_GET['company']}">
                <input type="hidden" name="industry" id="industry" value="{$_GET['industry']}">
                <input type="hidden" name="position" id="position" value="{$_GET['position']}">
                <input type="hidden" name="province_name" id="province_name" value="{$_GET['province_name']}">
                <input type="hidden" name="city_name" id="city_name" value="{$_GET['city_name']}">
            </ul>
            <a onclick="tiaozhuan()" class="btn ub ub-fl umar-b2 uinput" href="javascript:void(0);"><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1 tx-cf" type="button" name="" value="确认"></a>
                  
        </div>
    <!-- /选择职位 -->
</div>
<!-- /c -->
    <!-- 页脚 -->
    
        <template file="Content/footer.php"/> 
     
    <!-- /页脚 -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">

function setCookie(name,value)
{
	var Days = 30;
	var exp = new Date();
	exp.setTime(exp.getTime() + Days*24*60*60*1000);
	document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
function getCookie(name)
{
	var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	if(arr=document.cookie.match(reg))
	return unescape(arr[2]);
	else
	return null;
}
function tiaozhuan(){
	var back=<?php echo $back; ?>;
    if(1 != back){
		var company=$('#company').val();
		var position=$('#position').val();
		var industry=$('#industry').val();
		var province_name=$('#province_name').val();
		var city_name=$('#city_name').val();
		window.location.href="/index.php?m=User&a=perfect_information&province_name="+province_name+"&city_name="+city_name+"&industry="+industry+"&position="+position+"&company="+company;
	}else{
		setCookie('position', $('#position').val());
		window.location.href='/index.php?m=User&a=information';
		//console.info(getCookie('position'));
	}
}

$(function(){
  $(".career li").click(function(){
    var text = $(this).find("a").text();
    $(this).addClass("cur").siblings().removeClass("cur");
    $("#position").val(text);
   // alert($("#position").val());
  });

 // $(function(){

      //  $(".career li").live('click',function() {
            
      //      var text = $(this).find("a").text();
            //alert(text);exit;
     //       $("#position").val(text);

     //   });

  //  });
})       
</script>

</html>