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
    <link rel="stylesheet" href="/statics/default/css/date.css" type="text/css" />
    <title>股权帮个人中心 我的-积分明细</title>
    <script type="text/javascript" src="/statics/default/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="/statics/default/js/date.js" ></script>
    <script type="text/javascript" src="/statics/default/js/iscroll.js" ></script>
    <script type="text/javascript">
        $(function(){
            $('#beginTime').date();
            $('#endTime').date({theme:"1"});
        });
    </script>
</head>
<body class="um-vp" style="background:#f4f4f4;">
<!-- c --> 
<div class="cBox" style="background:#f4f4f4;">
    <!-- 我的积分 -->
    <div class="ub ub-ver mySoreBox">       
        
        <template file="Content/score_header.php" />

            <form action="">
                <div class="timeChose uba ub ub-f1 ubb-d bgc umar-b uinn5">
                    <input id="beginTime" name="beginTime" value="" class="kbtn ub ub-f1 uba ubb-d" placeholder="开始时间" />
                    <input id="endTime" name="endTime" value="" class="kbtn ub ub-f1 uba ubb-d" placeholder="结束时间" />
                    <div class="searchBT uinput  ub ub-ac ub-pc"><input class="tx-cf" type="button" name="button" onclick="chaxun();" value="查询"></div> 
                </div>
            </form>
                        
<script type="text/javascript">
    //查询时间范围内的积分明细
function chaxun(){
    var beginTime = $('#beginTime').val();
    var endTime = $('#endTime').val();
    //alert(endTime);return false;
    //alert(1);
    $.ajax({
       type: "POST",
       url: "/index.php?m=User&a=chaxun",
       data: "&beginTime="+beginTime+"&endTime="+endTime,
       dataType: "json",
       success: function(msg){
       // alert(2);
                if(msg===null){
                //alert(4);
                    $('.List').children().remove();
                    $('.List').append('<h1 style="text-align:center;">这段时间里没有积分明细</h1>');
                }else{
                //alert(3);
                    //alert(msg[0]);return false;
                    var q = '';
                    q+='<ul class="ub ub-ver">';
                    for(var i=0;i<msg.length;i++){
                        q+='<li class="bgc ubb ubt ubb-d">';
                           q+='<div class="con ub ubb ubb-d">';
                                q+='<div class="left ub ub-ver">';
                                    q+='<h5 class="ub">'+msg[i].source+'</h5>';
                                    q+='<div class="info ub tx-c8">';
                                            q+='<div class="name ub">'+msg[i].truename+'</div>';  
                                            q+='<div class="level ub">'+msg[i].class_name+'</div>'; 
                                            q+='<div class="time ub">'+msg[i].addtime.substr(0,10)+'</div>';
                                    q+='</div>';
                                q+='</div>';
                                q+='<div class="right ub ub-ver ub-f1">';
                                    q+='<div class="money ub ub-pe">';
                                        if(msg[i].score_type=="兑换消费"){
                                            q+='<b class="tx-red">'+msg[i].score+'</b>';
                                        }else{
                                            q+='<b class="tx-cgn">'+msg[i].score+'</b>';
                                        }
                                        
                                    q+='</div>';
                                    q+='<div class="tt ub tx-c8 ub-pe">'+msg[i].score_type+'</div>';
                                q+='</div>';
                            q+='</div>';
                        q+='</li>';
                    }
                    q+='</ul>';

                    $('.List').children().remove();
                    $('.List').append(q);
                }
           }
        });
    
    return false;
}    
</script>
			<div id="datePlugin"></div>
            <div class="List">
				<div class="hidden">    
					<volist name="list" id="vo">
						<li class="bgc ubb ubt ubb-d">
							<div class="con ub ubb ubb-d">
								<div class="left ub ub-ver">
									<h5 class="ub">{$vo['source']}</h5>
									<div class="info ub tx-c8">
											<div class="name ub">{$vo.truename}</div>  
											<div class="level ub">{$vo.class_name}</div>
											<div class="time ub"><?php echo substr($vo['addtime'],0,10)?></div>
									</div>
								</div>
								<div class="right ub ub-ver ub-f1">
									<div class="money ub ub-pe">
										<b <if condition="$vo['score_type'] eq '兑换消费'">class="tx-red"<else />class="tx-cgn"</if> >{$vo.score}</b>
									</div>
									<div class="tt ub tx-c8 ub-pe">{$vo.score_type}</div>
								</div>
							</div>
						</li>
					</volist>   
				</div>
            <ul class="ub ub-ver lists"></ul>
			<if condition="(count($list)) elt 5">
					<li class="checkMore ub ub-ac ub-pc uinn ulev-1 tx-c8 more" href="javascript:;">全部加载完毕...</li>
			<else/>
				<a class="checkMore ub ub-ac ub-pc uinn ulev-1 tx-c8 more" href="javascript:;" onClick="content_new.loadMore();">点击查看更多>></a>
			</if>
        </div>              
    </div>
    <!-- /我的积分 -->
</div>
<!-- /c -->
    <!-- 页脚 -->
    
        <template file="Content/footer.php"/> 
     
    <!-- /页脚 -->
</body>
<script type="text/javascript">
    //点击加载更多
    var _content = []; //临时存储li循环内容
    var content_new = {
      _default:5, //默认显示个数
      _loading:5,  //每次点击按钮后加载的个数
      init:function(){
        var lis = $(".List .hidden li");
        $(".List ul.lists").html("");
        for(var n=0;n<content_new._default;n++){
          lis.eq(n).appendTo(".List ul.lists");
        }
        
        for(var i=content_new._default;i<lis.length;i++){
          _content.push(lis.eq(i));
        }
        $(".List .hidden").html("");
      },
      loadMore:function(){
        var mLis = $(".List ul.lists li").length;
        for(var i =0;i<content_new._loading;i++){
          var target = _content.shift();
          if(!target){
            $('.List .more').html("<p>全部加载完毕...</p>");
            break;
          }
          $(".List ul.lists").append(target);
          $(".List ul.lists li").eq(mLis+i).each(function(){
            
          });
        }
      }
    }
    content_new.init();   
</script>

<script type="text/javascript">
$(function(){
    $('#beginTime').date();
    $('#endTime').date();
});
</script>
</html>