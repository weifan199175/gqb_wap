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
    <title>股权帮个人中心 社员注册</title>
</head>
<style>
.lrBox .btn input {
    padding-top: 0.6em;
    padding-bottom: 0.6em;
    background: #20C1E0;
    color: #fff;
}

.ybtn {
    width: 7em;
    height: 2.6em;
    background: #20C1E0;
    color: #fff;
}

.lrBox .iconfont {
    color: #999;
}
</style>
<body class="um-vp">
<!-- c -->
<div class="cBox">
    <!-- 注册 -->
    <div class="ub ub-ver lrBox">
		<div class="lrTOP ub ub-ac uinn5">
            <div class="phto ub ub-ac umar-r">
            <img <if condition="!empty($u_i_m)">src="{$u_i_m['userimg']}"</if> alt="">
            </div>
            <div class="name ub ub-ver">
                <div class="nm ub umar-b ulev0">
                <if condition="isset($u_i_m['nickname']) AND !empty($u_i_m['nickname'])">
                {$u_i_m['nickname']}<span class="ub umar-l iconfont icon-ren"></span>
                </if>
                </div>
                <div class="address ub ulev-1"><if condition="!empty($u_i_m)">{$u_i_m['province_name']}{$u_i_m['city_name']}</if></div>
            </div>
        </div>
       
            <h5 class="ub ub-ac- ub-pc uinn ulev2">注册</h5>
             <form action="" method="post" id="regform">
             <!--邀请码-->
            <input type="hidden" name="invitation_code" id="invitation_code" value="{$u_i_m['invitation_code']}" />
            <input type="hidden" name="fenbu_code" id="fenbu_code" value="{$fenbu_code}" />
            <!--注册来源-->
            <input type="hidden" name="source" id="source" value="{$source}" />
   
            <ul class="ub-f1 uinn umar-b2">
                <li class="ub ub-f1 ub-ac ubb uinn">
                    <label class="ub umar-r ulev1 iconfont icon-ren" for=""></label>
                    <div class="ub ub-f1 uinput"><input class="ub-f1 ulev-3" type="text" name="truename" id="truename" placeholder="请输入您的姓名"></div>
                </li>
                <li class="ub ub-f1 ub-ac ubb uinn">
                    <label class="ub umar-r ulev1 iconfont icon-shouji" for=""></label>
                    <div class="ub ub-f1 uinput"><input class="ub-f1 ulev-3" type="tel" value="{$dia_mobile}" name="mobile" id="mobile" placeholder="请输入您的手机号"></div>
                </li>  
                <li class="ub ub-f1 ub-ac ubb uinn">
                    <label class="ub umar-r ulev1 iconfont icon-mima" for=""></label>
                    <div class="ub ub-f1 uinput"><input class="ub-f1 ulev-3" type="password" name="password" id="password" placeholder="请输入密码"></div>                
                </li>

                <li class="ub ub-f1 ub-ac ubb uinn">
                    <label class="ub umar-r ulev1 iconfont icon-susheyaochiguanli" for=""></label>
                    <div class="ub ub-f1 uinput">
                        <input id="phoneVerify" class="ub-f1 ulev-3" type="tel" name="reg" placeholder="请输入验证码">
                       </div>
                    <div class="ybtn ub umar-l nav-btn uc-a3 ulev-1"><a href="javascript:;" class="yzm" id="yzm" onclick="sendMessage();">获取</a></div>                
                </li>
            </ul>
            </form>
            <a class="btn ub ub-fl umar-b2 uinput" id="submit" >
                <input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1" type="button" value="下一步">
            </a>
       
        <div class="lgother ub ub-f1 ub-pc uinn">
            <a class="ulev0" href="/index.php?m=User&a=login">已有账号登录</a>            
        </div>
    </div>
    <!-- /注册 -->
</div>
<!-- /c -->
    <!-- 页脚 -->
    
        <template file="Content/footer.php"/> 
     
    <!-- /页脚 -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
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

function sendMessage(){
    //获取验证码
    var mobile = $('#mobile').val();
    var regtel = /^1[34578]{1}\d{9}$/;
    if(mobile==''){
        alert('请填写手机号');
        return false;
    }else if(!regtel.test(mobile)){
            alert('请输入正确的手机号');
            return false;
    }else{
        var url = '/index.php?m=User&a=regcode';
        $.post(url, {'mobile':mobile}, function (r){
            if(r==0){
                //点击后跳转读秒
                numRoll();
                alert('验证码已发送至您的手机，请注意查收！');
            }else if(r==1){
                alert('该手机号已经注册过，不可再次注册！');
            }   
        },'json');
    }
}

$(function(){
    //提交验证
    $('#submit').click(function(){
        var truename = $('#truename').val();
        var mobile = $('#mobile').val();
        var password = $('#password').val();
        var yzm = $('#phoneVerify').val();
        var openId=$('#openId').val();
        var nickname=$('#nickname').val();
        var userimg=$('#userimg').val();
        var invitation_code=$('#invitation_code').val();//个人邀请码
        var fenbu_code=$('#fenbu_code').val();//分部邀请码
		var source=$('#source').val();//注册来源
        
        //姓名验证
        if(truename==''){
            alert('请输入您的姓名');
            return false;
        }else if(mobile==''){
            //手机号验证
            alert('请输入手机号');
            return false;
        }else if(!checkMobile(mobile)){
            alert('请输入正确的手机号');
            return false;
        }else if(password==''){
            alert('请输入密码');
            return false;
        }else if(password.length<6||password.length>24){
            alert('请输入6-24位数字或字母的密码');
            return false;
        }else if(yzm==''){
            alert('请输入验证码');
            return false;
        }else{
            var data = new Object();
            data['truename'] = truename;
            data['mobile'] = mobile;
            data['password'] = password;
            data['yzm'] = yzm;
            data['invitation_code']=invitation_code;
            data['fenbu_code']=fenbu_code;
            data['source']=source;
            $.post('/index.php?m=User&a=userreg',data, function(msg){
                if(msg.error==0){
                    alert(msg.info);
                    window.location.href='/index.php?m=User&a=perfect_information';
                    // window.location.href='/index.php?m=User&a=perfect_information&invitation_code='+invitation_code+'&source='+source;
                }else{
                    alert(msg.info);
                    return false;
                }
               
            },'json');
        }
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