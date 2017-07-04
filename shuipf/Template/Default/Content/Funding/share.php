<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" /> -->
    <meta http-equiv=”X-UA-Compatible” content=”IE=Edge,chrome=1″>
    <meta charset="utf-8">
    <title>{$data['userinfo']['truename']}的众筹</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
    <script src="http://g.tbcdn.cn/mtb/lib-flexible/0.3.4/??flexible_css.js,flexible.js"></script>
    <script src="/statics/zc/js/myFunding.min.js"></script>
    <script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>  
    <script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <link rel="stylesheet" href="/statics/default/css/public.css">
    <link rel="stylesheet" href="/statics/default/css/ui-box.css">
    <link rel="stylesheet" href="/statics/default/css/ui-base.css">
    <link rel="stylesheet" href="/statics/default/css/ui-color.css">
    <link rel="stylesheet" href="/statics/default/css/appcan.control.css">
    <link rel="stylesheet" href="/statics/default/css/iconfont/iconfont.css">
    <link rel="stylesheet" href="/statics/default/css/index.css">
    <link rel="stylesheet" href="/statics/default/css/common.min.css">
    <link rel="stylesheet" href="/statics/zc/css/myFunding.min.css">
</head>
<script type="text/javascript">
function getword(event){
	var share_default = new Object();
	share_default['id'] = $('#fundid').val();
	if(event =='1')
    {
		share_default['share']='股权帮、学股权、玩社群、连接合伙人、合伙创造新物种';  
	}else if(event == '2')
    {
		share_default['share']='新物种合伙人社群股权帮，让股权成为无边界资产'; 
	}	
	//ajax 将分享提交到数据库中
	ajaxsend(share_default);
}
//获取自定义的分享句子
$(function(){
	$('#divOK').on("touchstart",function(){
		var share_diy = new Object();
		share_diy['id'] =$('#fundid').val();
		share_diy['share'] = $('#talkInfo').val();
		//替换内容
		if( share_diy['share'] != null && share_diy['share'] !=undefined && share_diy['share'] !='')
		{
			$('#fTalk').html(share_diy['share']);
			//ajax 提交数据
			ajaxsend(share_diy);
					    
		    closeW();
		}else
		{
			alert('请说点什么吧！')
		}	    
	});
})


//关闭分享页面弹窗
function closeW()
{
	$('.talkDiv,.bg').hide();
	//$('.btns .enter').on('touchstart',function(){})
}
var s_title = '<?php echo $data['courseinfo']['title']?>';     //分享标题
var s_link = '{$share_url}';  //分享链接    
var s_imgUrl = "<?php echo $data['courseinfo']['thumb']?>";//分享图标
var s_desc = '<?php echo $data['fundinfo']['share']?>';
//ajax 提交数据
function ajaxsend(data)
{
	$.ajax({
        Type:'POST',
        dataType:'json',
        data:data,
        url:'/index.php/content/funding/ajaxSaveShare',
        success:function(r){
      	 if(r == 1)
      	 {
          	var html = data.share;
      		//将分享语句替换到隐藏域中
            $('#changeword').val(html);
            //调用函数，分享到朋友圈
            WechatshareTimeline(s_title,s_link,html,s_imgUrl);
            //调用函数，分享给朋友
            WechatshareFriend(s_title,s_link,html,s_imgUrl);
            //调用函数，分享给QQ
            WechatshareQQ(s_title,s_link,html,s_imgUrl);
            //调用函数，分享给微博
            WechatshareWeibo(s_title,s_link,html,s_imgUrl);
            //调用函数，分享给空间
            WechatshareZone(s_title,s_link,html,s_imgUrl);
      	 }
        },
	});	

}
   
</script>

