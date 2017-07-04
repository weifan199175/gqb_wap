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
    <link rel="stylesheet" href="/statics/default/css/learn.css">
    <title><if condition=" isset($SEO['title']) && !empty($SEO['title']) ">{$SEO['title']}</if>{$SEO['site_title']}</title>
</head>
<body class="um-vp" style="background: #f4f4f4;">
<!-- c -->
<div class="cBox"> 
    <!-- 学股权-股权视频 -->
    <div class="ub ub-ver videokBox">
        <if condition="$catid eq 27">
		<template file="Content/hehuo_header.php"/>
		<else />
        <template file="Content/guquan_header.php"/>
		</if>
        <div class="videoList ub ub-ver">

            <get sql="SELECT * FROM jbr_video where status=99 and catid=$catid  ORDER BY id desc" >
                <ul class="ub ub-ver ub-f1" >
                    <volist name="data" id="vo">
                    <?php
                        $rbc_id = M('video')->where('id='.$vo['id'])->getField('authority');
                        $rbc = M('video_type')->where('id='.$rbc_id)->find();
                        $rbc['desc'] = str_replace("+","/",$rbc['desc']);
                        if($vo['is_live']==1){
                            $vo['live_desc']='直播';
                        }else{
							$vo['live_desc']='视频';
						}              
                    ?>
                       
                    <!-- 非直播 -->
                    <li class=" ub uinn5 ubb ubt ubb-d bgc">
                        <a class="ub ub-ver ub-f1" href="javascript:void(0);" onclick='get_video("{$vo['authority']}","{$vo['id']}","{$rbc['score']}");' >
						<if condition="$vo['is_live'] eq 1">
                            <div class="title ub">【{$vo.live_desc}】{$vo.title}-{$vo.start_time|date="Y-m-d",###}开播</div>
						<else />
						    <div class="title ub">【{$vo.live_desc}】{$vo.title}</div>
                        </if>						
                                <div class="img ub ub-ac ub-pc ub-f1">
                                    <img src="{$vo.thumb}" />
                                    <div class="bgup ub ub-ac ub-pc">
                                        <span class="ub iconfont icon-shipin"></span>
                                    </div>
                                </div>
                            <div class="vInfo ub ub-f1">
                                <div class="name ub"><span class="tx-c4 iconfont icon-ren1"></span><i>{$vo.source}</i></div>
                                <div class="time ub"><span class="tx-c4 iconfont icon-shijian"></span><i class="tx-c8">{$vo.updatetime|date="Y-m-d",###}</i></div>
                                <div class="number ub ub-ac"><span class="ub-ac tx-c4 iconfont icon-yanjing1"></span><i class="ub ub-ac tx-c8">{$vo.views}</i></div>
                                <div class="info ub ub-ver ub-f1">
                                <if condition="$rbc['score'] gt 0">
                                    <!-- 对于非开发人群需要积分 -->
                                    <div class="ub ub-pe tx-cog2">{$vo['live_desc']}需支付{$rbc['score']}积分</div>
                                    <div class="ub ub-pe tx-cog2">({$rbc['desc']}免费)</div>
                                <else/>
                                <!-- 不需要积分，该视频免费 -->
                                <div class="ub ub-pe tx-cog2">{$vo['live_desc']}免费</div>
                                </if>
                                </div>
                            </div>                            
                        </a>
                    </li>
                    </volist>                           
                </ul>
            </get> 
              
            <a class="checkMore ub ub-ac ub-pc uinn ulev-1 tx-c8 more" href="javascript:;" onClick="content_new.loadMore();">点击查看更多>></a>
                    
        </div>              
    </div>
    <!-- /学股权-股权视频-->
     <!-- 页脚 -->
      <template file="Content/footer.php"/>    
     <!-- /页脚 -->

</div>
<!-- /c -->

<!--弹出层-->
<div class="PopUp uc-a3">
    <div class="PopUp_box ub ub-ver ub">
       <div class="contUp ub" id="t1">
            您好！请登录，谢谢！
       </div>
       <a class="btn ub uinn" href="javascript:void(0);">
            <div class="callbtn ub ub-f1 ub-ac ub-pc tx-cf uc-a3 uinn7 bg-red ulev0" id="t2">                
                登录
            </div>
        </a>
    </div>
</div>
<!--/弹出层-->

<!-- jQuery 遮罩层 -->
<div class="fullbg"></div>
<!-- end jQuery 遮罩层 -->



</body>
<script type="text/javascript" src="/statics/default/js/jquery.js"></script>
<!-- 弹出层 -->
<script src="/statics/default/js/ff.js" type="text/javascript"></script>
<script type="text/javascript">
    //点击加载更多
    var _content = []; //临时存储li循环内容
    var content_new = {
      _default:5, //默认显示个数
      _loading:5,  //每次点击按钮后加载的个数
      init:function(){
        var lis = $(".videoList ul li");
        $(".videoList ul").html("");
        for(var n=0;n<content_new._default;n++){
          lis.eq(n).appendTo(".videoList ul");
        }
        
        for(var i=content_new._default;i<lis.length;i++){
          _content.push(lis.eq(i));
        }
      
      },
      loadMore:function(){
        var mLis = $(".videoList ul li").length;
        for(var i =0;i<content_new._loading;i++){
          var target = _content.shift();
          if(!target){
            $('.videoList .more').html("<p>全部加载完毕...</p>");
            break;
          }
          $(".videoList ul").append(target);
          $(".videoList ul li").eq(mLis+i).each(function(){
            
          });
        }
      }
    }
    content_new.init();   
</script>
<script type="text/javascript">
$(function(){
    $(".fullbg").click(function(){
        $(".PopUp").animate({opacity:"hide"},100);
        $(".fullbg").hide();
    })
})

function pay_score(video_id){
    $.post("/index.php?m=Video&a=pay_score", {'video_id':video_id}, function (r){
               
        if(r==0){
            alert('积分支付成功');
            window.location.href='/index.php?a=shows&catid=6&id='+video_id;
        }else if(r==2){
            alert('您的可用积分不足以观看此视频，请立即充值积分以便观看，谢谢！');
            return false;
        }else{
            alert("积分支付失败");
            return false;
        }
        
    },'json');
}
function get_video(authority,video_id,score){
    //  异步判断是否观看
    var flag = 0;
    $.post("/index.php?m=Video&a=iscan_see", {'authority':authority,'video_id':video_id}, function (info){
                if(info.code==0){
                    window.location.href='/index.php?a=shows&catid=6&id='+video_id;
                }else if(info.code==1){
                    if(confirm('是否需要支付积分观看,需支付'+score+'个积分？')){
                      pay_score(video_id);
                    }else{
                        return false;
                    }

                }else{
                    // 错误信息提示
                    $("#t1").html(info.msg);
                    $("#t2").html("立即登录");
                    $(".PopUp").animate({opacity:"show"},300);
                    $(".fullbg").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"block"});
                    
                    $("#t2").click(function(){
                        $(".PopUp").animate({opacity:"hide"},300);
                        $(".fullbg").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"none"});     
                        window.location.href='/index.php?m=User&a=index';
                    })
                }
        
        },'json');
}
</script>
<!-- /弹出层 -->
</html>