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
    <link rel="stylesheet" href="/statics/default/css/center.css">
    <title>股权帮个人中心 我的钱包-我的钱包</title>
</head>
<body class="um-vp" style="background:#f4f4f4;">
<!-- c --> 
<div class="cBox" style="background:#f4f4f4;">
    <!-- 总收入 -->
    <div class="ub ub-ver incommeBox">
        <div class="title ub">
            <a href="#" class="ub ub-ac Left"><em class="iconfont icon-jiantouzuo"></em></a>
            <div class="ub ub-ac ub-pc ub-f1 Mid"><span>我的钱包</span></div>
            <div class="ub zdbt"><a class="tx-c2" href="/index.php?m=User&a=Present_detail" id="">账单</a></div>
        </div>
        <div class="allIncomme umar-b0 ub ub-ver">
            <div class="tit ub ub-ac ub-pc tx-cf">总收入</div>
            <div class="number ub ub-ac ub-pc tx-cf">
                <em>{$purse}</em><i>元</i>
            </div>
        </div>
        <div class="incomeClass bgc">
            <div class="conif ub ub-pc ub-ac ubb ubb-d">
                <div class="list ub ub-ver ub-pc ub-ac ubr ubb-d">
                    <em class="ub tx-c4">总收入</em>
                    <span class="ub tx-red">{$purse}</span>
                </div>
                <!--<div class="list ub ub-ver ub-pc ub-ac ubr ubb-d">
                    <em class="ub tx-c4">预期收入</em>
                    <span class="ub tx-red">4800</span>
                </div>-->
                <div class="list ub ub-ver ub-pc ub-ac">
                    <em class="ub tx-c4">可提现金额</em>
                    <span class="ub tx-red">{$purse}</span>
                </div>
            </div>            
        </div>
        <div class="allready ub uinn5 ubb ubt ubb-d bgc">
            <div class="tt ub tx-c2">已提现金额</div>
            <div class="number ub ub-f1 ub-pe tx-c2"><i>{$num}</i> 元</div>
        </div>
        <a class="go-chose btn ub umar-a uinput ub-ac ub-pc ulev-3 uc-a1 bg-red tx-cf" href="javascript:tixian('{$purse}')">申请提现</a>              
    </div>
    <!-- /总收入 -->
</div>
<!-- /c -->
    <!-- 页脚 -->
    
        <template file="Content/footer.php"/> 
     
    <!-- /页脚 -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
function tixian(money){
	if(money<500){
		alert("可提现金额要大于500才能提现哦~");
	}else {
		window.location.href="/index.php?m=User&a=tixian&purse="+money;
	}
}
</script>

</html>