<body>
<!-- 顶部锚点 -->
<input type="hidden" value="<?php echo $data['fundinfo']['share']?>" id="changeword" style = "display:none;">
<span name='top'></span>
    <!-- 固定icons 
    <div class="icons">
        <a href="#top">
            <i class="myiconfont">&#xe609;</i>
        </a>
        <a href="/index.php?a=lists&catid=7">
            <i class="myiconfont">&#xe60d;</i>
        </a>
    </div>
    -->
    <!-- 选择分享内容 -->
    <ul class="talkList">
        <li sts="0"  onclick="getword(1)">
            <div class="share">股权帮、学股权、玩社群、连接合伙人、合伙创造新物种</div>
            <i class="myiconfont checkIcon" id='talklist1' <?php if($data['fundinfo']['share']==='股权帮、学股权、玩社群、连接合伙人、合伙创造新物种'){echo '';}else{echo "style='display: none;'";}?>>&#xe634;</i>
        </li>
        <li sts="0"  onclick="getword(2)">
            <div class="share" >新物种合伙人社群股权帮，让股权成为无边界资产</div>
            <i class="myiconfont checkIcon" id='talklist2' <?php if($data['fundinfo']['share']==='新物种合伙人社群股权帮，让股权成为无边界资产'){echo '';}else{echo "style='display: none;'";}?>>&#xe634;</i>
        </li>
        <li sts="0" class="freeTalk">
        <?php if(!empty($data['fundinfo']['share']) && $data['fundinfo']['share']!=='股权帮、学股权、玩社群、连接合伙人、合伙创造新物种' && $data['fundinfo']['share'] !=='新物种合伙人社群股权帮，让股权成为无边界资产') { ?>
            <div class="checkFunding" id='fTalk'><?php echo $data['fundinfo']['share'] ?></div>
            <i class="myiconfont checkIcon">&#xe634;</i>
        <?php } else { ?>
            <div class="checkFunding" id='fTalk'>自己说点什么吧</div>
            <i class="myiconfont checkIcon" style="display: none;" id='talklist3'>&#xe634;</i>
        <?php } ?>
        </li>
    </ul>
    <!-- 输入分享内容 -->
    <div class="talkDiv">
        <div class="talkDivTitle">写点你想说的</div>
        <textarea name="" id="talkInfo" cols="30" rows="10" class="talkInfo"></textarea>
        <div class="btns">
            <div class="cancel">取消</div>
            <div class="enter" id='divOK'>确定</div>
        </div>
    </div>
    <div class="bg"></div>
    <!-- 用户信息 -->
    <div class="fundingInfo">
        <div class="userPic">
            <img src="{$data['userinfo']['userimg']}" alt="">
        </div>
        <div class="fundingRight">
            <div class="fundingTitle">{$data['userinfo']['truename']}的众筹</div>
            <div class="fundingTime">{$data['start_time']}前发起</div>
            <div class="fundingBar" num="{$data['fundinfo']['price']}">
                <div class="inBar" num="{$data['fundinfo']['total_price']}"></div>
            </div>
            <?php if($data['fundinfo']['end_time']>time() && $data['fundinfo']['status'] ==0 ) { ?>
            <i class="myiconfont fundingSts running">&#xe64f;</i>
            <?php }else if($data['fundinfo']['status'] ==1) { ?>
            <i class="myiconfont fundingSts over">&#xe633;</i>
            <?php }else { ?>
            <i class="myiconfont fundingSts late">&#xe6ca;</i>
            <?php } ?>
        </div>
    </div>
    <!-- 众筹进度 -->
    <div class="fundingDate">
        <div class="peopleNum">
            <p>支持人数</p>
            <p class="peopleTotle">{$data['count']}人</p>
        </div>
        <div class="progress">
            <p>完成进度</p>
            <p class="progressTotle"><?php echo floor($data['fundinfo']['total_price']*100/$data['fundinfo']['price'])?>%</p>
        </div>
        <div class="surplus">
            <p>剩余金额</p>
            <p class="surplusTotle"><?php echo ($data['fundinfo']['price']-$data['fundinfo']['total_price']);?>元</p>
        </div>
    </div>
    <!-- 课程详情 -->
    <div class="classInfo">
        <div class="classPic">
            <img src="{$data['courseinfo']['thumb']}" alt="">
        </div>
        <div class="classTitle">
         {$data['courseinfo']['title']}
        </div>
        <div class="describe">
            {$data['courseinfo']['description']}
        </div>
    </div>
    
    <?php if($data['fundinfo']['end_time']>time()){ 
       $res = timediff(time(),$data['fundinfo']['end_time']);
    ?>
    <!-- 倒计时 -->
    <div class="time">
        <div class="timeTitle">距离众筹结束还剩：</div>
        <div class="timeInfo">
            <span class="day"><?php echo $res['day'] ?></span>天
            <span class="hour"><?php echo $res['hour'] ?> </span>小时
            <span class="minutes"><?php echo $res['min'] ?></span>分
            <span class="second"> <?php echo $res['sec'] ?></span>秒
        </div>
        <div class="timeFooter">
            赶紧找小伙伴支持你吧！
        </div>
    </div>
    <?php } ?>
    <!-- 众筹须知 -->
    <div class="notice">
        <div class="noticeTitle">众筹须知</div>
        <ul class="noticeInfo">
            <li>1.众筹仅限本人参加众筹课程，不能更换课程；</li>
            <li>2.众筹成功因个人原因不能参加，款项不退，参课资格自动转入下一次课程；</li>
            <li>3.若众筹不成功，已筹金额将在五个工作日内原路退回（例如：4月21号开课，则所有众筹失败的活动金额，将在21号往后5个工作日内陆续返还）；</li>
            <li>4.如有任何问题可参考<a href="http://<?php echo $_SERVER['HTTP_HOST']?>/statics/zc/help.html">《众筹活动规则》</a>，若仍有疑问可拨打咨询热线<a href="tel:4000279828">400-027-9828</a></li>
        </ul>
    </div>
    <!-- 评论 -->
    <div class="comment">
        <div class="commentTitle">已有{$data['count']}人支持</div>
        <ul>
        <?php foreach($data['replay'] as $v) {?>
            <li>
                <div class="commentPic">
                    <img src="<?php echo $v['userimg']?>" alt="">
                </div>
                <div class="commentInfo">
                    <div class="commentName"><?php echo $v['truename']?></div>
                    <?php if(getTime($v['msg_time']) == '刚刚') { ?>
                    <div class="commentTime"><?php echo getTime($v['msg_time'])?></div>
                    <?php }else{?>
                    <div class="commentTime"><?php echo getTime($v['msg_time'])?>前</div>
                    <?php } ?>
                    <div class="commentContent">
                        <?php echo $v['message']?>
                    </div>
                    <div class="commentPrice">
                                       付款<?php echo $v['money']?>元
                    </div>
                    <?php if(empty($v['reply'])) { ?>
                    <div class="commentBtn" id="Replaydiv<?php echo $v['id']?>">
                        <div class="replyBtn" id="replayword" value="<?php echo $v['id']?>">回复</div>
                        <input type="hidden" value="<?php echo $v['id']?>" id='replayid'>
                    </div>
                    <?php }else{ ?>
                     <div class="replyDiv" id='replyDiv'>发起人回复：<?php echo $v['reply']?>
                    </div>
                    <?php } ?>
                </div>
            </li>
            
       <?php } ?>
        </ul>
    </div>
    <!-- 回复评论 -->
    <!-- 输入分享内容 -->
    <div class="AddReply">
        <div class="AddReplyTitle">写点你想说的</div>
        <textarea name="" id="AddReplyInfo" cols="30" rows="10" class="AddReplyInfo"></textarea>
        <div class="replyBtns">
            <div class="cancel">取消</div>
            <div class="enter" id="replayOk">确定</div>           
        </div>
    </div>
    <div class="replyBg"></div>
    
    <!-- 找人众筹的弹出分享层 -->
    <div class="shareBg">
        <div class="sharePic">
            <img src="/statics/zc/images/fx.png">
        </div>
    </div>
    
    <!-- 按钮 -->
    <?php if($data['fundinfo']['status']== '1' || $data['fundinfo']['status']== '-1') { ?>
    <div class="myFundingBtns">
        <div class="myFunding">
            <a href="/index.php?m=User&a=zc">我的众筹</a>
        </div>
    </div>
    <?php }else{ ?>
    <div class="myFundingBtns">
        <div class="supportMyself">
            <a href="/index.php/Content/WeixinPay/confirm_zcorder.html?funding_id=<?php echo $data['fundinfo']['id']?>">自己支持</a> 
        </div>
        <div class="findSupport">
            <a href="javascript:void(0)">找人众筹</a>
        </div>
        <div class="myFunding">
            <a href="/index.php?m=User&a=zc">我的众筹</a>
        </div>
    </div>
    <?php } ?>
    <!-- foote开始 -->
    <template file="Content/new_footer.php"/> 
    
