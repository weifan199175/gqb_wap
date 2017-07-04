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
<!-- 临时重写页面颜色为蓝色-S -->
<style>
.btn button {
    min-height: 2.2em;
    border: none;
    box-shadow: none;
    color: #fff;
    outline: none;
    background: #20C1E0;
    text-align: center;
    vertical-align: middle;
}
.lrBox .iconfont {
    color: #20C1E0;
}

<!-- 临时重写页面颜色为蓝色-E -->
</style>
<body class="um-vp">
<!-- c -->
<div class="cBox">
    <!-- 注册 完善资料 -->
    <form action="" method="post">
    <div class="ub ub-ver lrBox">
        <div class="lgPic ub ub-pc ub-ac uinn"><img src="/statics/default/images/logo1.png" alt=""></div>
        <h5 class="ub ub-ac- ub-pc uinn ulev2">完善资料</h5>
        <ul class="rgInfo ub-f1 uinn umar-b2">
            <li class="ub ub-f1 ub-ac ubb uinn">
                <label class="ub umar-r" for="">公司名称</label>
                <div class="ub ub-f1 uinput"><input onblur="setCookie('company',this.value);" class="ub ub-f1 tx-r ulev-3" type="text" name="company" id="company" value="{$company}" placeholder="请输入您的公司"></div>
                <span class="ub iconfont"></span> 
            </li>
            <li class="ub ub-f1 ub-ac ubb uinn">
                <label class="ub umar-r" for="">您的职位</label>
                <div class="ub ub-f1 uinput"><a class="ub ub-f1 ub-ac ub-pc" href="/index.php?m=User&a=position_choose&position={$_GET['position']}&industry={$_GET['industry']}&province_name={$_GET['province_name']}&city_name={$_GET['city_name']}"><input class="ub-f1 tx-r ulev-3" type="text" name="position" id="position" value="{$_GET['position']}" placeholder="请选择" readonly="readonly"></a></div>
                <span class="ub iconfont icon-jiantou"></span>
            </li>  
            <!-- <li class="ub ub-f1 ub-ac ubb uinn">
                <label class="ub umar-r" for="">您的行业</label>
                <div class="ub ub-f1 uinput"><a class="ub ub-f1 ub-ac ub-pc" href="/index.php?m=User&a=industry_choose&position={$_GET['position']}&industry={$_GET['industry']}&province_name={$_GET['province_name']}&city_name={$_GET['city_name']}&company={$_COOKIE['company']}"><input class="ub-f1 tx-r ulev-3" type="text" name="industry" id="industry" value="{$_GET['industry']}" placeholder="请选择" readonly="readonly"></a></div>
                <span class="ub iconfont icon-jiantou"></span>            
            </li> -->
            <!-- <li class="ub ub-f1 ub-ac ubb uinn">
                <a class="ub ub-ac ub-pc" href="/index.php?m=User&a=area_choose&position={$_GET['position']}&industry={$_GET['industry']}&province_name={$_GET['province_name']}&city_name={$_GET['city_name']}&company={$_COOKIE['company']}">
                <label class="ub umar-r tx-c2" for="">所在地区</label>
                <div class="ub ub-f1 uinput"><input class="ub-f1 tx-r ulev-3" type="text" name="province_name" id="province_name" value="{$_GET['province_name']}" placeholder="请选择" readonly="readonly"><input class="ub-f1 tx-r ulev-3" type="text" name="city_name" id="city_name" value="{$_GET['city_name']}" placeholder="" readonly="readonly"></div>
                <span class="ub iconfont icon-jiantou"></span>
                </a>         
            </li> -->
            <!-- <li class="ub ub-ver ub-f1 ubb uinn">
                <label class="ub umar-r" for="">请选择您加入股权帮的原因</label>
                <div class="radioBox ub ub-ver uinn5 umar-t">
                    <div class="radioList ub">
                        <div class="ub ub-ac radiobox">
                            <input class="" type="checkbox" name="reason[]" id="r1" value="学习股权知识" >
                        </div>
                        <div class="reasn ub ub-f1 ub-ac">学习股权知识</div>
                    </div>
                    <div class="radioList ub">                        
                        <div class="ub ub-ac radiobox">
                            <input class="" type="checkbox" name="reason[]" id="r2" value="投融资" >
                        </div>
                        <div class="reasn ub ub-f1 ub-ac">投融资</div>
                    </div>
                    <div class="radioList ub">
                        <div class="ub ub-ac radiobox">
                            <input class="" type="checkbox" name="reason[]" id="r3" value="寻找合伙人" >
                        </div>
                        <div class="reasn ub ub-f1 ub-ac">寻找合伙人</div>
                    </div>
                    <div class="radioList ub">
                        <div class="ub ub-ac radiobox">
                            <input class="" type="checkbox" name="reason[]" id="r4" value="共享资源" >
                        </div>
                        <div class="reasn ub ub-f1 ub-ac">共享资源</div>
                    </div>
                </div>   
            </li> -->
			<!--邀请码-->
			<input type="hidden" name="invitation_code" id="invitation_code" value="{$member['invitation_code']}" />
			<!--注册来源-->
			<input type="hidden" name="source" id="source" value="{$member['source']}" />
        </ul>
        <div class="reading umar-a tx-c4"><span class="tx-red iconfont icon-xinghao"></span>提交即默认同意相关服务条款<a href="{:getCategory(21,'url')}">阅读详情</a></div>
        <a class="btn ub ub-ac ub-pc ub-fl umar-b2 uinput" id="submit" href="javascript:void(0);"><button class="ulev-3 uc-a1" style="display:block; width:94%;" >完成</button></a>        
    </div>
    </form>
    <!-- /注册 完善资料-->
</div>
<!-- /c -->
    <!--邀请码-->
    
    <!-- 页脚 -->
    
        <template file="Content/footer.php"/> 
     
    <!-- /页脚 -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/statics/default/js/base.js"></script>
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
    function checkcookie(){
        if(getCookie('company') != '' && getCookie('company') != undefined){
            $('#company').val(getCookie('company'));
        }
    }
    function delCookie(name){  
                    var exp = new Date();  
                    exp.setTime(exp.getTime() - 1);  
                    var cval=getCookie(name);  
                    if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();  
                }

    $(function(){
    checkcookie();
    
    //提交验证
    $('#submit').click(function(){
		var company = $("#company").val();
		var position = $("#position").val();
		var industry = $(industry).val();
		var province_name = $(province_name).val();
		var city_name = $(city_name).val();
		
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
        
        var data = $("form").serialize();


        $.post('/index.php?m=User&a=userperfect_information',data , function(r){
            if(r.code==0){
                if(r.url != null && r.url != undefined){
                    window.location.href=r.url;
                }else {
                    window.location.href='/index.php?m=User&a=reg_success';
                }
                $('#company').val(delCookie('company'));
            }else if(r.code==1){
                alert('数据有误');
                return false;
            }else if(r.code==2){
                alert('您已经完善过资料了，请勿重复操作！');
                return false;
            }
        },'json');
        
        return false;
    })
})
</script>

</html>