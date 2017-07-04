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
    <!-- <link rel="stylesheet" href="/statics/default/css/jquery.mobile-1.4.5.css"> -->
    <link rel="stylesheet" href="/statics/default/css/center.css">    
    <title>股权帮个人中心 完善资料-选择行业</title>
</head>
<body class="um-vp">
<!-- c -->
<div class="cBox">
    <!-- 选择行业 --> 
        <div class="industryBox ub ub-ver">
            <ul class="industry ub ub-ver">
                <volist name="data" id="vo">
                    <li class="ub ub-ver">
                        <div class="mainindus ub ubb ubb-d">                    
                            <div class="ub ub-f1 ub-pc ub-ac ulev0 uinn5 tx-c2">{$vo.industry_name}</div>
                            <em class="ub ub-ac ub-pc tx-a umar-r ulev1 iconfont icon-jiantoushang icon-jiantoushang-copy"></em>
                        </div>
                        
                        <div class="subindus ub-ver ubb ubb-d bg-f4">
                            <volist name="vo[sub]" id="v">                   
                                <a class="ub ub-pc ub-ac ulev0 uinn5 tx-c2" href="javascript:;">{$v.industry_name}</a>
                            </volist>    
                        </div>
                    </li>
                </volist>    
            </ul> 
            <!--<a onclick="tiaozhuan()" class="btn ub ub-fl umar-b2 uinput" href="javascript:void(0);"><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1 tx-cf" type="button" name="" value="确认"></a>-->
        </div>
    <!-- /选择行业 -->
</div>
        <input type="hidden" name="company" id="company" value="{$_GET['company']}">
        <input type="hidden" name="industry" id="industry" value="{$_GET['industry']}">
        <input type="hidden" name="position" id="position" value="{$_GET['position']}">
        <input type="hidden" name="province_name" id="province_name" value="{$_GET['province_name']}">
        <input type="hidden" name="city_name" id="city_name" value="{$_GET['city_name']}">
<!-- /c -->
<!-- 页脚 -->
    <div class="ftBtFixed ubt ubb-d">
        <a class="btn ub uinn" href="javascript:void(0);"  onclick="tiaozhuan()">
            <div class="callbtn ub ub-f1 ub-ac ub-pc tx-cf uc-a3 uinn7 bg-red ulev0">
                完成
            </div>
        </a>
    </div>
    <template file="Content/footer.php"/> 
     
    <!-- /页脚 -->
</body>
<script  src="/statics/default/js/jquery-1.8.3.min.js"></script>
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
        setCookie('industry', $('#industry').val());
        window.location.href='/index.php?m=User&a=information';
        //console.info(getCookie('company'));
    }
}

    $(function () {
        $(".subindus").hide();
        $(".industryBox ul li").click(function(){
            var thisSpan=$(this);
            $(".industryBox ul li .mainindus").find("em").removeClass("icon-jiantoushang-copy");
            $(".subindus", this).prev(".mainindus").find("em").addClass("icon-jiantoushang-copy");
            $(this).children(".subindus").slideDown("fast");
            $(this).siblings().children(".subindus").slideUp("fast");
        })
    });

    // 
    $(function(){
      $(".industry li .subindus a").click(function(){
        $(this).addClass("cur").siblings().removeClass("cur");
      });
    })

    $(function(){

        $(".subindus .cur").live('click',function() {
            
            var text = $(this).text();
            //alert(text);exit;
            $("#industry").val(text);

        });

    });
</script>


</html>