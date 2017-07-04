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
    <title>股权帮个人中心 找回密码-设置验证手机号</title>
</head>
<body class="um-vp">
<!-- c -->
<div class="cBox">
    <!-- 找回密码-验证手机号 -->
    <div class="ub ub-ver getBkPasswod">
        <form action="" method="post">
            <ul class="ub-f1">
                <li class="ub ub-f1 ub-ac ubb uinn">
                    <label class="ub" for="">手机号</label>
                    <div class="ub ub-f1 uinput"><input class="ub-f1 ulev-3" type="text" name="mobile" id="mobile" placeholder="请输入您的手机号"></div>
                </li>
                <li class="ub ub-f1 ub-ac ubb uinn">
                    <label class="ub" for="">验证码</label>
                    <div class="ub ub-f1 uinput"><input class="ub-f1 ulev-3" type="text" id="yzmhq" name="" placeholder="请输入验证码"></div>  
                    <div class="ybtn ub umar-l nav-btn uc-a3 ulev-1"><a href="javascript:;" class="yzm" id="yzm" onclick="sendMessage();">获取验证码</a></div>              
                </li>
            </ul>  
            <a class="btn ub ub-fl uinput" href=""><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1" type="submit" id="submit" value="下一步" name=""></a>
        </form>
    </div>
    <!-- /找回密码-验证手机号 -->
</div>
<!-- /c -->
    <!-- 页脚 -->
    
        <template file="Content/footer.php"/> 
     
    <!-- /页脚 -->

</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
<script>
//读秒
var timer = 60;
function numRoll(){
    
    if(timer <= 0){
        $('.ybtn').css('background-color','#e60012;').attr('onclick','sendMessage();').text("重新发送");
        timer   =   60;
    }else if(timer > 0){
        timer--;
        $('.ybtn').css('background-color','#AAA').attr('onclick','').text("("+timer+")已发送");
        setTimeout("numRoll()",1000);
    }
}

function sendMessage(){
    //获取验证码
    var mobile = $('#mobile').val();
    var regtel = /^1[34578]{1}\d{9}$/;
    if(!mobile){
        alert('请填写手机号');
        return false;
    }else if(!regtel.test(mobile)){
            alert('请输入正确的手机号');
            return false;
    }

    var url = '/index.php?m=User&a=find_pass_code';
    var data = new Object();
    data['mobile'] = mobile;
    $.post(url, data, function (r){
        if(r.code==0){
			//点击后跳转读秒
			numRoll();
            alert('验证码已发送至您的手机，请注意查收！');    
        }else{
			alert(r.msg); 
		}    
    },'json');
    }
    
$(function(){
    //提交验证
    $('#submit').click(function(){
        var mobile = $('#mobile').val();
        var yzm = $('#yzmhq').val();
        
        //手机号验证
        if(mobile==''){
            alert('请输入手机号');
            return false;
        }
        
        //验证码验证
        if(yzm==''){
            alert('请输入验证码');
            return false;
        }
        
        var data = new Object();
        data['yzm'] = yzm;
        data['mobile'] = mobile;
        $.post('/index.php?m=User&a=find_pass1',data , function(r){
            if(r==0){
                window.location.href='/index.php?m=User&a=find_password2';
            }else if(r==1){
                alert('验证码错误');
            }else if(r==2){
                alert('手机号错误');
            }
        },'json');
        
        return false;
    })
    
})  
</script>

</html>