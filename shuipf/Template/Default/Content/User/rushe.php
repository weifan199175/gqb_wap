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
    <title>股权帮个人中心 我的-我要入社</title>
</head>
<body class="um-vp" style="background: #f4f4f4;">
<!-- c -->
<div class="cBox"> 
    <!-- 我的-我要入社 -->
    <form action="" method="post">
        <div class="ub ub-ver joinBox">
            <div class="join ub ub-pc ub-ac uinn bgc"><img src="/statics/default/images/logo3.png" alt=""></div>
            <h5 class="title ub ub-ac- ub-pc uinn bgc">加入股权帮</h5>
            <ul class="joinChose ub-f1 bgc">
                <li class="ub ubb ubt ubb-d uinn5">
                    请选择入社方式        
                </li>
                <li class="sychose chose ub ub-ver ubb ubb-d">
                    <!--
					<div class="sychoseList ub ub-f1 uinn5 umar-a ubb ubb-d">
                        <div class="ub ub-f1">铁杆社员<i>（年费制1万元/人）</i></div>
                        <div class="ub radiobox">
                            <input type="radio" name="mc" id="mc" value="3" />
                        </div>
                    </div>
					-->
                    <div class="sychoseList ub ub-f1 uinn5 umar-a ubb ubb-d">
                        <div class="ub ub-f1">铁杆社员<i>（一年制3万元/人）</i></div>
                        <div class="ub radiobox">
                            <input type="radio" checked name="mc" id="mc" value="4" />
                        </div>
                    </div>
                </li>  
                <li class="sumM ub ubb ub-ac uinn ubb ubb-d">
                    <div class="tit ub uinn tx-c2">支付总金额</div>
                    <div class="number ub ub-f1 ub-pe tx-red">
                       <!-- <input class="input_01" type="text" name="price" id="price" value="¥10000元" readonly="readonly">
					   -->
                        <input class="input_02" checked type="text" name="price" id="price" value="¥30000元" readonly="readonly">
                    </div>        
                </li>            
            </ul>
			<!--
            <ul class="joinChose ub-f1 bgc">
                <li class="ub ubb ubt ubb-d uinn5">
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
            <div class="reading umar-a tx-c4"><span class="tx-red iconfont icon-xinghao"></span>提交即默认同意相关服务条款<a href="{:getCategory(25,'url')}">阅读详情</a></div>-->
            <a class="btn ub ub-fl umar-b2 uinput" href="javascript:;"><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1 tx-cf" type="button" id="submit" name="" value="提交"></a>        
        </div>
		
    </form>
    <!-- /我的-我要入社-->
</div>
<!-- /c -->
    <!-- 页脚 -->
    
        <template file="Content/footer.php"/> 
     
    <!-- /页脚 -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery.js"></script>
<script type="text/javascript">
    $(function(){
    $(".sychose .sychoseList").click(function(){
        var _index = $(this).index();
        var postCnt = $(this).parent().next(".sumM").find("input");       
        postCnt.hide();
        postCnt.eq(_index).show();
    });
}); 
</script>

<script type="text/javascript">   

    $(function(){
    //提交验证
    $('#submit').click(function(){
		//alert(111);
        //var member_id='<?php echo $_SESSION['userid'];?>';
		var member_class='<?php echo $_SESSION['member_class'];?>';
        var mc = $('input:radio[name="mc"]:checked').val();
		//alert(mc);
        var price = $('#price').val();
        //alert(price);exit;
        //var pay_type = $('input:radio[name="pay_type"]:checked').val();
        
        //alert(member_class);
       if(member_class=='4'&&mc=="4"){
            alert("您已经是铁杆社员了");
            return false;
        }else if(member_class=='4'&&mc=="3"){
            alert("您已经是铁杆社员了");
            return false;
        }else if(member_class=='1'){
            alert("请您先完善资料再升级");
            window.location.href='/index.php?m=User&a=perfect_information';
        }
		//console.info(member_class + ':' + price);
		//return false;
        //生成订单
        var data = new Object();

        if(mc=='3'){
            data['price'] = 30000;
            data['product_type']=15;
        }else if(mc=='4'){
            data['price'] = 30000;
            data['product_type']=16;
        }

        //data['member_id']=member_id;
        // data['pay_type'] = pay_type;

        var url = '/index.php?m=Order&a=addorder';
        $.post(url, data, function (r){
            if(r.code=='0')
            {

                window.location.href='/index.php/Content/WeixinPay/confirm_order.html?order_num='+r.order_num;
        
            }else{
                alert("提交失败！");return;
            }
            
                
               
        },'json');
        
        return false;
    })


})
</script>
</html>