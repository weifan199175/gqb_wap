<!DOCTYPE html>
<html lang="en">

<head>
    <title>提交成功页</title>
    <meta charset="UTF-8">
    <!--     <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"> -->
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
    <link rel="stylesheet" href="/statics/default/css/askSuccess.min.css">
</head>
<script>
$(function() {
    FastClick.attach(document.body);
})
</script>

<body>
    <!-- 提交问题 -->
    <div class="askSuccess">
        <div class="computer">
        	<img src="/statics/default/images/computer.png" alt="">
        </div>
         <div class="gx">
            恭喜你，提交成功
        </div>
        <p class="wait">请您耐心等待</p>
        <p class="txt"></p>
        <div class="btn btn1">
            <a href=""></a>
        </div>
        <div class="btn btn2">
            <a href=""></a>
        </div>
        <div class="copyright">
            伯格联合（北京）科技有限公司
        </div>
    </div>
    <script>
    var links = [
        "/index.php/content/diacrisisTool/free_ask?id={$id}",
        "/index.php/content/WeixinPay/EquityOrder.html?id={$id}",
        "/index.php"
    ];
    var txt = [
        "我们将会在三个工作日内,将您所需要的模板文件发送到您指定的邮箱，请注意查收",
        "我们的工作人员会在三个工作日内与你联系"
    ];
    var btn1 = [
        "我有问题想免费咨询",
        "返回你的报告"
    ];
    var btn2 = [
        "返回你的报告",
        "了解股权帮"
    ];
    var n = {$type};
    $(".askSuccess .txt").text(txt[n - 1]);
    $(".btn1 a").text(btn1[n - 1]);
    $(".btn2 a").text(btn2[n - 1]);

    if (n == 1) {
        $(".btn1 a").attr('href', links[0]);
        $(".btn2 a").attr('href', links[1]);
    }else if(n==2){
        $(".btn1 a").attr('href', links[1]);
        $(".btn2 a").attr('href', links[2]);
    }


    var H = $(window).height();
    var W = $(window).width();
    $(".askSuccess").height(H);
    $(".askSuccess").width(W);
    </script>
</body>

</html>
