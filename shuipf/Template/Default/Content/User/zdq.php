<!DOCTYPE html>
<html lang="en">

<head>
    <title>我的诊断结果</title>
    <meta charset="UTF-8">
    <!--     <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"> -->
    <meta http-equiv=”X-UA-Compatible” content=”IE=edge,chrome=1″/>
    <script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
    <script src="http://g.tbcdn.cn/mtb/lib-flexible/0.3.4/??flexible_css.js,flexible.js"></script>
    <script type="text/javascript" src="/statics/regSuccess/fastclick.min.js"></script>
    <script src="https://cdn.bootcss.com/velocity/1.5.0/velocity.min.js"></script>
    <link rel="stylesheet" href="/statics/zdq/css/public.css">
    <link rel="stylesheet" href="/statics/zdq/css/ui-box.css">
    <link rel="stylesheet" href="/statics/zdq/css/ui-base.css">
    <link rel="stylesheet" href="/statics/zdq/css/ui-color.css">
    <link rel="stylesheet" href="/statics/zdq/css/appcan.control.css">
    <link rel="stylesheet" href="/statics/zdq/css/iconfont/iconfont.css">
    <link rel="stylesheet" href="/statics/zdq/css/index.css">
    <link rel="stylesheet" href="/statics/zdq/css/reset.min.css">
    <link rel="stylesheet" href="/statics/zdq/css/common.min.css">
    <link rel="stylesheet" href="/statics/zdq/css/diagnosisList.min.css">
    
</head>
<script>
$(function() {
    FastClick.attach(document.body);
})
</script>

<body>
    <ul class="diagnosisList">
    <?php foreach ($data as $k=>$d){?>
        <li>
            <div class="listTop">
                <div class="projectTitle">
                <?php echo $d['project']?>
                </div>
                <div class="score">得分:<span><?php echo $d['score']?></span></div>
            </div>
            <ul class="starts">
            <?php for ($i=0;$i<$d['star'];$i++) {?>
                <li>
                    <i class="myiconfont successStar">&#xe6b9;</i>
                </li>
            <?php }?>
            <?php for ($i=0;$i<7-$d['star'];$i++) {?>
                <li>
                    <i class="myiconfont">&#xe6b9;</i>
                </li>
            <?php }?>
            </ul>
            <div class="time"><?php echo date("Y-m-d H:i",$d['datetime'])?></div>
            <div class="look">
                <a href="index.php/Content/WeixinPay/EquityOrder?id=<?php echo $d['id']?>">查看结果</a>
            </div>
        </li>
    <?php }?>
    </ul>
    <!-- foote开始 -->
    <template file="Content/new_footer.php"/>
</body>

</html>
