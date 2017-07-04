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
    <title>股权帮个人中心 确认订单</title>
	<?php 
        
		//判断是否微信浏览器打开
		  
	   if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false)
	   {
     
	?>
	<script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest', 
			<?php echo $jsApiParameters; ?>,
			function(res){
				WeixinJSBridge.log(res.err_msg);
				//alert(res.err_code+res.err_desc+res.err_msg);
				 if(res.err_msg == "get_brand_wcpay_request:ok"){
					var url_success	=	'/index.php?m=WeixinPay&a=pay_success&order_num='+<?php echo $order_num; ?>;
					alert('支付成功');
				    window.location.href = url_success;
				}else{
				   //返回跳转到订单列表页面
				   alert('支付失败');
				   window.location.href="/index.php?m=User&a=order";	 
			   }
			   /*
			   WeixinJSBridge.log(res.err_msg);
			   alert("支付成功");
			   window.location.href = '/index.php?m=WeixinPay&a=pay_success&order_num='+<?php echo $order_num; ?>;
			   */
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	
	
	</script>
	
	<?php } ?>
	
</head>
<body class="um-vp" style="background: #f4f4f4;">

<!-- c -->
<div class="cBox"> 
    <!-- 确认订单 -->
    <div class="ub ub-ver confirmOrderBox">
    <if condition="!empty($course)">
        <ul class="classList">
            <li class="ub ubb ubb-d uinn bgc">
                <a class="ub ub-f1" href="{$course.url}">
                    <div class="img ub ub-ac uof"><img src="{$course.thumb}" alt=""></div>
                    <div class="con ub ub-f1 ub-ver">
                        <h5 class="ub umar-b tx-c2 uof">{$course.title}</h5>
                        <div class="info ub tx-red">
                            <span class="ub ub-ac iconfont icon-boshimao-copy"></span>
                            <em class="ub ub-ac">讲师：<i>{$course.teacher}</i></em>
                        </div> 
                        <div class="info ub">
                            <span class="ub tx-c4 iconfont icon-shijian"></span>
                            <em class="ub ub-ac tx-c8">时间：<i>{$course.start_time|date="Y-m-d",###}</i></em>
                        </div>
                        <div class="info ub">
                            <span class="ub tx-c4 iconfont icon-xiao31"></span>
                            <em class="ub tx-c8 ub-ac">地点：<i>{$course.city}</i></em>
                        </div>
                        <div class="price ub ub-ac tx-red">
                            <i>¥</i>
                            <span>{$course.price}</span>
                        </div>
                    </div>
                </a>
            </li>            
        </ul>
    <elseif condition="$_GET['product_type'] eq '15'" />
        <div class="myApply ub ub-pc ub-ac uinn bgc"><img src="/statics/default/images/logo4.png" alt=""></div>
        <h5 class="title ub ub-ac ub-pc uinn bgc tx-c2">股权帮已废弃的铁杆社员入社费用</h5>
        <div class="price ub ub-ac ub-pc tx-red bgc">¥ 30000元</div>
    <elseif condition="$_GET['product_type'] eq '16'" />
        <div class="myApply ub ub-pc ub-ac uinn bgc"><img src="/statics/default/images/logo4.png" alt=""></div>
        <h5 class="title ub ub-ac ub-pc uinn bgc tx-c2">股权帮铁杆社员入社费用</h5>
        <div class="price ub ub-ac ub-pc tx-red bgc">¥ 30000元</div>
    </if>
    <if condition="$order['product_type'] eq 2">
        <div class="jfBox ub ub-ver tx-cf bg-red">
            <div class="tt ub ub-ac ub-pc uinn">剩余积分</div>
            <div class="number ub ub-ac ub-pc">{$member.score}</div>
        </div>
        <div class="jfreset ub ub-ac mar-b7 ubb ubb-d uinn5 bgc">
            <div class="tt ub">充值金额</div>
            <div class="number ub ub-f1 ub-pe uinput"><?php echo $_GET['money'];?></div>
        </div>
    </if>
        <ul class="joinChose ub-f1 bgc">
            <li class="number ub ubb ubt ubb-d uinn5">
                <div class="ub ub-ac">订单号</div>
                <div class="nm ub ub-f1 ub-ac ub-pe tx-c8">{$order.verification_code}</div>
            </li>
            <li class="number ub ubb ubb-d uinn5">
                <div class="ub ub-ac">商品总计</div>
                <div class="money ub ub-f1 ub-ac ub-pe tx-red">
                <i>¥{$order.price}</i> 元
                </div>
            </li>
            <div <if condition="$product">style="display: none;"</if>>
             <li class="ub ubb ubb-d uinn5">
                请选择支付类型     
            </li>
            <li class="chose ub ub-ver ubb ubb-d">
                <div class="ub ub-f1 uinn5 ub-ac ubb ubb-d">
                    <div class="ub zfImg"><img src="/statics/default/images/zfxj.png" alt=""></div>
                    <div class="con ub ub-ver ub-f1">
                        <h5 class="price ub ub-ac tx-red">{$order.price}元</h5>
                        <span class="ub tx-c8">现金支付</span>
                    </div>
                    <div class="ub radiobox">
                        <input type="radio" value="1" name="chose_type" checked />
                    </div>
                </div>
       <if condition="!empty($course)">
                <div class="ub ub-f1 uinn5 ub-ac">
                    <div class="ub zfImg"><img src="/statics/default/images/zfjf.png" alt=""></div>
                    <div class="con ub ub-ver ub-f1">
                        <h5 class="price ub ub-ac tx-red">{$course.mix_price}元+{$course.mix_score}积分</h5>
                        <span class="ub tx-c8">现金+积分支付</span>
                    </div>
                    <div class="ub radiobox">
                        <input type="radio" value="2" name="chose_type"/>
                    </div>
                </div>
      </if>
            </li>
            </div>
            <li class="ub ubb ubb-d uinn5">
                请选择支付方式        
            </li>
            <li class="chose ub ub-ver ubb ubb-d">
            <?php if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false){?>
                <div class="ub ub-f1 uinn5 ub-ac ubb ubb-d">
                    <div class="ub zfImg"><img src="/statics/default/images/zf1.png" alt=""></div>
                    <div class="con ub ub-ver ub-f1">
                        <h5 class="ub uof tx-c4">微信支付</h5>
                        <span class="ub tx-c8">推荐安装微信5.0及以上版本的使用</span>
                    </div>
                    <div class="ub radiobox">
                        <input type="radio" value="1" name="chose_zf" checked />
                    </div>
                </div>
            <?php }?>
				<!--
                <div class="ub ub-f1 uinn5 ub-ac ubb ubb-d">
                    <div class="ub zfImg"><img src="/statics/default/images/zf2.png" alt=""></div>
                    <div class="con ub ub-ver ub-f1">
                        <h5 class="ub uof tx-c4">银联支付</h5>
                        <span class="ub tx-c8">支持工行、建行、农行、招行等银行大额支付</span>
                    </div>
                    <div class="ub radiobox">
                        <input type="radio" value="2" name="chose_zf"/>
                    </div>
                </div>
				-->
                <div class="ub ub-f1 uinn5 ub-ac">
                    <div class="ub zfImg"><img src="/statics/default/images/zf3.png" alt=""></div>
                    <div class="con ub ub-ver ub-f1">
                        <h5 class="ub uof tx-c4">支付宝支付</h5>
                        <span class="ub tx-c8">推荐有支付宝账号用户使用</span>
                    </div>
                    <div class="ub radiobox">
                        <input type="radio" value="3" name="chose_zf" <?php echo (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false)?"checked":""?>/>
                    </div>
                </div>
            </li>
        </ul>
        <if condition="$course['catid'] eq 13 && $member['class_name'] eq 4">       
            <a class="btExchange btn ub ub-fl umar-b2 uinput" href="javascript:;" Onclick="check_pay_pass();"><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1 tx-cf" type="button" value="积分兑换"></a>
        <else />
            <div class="reading umar-a2 ub ub-ac umar-a tx-c4"><span class="tx-red ulev-1 iconfont icon-xinghao"></span>提交即默认同意相关协议
			<if condition="$_GET['product_type'] eq '15'">
				<a href="{:getCategory(22,'url')}">阅读详情</a>
			<elseif condition="$_GET['product_type'] eq '16'" />
				<a href="{:getCategory(23,'url')}">阅读详情</a>
			<elseif condition="$order['product_type'] eq '2'" />
				<a href="{:getCategory(26,'url')}">阅读详情</a>	
			</if>
			</div>
        </if>
        <a class="btSubmit btn ub ub-fl uinput" href="javascript:;" Onclick="tijiao();"><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1 tx-cf" type="button" value="确认支付"></a>        
    </div>
    <!-- /确认订单-->
</div>
<!-- /c -->
<input type="hidden" id="order_num" value="{$order.verification_code}" />
<input type="hidden" value="{$member.score}"  id="member_score" />
<input type="hidden" value="{$course.score}"  id="course_score" />
<input type="hidden" value="{$course.mix_score}"  id="need_score" />
<input type="hidden" value="{$course.id}"  id="course_id" />
<!--弹出层    输入支付密码-->
<div class="PopUp5 uc-a3" style="display:none;">
    <div class="PopUp_box ub ub-f1 ub-ver ub">
       <div class="contUp">
            <div class="title"><span id="set_text" style="font-size: 1em;">输入支付密码</span></div>
            <div style="padding-top: 20px;text-align: center;">
                <form id="password" >
                    <input readonly class="pass" type="password"maxlength="1"value=""><input readonly class="pass" type="password"maxlength="1"value=""><input readonly class="pass" type="password"maxlength="1"value=""><input readonly class="pass" type="password"maxlength="1"value=""><input readonly class="pass" type="password"maxlength="1"value=""><input readonly class="pass pass_right" type="password"maxlength="1"value="">
                </form>
            </div>
            <div id="keyboardDIV"></div>
       </div>
    </div>
</div>
<!--/弹出层-->

<!-- jQuery 遮罩层 -->
<div class="fullbg"></div>
<!-- end jQuery 遮罩层 -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery.js"></script>
<!-- 密码输入框 -->
<script type="text/javascript" src="/statics/default/js/fastclick.js"></script>
<!-- /密码输入框 -->
<script src="/statics/default/js/ff.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
   
    $(".fullbg").click(function(){
        $(".PopUp5").animate({opacity:"hide"},100);
        $(".fullbg").hide();
    });
});
var course_id=$('#course_id').val();
var member_score=$('#member_score').val()-0;
var order_num = $('#order_num').val();

