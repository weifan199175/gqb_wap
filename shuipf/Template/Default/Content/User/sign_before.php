<!DOCTYPE html>
<html class="um landscape min-width-240px min-width-320px min-width-480px min-width-768px min-width-1024px">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <!-- 新 Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">

<!-- 可选的Bootstrap主题文件（一般不用引入） -->
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">

<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/statics/default/css/public.css">
    <link rel="stylesheet" href="/statics/default/css/ui-box.css">
    <link rel="stylesheet" href="/statics/default/css/ui-base.css">
    <link rel="stylesheet" href="/statics/default/css/ui-color.css">
    <link rel="stylesheet" href="/statics/default/css/appcan.control.css">
    <link rel="stylesheet" href="/statics/default/css/iconfont/iconfont.css">
    <link rel="stylesheet" href="/statics/default/css/center.css">
    <title>股权帮个人中心 签到（签到前）</title>
</head>
<body class="um-vp" style="background: #fff;">
<!-- c --> 
<div class="cBox">
    <!-- 签到 签到前 -->
    <div class="pastBox">
        <div class="past ub ub-ver">
            <div class="time ub ub-f1 ubb ubb-d uinn5 tx-c4">签到日期：<i id="show"><?php echo date('Y-m-d',time());?></i></div>
            <if condition="!isset($r)||empty($r)">
                <div class="pastClick ub ub-ac ub-pc ub-ver">
                    <div class="pastBG ub ub-ac ub-pc"><a href="javascript:void(0);" onclick="sign()" >签到</a></div>
                    <input type="hidden" name="member_id" id="member_id" value="{$_SESSION['userid']}">
                    <div class="tips ub ub-ac ub-pc tx-c8">立即签到获取积分！</div>
                </div>
            <else />
                <div class="pastClick ub ub-ac ub-pc ub-ver">
                <div class="pastBG pastBG2 ub ub-ac ub-pc">已签到</div>
                <div class="tips ub ub-ac ub-pc tx-c8">您今天已成功签到!</div>
                </div>
            </if>
            <div class="timeScore ub uinn">
                <div class="tm ub ub-f1 uba ubb-d ub-ac ub-pc umar-r"><span class="tx-cblu iconfont icon-rili"></span><em>签到天数：<i>{$counts}</i></em></div>
                <div class="score ub ub-f1 uba ubb-d ub-ac ub-pc umar-l"><span class="tx-cog2 iconfont icon-jifen2"></span><em>累计积分：<i>{$total_scores}</i></em></div>
            </div>
            <div class="pTips">
                <span class="xhIcon tx-red iconfont icon-xinghao"></span>
                <em class="tx-red">每天签到一次可获取{$sign_score.get_score}积分</em>
                <span class="jfIcon tx-cog2 iconfont icon-jifen"></span>
            </div>
        </div>
    </div>
    <!-- /签到前 -->
</div>
<div class="banner"style="width: 100%;text-align: center;margin-top: 0.8em">
    <img class="img-responsive" src="statics/default/images/qiandao.jpg" alt="" />
</div>
<!-- /c -->
    <!-- 页脚 -->
    
        <template file="Content/footer.php"/> 
     
    <!-- /页脚 -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/statics/default/js/base.js"></script>

<script type="text/javascript">
    function sign(){
        //alert(111);exit;
        var member_id = $('#member_id').val();
        var url = '/index.php?m=User&a=usersign';
        var data = new Object();
        data['member_id'] = member_id;
        $.post(url, data, function (r){
        if(r==0){
            alert('签到成功');
            window.location.reload();
        }else if(r==1){
            alert('今日已经签到');
        }else if(r==2){
            alert('参数错误');
        }else if(r==3){
            alert('签到失败');
        }   
    },'json');
    }    
</script>

</html>