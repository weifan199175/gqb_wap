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
<div class="cover"></div>
    <div class="fxDiv">
        <img src="/statics/default/images/fxPic.png" alt="">
        <div class="closeBtn">
            <img src="/statics/default/images/closeBtn.png" alt="">
        </div>
    </div>
    <div class="check">
        <div class="checkTitle">手机验证</div>
        <div class="telDiv">
            <div class="inputTitle">手机号:</div>
            <input type="number" placeholder="请输入手机号" value="{$dia_res['mobile']}" id='mobile'>
        </div>
        <div class="checkDiv">
            <div class="inputTitle">验证码:</div>
            <div class="numberDiv">
            <input type="number" class='yzm'>
            <div class="time" onclick='sendMessage()'>获取</div>
        </div>
        </div>
<!--         <div class="err"> -->
<!--             验证码错误 -->
<!--         </div> -->
        <div class="btns">
            <a href="javascript:void(0)" class="cancel">取消</a>
            <a href="javascript:void(0)" class="enter" onclick="autoReg()">确定</a>
        </div>
    </div>
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
		<div class="rewardBtn">
		   <a href="javascript:void(0)" onclick='checklogin()'>获取详细报告</a>
		</div>
        <div class="fxBtn">
		   <a href="javascript:void(0)">分享</a>
		</div>
        </div>
<input type='hidden' value='{$dia_res["id"]}' id='id'>
<input type='hidden' value='{$userid}' id='userid'>
<input type='hidden' value='{$dia_res["member_id"]}' id='member_id'>
<input type='hidden' value='{$is_reg}' id='is_reg'>
<input type='hidden' value='{$invitation_code}' id='invtitation_code'>
<input type="hidden" value="{$signature}" id="signature" />
<input type="hidden" value="{$dia_res['mobile']}" id="mobile" />
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

var ShareWord = [
          "我将坐拥20亿元资产，我的财富堪比冯仑！",
          "我是坐拥100亿元财富资产的成功商人，我将是下一个梁光伟！",
          "我是坐拥300亿元财富资产的商业大亨，王石跟我谈笑风生！",
          "我是坐拥500亿元财富的商业巨头，任正非跟我比不过尔尔！",
          "我是坐拥1000亿元财富的商业龙头，周鸿祎都在遥望我的背影！",
          "我是坐拥2000亿元财富的商业领袖，我将与王健林比肩！",
          "我是坐拥2200亿元财富的商业传奇，中国下一个马云、雷军就是我！",
      ]

  $(".resultPage .peoples").html(res[n - 1]);
    $(".resultPage .kind").html(kinds[n - 1]);
    $(".resultPage .tip1").html(tip1[n - 1]);
    $(".resultPage .lev span").html(n);


var userid = $('#userid').val();
var member_id = $('#member_id').val();
var status = $('#status').val();
var time = <?php echo $time; ?>;	   
var jsapi_ticket = '<?php echo $jsapi_ticket; ?>';				
var url = window.location.href;		
var signature = $("#signature").val();	
var s_title = '我的企业股权架构评分为:'+'{$dia_res.score}';     //分享标题
var s_link = '{$share_url}';  //分享链接
var s_desc = ShareWord[n-1];              //分享描述
var s_imgUrl = "http://dev.guquanbang.com/statics/default/images/result/res"+n+".png";//分享图标
var flag = 0;  //代表是否给用户发送了密码  0 代表 未发送， 1 代表已发送

//读秒
var timer = 60;
function numRoll(){
    
    if(timer <= 0){
        $('.time').css('background-color','#e60012').attr('onclick','sendMessage();').text("重新发送");
        timer   =   60;
    }else if(timer > 0){
        timer--;
        $('.time').css('background-color','#AAA').attr('onclick','').text("("+timer+")已发送");
        setTimeout("numRoll()",1000);
    }
}


function sendMessage(){
    //获取验证码
    var mobile = $('#mobile').val();
    var regtel = /^1[34578]{1}\d{9}$/;
    if(mobile==''){
        alert('请填写手机号');
        return false;
    }else if(!regtel.test(mobile)){
            alert('请输入正确的手机号');
            return false;
    }else{
        var url = '/index.php?m=User&a=regcode';
        $.post(url, {'mobile':mobile}, function (r){
            if(r==0){
                //点击后跳转读秒
                numRoll();
                alert('验证码已发送至您的手机，请注意查收！');
            }else if(r==1){
                alert('该手机号已经注册过，不可再次注册！');
            }   
        },'json');
    }
}
//获取随机的密码
function MathRand() 
{ 
	var Num=""; 
	for(var i=0;i<6;i++) 
    { 
		Num+=Math.floor(Math.random()*10); 
    } 
    return Num;
} 

