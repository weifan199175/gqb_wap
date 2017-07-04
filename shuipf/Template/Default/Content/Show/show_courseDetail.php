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
    <link rel="stylesheet" href="/statics/default/css/swiper.min.css">
    <link rel="stylesheet" href="/statics/default/css/index.css">
    <title>课程列表</title>
</head>
<body style="background-color: #f4f4f4;">

    <!-- 课程详情 -->
    <div class="BclassBox">    
        <h5 class="title ub ub-ac ub-pc">{$title}</h5>
        <div class="con uinn">
            {$content}
        </div>     
    </div>
    <!-- /课程详情 -->

    <!-- 页脚 -->
    <div class="ftBtFixed ubt ubb-d">
        <a class="btn ub uinn" href="tel:{:cache('Config.tel_1')}">
            <div class="callbtn ub ub-f1 ub-ac ub-pc tx-cf uc-a3 uinn7 bg-red ulev0">
                <span class="iconfont icon-dianhua"></span>
                电话咨询
            </div>
        </a>
    </div>
        
        <template file="Content/footer.php"/>
     
    <!-- /页脚 -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/statics/default/js/swiper.min.js"></script>

<script type="text/javascript">
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true
    });
</script>

</html>