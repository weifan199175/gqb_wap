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
    <title>股权帮个人中心 我的-订单详情</title>
</head>
<body class="um-vp" style="background:#f4f4f4;">
<!-- c -->
<div class="cBox" style="background:#f4f4f4;">
    <!-- 订单详情 --> 
    <div class="ub ub-ver orderDtBox">
        <ul class="classList">
            <li class="ub ubb ubb-d uinn bgc">
                <a class="ub ub-f1" href="">
                    <div class="img ub ub-ac uof"><img src="{$res.thumb}" alt=""></div>
                    <div class="con ub ub-f1 ub-ver">
                        <h5 class="ub umar-b tx-c2 uof">{$res.title}</h5>
						<if condition="$res['product_type'] eq 1">
                        <div class="info ub tx-red">
                            <span class="ub ub-ac iconfont icon-boshimao-copy"></span>
                            <em class="ub ub-ac">讲师：<i>{$res.teacher}</i></em>
                        </div> 
                        <div class="info ub">
                            <span class="ub tx-c4 iconfont icon-shijian"></span>
                            <em class="ub ub-ac tx-c8">时间：<i>{$res.start_time|date="m-d",###}</i></em>
                        </div>
                        <div class="info ub">
                            <span class="ub tx-c4 iconfont icon-xiao31"></span>
                            <em class="ub tx-c8 ub-ac">地点：<i>{$res.city}</i></em>
                        </div>
						<else if condition="product_type eq 5" >
						<div class="info2 ub">
                             {$res.description}
                        </div>
						</if>
                        <div class="price ub ub-ac tx-red">
                            <i>¥</i>
                            <span>{$res.price}</span>
                        </div>
                    </div>
                </a>
            </li>            
        </ul>

        <ul class="orderDt bgc">
            <li class="ubb ubb-d tx-c8">订单详情</li>
			<if condition="$res['product_type'] eq 1">
            <li class="ubb ubb-d tx-c4">
                核销码：<i>{$res.verification_code}</i>
            </li>
			</if>
            <li class="ubb ubb-d tx-c4">
                下单时间：<i>{$res.addtime}</i>
            </li>
            <li class="ubb ubb-d tx-c4">
                购买手机号：<i>{$res.mobile}</i>
            </li>
            <!--<li class="ubb ubb-d tx-c4">
                数量：<i>1</i>
            </li>-->
            <li class="ubb ubb-d tx-c4">
                总价：<i>¥{$res.price}</i>
            </li>
        </ul>
        <if condition="$res[for_invoice] eq 1">      
            <a class="go-chose btn ub umar-a uinput ub-ac ub-pc ulev-3 uc-a1 bg-red tx-cf" href="/index.php?m=User&a=invoice&id={$res.id}">索要发票</a>  
        </if>          
    </div>
    <!-- /订单详情 -->
</div>
<!-- /c -->
    <!-- 页脚 -->
    
        <template file="Content/footer.php"/> 
     
    <!-- /页脚 -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">    
</script>

</html>