//支付密码输入判断
function check_pay_pass()
{
	var check_pass_word='';
	var passwords = $('#password').get(0);
	$(".PopUp5").animate({opacity:"show"},300);    
	$(".fullbg").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"block"});
    var div = '\
	<div id="key" style="position:absolute;width:100%;bottom:0px; left:0">\
		<ul id="keyboard" style="font-size:20px;margin:2px -2px 1px 2px">\
			<li class="symbol"><span class="off">1</span></li>\
			<li class="symbol"><span class="off">2</span></li>\
			<li class="symbol btn_number_"><span class="off">3</span></li>\
			<li class="tab"><span class="off">4</span></li>\
			<li class="symbol"><span class="off">5</span></li>\
			<li class="symbol btn_number_"><span class="off">6</span></li>\
			<li class="tab"><span class="off">7</span></li>\
			<li class="symbol"><span class="off">8</span></li>\
			<li class="symbol btn_number_"><span class="off">9</span></li>\
			<li class="delete lastitem">删除</li>\
			<li class="symbol"><span class="off">0</span></li>\
			<li class="cancle btn_number_">取消</li>\
		</ul>\
	</div>\
	';
    var character,index=0;	$("input.pass").attr("disabled",true);	$("#password").attr("disabled",true);$("#keyboardDIV").html(div);
    $('#keyboard li').click(function(){
        if ($(this).hasClass('delete')) {
        	$(passwords.elements[--index%6]).val('');
        	if($(passwords.elements[0]).val()==''){
        		index = 0;
        	}
            return false;
        }
        if ($(this).hasClass('cancle')) {
            //parentDialog.close();
			$(".PopUp5").animate({opacity:"hide"},100);
            $(".fullbg").hide();
			for (var i = 0; i < passwords.elements.length; i++) {
				$(passwords.elements[i]).val('');
			}
            return false;
        }
        if ($(this).hasClass('symbol') || $(this).hasClass('tab'))
		{
            character = $(this).text();
			$(passwords.elements[index++%6]).val(character);
			if($(passwords.elements[5]).val()!='')
			{
        		index = 0;
        	}
			
			if($(passwords.elements[5]).val()!='') 
			{
				var temp_rePass_word = '';
				for (var i = 0; i < passwords.elements.length; i++) {
					temp_rePass_word += $(passwords.elements[i]).val();
				}
				check_pass_word = temp_rePass_word;
				var data = new Object();
				data['pay_pass'] =  check_pass_word;
				$("#key").hide();
				var url = '/index.php?m=Message&a=check_pay_pass';
				$.post(url, data, function (r){
					if(r.code=='0')
					{
						$(".PopUp5").animate({opacity:"hide"},100);
						$(".fullbg").hide();
						for (var i = 0; i < passwords.elements.length; i++) {
							$(passwords.elements[i]).val('');
						}
						setTimeout(function(){
							  jifen(); 
							},300);
						
					}else{
						if(r.code==1)
						{
						   alert("请设置支付密码！");
						   window.location.href='/index.php?m=user&a=pay_pass';
						   return;
						}
						var result_text='\
									<span>支付密码</span>\
									<span style="color: red;">'+r.msg+'</span>\
									';
								$("#set_text").html(result_text);
								$("#key").show();
						for (var i = 0; i < passwords.elements.length; i++) {
							$(passwords.elements[i]).val('');
						}
					}	
					   
				},'json');
			
			}
        }
        return false;
    });
}
//积分支付
function jifen()
{
	if(confirm("确认使用积分兑换？"))
	{
		var data = new Object();

		data['order_num'] = order_num;      //订单号
		
		var url = '/index.php?m=WeixinPay&a=pay_order_score';
		$.post(url, data, function (r){
			if(r=='0')
			{
				
			   alert("恭喜，兑换成功！");
	           window.location.href='/index.php/Content/WeixinPay/pay_success.html';	
			}else if(r=='1'){
				alert("积分不足！");return;
			}else{
				alert("兑换失败！");return;
			}	
			   
		},'json');
		return;
	}
	
}

