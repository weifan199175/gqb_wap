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
    <title>股权帮个人中心 社员服务-铁杆社员详情</title>
</head>
<body class="um-vp" style="background: #f4f4f4;">
<!--头部-->
<div class="ub ub-ac header">
    <a href="#" class="ub ub-ac headerLeft"><em class="iconfont icon-jiantouzuo"></em></a>
    <div class="ub ub-pc ub-f1 headerMid"><span>社员服务</span></div>
    <a href="#" class="ub ub-ac headerRig"><em class="iconfont icon-6"></em></a>
</div>
<!--头部-->
<!-- c -->
<div class="sBox"> 
    <!-- 社员服务 -->
    <div class="ub ub-ver memberBox">
        <!-- title -->
        <div class="sTitle mar-b7 ub ub-ver bgc">
            <div class="ub ubb ubb-d uof">
                <div class="list ub ub-ac ub-pc ubr ubb-d ub-f1"><span class="stt1 ub"></span><em>上课报名</em></div>
                <div class="list ub ub-ac ub-pc ubr ubb-d ub-f1"><span class="stt2 ub"></span><em>股权博弈</em></div>
                <div class="list ub ub-ac ub-pc ub-f1"><span class="stt3 ub"></span><em>新物种进化营</em></div>
            </div>
            <div class="ub ubb ubb-d uof">
                <div class="list ub ub-ac ub-pc ubr ubb-d ub-f1"><span class="stt4 ub"></span><em>铁杆社员</em></div>
                <div class="list current ub ub-ac ub-pc ubr ubb-d ub-f1"><span class="stt5 ub"></span><em>合伙社员</em></div>
                <div class="list ub ub-ac ub-pc ub-f1"><span class="stt6 ub"></span><em>股权咨询</em></div>
            </div>
        </div>
        <!-- /title -->
        <div class="menber ub ub-ver bgc">
            <h5 class="ub">{$title}</h5>
            <div class="con ub">
                <p>
                    {$content}
                </p>
            </div>
        </div>                          
    </div>
    <!-- /社员服务-->
    <!-- 页脚 -->
    <div class="footer">
        <a class="btn ub ubt ubb ubb-d uinn" href="javascript:void(0);" onclick="join()">
            <div class="callbtn ub ub-f1 ub-ac ub-pc tx-cf uc-a3 uinn7 bg-red ulev0">                
                申请加入
            </div>
        </a>
        <div class="ftNav ub">
            <a class="current ub ub-ver ub-ac ub-pc tx-c4" href="#">
                <em class="ub iconfont icon-htmal5icon06"></em>
                <span class="ub">主页</span>
            </a>
            <a class="ub ub-ver ub-ac ub-pc tx-c4" href="#">
                <em class="gqblogo ub"></em>
                <span class="ub">股权帮</span>
            </a>
            <a class="ub ub-ver ub-ac ub-pc tx-c4" href="#">
                <em class="ub iconfont icon-ren"></em>
                <span class="ub">我的</span>
            </a>
            <a class="ub ub-ver ub-ac ub-pc tx-c4" href="#">
                <em class="ub iconfont icon-bangzhuzhongxin"></em>
                <span class="ub">帮助中心</span>
            </a>
        </div> 
    </div>     
    <!-- /页脚 -->
</div>
<!-- /c -->
<!--弹出层-->
<div class="PopUp uc-a3">
    <div class="PopUp_box ub ub-ver ub">
       <div class="contUp ub" id="t1">
            您好！请登录后再申请，谢谢！<!--您好，注册会员，请完成资料后再报名，谢谢！-->
       </div>
       <a class="btn ub uinn" href="javascript:void(0);">
            <div class="callbtn ub ub-f1 ub-ac ub-pc tx-cf uc-a3 uinn7 bg-red ulev0" id="t2">                
                登录<!--完善资料-->
            </div>
        </a>
    </div>
</div>
<!--/弹出层-->

<!-- jQuery 遮罩层 -->
<div class="fullbg"></div>
<!-- end jQuery 遮罩层 -->

</body>
<script type="text/javascript" src="/statics/default/js/jquery.js"></script>
<script type="text/javascript" src="/statics/default/js/swiper.min.js"></script>

<script src="/statics/default/js/ff.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){  

    $(".fullbg").click(function(){
        $(".PopUp").animate({opacity:"hide"},100);
        $(".fullbg").hide();
    });
});

//铁杆社员申请
function join()
{
    //alert(111);return;
    var product_id='<?php echo $id;?>';
    var product_type='<?php echo $catid;?>';
    //alert(product_type);exit;
    var memberid = '<?php echo $_SESSION['userid']; ?>';
    var memberclass = '<?php echo $_SESSION['member_class']; ?>';
    
    if(memberid=='')
    {
        $(".PopUp").animate({opacity:"show"},300);
        $(".fullbg").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"block"});
        
        $("#t2").click(function(){
            window.location.href='/index.php?m=User&a=login';
        })
        
    }else if(memberclass=='3'&&product_type=='15'){
        alert("您已经是铁杆社员了");
        return false;
    }else if(memberclass=='4'&&product_type=='16'){
        alert("您已经是合伙社员了");
        return false;
    }else{

        //生成订单
        var data = new Object();

        if(product_type=='15'){
            data['price'] = 10000;
            data['product_type']=15;
        }else if(product_type=='16'){
            data['price'] = 30000;
            data['product_type']=16;
        }
        
        data['product_id'] = product_id;
        data['memberid'] = memberid; 
        data['mobile'] = $("#mobile").val(); 
        
        var url = '/index.php?m=Order&a=addorder';
        $.post(url, data, function (r){
            if(r.code=='0')
            {

                window.location.href='/index.php/Content/WeixinPay/confirm_order.html?order_num='+r.order_num+"&product_type="+product_type;
        
            }else{
                alert("提交失败！");return;
            }
            
                
               
        },'json');
        return;
    }
    
    
}

</script>
<!-- /弹出层 -->

</html>