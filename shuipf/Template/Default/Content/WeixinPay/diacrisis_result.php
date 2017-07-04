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
    <script src="/statics/default/js/diagnosisSuccess.min.js"></script>
    <link rel="stylesheet" href="/statics/default/css/public.css">
    <link rel="stylesheet" href="/statics/default/css/ui-box.css">
    <link rel="stylesheet" href="/statics/default/css/ui-base.css">
    <link rel="stylesheet" href="/statics/default/css/ui-color.css">
    <link rel="stylesheet" href="/statics/default/css/appcan.control.css">
    <link rel="stylesheet" href="/statics/default/css/iconfont/iconfont.css">
    <link rel="stylesheet" href="/statics/default/css/index.css">
    <link rel="stylesheet" href="/statics/zc/css/reset.min.css">
    <link rel="stylesheet" href="/statics/zc/css/common.min.css">
    <link rel="stylesheet" href="/statics/default/css/resultPage2.min.css">
</head>
<script>
    $(function() {
        FastClick.attach(document.body);
    })
</script>

<body>
<!-- 成功页面 -->
 <!-- 详细诊断结果 -->
    <div class="cover"></div>
    <div class="projectTitle">
        <p>{$res.project}</p>
    </div>
    <div class="projectInfo">
        <!-- 评分 -->
        <div class="score">
            <div class="left">股权评分:</div>
            <span>{$res.score}分</span>
        </div>
        <!-- 等级 -->
        <div class="level">
            <div class="left">股权等级:</div>
            <div class="starts">
               {$res.star}星级
            </div>
        </div>
        <!-- 股东信息 -->
        <div class="vip">
            <div class="vipNum">
                <div class="left">股东总共:</div>
                <span>{$res.partner_num}人</span>
            </div>
            <div class="percent">
                <div class="left">股份比例为:</div>
                <ul>
                <volist name='scale' id='v1'>
                    <li>{$v1[0]}为 <span>{$v1[1]}%</span>;</li>
                </volist>
                </ul>
            </div>
            <div class="ceo">
                <div class="left">CEO为:</div>
                <span>{$res.is_ceo}</span>
            </div>
            <div class="boss">
                <div class="left">董事长为:</div>
                <span>{$res.is_direct}</span>
            </div>
            <div class="pool">
                 <?php if($res['is_pool'] == '0'){ ?>
                <div class="left">&nbsp;</div>
                            公司暂时未设高管持股计划
                <?php }else{ ?>
                <div class="left">&nbsp;</div>
                             公司设有高管持股计划
                <?php }　?>             
            </div>
            <div class="vipJob">
                <div class="left">股东:</div>
                <div class="vipName">
                    <?php if($res['is_full_time']!=''){?>
                    <div class="isVip"><span><?php echo $res['is_full_time'] ?></span>为全职股东</div>
                    <?php }else{?>
                    <div class="isVip"></div>
                    <?php }?>
                    <?php if($other_full == ''){?>
                    <div class="noVip"></div>
                    <?php }else{ ?>
                    <div class="noVip"><span>{$other_full}</span>暂时未全职</div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- 优势劣势 -->
        <div class="goodBad">
            <div class="good">
                <div class="title"><img src="/statics/default/images/good.png" alt=""></div>
                <div class="goodTxt txt"></div>
            </div>
            <div class="bad">
                <div class="title"><img src="/statics/default/images/bad.png" alt=""></div>
                <div class="badTxt txt"></div>
            </div>
        </div>
        <!-- 长图 -->
        <div class="longPic">
            <img src="" alt="">
        </div>
        <!-- 按钮 -->
        <div class="btns">
            <div class="askBtn">
                <a href="/index.php/content/diacrisisTool/down_email?id={$res.id}">相关合伙协议模板下载</a>
            </div>
            <div class="payBtn">
                <a href="javascript:void(0)" onclick='buy()'>打赏9.9元学习股权微课一年</a>
            </div>
        </div>
        <div class="bottomCode">
            <img src="/statics/default/images/bottomCode.jpg" alt="">
        </div>
        
        <!-- 支付div -->
        <div class="payDiv">
                <div class="payTitle">
                请选择支付方式
                <img src="/statics/default/images/closePay.png" alt="">
            </div>
           <a class="aliPay" href="javascript:void(0)" onclick="zhifubao()">
            <i class="myiconfont">&#xe611;</i>
           </a>
           <a class="wxPay" href="javascript:void(0)" onclick="weixin()">
            <i class="myiconfont">&#xe69d;</i>
           </a>      
        </div>
    </div>
    <!-- foote开始 -->
    <div class="footer ubt ubb-d">
        <div class="ftNav ub">
            <a class="current ub ub-ver ub-ac ub-pc tx-c4" href="/index.php">
                <em class="gqblogo ub"></em>
                <span class="ub">首页</span>
            </a>
            <!--<a class="ub ub-ver ub-ac ub-pc tx-c4" href="#">
                <em class="gqblogo ub"></em>
                <span class="ub">股权帮</span>
            </a>-->
            <a class=" ub ub-ver ub-ac ub-pc tx-c4" href="/index.php?m=User&amp;a=index">
                <em class="ub iconfont icon-ren"></em>
                <span class="ub">我的</span>
            </a>
            <a class=" ub ub-ver ub-ac ub-pc tx-c4" href="/index.php?a=lists&amp;catid=8">
                <em class="ub iconfont icon-bangzhuzhongxin"></em>
                <span class="ub">帮助中心</span>
            </a>
        </div>
    </div>
    <script>
    // 显示结果
    var n ={$res.star} ;
    var good = [
        "梁山公司组建速度快。在公司创业阶段，众筹的模式能够最快速度召集人手。",
        "太平天国模式公司组建速度比较迅速。初始合伙人也比较有干劲儿。",
        "早期CPC模式，由于投资人的引入，通过大量资源或者资金解决了公司前期迅速扩张的困难，公司起步阶段可以拥有较为“舒适”的发展环境。",
        "北宋王朝是目前国内民营企业较为主流的模式。公司老板拥有公司控制权并且能在执行上把控。公司在发展时，能有核心人物负责，对公司未来发展奠定良好的基础。",
        "蒋介石模式拥有公司核心人物，公司在发展路径上不会跑偏，而且由于核心人物真正拥有控制权，也不会出大权旁落的悲惨结局。",
        "刘邦模式是较为成功的公司模式。一个精明能干的老板，带领着充满梦想的团队，许多成功公司都曾出现过。在公司成功后，公司用期权兑现之前的承诺。此类模式在工业化时代的股权设计中也十分成熟。",
        "刘备模式是目前较为完美的公司股权治理模式。公司在核心人物、股权分配以及合伙人职能上都具有合理的安排。",
    ]
    var bad = [
        "梁山模式由于公司筹建中忽略核心控制人的问题，公司实际上处于无人控制、无人管理的状态。公司在运行后，由于没有核心人物的把控，这种公司往往速生速灭。",
        "公司缺乏核心人物，或者说公司控制者与实际执行者出现了分制局面。这种局面极易出现执行层反水控制层的状况。对公司长期健康发展不利。",
        "由于公司的控制权并不在真正的执行层，公司的决策和执行的处于分制状态，在公司重要的关键节点上，创始人团队与投资人团队内讧很难避免，甚至创始人失去公司，也屡屡发生。",
        "北宋王朝之所以不温不火，是因为公司内部权力高度集中于老板一人，公司缺乏新鲜血液与牛人的加入，使得这类公司面对困难，核心人物老板十分无助，公司发展出现瓶颈，无法逾越。",
        "虽然蒋模式核心人物能够有效管控公司，但是其他小股东并不为公司出力，公司缺乏向心力与凝聚力。这样的公司无法形成战斗合力，在与其他凝聚力较强的公司竞争时，公司难以为继。",
        "在移动互联网时代，劳动开始雇佣资本，传统的这种期权模式出现了极大的局限性。公司由传统的雇佣变成了合伙，这样牛人才会愿意加入。",
        "从初创期企业来看，刘备模式近乎完美，但是在一个企业生命周期来看，由于种种原因，进入成熟期的企业很难再现刘备模式的辉煌。"
    ]
    $(".goodTxt").text(good[n - 1]);
    $(".badTxt").text(bad[n - 1]);
    $(".longPic img").attr('src', '/statics/default/images/result/res'+n+'.jpg');
    $(".payDiv .payTitle img").on("click", function() {
        $(".cover").hide();
        $(".payDiv").velocity({
            bottom: "-5.4rem"
        }, 400);
    });
    </script>
</body>

</html>

   
<input type='hidden' value='{$dia_res["id"]}' id='id'>
<input type='hidden' value='{$userid}' id='userid'>
<input type='hidden' value='{$member_id}' id='member_id'>
<input type='hidden' value='{$dia_res["status"]}' id='status'>
<input type='hidden' value='{$invitation_code}' id='invtitation_code'>
<input type="hidden" value="{$signature}" id="signature" />
</body>
<!--微信分享-->
<script type="text/javascript">
 function buy()
 {
	    //判断用户是否购买过
	    var userid = $('#member_id').val();
	    if(userid == '')
		{
			//用户未登录，
			alert('请先登录！');
			window.location.href='/index.php/content/user/login';
		}else
	    {
		    $.ajax({
		    	url:'/index.php/content/diacrisisTool/ajaxGetStatus?userid='+userid,
	            type:"GET",
	            dataType:"json",
	            success:function(r){
		             if(r.code==-1)
			         {
				         //用户已经购买了，
				         window.location.href = '/index.php/content/diacrisisTool/pay_wk_success?order_num='+r.order_num;
				     }else{
					    	//显示支付按钮
				    	    $(".cover").show();
					 	    $(".payDiv").velocity({
					 	        bottom: 0
					 	    }, 400); 
				     }
	            }
			});
		}

 }  



    //调用微信同意下单接口，获得微信预支付订单号
    var requestParam = null;
    var order_num = null;
    function weixin(){
        var url = '/index.php/Content/WeixinPay/EquityOrder';
        $.ajax({
            url:url,
            type:"GET",
            timeout:15000,
            dataType:"json",
            success:function(r){
                if(r.code == 0){
                    requestParam=JSON.parse(r.jsApiParameters);
                    order_num = r.order_num;
                    pay();
                }else if(r.code== -2 ){
                    alert('请先登录！');
                    window.location.href='/index.php/content/user/login';
                }else if(r.code== -1)
                {
                	alert(r.msg);
                	return false;
                }
            },
        })
    }

    //微信支付
    function pay(){
        WeixinJSBridge.invoke('getBrandWCPayRequest',{
            "appId": requestParam.appId,
            "timeStamp": requestParam.timeStamp,
            "nonceStr": requestParam.nonceStr,
            "package": requestParam.package,
            "signType": requestParam.signType,
            "paySign": requestParam.paySign
        },function(res){
            if(res.err_msg == "get_brand_wcpay_request:ok" ) {                             
                alert("支付成功");
                window.location.href='/index.php/content/DiacrisisTool/pay_wk_success?order_num='+order_num;
            }
            else if(res.err_msg == "get_brand_wcpay_request:cancel" ){
                alert("支付失败");
            }
        });
    }

    //支付宝支付
    function zhifubao()
    {
        var data = new Object();
        var url = '/index.php/Content/AliPay/dia_pay_confirm';
        $.ajax({
            url:url,
            type:"GET",
            timeout:15000,
            dataType:"json",
            success:function(r){
                if(r.code=='1'){
                    //获得订单号
                    window.location.href='/index.php/Content/AliPay/confirm/order_type/wk/order_num/'+r.msg.verification_code;
                }else if(r.code==-2)
                {
                    //用户未登录，
                    window.location.href='/index.php/content/user/login';
                }
            },         
        })


    }
</script>
</html>