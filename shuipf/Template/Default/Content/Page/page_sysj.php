<!DOCTYPE html>
<html lang="en">
<head>
    <title>铁杆社员专题页</title>
    <meta charset="utf-8">
<!--     <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"> -->
    <meta http-equiv=”X-UA-Compatible” content=”IE=edge,chrome=1″/>
    <script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
    <script src="http://g.tbcdn.cn/mtb/lib-flexible/0.3.4/??flexible_css.js,flexible.js"></script>
    <script type="text/javascript" src="/statics/default/js/fastclick.min.js"></script>
    <script src="https://cdn.bootcss.com/velocity/1.5.0/velocity.min.js"></script>
    <link rel="stylesheet" href="/statics/default/css/public.css">
    <link rel="stylesheet" href="/statics/default/css/ui-box.css">
    <link rel="stylesheet" href="/statics/default/css/ui-base.css">
    <link rel="stylesheet" href="/statics/default/css/ui-color.css">
    <link rel="stylesheet" href="/statics/default/css/appcan.control.css">
    <link rel="stylesheet" href="/statics/default/css/iconfont/iconfont.css">
    <link rel="stylesheet" href="/statics/default/css/index.css">   
    <link rel="stylesheet" href="/statics/zc/css/reset.min.css">
    <link rel="stylesheet" href="/statics/zc/css/common.min.css">
    <link rel="stylesheet" href="/statics/default/css/ironfans.min.css">
</head>
<script>
$(function() {
    FastClick.attach(document.body);
})
</script>

<body>
    <div class="banner">
        <img src="/statics/default/images/ironFansBanner.jpg" alt="">
    </div>
    <div class="title">
        授课嘉宾
    </div>
    <div class="courseBanner">
        <img src="/statics/default/images/ironfansTeacher.jpg" alt="">
    </div>
    <div class="title">
        精品课程
    </div>
    <ul class="course">
        <li>
            <a href="#">
                <div class="coursePic">
                    <img src="/statics/default/images/ironfans1.png" alt="">
                </div>
                <div class="courseInfo">
                    <div class="courseTitle">《迭代创业》</div>
                    <div class="courseDes">
                        非连续性商业环境已经成为常态,未来只有创业的公司,没有成功的公司。
                    </div>
                </div>
            </a>
        </li>
        <li>
            <a href="#">
                <div class="coursePic">
                    <img src="/statics/default/images/ironfans2.png" alt="">
                </div>
                <div class="courseInfo">
                    <div class="courseTitle">《产品战略》</div>
                    <div class="courseDes">
                        市场应该是以“产品如何满足目标客户的需求”为定义。
                    </div>
                </div>
            </a>
        </li>
        <li>
            <a href="#">
                <div class="coursePic">
                    <img src="/statics/default/images/ironfans3.png" alt="">
                </div>
                <div class="courseInfo">
                    <div class="courseTitle">《股权架构设计·方案班》</div>
                    <div class="courseDes">
                        如何实现移动互联时代的组织变革?如何设计细分市场NO.1的股权架构?
                    </div>
                </div>
            </a>
        </li>
        <li>
            <a href="#">
                <div class="coursePic">
                    <img src="/statics/default/images/ironfans4.png" alt="">
                </div>
                <div class="courseInfo">
                    <div class="courseTitle">《互联网营销》</div>
                    <div class="courseDes">
                        互联网时代,没有成功的企业,只有创业公司。
                    </div>
                </div>
            </a>
        </li>
    </ul>
    <div class="title">
        社员特权服务
    </div>
    <div class="courseBanner">
        <img src="/statics/default/images/ironfansRule.jpg" alt="">
    </div>
    <div class="title">
        加入股权帮，让股权成为无边界资产
    </div>
    <div class="courseBanner">
        <img src="/statics/default/images/ironfansPic.jpg" alt="">
    </div>
    <!-- foote开始 -->
    <div class="footer ubt ubb-d">
        <div class="ftNav ub">
            <a class="current ub ub-ver ub-ac ub-pc tx-c4" href="/index.php">
                <em class="gqblogo ub"></em>
                <span class="ub">首页</span>
            </a>
            <!--<a class="ub ub-ver ub-ac ub-pc tx-c4" href="#">
                <em class="gqblogo ub"></em>
                <span class="ub">股权帮</span>
            </a>-->
            <a class=" ub ub-ver ub-ac ub-pc tx-c4" href="/index.php?m=User&amp;a=index">
                <em class="ub iconfont icon-ren"></em>
                <span class="ub">我的</span>
            </a>
            <a class=" ub ub-ver ub-ac ub-pc tx-c4" href="/index.php?a=lists&amp;catid=8">
                <em class="ub iconfont icon-bangzhuzhongxin"></em>
                <span class="ub">帮助中心</span>
            </a>
        </div>
    </div>

<script type="text/javascript">
$(".files li").click(function() {
    var sts = $(this).find('.filePic').attr("sts");
    if (sts == 0) {
        $(this).find(".thisFile").show();
        $(this).find(".filePic").addClass('fileShadow');
        $(this).find('.filePic').attr("sts", 1);
    } else if (sts == 1) {
        $(this).find(".thisFile").hide();
        $(this).find(".filePic").removeClass('fileShadow');
        $(this).find('.filePic').attr("sts", 0);
    }


});

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
    //alert(product_type);return;
    if(memberid=='')
    {
        $(".PopUp").animate({opacity:"show"},300);
        $(".fullbg").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"block"});
        
        $("#t2").click(function(){
            window.location.href='/index.php?m=User&a=login';
        })
        
    }else if(memberclass=='1'){
        alert("请完善资料后再升级社员！");
        window.location.href='/index.php?m=User&a=perfect_information';
    }else if(memberclass=='3'&&product_type=='16'){
        alert("您已经是铁杆社员了");
        return false;
    }else if(memberclass=='4'&&product_type=='16'){
        alert("您已经是铁杆社员了");
        return false;
    }else{

        //生成订单
        var data = new Object();

        if(product_type=='15'){
            data['price'] = 30000;
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
</body>
</html>