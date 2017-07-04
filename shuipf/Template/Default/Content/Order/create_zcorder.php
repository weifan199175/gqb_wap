<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" /> -->
    <meta http-equiv=”X-UA-Compatible” content=”IE=Edge,chrome=1″>
    <meta charset="utf-8">
    <title>确认众筹订单</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
    <script src="http://g.tbcdn.cn/mtb/lib-flexible/0.3.4/??flexible_css.js,flexible.js"></script>
    <script src="/statics/zc/js/pay.min.js"></script>
    <script src="/statics/layer_mobile/layer.js"></script>
    <link rel="stylesheet" href="/statics/zc/css/public.css">
    <link rel="stylesheet" href="/statics/zc/css/ui-box.css">
    <link rel="stylesheet" href="/statics/zc/css/ui-base.css">
    <link rel="stylesheet" href="/statics/zc/css/ui-color.css">
    <link rel="stylesheet" href="/statics/zc/css/appcan.control.css">
    <link rel="stylesheet" href="/statics/zc/css/iconfont/iconfont.css">
    <link rel="stylesheet" href="/statics/zc/css/index.css">
    <link rel="stylesheet" href="/statics/zc/css/common.min.css">
    <link rel="stylesheet" href="/statics/zc/css/pay.min.css">
</head>

<body>
    <!-- form开始 -->
    <div class="userInfo">
        <div class="nameInput">
            <span>&nbsp;姓&nbsp;名&nbsp;：</span>
            <input type="text" placeholder="请填写姓名" value="{$member['truename']}" id="truename" maxlength="10">
            <div class="error" id="error_name">&nbsp;</div>
        </div>
        <div class="phoneInput">
            <span>手机号：</span>
            <input type="tel" placeholder="请填写电话" value="{$member['mobile']}" id="mobile" maxlength="11">
            <div class="error" id="error_tel">&nbsp;</div>
        </div>
    </div>
    <!-- 支付列表开始 -->
    <div class="classList">
        <ul>
            <li>
                <div class="liTitle">{$course['title']}</div>
                <div class="classInfo">
                    <div class="classPic">
                        <img src="{$course['thumb']}" alt="">
                    </div>
                    <div class="classRight">
                        <div class="classTitle">
                            {$course['description']}
                        </div>
                        <div class="classPrice">￥<?php echo sprintf("%.2f", $course['price']);?> <span>x1</span> </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <!-- 确认众筹支付 -->
    <ul class="checkDiv">
        <li sts="1">
            <div class="checkFunding">众筹支付</div>
            <i class="myiconfont checkIcon">&#xe634;</i>
        </li>
    </ul>
    <!-- 合计 -->
    <div class="totleDiv">
        <div class="help">
            <a href="/statics/zc/help.html">
                <i class="myiconfont helpIcon">&#xe602;</i>问题咨询
            </a>
        </div>
        <div class="totlePrice">合计￥<?php echo sprintf("%.2f", $course['price']);?></div>
    </div>
    <!-- 提交按钮 -->
    <div class="payBtnDiv">
        <div class="payBtn"><a href="javascript:zhongchou()">提交</a></div>
    </div>
    <!-- foote开始 -->
    <template file="Content/new_footer.php"/> 
<script>
$(function(){
	$("#truename").focus(function(){
		$("#error_name").html("&nbsp;");
	});
	$("#mobile").focus(function(){
		$("#error_tel").html("&nbsp;");
	});
	
})
function zhongchou()
{
    var is_zc = "<?php echo $course['is_zc']?>";

    if(is_zc != "1"){
        alert("该课程不能参与众筹！");
        return;
    }
	
	var data = new Object();
	data['pay_type'] = 5; //众筹支付
	
	data['product_type'] = 1;//课程

	
	
	data['price'] = parseInt("<?php echo $course['price']?>");//金额
	data['score'] = 0;
	data['product_id'] = "<?php echo $course['id']?>";
	data['product_name'] = "<?php echo $course['title']?>";
	
	data['truename'] = $("#truename").val();
	data['mobile'] = $("#mobile").val();
	if(!data['truename']){
		$("#error_name").html("请输入你的姓名");
		document.getElementById("truename").scrollIntoView();//锚点跳转
		
		return;
	}
    var regtel = /^1[34578]{1}\d{9}$/;
    //手机号验证
    if(!regtel.test(data['mobile'])){
		$("#error_tel").html("请输入正确的手机号");
		document.getElementById("mobile").scrollIntoView();//锚点跳转
        return;
    }
	l_waiting();
	var url = '/index.php?m=Order&a=addorder';
	$.post(url, data, function (r){
		l_done();
		if(r.code=='0') {
			window.location.href='/index.php?m=Funding&a=share&id='+r.funding_id;
		}else if(r.code=='2'){
			alert("该课程您已经众筹过了，请勿重复操作！");return;
		}else if(r.code=='3'){
			alert("该课程马上就要开课了，不再参与众筹！");return;
		}else{
			alert("提交失败！");return;
		}
	},'json');
	return;
}
</script>
</body>
</html>