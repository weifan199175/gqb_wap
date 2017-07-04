<!DOCTYPE html>
<html lang="en">

<head>
    <title>诊断结果页</title>
    <meta charset="UTF-8">
    <!--     <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"> -->
    <meta http-equiv=”X-UA-Compatible” content=”IE=edge,chrome=1″/>
    <script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
    <script src="http://g.tbcdn.cn/mtb/lib-flexible/0.3.4/??flexible_css.js,flexible.js"></script>
    <script type="text/javascript" src="/statics/default/js/fastclick.min.js"></script>
    <script src="https://cdn.bootcss.com/velocity/1.5.0/velocity.min.js"></script>
<!--    <script src="/statics/default/js/diagnosisSuccess.min.js"></script>-->
    <link rel="stylesheet" href="/statics/default/css/public.css">
    <link rel="stylesheet" href="/statics/default/css/ui-box.css">
    <link rel="stylesheet" href="/statics/default/css/ui-base.css">
    <link rel="stylesheet" href="/statics/default/css/ui-color.css">
    <link rel="stylesheet" href="/statics/default/css/appcan.control.css">
    <link rel="stylesheet" href="/statics/default/css/iconfont/iconfont.css">
    <link rel="stylesheet" href="/statics/default/css/index.css">
    <link rel="stylesheet" href="/statics/zc/css/reset.min.css">
    <link rel="stylesheet" href="/statics/zc/css/common.min.css">
    <link rel="stylesheet" href="/statics/default/css/resultPage.min.css?v=1">
</head>
<script>
$(function() {
    FastClick.attach(document.body);
})
</script>

<body>
    <!-- 成功页面 -->
    <div class="resultPage">
        <p class="resultTxt">您的企业股权架构评分为：</p>
        <div class="resBg">
            <img src="/statics/default/images/resBg.png" alt="">
            <div class="resultNum">
                <div class="diamondsDiv">
                    <i class="myiconfont diamonds">&#xe646;</i>
                </div>
                <div class="resNum"><span>{$dia_res["score"]}</span>分</div>
           
       </div>
        
       
    
    <div class="starDiv"><i class="myiconfont star">&#xe6cb;</i>
                <div class="lev"> <span></span>  星级</div>
            </div>
       
       
        

       
        </div>
        <div class="tip1"></div>
        <div class="tip2">最高星级是7星级，最高分数为100分</div>
        <div class="kind"></div>
        <div class="people">
            <div class="peoplePic">
                <img src="/statics/default/images/biaoqing4.png" alt="">
            </div>
            <div class="peoples">
                
            </div>
        </div>         
		<div class="fxBtn">
		   <a href="/index.php/content/diacrisisTool/diacrisisTool">我也要玩</a>
		</div>
		<div class="rewardBtn">
		   <a href="/index.php" >了解股权帮</a>
		</div>
        
        </div>
<input type='hidden' value='{$dia_res["id"]}' id='id'>
<input type='hidden' value='{$invitation_code}' id='invtitation_code'>
</body>
<!--微信分享-->
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>  
<script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script> 
<script type="text/javascript">
var H=$(window).height();
var W=$(window).width();
$(".resultPage").width(W);
$(".resultPage").css('minHeight',H+'px');

// 显示结果
var n = {$dia_res.star};
var kinds = [
              "义薄云天之水泊梁山",
              "甩手掌柜的太平天国",
              "投资人控股下的中苏合资",
              "朕即天下的北宋王朝",
              "包罗万象的蒋家王朝",
              "画饼期权的大汉高祖",
              "同心同德的西蜀汉邦"
            ];
            
var tip1 = [
            "您公司的股权架构仅仅击败了13%的企业",
            "您公司的股权架构仅仅击败了24.5%的企业",
            "您公司的股权架构仅仅击败了37.3%的企业",
            "您公司的股权架构勉强超过了51%的企业",
            "您公司的股权架构成功战胜了63%企业",
            "您公司的股权架构已超越75%的企业",
            "您公司的股权架构凌驾于90%的企业以上",
        ]


var res = [
         "恭喜您!<br/>坐拥20亿元资产，您的财富堪比冯仑！",
        "恭喜您!<br/>您是坐拥100亿元财富资产的成功商人，您将是下一个梁光伟！",
        "恭喜您!<br/>您是坐拥300亿元财富资产的商业大亨，王石跟您谈笑风生！",
        "恭喜您!<br/>您是坐拥500亿元财富的商业巨头，任正非跟您比不过尔尔！",
        "恭喜您!<br/>您将是坐拥1000亿元财富的商业龙头，周鸿祎都在遥望您的背影！",
        "恭喜您!<br/>您将是坐拥2000亿元财富的商业领袖，您将与王健林比肩！",
        "恭喜您!<br/>您将是坐拥2200亿元财富的商业传奇，中国下一个马云、雷军就是您！",
    ]


    $(".resultPage .peoples").html(res[n - 1]);
    $(".resultPage .kind").html(kinds[n - 1]);
    $(".resultPage .tip1").html(tip1[n - 1]);
    $(".resultPage .lev span").html(n);

$(".loginBg").on("click", function() {
        $(this).hide();
        $(".login").hide();
    });
    $(".closeBtn").click(function(){
        $(".cover,.fxDiv").hide();
    });
    $(".cancel").click(function() {
        $(".cover,.check").hide();
    });
</script>
</html>