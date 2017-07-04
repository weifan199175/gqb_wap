<!DOCTYPE html>
<html class="um landscape min-width-240px min-width-320px min-width-480px min-width-768px min-width-1024px">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="/statics/default/css/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="/statics/default/css/express-area.css">
    <link rel="stylesheet" href="/statics/default/css/public.css">
    <link rel="stylesheet" href="/statics/default/css/ui-box.css">
    <link rel="stylesheet" href="/statics/default/css/ui-base.css">
    <link rel="stylesheet" href="/statics/default/css/ui-color.css">
    <link rel="stylesheet" href="/statics/default/css/appcan.control.css">
    <link rel="stylesheet" href="/statics/default/css/iconfont/iconfont.css">
    <link rel="stylesheet" href="/statics/default/css/center.css">
    <title>股权帮个人中心 我的-合伙社员申请</title>
</head>
<body class="um-vp" style="background: #f4f4f4;">
<!-- c -->
<div class="cBox"> 
    <!-- 我的-合伙社员申请 -->
    <form action="" method="post">
        <div class="ub ub-ver myApplyBox">
            <div class="myApply ub ub-pc ub-ac uinn bgc"><img src="/statics/default/images/logo4.png" alt=""></div>
            <h5 class="title ub ub-ac ub-pc uinn bgc tx-c2">股权帮合伙社员入社费用</h5>
            <div class="price ub ub-ac ub-pc tx-red bgc">¥ 30000元</div>
            <ul class="joinChose ub-f1 bgc">
                <li class="ub ubb ubb-d uinn5">
                    请选择支付方式        
                </li>
                <li class="chose ub ub-ver ubb ubb-d">
                    <div class="ub ub-f1 uinn5 ub-ac ubb ubb-d">
                        <div class="ub zfImg"><img src="/statics/default/images/zf1.png" alt=""></div>
                        <div class="con ub ub-ver ub-f1">
                            <h5 class="ub uof tx-c4">微信支付</h5>
                            <span class="ub tx-c8">推荐安装微信5.0及以上版本的使用</span>
                        </div>
                        <div class="ub radiobox">
                            <input type="radio" name="pay_type" id="pay_type" value="微信支付" />
                        </div>
                    </div>
                    <div class="ub ub-f1 uinn5 ub-ac ubb ubb-d">
                        <div class="ub zfImg"><img src="/statics/default/images/zf2.png" alt=""></div>
                        <div class="con ub ub-ver ub-f1">
                            <h5 class="ub uof tx-c4">银联支付</h5>
                            <span class="ub tx-c8">支持工行、建行、农行、招行等银行大额支付</span>
                        </div>
                        <div class="ub radiobox">
                            <input type="radio" name="pay_type" id="pay_type" value="银行卡" />
                        </div>
                    </div>
                    <div class="ub ub-f1 uinn5 ub-ac">
                        <div class="ub zfImg"><img src="/statics/default/images/zf3.png" alt=""></div>
                        <div class="con ub ub-ver ub-f1">
                            <h5 class="ub uof tx-c4">支付宝支付</h5>
                            <span class="ub tx-c8">推荐有支付宝账号用户使用</span>
                        </div>
                        <div class="ub radiobox">
                            <input type="radio" name="pay_type" id="pay_type" value="支付宝" />
                        </div>
                    </div>
                </li>
            </ul>
            <div class="reading umar-a tx-c4"><span class="tx-red iconfont icon-xinghao"></span>提交即默认同意相关服务条款<a href="">阅读详情</a></div>
            <a class="btn ub ub-fl umar-b2 uinput" href=""><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1 tx-cf" type="submit" id="submit" name="" value="完成"></a>        
        </div>
    </form>
    <!-- /我的-合伙社员申请-->
</div>
<!-- /c -->
<!-- 页脚 -->
    
        <template file="Content/footer.php"/> 
     
    <!-- /页脚 -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery.js"></script>
<script type="text/javascript">
    $(function(){
    //提交验证
    $('#submit').click(function(){
        var pay_type = $('input:radio[name="pay_type"]:checked').val();

        //支付方式
        if(pay_type==null){
            alert('请选择支付方式');
            return false;
        }
        
        
        var data = new Object();
        data['pay_type'] = pay_type;

        $.post('/index.php?m=User&a=userhhsy',data , function(r){
            if(r==0){
                alert('提交成功,请您去明细中查看处理结果');
                return false;
            }else if(r==1){
                alert('提交失败');
                return false;
            }else if(r==2){
                alert('您已经是合伙社员了');
                return false;
            }
        },'json');
        
        return false;
    })


})
</script>
</html>