<input type='hidden' value="{$data.fundinfo.id}" id='fundid'>
<input type='hidden' value="<?php echo ($data['fundinfo']['end_time']-time()) ?>" id='fundtime'>
<input type="hidden" value="{$signature}" id="signature" />

</body>
<script type = "text/javascript">
var begin = $('#fundtime').val();
//倒计时方法
var intDiff = parseInt(begin); //倒计时总秒数量
function timer(intDiff) {
    window.setInterval(function() {
        var day = 0,
            hour = 0,
            minute = 0,
            second = 0; //时间默认值
        if (intDiff > 0) {
            day = Math.floor(intDiff / (60 * 60 * 24));
            hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
            minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
            second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
        }
        if (minute <= 9) minute = '0' + minute;
        if (second <= 9) second = '0' + second;
        $('.timeInfo .day').html(day);
        $('.timeInfo .hour').html('<s id="h"></s>' + hour);
        $('.timeInfo .minutes').html('<s></s>' + minute);
        $('.timeInfo .second').html('<s></s>' + second);
        intDiff--;
    }, 1000);
}

//关闭回复页面弹窗
function closeR()
{
	$('.AddReply,.replyBg').hide();
	//$('.btns .enter').on('touchstart',function(){})
}
$(".replyBtn").on("touchstart",function(){
	$(".AddReply").show(),$(".replyBg").show();
	var id = $(this).attr('value');
	$('#replayOk').val(id);
});
//回复提交
	$('#replayOk').on("touchstart",function(){
		var id = $('#replayOk').val();
		var replay = new Object();
		replay['id'] =id ;
		replay['reply'] = $('#AddReplyInfo').val();
		var idstr = '#Replaydiv'+replay['id'];
		//替换内容
		if( replay['reply'] != null && replay['reply'] !=undefined && replay['reply'] !='')
		{
			//替换内容
			var html ='';
			html += "<div class='replyDiv' id='replyDiv'>";
      　　　　  html  += "发起人回复:"+replay['reply']+"</div>";
      　　　　  $(idstr).replaceWith(html);
			//ajax 提交数据
			$.ajax({
                Type:'POST',
                dataType:'json',
                data:replay,
                url:'/index.php/content/funding/ajaxSavereplay',
                success:function(r){
      	           if(r==1)
      	            {
      		            alert('回复成功！');
      	            }
                },
	        });	    
		    closeR();
		}else
		{
			alert('回复不能为空');
			return false;
		}	    
	});

