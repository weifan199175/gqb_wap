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
    <title>股权帮个人中心 找回密码-设置新密码</title>
</head>
<body class="um-vp">
<!-- c -->
<div class="cBox">
    <!-- 找回密码 -->
    <div class="ub ub-ver getBkPasswod">
        <form action="" method="post">
            <ul class="ub-f1">
                <li class="ub ub-f1 ub-ac ubb uinn">
                    <label class="ub umar-r" for="">新密码</label>
                    <div class="ub ub-f1 uinput"><input class="ub-f1 ulev-3" type="password" name="password" id="password" placeholder="请输入新密码"></div>
                </li>
                <li class="ub ub-f1 ub-ac ubb uinn">
                    <label class="ub umar-r" for="">确认新密码</label>
                    <div class="ub ub-f1 uinput"><input class="ub-f1 ulev-3" type="password" name="password" id="password2" placeholder="请确认新密码"></div>                
                </li>
            </ul>  
            <a class="btn ub ub-fl uinput" href=""><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1" type="submit" id="submit" name="" value="确认修改"></a>
        </form>
    </div>
    <!-- /找回密码 -->
</div>
<!-- /c -->
    <!-- 页脚 -->
    
        <template file="Content/footer.php"/> 
     
    <!-- /页脚 -->

</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
    $(function(){
    //提交验证
    $('#submit').click(function(){
        
        var password = $('#password').val();
        var password2 = $('#password2').val();
        //密码验证
        if(password==''){
            alert('请输入新密码');
            return false;
        }else if(password.length<6||password.length>24){

            alert('6-24位数字或字母的密码');
            return false;
        }
        
        if(password2==''){
            alert('请确认密码');
            return false;
        }else if(password!=password2){
            alert('两次输入密码不一致，请重新输入。');
            return false;
        }
        
        var data = new Object();
        data['password'] = password;
        $.post('/index.php?m=User&a=find_pass2',data , function(r){
            if(r==0){
                window.location.href='/index.php?m=User&a=find_password3';
                return false;
            }else if(r==1){
                alert('设置失败');
                return false;
            }
        },'json');
        
        return false;
    })
    
})    
</script>

</html>