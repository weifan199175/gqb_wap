<!DOCTYPE html>
<html class="um landscape min-width-240px min-width-320px min-width-480px min-width-768px min-width-1024px">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="/statics/default/css/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="/statics/default/css/public.css">
    <link rel="stylesheet" href="/statics/default/css/ui-box.css">
    <link rel="stylesheet" href="/statics/default/css/ui-base.css">
    <link rel="stylesheet" href="/statics/default/css/ui-color.css">
    <link rel="stylesheet" href="/statics/default/css/appcan.control.css">
    <link rel="stylesheet" href="/statics/default/css/iconfont/iconfont.css">
    <link rel="stylesheet" href="/statics/default/css/swiper.min.css">
    <link rel="stylesheet" href="/statics/default/css/service.css">
    <title>社员服务-股权咨询</title>
</head>
<body class="um-vp" style="background: #f4f4f4;">
<!-- c -->
<div class="sBox"> 
    <!-- 社员服务 股权咨询-->
    <div class="ub ub-ver UPmemberBox">
        
		<div class="newsTitle ub ub-ac">
            <em class="ub iconfont icon-shutiao"></em>
            股权咨询
        </div>
        <!-- 股权咨询 -->
		<input type="hidden" value="{$_SESSION['userid']}" id="userid" />
        <div class="classBox">
            <div class="hidden">

                <content action="lists" catid="$catid"  order="updatetime DESC,listorder DESC" > 
                        <volist name="data" id="vo">
                            <li class="ub ubb-d uinn">
                                <div class="img ub ub-ac uof"><a href="{$vo.url}"><img src="{$vo.thumb}" alt=""></a></div>
                                <div class="con ub ub-f1 ub-ver">
                                    <h5 class="ub umar-b tx-c2 uof"><a href="{$vo.url}">{$vo.title}</a></h5>
                                    <span>所需积分：<i class="tx-red">{$vo.score} 分</i></span>    
                                    <div class="zxbt ub">
                                        <a class="ub ub-ac ub-pc uba uc-a1 tx-a" href="javascript:;" Onclick="show_pay_pass({$vo.score},{$vo.id},'{$vo.title}');">积分兑换</a>
                                        <a class="ub ub-ac ub-pc uba uc-a1 tx-cgn" href="/index.php?m=Message&a=zixun_form&zx_id={$vo.id}">我要咨询</a>
                                    </div>
                                </div>
                            </li>
                        </volist>   
                </content>
            </div>
            <ul class="classList zxList lists"></ul>
                <a class="checkMore ub ub-ac ub-pc uinn ulev-1 tx-c8 more" href="javascript:;" onClick="content_new.loadMore();">点击查看更多>></a>        
        </div>
        <!-- /股权咨询 -->                               
    </div>
	
	
    
	<!-- /社员服务 股权咨询-->
    <!-- 页脚 -->
    <?php if($_SESSION['userid']==''){ ?>  
    <div class="ftBtFixed ubt ubb-d">
        <a class="btn ub uinn" href="javascript:void(0);"  Onclick="join();">
            <div class="callbtn ub ub-f1 ub-ac ub-pc tx-cf uc-a3 uinn7 bg-red ulev0">
                申请加入
            </div>
        </a>
    </div>
    <?php } ?>
       <template file="Content/footer.php"/>       
    <!-- /页脚 -->
</div>
<!-- /c -->

<!--弹出层    提示消息-->
<div class="PopUp uc-a3">
    <div class="PopUp_box ub ub-ver ub">
        <!-- 积分充值调用 -->
       <div class="contUp ub">
            您好，您的可用积分不足以兑换，请立即充值！ 
             <!--您好，您还不是股权帮的注册社员，请先注册后再申请咨询，谢谢！   （立即注册时的文字提示） -->
       </div>
       <a class="btn ub uinn" href="/index.php?m=WeixinPay&a=charge" >
            <div class="callbtn ub ub-f1 ub-ac ub-pc tx-cf uc-a3 uinn7 bg-red ulev0">                
                立即充值
                <!-- 立即注册    (立即注册时按钮) -->
            </div>
        </a>
         <!-- /积分充值调用 -->
    </div>
</div>
<!--/弹出层-->

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
<!--提示弹窗-->
<div class="PopUp3 uc-a3" style="display:none;">
    <div class="PopUp_box ub ub-ver ub">
       <div class="contUp ub ub-pc"id="tishi">
            提示信息
       </div>
    </div>
</div>
<!--/提示弹窗-->