//自动帮用户注册
function autoReg()
{
	var data= new Object();
    data['truename'] = "{$dia_res['name']}";
    data['mobile'] =$('#mobile').val();
    data['password'] = MathRand();
    data['yzm'] = $('.yzm').val();
    data['source']='WEB';
    data['job'] = "{$dia_res['job']}";
    if(data['yzm']==''){
        alert('请输入验证码');
        return false;
    }
    $.post('/index.php?m=User&a=userreg',data, function(msg){
        if(msg.error==0){
            alert(msg.info);
            //将密码发送到用户手机中
            sendPassword(data['password'],data['mobile'])
            //密码发送成功,跳转到详情页
            window.location.href = '/index.php/Content/WeixinPay/EquityOrder.html?id='+{$dia_res.id};                    
        }else{
            alert(msg.info);
            return false;
        }
       
    },'json');
    //提交注册信息    
}
//用户成功注册后，将随机密码发送到用户手机上；
function sendPassword(password,mobile,change_flag)
{
	var info  = new Object();
	info['mobile'] = mobile;
	info['password'] = password;
	$.post('/index.php?m=User&a=sendPwd',info, function(msg){
        if(msg=='0'){
            alert('股权帮已帮您注册，密码已发送到您的手机！');
        }else{
            alert('您的密码为：'+password+'请您牢记！');
        }
       
    },'json');
}

//修改flag
function change_flag(r)
{
	if(r == '1')
	{
		flag = 1;
	}
}
//显示分享的图片
function share()
{
	if(userid == undefined || userid == null || userid == '')
    {
         //弹出登录屏蔽层
        window.location.href = '/index.php/content/user/reg/'
        return false;
	}
    //判断当前登录这是否为这条记录的创建者
    if( userid !=='' && userid == member_id)
    {
    	$('.fxDiv').css('display','block');  
    }else
    {
        alert('您不是本次计算结果的拥有人，不能分享！');
    }
}

//页面加载即执行
wx.config({
		debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
		appId: '<?php echo $appid?>', // 必填，公众号的唯一标识
		timestamp: time, // 必填，生成签名的时间戳
		nonceStr: 'BogLeUnion', // 必填，生成签名的随机串
		signature: signature,// 必填，签名，见附录1
		jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareWeibo','onMenuShareQZone'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
});	



wx.ready(function (){	   
   //隐藏分享按钮
   
   //分享到朋友圈
   wx.onMenuShareTimeline({
    title: s_title, // 分享标题
    link: s_link, // 分享链接
    imgUrl: s_imgUrl, // 分享图标
    success: function () { 
    	alert('分享成功');
    },
    cancel: function () { 
        // 用户取消分享后执行的回调函数
		alert("您已取消分享！");
    }
   });

   //分享给朋友
   wx.onMenuShareAppMessage({
    title: s_title, // 分享标题
    desc: s_desc, // 分享描述
    link: s_link, // 分享链接
    imgUrl: s_imgUrl, // 分享图标
    type: '', // 分享类型,music、video或link，不填默认为link
    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
    success: function () { 
    	alert('分享成功');
    },
    cancel: function () { 
        // 用户取消分享后执行的回调函数
		alert("您已取消分享！");
    }	
   });

   //分享到QQ
   wx.onMenuShareQQ({
    title: s_title, // 分享标题
    desc: s_desc, // 分享描述
    link: s_link, // 分享链接
    imgUrl: s_imgUrl, // 分享图标
    success: function () { 
    	alert('分享成功');
    },
    cancel: function () { 
       alert("您已取消分享！");
    }
   });

   //分享到腾讯微博
   wx.onMenuShareWeibo({
    title: s_title, // 分享标题
    desc: s_desc, // 分享描述
    link: s_link, // 分享链接
    imgUrl: s_imgUrl, // 分享图标
    success: function () { 
    	alert('分享成功');
    },
    cancel: function () { 
       alert("您已取消分享！");
    }
  });

   //分享到QQ空间
   wx.onMenuShareQZone({
    title: s_title, // 分享标题
    desc: s_desc, // 分享描述
    link: s_link, // 分享链接
    imgUrl: s_imgUrl, // 分享图标
    success: function (){ 
    	alert('分享成功');
    },
    cancel: function (){ 
        alert("您已取消分享！");
    }

  });
	
});
</script>
<script>
//判断是否登录后，才能进行打赏
function checklogin()
{
	var userid = $('#userid').val();
	var id = $('#id').val();
	var is_reg = $('#is_reg').val();
	if(userid == undefined || userid == null || userid == '')
    {
	    if(is_reg == 1)
		{
		   //判断出诊断记录中的号码已被注册过后
		   //跳转到登录页面
		   window.location.href = '/index.php/content/user/login';	
	    }else if(is_reg == 0)
		{
		   //判断用户诊断记录中的号码未被注册过
	        $(".rewardBtn").click(function() {
	            $(".cover,.check").show();
	        });
	    }
           
	}else
	{
	   //用户登陆或者注册后会跳转到详情页面
        window.location.href = '/index.php/Content/WeixinPay/EquityOrder.html?id='+{$dia_res.id};
	    /**用于一元打赏股权诊断器的**/
		/*//用户登录，可以使用打赏功能
	    $(".payDiv").velocity({
	            bottom: 0
	        }, 400);
	    */
	}
}

