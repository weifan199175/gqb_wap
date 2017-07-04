<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" /> -->
    <meta http-equiv=”X-UA-Compatible” content=”IE=Edge,chrome=1″>
    <meta charset="utf-8">
    <title>众筹列表</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
    <script src="http://g.tbcdn.cn/mtb/lib-flexible/0.3.4/??flexible_css.js,flexible.js"></script>
    <script src="/statics/zc/js/fundingList.min.js"></script>
    <link rel="stylesheet" href="/statics/zc/css/public.css">
    <link rel="stylesheet" href="/statics/zc/css/ui-box.css">
    <link rel="stylesheet" href="/statics/zc/css/ui-base.css">
    <link rel="stylesheet" href="/statics/zc/css/ui-color.css">
    <link rel="stylesheet" href="/statics/zc/css/appcan.control.css">
    <link rel="stylesheet" href="/statics/zc/css/iconfont/iconfont.css">
    <link rel="stylesheet" href="/statics/zc/css/index.css">
    <link rel="stylesheet" href="/statics/zc/css/common.min.css">
    <link rel="stylesheet" href="/statics/zc/css/fundingList.min.css">
</head>

<body>
    <!-- 列表nav -->
    <ul class="listNav">
        <li class="on">进行中</li>
        <li>成功</li>
        <li>失败</li>
    </ul>
    <!-- 进行中 -->
    <ul class="runningList">
    <?php if(count($data['doing']) != 0){?>
        <?php foreach ($data['doing'] as $k=>$d){?>
            <li>
                <div class="classPic">
                    <img src="<?php echo $d['thumb']?>" alt="">
                    <div class="classSts">进行中</div>
                </div>
                <div class="classRight">
                    <div class="classTitle">
                        <?php echo $d['title']?>
                    </div>
                    <div class="classBar" num="<?php echo $d['price']?>">
                        <div class="inBar" num="<?php echo $d['total_price']?>"></div>
                    </div>
                    <div class="classProgress">
                        <div class="classPercent">完成进度：<?php echo floor($d['total_price']/$d['price']*100)?>%</div>
                        <div class="classMoney">还差：<?php echo $d['price']-$d['total_price']?>元</div>
                    </div>
                    <div class="classBtns">
                        <div class="join">
                            <a href="/index.php?m=Funding&a=share&id=<?php echo $d['id']?>">去众筹</a>
                        </div>
                        <div class="my">
                            <a href="/index.php/Content/WeixinPay/confirm_zcorder.html?funding_id=<?php echo $d['id']?>">自己支持</a>
                        </div>
                    </div>
                </div>
            </li>
        <?php }?>
    <?php }else {?>
    <p>你还没有相关众筹记录</p>
    <?php }?>
    </ul>
    <!-- 已完成 -->
    <ul class="runningList overList">
    <?php if(count($data['done']) != 0){?>
        <?php foreach ($data['done'] as $k=>$d){?>
            <li>
                <div class="classPic">
                    <img src="<?php echo $d['thumb']?>" alt="">
                    <div class="classSts">众筹成功</div>
                </div>
                <div class="classRight">
                    <div class="classTitle">
                        <?php echo $d['title']?>
                    </div>
                    <div class="classBar" num="<?php echo $d['price']?>">
                        <div class="inBar" num="<?php echo $d['total_price']?>"></div>
                    </div>
                    <div class="classProgress">
                        <div class="classPercent">完成进度：100%</div>
                        <div class="classMoney">还差：0元</div>
                    </div>
                </div>
            </li>
        <?php }?>
    <?php }else {?>
    <p>你还没有相关众筹记录</p>
    <?php }?>
    </ul>
    <!-- 已过期 -->
    <ul class="runningList lateList">
    <?php if(count($data['late']) != 0){?>
        <?php foreach ($data['late'] as $k=>$d){?>
            <li>
                <div class="classPic">
                    <img src="<?php echo $d['thumb']?>" alt="">
                    <div class="classSts">众筹失败</div>
                </div>
                <div class="classRight">
                    <div class="classTitle">
                        <?php echo $d['title']?>
                    </div>
                    <div class="classBar" num="<?php echo $d['price']?>">
                        <div class="inBar" num="<?php echo $d['total_price']?>"></div>
                    </div>
                    <div class="classProgress">
                        <div class="classPercent">完成进度：<?php echo floor($d['total_price']/$d['price']*100)?>%</div>
                        <div class="classMoney">还差：<?php echo $d['price']-$d['total_price']?>元</div>
                    </div>
                </div>
            </li>
        <?php }?>
    <?php }else {?>
    <p>你还没有相关众筹记录</p>
    <?php }?>
    </ul>
    <!-- foote开始 -->
    <template file="Content/new_footer.php"/>
</body>

</html>