</body>
<script type="text/javascript" src="/statics/default/js/jquery.js"></script>
<script type="text/javascript" src="/statics/default/js/swiper.min.js"></script>
<script type="text/javascript">
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true
    });
</script>
<!-- 密码输入框 -->
<script type="text/javascript" src="/statics/default/js/fastclick.js"></script>

<script>
    function init(){
        var width=$(window).width();
        var height=$(window).height();
        $("body").css("height",height);
        $("body").css("width",width);
    }
    window.addEventListener('load', function() {
          FastClick.attach(document.body);
        }, false);
</script>
<!-- /密码输入框 -->
<script src="/statics/default/js/ff.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){     

    $(".fullbg").click(function(){
        $(".PopUp").animate({opacity:"hide"},100);
        $(".fullbg").hide();
    });
});
</script>
<!-- /弹出层 -->
<script>
//判断是否有兑换资格   弹出输入支付密码框
function show_pay_pass(needscore,product_id,title)
{
	
	var member_class= '<?php echo $_SESSION['member_class']; ?>'; 
	var data = new Object();
	
	data['score'] = parseInt(needscore);
	data['product_id'] = product_id;
	data['product_name'] = title;
	
	if($("#userid").val()==''){
	     alert("请先登录！");return;	
	}else if(member_class=='1'){
		alert("请完善资料后再兑换该产品！");
        window.location.href='/index.php?m=User&a=perfect_information';return;
	}
		var url = '/index.php?m=Message&a=check_pay';
		$.post(url, data, function (r){
			if(r.code=='0')
			{
				check_pay_pass(needscore,product_id,title)
				
			}else{
				alert(r.msg);return;
			}
			   
		},'json');
		return;
}

//支付密码输入判断
function check_pay_pass(needscore,product_id,title){
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
							  duihuan(needscore,product_id,title);
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


//积分兑换
function duihuan(needscore,product_id,title)
{
	
		if(confirm("确认使用积分兑换？"))
		{
		    var data = new Object();
	
			data['pay_type'] = 2;      //积分支付
			data['product_type'] = 5;  //股权咨询产品
			data['price'] = '0'
			data['score'] = parseInt(needscore);
			data['product_id'] = product_id;
			data['product_name'] = title;
			
			data['truename'] = '<?php echo $user['truename']; ?>'; 
			data['mobile'] = '<?php echo $user['mobile']; ?>'; 
			
			var url = '/index.php?m=Message&a=addorder';
			$.post(url, data, function (r){
				if(r.code=='0')
				{
					//show_pay_pass();
				    alert("兑换成功，平台工作人员2个工作日内将与您联系！");return;
			    }else if(r.code=='2'){
					alert("您已兑换过该产品，请耐心等待！");return;
				}else if(r.code=='3'){
					$(".PopUp").animate({opacity:"show"},300);
                    $(".fullbg").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"block"});
					 return;
				}else{
					alert("兑换失败！");return;
				}	
				   
			},'json');
			return;
	   }
		
}






</script>
<script type="text/javascript">
    //点击加载更多
    var _content = []; //临时存储li循环内容
    var content_new = {
      _default:5, //默认显示个数
      _loading:5,  //每次点击按钮后加载的个数
      init:function(){
        var lis = $(".classBox .hidden li");
        $(".classBox ul.lists").html("");
        for(var n=0;n<content_new._default;n++){
          lis.eq(n).appendTo(".classBox ul.lists");
        }
        
        for(var i=content_new._default;i<lis.length;i++){
          _content.push(lis.eq(i));
        }
        $(".classBox .hidden").html("");
      },
      loadMore:function(){
        var mLis = $(".classBox ul.lists li").length;
        for(var i =0;i<content_new._loading;i++){
          var target = _content.shift();
          if(!target){
            $('.classBox .more').html("<p>全部加载完毕...</p>");
            break;
          }
          $(".classBox ul.lists").append(target);
          $(".classBox ul.lists li").eq(mLis+i).each(function(){
            
          });
        }
      }
    }
    content_new.init();   
</script>
<script type="text/javascript">
$(function(){
   
    $(".fullbg").click(function(){
        $(".PopUp5").animate({opacity:"hide"},100);
        $(".fullbg").hide();
    });
});

//弹窗提示
function Zalert(str)
{
	$("#tishi").html(str);
	$(".PopUp3").animate({opacity:"show"},300).delay(2000).fadeOut("slow");
	$(".fullbg").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"block"}).delay(2100).fadeOut("slow");
}
</script>

</html>