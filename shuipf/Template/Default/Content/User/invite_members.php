<!DOCTYPE html>
<html class="um landscape min-width-240px min-width-320px min-width-480px min-width-768px min-width-1024px">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="/statics/default/css/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="/statics/default/css/express-area.css">
    <link rel="stylesheet" href="/statics/default/css/public.css">
    <link rel="stylesheet" href="/statics/default/css/ui-box.css">
    <link rel="stylesheet" href="/statics/default/css/ui-base.css">
    <link rel="stylesheet" href="/statics/default/css/ui-color.css">
    <link rel="stylesheet" href="/statics/default/css/appcan.control.css">
    <link rel="stylesheet" href="/statics/default/css/iconfont/iconfont.css">
    <link rel="stylesheet" href="/statics/default/css/center.css">
    <title>股权帮个人中心 我的-邀请社员</title>
</head>
<body class="um-vp" style="background: #fff;">
<!-- c -->
<div class="cBox"> 
    <!-- 我的-邀请社员 -->
    <form action="" method="post">
        <div class="ub ub-ver invitedBox">
            <div class="invitPhto ub ub-pc ub-ac"><img <if condition="$_SESSION['userimg'] eq ''">src="/statics/default/images/phto.jpg"<else />src=""</if> alt="$_SESSION['userimg']"></div>
            <div class="inviName ub ub-ac ub-pc tx-c4">我是{$_SESSION['nickname']}</div>
            <h5 class="invtitle ub ub-ac- ub-pc tx-c2">这里是股权学习的最佳平台</h5>
            <p class="invtt ub ub-ac- ub-pc tx-c2">成为我的社员</p>
            <div class="invitLogo ub ub-pc ub-ac"><img src="/statics/default/images/logo3.png" alt=""></div>
            <ul class="invitInput ub-f1">           
                <li class="ipt ub">
                    <div class="ub ub-f1 uba ubb-d uinput">
                        <input class="ub" type="text" name="truename" id="truename" value="" placeholder="请输入您的姓名">
                    </div>               
                </li>
                <li class="ipt ub">
                    <div class="ub ub-f1 uba ubb-d uinput">
                        <input class="ub" type="text" name="mobile" id="mobile" value="" placeholder="请输入您的手机号">
                    </div>               
                </li>
                <li class="ipt ub">
                    <div class="ub ub-f1 uba ubb-d uinput">
                        <input class="ub" type="password" name="password" id="password" value="" placeholder="请输入密码">
                    </div>               
                </li>
                <li class="yzm ipt ub">
                    <div class="ub ub-f1 ub-ac uba ubb-d uinput">
                        <input class="ub ub-f1 umar-l" type="text" name="reg" id="phoneVerify" value="" placeholder="请输入验证码">
                        <div class="inYzm ub ub-ac ub-pc uba uc-a3 tx-cgn umar-l umar-r"><a href="javascript:;" class="yzm" id="yzm" onclick="sendMessage();">获取</a></div>
                    </div>               
                </li>                       
            </ul>    
            
            <a class="btn ub ub-fl umar-b2 uinput" href=""><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1 tx-cf" type="submit" id="submit" name="" value="成为社员"></a>  
            <a class="invRules ub ub-ac ub-pc tx-c4 uinn" href="#">社员规则</a>      
        </div>
    </form>
    <!-- /我的-邀请社员-->
</div>
<!-- /c -->
<!-- 页脚 -->
    
        <template file="Content/footer.php"/> 
     
    <!-- /页脚 -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery.js"></script>

<script type="text/javascript">
    //读秒
var timer = 60;
function numRoll(){
    
    if(timer <= 0){
        $('.inYzm').css('background-color','#AAA').attr('onclick','sendMessage();').text("重新发送");
        timer   =   60;
    }else if(timer > 0){
        timer--;
        $('.inYzm').css('background-color','#AAA').attr('onclick','').text("("+timer+")已发送");
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

    //点击后跳转读秒
    numRoll();
    
    var url = '/index.php?m=User&a=regcode';
    var data = new Object();
    data['mobile'] = mobile;
    data['chachong'] = 1;
    
    $.post(url, data, function (r){
        if(r==0){
            alert('验证码已发送至您的手机，请注意查收！');
        }else if(r==1){
            alert('该手机号已经注册过，不可再次注册！');
        }   
    },'json');
    //60秒倒计时
    }

    $(function(){
    //提交验证
    $('#submit').click(function(){
        var truename = $('#truename').val();
        var mobile = $('#mobile').val();
        var password = $('#password').val();
        var yzm = $('#phoneVerify').val();
        //var openId=$('#openId').val();
        //var nickname=$('#nickname').val();
        //var userimg=$('#userimg').val();
        
        //姓名验证
        if(truename==''){
            alert('请输入您的姓名');
            return false;
        }
        //手机号验证
        if(mobile==''){
            alert('请输入手机号');
            return false;
        }else if(!checkMobile(mobile)){
            alert('请输入正确的手机号');
            return false;
        }
        
        //密码验证
        if(password==''){
            alert('请输入密码');
            return false;
        }else if(password.length<6||password.length>24){
            alert('请输入6-24位数字或字母的密码');
            return false;
        }
        
        //验证码验证
        if(yzm==''){
            alert('请输入验证码');
            return false;
        }
        
        var data = new Object();
        data['truename'] = truename;
        data['mobile'] = mobile;
        data['password'] = password;
        data['yzm'] = yzm;
        //data['openId']=openId;
        //data['nickname']=nickname;
        //data['userimg']=userimg;

        $.post('/index.php?m=User&a=userinvite_members',data , function(r){
            if(r==0){
                window.location.href='/index.php?m=User&a=perfect_information';
            }else if(r==1){
                alert('验证码错误');
                return false;
            }else if(r==2){
                alert('该号码已被注册');
                return false;
            }
        },'json');
        
        return false;
    })

    //手机验证
function checkMobile( s ){   
 var regu =/^1[34578]{1}\d{9}$/; 
  var re = new RegExp(regu); 
     if (re.test(s)) { 
          return true; 
         }else{ 
           return false; 
        } 
}

})
</script>

</html>