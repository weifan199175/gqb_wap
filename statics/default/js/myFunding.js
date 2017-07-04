
// 进度条
function progress(){
	var totle = $(".fundingInfo .fundingBar").attr("num");
    var num = $(".fundingInfo .inBar").attr("num");
    var percent = num / totle;
    percent=percent*100+"%";
    var totleW = $(".fundingInfo .fundingBar").width();
    $(".fundingInfo .inBar").width(0);

    $(".fundingInfo .inBar").stop(true,true).animate({ width: percent }, 1500);
}
$(function() {
    // 分享内容切换效果
    $(".talkList li").on("touchstart", function() {
        var sts = $(this).attr("sts");
        if (sts == 0) {
            $(this).find('.checkIcon').show();
            $(this).siblings('li').find('.checkIcon').hide();
            $(this).attr('sts', '1');
            $(this).siblings('li').attr('sts', '0');
        } else {
            $(this).attr('sts', '0');
        }
    });
    $(".freeTalk").on("touchstart", function() {
        $(".talkDiv").show();
        $(".bg").show();
    });
    $(".talkDiv .cancel").on("touchstart", function() {
        $(".talkDiv").hide();
        $(".bg").hide();
    });
    $(".talkDiv .enter").on("touchstart",function(){
        $(".talkDiv,.bg").hide();
    });
    // 倒计时
    timer(intDiff);

    // 回复评论
    $(".replyBtn").on("touchstart", function() {
        $(".AddReply").show();
        $(".replyBg").show();
    });
    $(".AddReply .cancel").on("touchstart", function() {
        $(".AddReply").hide();
        $(".replyBg").hide();
    });
    
    // 众筹进度条
    progress();
    // setTimeout("progress()",800);
});
