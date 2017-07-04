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
    <link rel="stylesheet" href="/statics/default/css/service.css">
    <title>上课报名</title>
</head>
<body class="um-vp" style="background: #fff;">

<!-- c -->
<div class="cBox"> 
    <!-- 上课报名 -->
    <div class="ub ub-ver inClassEnterBox">
        <div class="inClass ub ub-pc ub-ac tx-red">{$course.title}</div>
        <div class="price ub ub-pc ub-ac tx-red">￥{$course.price}</div>
        <div class="title ub ub-ac ub-pc tx-c4">讲师：<i>{$course.teacher}</i></div>
        <div class="title ub ub-ac ub-pc tx-c4">时间：<i>{$course.start_time|date="Y-m-d",###}</i></div>
        <div class="title ub ub-ac ub-pc tx-c4">地点：<i>{$course.city}</i></div>
		<?php 
		   // $_SESSION['member_class'] = 3;
		  
            if($_SESSION['member_class']>2){
				
				switch($_SESSION['member_class'])
				{
				    case 3:
				    $class_name = "创始社员";break;
					case 4:
					$class_name = "铁杆社员";break;
				}
				
		?>		
        <input type="hidden" value="3" id="pay_type" />		
		<div class="title ub ub-ac ub-pc tx-c4 tx-cog3">您是{$class_name}，可免费报名该课程！</div>
		<?php } ?>
        <ul class="enter ub-ver ub-f1">
            <li class="ub ub-ac ubb ubb-d uinn5">
                <span class="ub ub-ac iconfont icon-ren"></span>
                <div class="ub ub-f1 uinput"><input type="text" name="truename" id="truename" value="{$member.truename}" placeholder="{$member.truename}"></div>        
            </li>
            <li class="ub ub-ac ubb ubb-d uinn5">
                <span class="ub ub-ac iconfont icon-shouji"></span>
                <div class="ub ub-f1 uinput"><input type="text" name="mobile" id="mobile" value="{$member.mobile}" placeholder="{$member.mobile}"></div>        
            </li>      
            <br />
            <br />			
			<!--<span style="font-size:14px;color:red;">（可用积分：{$member.score}）</span>-->
			
        </ul>
        <a class="btn ub ub-fl umar-b2 uinput" href="javascript:;" Onclick="baoming();"><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1 tx-cf" type="button" name="" value="下一步"></a>      
         
		<input type="hidden" value="{$member.score}"  id="score" />
        <input type="hidden" value="{$course.price}"  id="price" />
		<input type="hidden" value="{$course.id}"  id="product_id" />
		<input type="hidden" value="{$course.score}"  id="course_score" />
		<input type="hidden" value="{$course.title}"  id="title" />
    </div>
    <!-- /上课报名-->
</div>
<!-- /c -->
 <template file="Content/footer.php"/> 
</body>
<script type="text/javascript" src="/statics/default/js/jquery.js"></script>
<script type="text/javascript">
 function baoming()
 {
	var truename=$("#truename").val();
	var mobile=$("#mobile").val();
	//姓名验证
        if(truename==''){
            alert('请输入您的姓名');
            return false;
        }

        var regtel = /^1[34578]{1}\d{9}$/;
        //手机号验证
        if(mobile==''){
            alert('请输入手机号');
            return false;
        }else if(!regtel.test(mobile)){
            alert('请输入正确的手机号');
            return false;
        }

	var data = new Object();
	if($("#pay_type").val()=='3')    
	{
		data['pay_type'] = 3; //特权支付
	}
	/*else if(parseInt($("#score").val())>=parseInt($("#price").val())){
		data['pay_type'] = 2; //积分支付
	}else{
		data['pay_type'] = 1; //在线支付
	}*/
	
	data['product_type'] = 1;
	
	data['price'] = parseInt($("#price").val());
	data['score'] = parseInt($("#course_score").val());
	data['product_id'] = $("#product_id").val();
	data['product_name'] = $("#title").val();
	
	data['truename'] = $("#truename").val(); 
	data['mobile'] = $("#mobile").val(); 
	
	var url = '/index.php?m=Order&a=addorder';
	$.post(url, data, function (r){
		if(r.code=='0')
		{
		   if(data['pay_type']=='3')   //特权支付直接跳转到支付成功页面
		   {
			   //window.location.href='/index.php/Content/WeixinPay/pay.html?order_num='+r.order_num;
			    window.location.href='/index.php/Content/WeixinPay/pay_success.html?order_num='+r.order_num;
		   }else{
			    window.location.href='/index.php/Content/WeixinPay/confirm_order.html?order_num='+r.order_num;
		   }	
		}else if(r.code=='2'){
					alert("该课程您已经报过名了，请勿重复操作！");return;
				}else{
			alert("提交失败！");return;
		}
		
			
		   
	},'json');
	return;
 }
 
 
 

</script>
</html>