//订单提交
function tijiao()
{	
	var pay_type = $(':radio[name="chose_zf"]:checked').val();
	var pay_act = $(':radio[name="chose_type"]:checked').val();
	var need_score=0;
	if(pay_act=='2'){
		need_score=$('#need_score').val()-0;
	}
	if(typeof(pay_type)=="undefined"){
		alert("请选择支付方式！");return;
	}else if(typeof(pay_act)=="undefined"){
		alert('请选择支付类型！');return;
	};
	//微信+现金
	if(pay_type=='1' && pay_act=='1')    
	{
		$.ajax({
			url:'/index.php?m=WeixinPay&a=cash_pay',
			data:{'type':1,'order_num':order_num,'course_id':course_id},
			type:'get',
			success:function(msg){
				if(msg){
					callpay();
				}else{
					alert('支付失败！请联系客服处理');
					return;
				}
			}
		});
	}else if(pay_type=='1' && pay_act=='2'){
		//微信+混合支付  *****判断积分是否足够支付
		if(member_score >= need_score){
			//ajax修改订单价格
			$.ajax({
				url:'/index.php?m=WeixinPay&a=mix_pay',
				data:{'type':4,'order_num':order_num,'course_id':course_id},
				type:'get',
				success:function(msg){
					if(msg){
						window.location.href='/index.php/Content/WeixinPay/confirm?order_num='+order_num;
						return;
					}else{
						alert('支付失败,请联系客服');
						return;
					}
				}
			});
		}else{
			alert("您的积分不足");
		}
	}
	if(pay_type=='2'){
		alert("银联支付暂未开放！");
	}
	//支付宝+现金
	if(pay_type=='3' && pay_act=='1'){
		$.ajax({
			url:'/index.php?m=WeixinPay&a=cash_pay',
			data:{'type':1,'order_num':order_num,'course_id':course_id},
			type:'get',
			success:function(msg){
				if(msg){
					window.location.href='/index.php/Content/AliPay/confirm.html?order_num='+order_num;
					return;
				}else{
					alert('支付失败！请联系客服处理');
					return;
				}
			}
		});
	}else if(pay_type=='3' && pay_act=='2'){
		//支付宝+混合支付******积分是否充足
		if(member_score >= need_score){
			//ajax修改订单价格
			$.ajax({
				url:'/index.php?m=WeixinPay&a=mix_pay',
				data:{'type':4,'order_num':order_num,'course_id':course_id},
				type:'get',
				success:function(msg){
					if(msg){
						window.location.href='/index.php/Content/AliPay/confirm.html?order_num='+order_num;
						return;
					}else{
						alert('支付失败！请联系客服处理');
						return;
					}
				}
			});
		}else{
			alert("您的积分不足");
		}
	}
}

</script>
</html>