</script>
<!--微信分享-->

<script type="text/javascript">

var time = <?php echo $time; ?>;
var jsapi_ticket = '<?php echo $jsapi_ticket; ?>';
var url = window.location.href;
var signature = $("#signature").val();
wx.config({
	debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
	appId: '<?php echo $appid?>', // 必填，公众号的唯一标识
	timestamp: time, // 必填，生成签名的时间戳
	nonceStr: 'BogLeUnion', // 必填，生成签名的随机串
	signature: signature,// 必填，签名，见附录1
	jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareWeibo','onMenuShareQZone'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
});

function WechatshareTimeline(s_title,s_link,s_desc,s_imgUrl){
	//分享到朋友圈
    wx.onMenuShareTimeline({
     title: s_title, // 分享标题
     link: s_link, // 分享链接
     imgUrl: s_imgUrl, // 分享图标
     success: function () { 
	    alert('分享成功！');
     },
     cancel: function () { 
     // 用户取消分享后执行的回调函数
		alert("您已取消分享！");
    }
   });
}

function WechatshareFriend(s_title,s_link,s_desc,s_imgUrl){
//分享给朋友
 wx.onMenuShareAppMessage({
 title: s_title, // 分享标题
 desc: s_desc, // 分享描述
 link: s_link, // 分享链接
 imgUrl: s_imgUrl, // 分享图标
 type: '', // 分享类型,music、video或link，不填默认为link
 dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
 success: function () { 
	 alert('分享成功！');
 },
 cancel: function () { 
     // 用户取消分享后执行的回调函数
		alert("您已取消分享！");
 }	
 });
}

function WechatshareQQ(s_title,s_link,s_desc,s_imgUrl){
//分享到QQ
 wx.onMenuShareQQ({
 title: s_title, // 分享标题
 desc: s_desc, // 分享描述
 link: s_link, // 分享链接
 imgUrl: s_imgUrl, // 分享图标
 success: function () { 
	 alert('分享成功！');
 },
 cancel: function () { 
    alert("您已取消分享！");
 } 
 });
}

function WechatshareWeibo(s_title,s_link,s_desc,s_imgUrl){
//分享到腾讯微博
wx.onMenuShareWeibo({
 title: s_title, // 分享标题
 desc: s_desc, // 分享描述
 link: s_link, // 分享链接
 imgUrl: s_imgUrl, // 分享图标
 success: function () { 
    alert('分享成功！');
 },
 cancel: function () { 
    alert("您已取消分享！");
 }
});
}

function WechatshareZone(s_title,s_link,s_desc,s_imgUrl){
//分享到QQ空间
wx.onMenuShareQZone({
 title: s_title, // 分享标题
 desc: s_desc, // 分享描述
 link: s_link, // 分享链接
 imgUrl: s_imgUrl, // 分享图标
 success: function (){ 
	 alert('分享成功！');
 },
 cancel: function (){ 
     alert("您已取消分享！");
 }

});
}

//页面加载完毕就执行
wx.ready(function (){
	var d_title = '<?php echo $data['courseinfo']['title']?>';     //分享标题
	var d_link = '{$share_url}';  //分享链接    
	var d_imgUrl = "<?php echo $data['courseinfo']['thumb']?>";//分享图标
	var d_desc = '<?php echo $data['fundinfo']['share']?>';
	WechatshareTimeline(d_title,d_link,d_desc,d_imgUrl);
	WechatshareFriend(d_title,d_link,d_desc,d_imgUrl);
	WechatshareQQ(d_title,d_link,d_desc,d_imgUrl);
	WechatshareWeibo(d_title,d_link,d_desc,d_imgUrl);
	WechatshareZone(d_title,d_link,d_desc,d_imgUrl);
});

</script>
</html>
