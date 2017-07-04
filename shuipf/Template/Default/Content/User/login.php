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
    <title>股权帮个人中心 社员登录</title>
</head>
<style>
.lrBox .iconfont {
    color: #999;
}

.lrBox .btn input {
    padding-top: 0.6em;
    padding-bottom: 0.6em;
    background: #20C1E0;
    color: #fff;
}
</style>
<body class="um-vp">
<!-- c -->
<div class="cBox">
    <!-- 社员登录 -->
    <div class="ub ub-ver lrBox">
        <a class="goIn ub uabs-r uba uc-a3 ulev-1" href="/index.php?m=User&a=rushe">我要入社</a>
        <div class="lgPic ub ub-pc ub-ac uinn"><img src="/statics/default/images/logo1.png" alt=""></div>
        <form action="" method="post">
            <h5 class="ub ub-ac- ub-pc uinn ulev2">社员登录</h5>
            <ul class="ub-f1 uinn umar-b3">
                <li class="ub ub-f1 ub-ac ubb uinn">
                    <label class="ub umar-r ulev1 iconfont icon-shouji" for=""></label>
                    <div class="ub ub-f1 uinput"><input class="ub-f1 ulev-3" type="text" name="mobile" id="mobile" placeholder="请输入您的手机号"></div>
                </li>
                <li class="ub ub-f1 ub-ac ubb uinn">
                    <label class="ub umar-r ulev1 iconfont icon-mima" for=""></label>
                    <div class="ub ub-f1 uinput">
                        <input class="ub-f1 ulev-3" type="password" name="password" id="password" placeholder="请输入密码">
                        <input style="display:none;" type="text" name="openId" id="openId" value="{$_GET['openId']}" >
                        <input style="display:none;" type="text" name="nickname" id="nickname" value="{$_GET['nickname']}" >
                        <input style="display:none;" type="text" name="userimg" id="userimg" value="{$_GET['userimg']}" >
                    </div>                
                </li>
                
            </ul>
            <a class="btn ub ub-fl umar-b uinput" href=""><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1" type="button" name="" id="submit" value="登录"></a>
        </form>
        <div class="lgother ub ub-f1 uinn">
            <div class="ub-f1 tx-l"><a class="ulev-1" href="/index.php?m=User&a=reg">立即注册</a></div>
            <div class="ub-f1 tx-r"><a class="ulev-1" href="/index.php?m=User&a=find_password1">忘记密码</a></div>
        </div>
    </div>
    <!-- /社员登录 -->
</div>
<!-- /c -->
    <!-- foote开始 -->
    <template file="Content/new_footer.php"/>
</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
    $(function(){
    $('#submit').click(function(){
        var data = new Object();
        data['mobile'] = $('#mobile').val();
        data['password'] = $('#password').val();
       /* data['openId']=$('#openId').val();
        data['nickname']=$('#nickname').val();
        data['userimg']=$('#userimg').val();*/
        //alert(data);exit;
        $.post('/index.php?m=User&a=userlogin',data , function(result){
            if(result.code==0){
                var url = result.url;
               if(url != null && url != undefined){
                	window.location.href= url ;
               }else{
//                     window.history.go(-1);
                   window.location.href="/index.php?m=User&a=index";
               }
                return true;
            }else if(result.code==1){
                alert('手机号错误');
                return false;
            }else if(result.code==2){
                alert('密码错误');
                return false;
            }else if(result.code==3){
                alert('该账号已被锁定,不允许登录');
                return false;
            }
        },'json');
        return false;
    })
})   
</script>

</html>