/**关闭支付页面***/
/*$(".payDiv").on("click", function() {
    $(this).velocity({
        bottom: "-2.133333rem"
    }, 400);
});*/


//调用微信同意下单接口，获得微信预支付订单号
/*var requestParam = null;
function weixin(){
	var data = new Object();
	data['dia_tool_id'] = {$dia_res.id};//诊断器结果ID
    var url = '/index.php/Content/WeixinPay/EquityOrder';
    $.ajax({
    	url:url,
    	type:"POST",
    	data:data,
    	timeout:15000,
    	dataType:"json",
    	success:function(r){
    		if(r.code == 0){
                        
        		requestParam=JSON.parse(r.jsApiParameters);
        		pay();
    		}else {
    			alert("订单创建失败，稍后重试");
    	   	}
    	},
    })	
}*/

//微信支付
/*function pay(){
    WeixinJSBridge.invoke('getBrandWCPayRequest',{
        "appId": requestParam.appId,
        "timeStamp": requestParam.timeStamp,
        "nonceStr": requestParam.nonceStr,
        "package": requestParam.package,
        "signType": requestParam.signType,
        "paySign": requestParam.paySign
    },function(res){
        if(res.err_msg == "get_brand_wcpay_request:ok" ) {
        	wx.showMenuItems({
    		    menuList: ['menuItem:share:appMessage','menuItem:share:timeline','menuItem:share:qq','menuItem:share:weiboApp','menuItem:favorite','menuItem:share:facebook','menuItem:share:QZone'] // 要显示的菜单项，所有menu项见附录3
    		}); //支付成功后显示右上角分享功能按钮
    		//替换html代码，显示出分享按钮
    		$('#html').html('<div class="rewardBtn payBtn"><a href="javascript:void(0)" onclick="share()">分享</a></div><div class="rewardBtn payBtn"><a href="/index.php/content/diacrisisTool/diacrisisTool" >股权诊断器</a></div>');

        	alert("支付成功");           
        }
        else if(res.err_msg == "get_brand_wcpay_request:cancel" ){
            alert("支付失败");
        }
    });
}*/

//支付宝支付
/*function zhifubao()
{
	var data = new Object();
	data['dia_tool_id'] = {$dia_res.id};//诊断器结果ID
    var url = '/index.php/Content/AliPay/dia_pay_confirm';
    $.ajax({
    	url:url,
    	type:"POST",
    	data:data,
    	timeout:15000,
    	dataType:"json",
    	success:function(r){
        	if(r.code=='1'){
            	//获得订单号
            	window.location.href='/index.php/Content/AliPay/confirm/order_type/zdq/order_num/'+r.msg.verification_code;
            }		
    	},
    	error:function(){
    		alert(data.errormsg);
    	}
    })	
}*/

$(".loginBg").on("click", function() {
        $(this).hide();
        $(".login").hide();
    });
    var tel="{$dia_res['mobile']}";
    tel=tel.substring(0,3)+"****"+tel.substring(7,12); 
    $(".checkTxt span").text(tel);

    $(".fxBtn").click(function() {
        $(".cover,.fxDiv").show();
    });
    $(".closeBtn").click(function(){
        $(".cover,.fxDiv").hide();
    });
    $(".cancel").click(function() {
        $(".cover,.check").hide();
    });
</script>
</html>