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
    <link rel="stylesheet" href="/statics/default/css/center.css">
    <title>股权帮个人中心 注册-完善资料</title>
</head>
<body class="um-vp">
<!-- c -->
<div class="cBox">
    <!-- 注册 完善资料 -->
    <form action="" method="post">
    <div class="ub ub-ver lrBox">
        <div class="lgPic ub ub-pc ub-ac uinn"><img src="/statics/default/images/register.jpg" alt=""></div>
        <h5 class="ub ub-ac- ub-pc uinn ulev2">完善资料</h5>
        <ul class="rgInfo ub-f1 uinn umar-b2">
            <li class="ub ub-f1 ub-ac ubb uinn">
                <label class="ub umar-r" for="">公司名称</label>
                <div class="ub ub-f1 uinput"><input class="ub ub-f1 tx-r ulev-3" type="text" name="company" id="company" value="" placeholder="请输入您的公司"></div>
                <span class="ub iconfont"></span> 

            </li>
            <li class="ub ub-f1 ub-ac ubb uinn">
                <label class="ub umar-r" for="">您的职位</label>
                <div class="ub ub-f1 uinput"><a class="ub ub-f1 ub-ac ub-pc" href="/index.php?m=User&a=position_choose&position={$_GET['position']}&industry={$_GET['industry']}&province_name={$_GET['province_name']}&city_name={$_GET['city_name']}"><input class="ub-f1 tx-r ulev-3" type="text" name="position" id="position" value="{$_GET['position']}" placeholder="请选择"></a></div>
                <span class="ub iconfont icon-jiantou"></span>
            </li>  
            <li class="ub ub-f1 ub-ac ubb uinn">
                <label class="ub umar-r" for="">您的行业</label>
                <div class="ub ub-f1 uinput"><a class="ub ub-f1 ub-ac ub-pc" href="/index.php?m=User&a=industry_choose&position={$_GET['position']}&industry={$_GET['industry']}&province_name={$_GET['province_name']}&city_name={$_GET['city_name']}&company={$_COOKIE['company']}"><input class="ub-f1 tx-r ulev-3" type="text" name="industry" id="industry" value="{$_GET['industry']}" placeholder="请选择"></a></div>
                <span class="ub iconfont icon-jiantou"></span>            
            </li>
            <li class="ub ub-f1 ub-ac ubb uinn">
                <a class="ub ub-ac ub-pc" href="/index.php?m=User&a=area_choose&position={$_GET['position']}&industry={$_GET['industry']}&province_name={$_GET['province_name']}&city_name={$_GET['city_name']}&company={$_COOKIE['company']}">
                <label class="ub umar-r tx-c2" for="">所在地区</label>
                <div class="ub ub-f1 uinput"><input class="ub-f1 tx-r ulev-3" type="text" name="province_name" id="province_name" value="{$_GET['province_name']}" placeholder="请选择"><input class="ub-f1 tx-r ulev-3" type="text" name="city_name" id="city_name" value="{$_GET['city_name']}" placeholder=""></div>
                <span class="ub iconfont icon-jiantou"></span>
                </a>         
            </li>
            <li class="ub ub-ver ub-f1 ubb uinn">
                <label class="ub umar-r" for="">请选择您加入股权帮的原因</label>
                <div class="radioBox ub ub-ver uinn5 umar-t">
                    <div class="radioList ub">
                        <div class="ub ub-ac radiobox">
                            <input class="" type="checkbox" name="reason" id="reason" value="学习股权知识" >
                        </div>
                        <div class="reasn ub ub-f1 ub-ac">学习股权知识</div>
                    </div>
                    <div class="radioList ub">                        
                        <div class="ub ub-ac radiobox">
                            <input class="" type="checkbox" name="reason" id="reason" value="投融资" >
                        </div>
                        <div class="reasn ub ub-f1 ub-ac">投融资</div>
                    </div>
                    <div class="radioList ub">
                        <div class="ub ub-ac radiobox">
                            <input class="" type="checkbox" name="reason" id="reason" value="寻找合伙人" >
                        </div>
                        <div class="reasn ub ub-f1 ub-ac">寻找合伙人</div>
                    </div>
                    <div class="radioList ub">
                        <div class="ub ub-ac radiobox">
                            <input class="" type="checkbox" name="reason" id="reason" value="共享资源" >
                        </div>
                        <div class="reasn ub ub-f1 ub-ac">共享资源</div>
                    </div>
                </div>
                   
            </li>
        </ul>
        <div class="reading umar-a tx-c4"><span class="tx-red iconfont icon-xinghao"></span>提交即默认同意相关服务条款<a href="#">阅读详情</a></div>
        <a class="btn ub ub-fl umar-b2 uinput" href=""><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1" type="submit" id="submit" name="" value="完成"></a>        
    </div>
    </form>
    <!-- /注册 完善资料-->
</div>
<!-- /c -->
    <!--邀请码-->
    <input type="hidden" name="invitation_code" id="invitation_code" value="{$_GET['invitation_code']}" />
    <!-- 页脚 -->
    
        <template file="Content/footer.php"/> 
     
    <!-- /页脚 -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/statics/default/js/base.js"></script>
<script type="text/javascript">
    $('#company').keyup(function(){
        //alert($(this).val());
        var company=$(this).val();
        if (document.cookie != "") {  
        setcookie("company", company);  
        }  
        //alert(getcookie("company"));
        
    })

    $(function(){

    //cookie获取公司名称
    $("#company").val(getcookie("company"));
    
    //提交验证
    $('#submit').click(function(){
        var company = $('#company').val();
        var position = $('#position').val();
        var industry = $('#industry').val();
        var province_name = $('#province_name').val();
        var city_name=$('#city_name').val();
        var reason=$('#reason').val();
        var invitation_code=$('#invitation_code').val();//邀请码
        
        //公司
        if(company==''){
            alert('请输入公司名称');
            return false;
        }
        //职位
        if(position==''){
            alert('请选择职位');
            return false;
        }
        
        //行业
        if(industry==''){
            alert('请选择行业');
            return false;
        }
        
        //地区
        if(province_name==''||city_name==''){
            alert('请选择地区');
            return false;
        }
        
        var data = new Object();
        data['company'] = company;
        data['position'] = position;
        data['industry'] = industry;
        data['province_name'] = province_name;
        data['city_name']=city_name;
        data['reason']=reason;
        data['invitation_code']=invitation_code;

        $.post('/index.php?m=User&a=userperfect_information',data , function(r){
            if(r==0){
                window.location.href='/index.php?m=User&a=reg_success';
            }else if(r==1){
                alert('数据有误');
                return false;
            }
        },'json');
        
        return false;
    })
})
</script>

</html>