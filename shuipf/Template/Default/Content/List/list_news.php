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
    <!-- 学股权-文章列表 -->
    <div class="ub ub-ver learnStkBox">
        
            <template file="Content/guquan_header.php"/>
            <div class="learnList ub ub-ver bgc">
            <div class="hidden">
                <content action="lists" catid="$catid"  order="updatetime DESC,listorder DESC">
                        <volist name="data" id="vo">
                            <li class="ub uinn ubb ubt ubb-d">
                                <a class="ub ub-f1" href="{$vo.url}">
                                    <div class="img ub"><img src="{$vo.thumb}" alt=""></div>
                                    <div class="ub ub-ver ub-f1">
                                        <div class="tit ub">{$vo.title|str_cut=###,30}</div>
                                        <div class="info ub ub-ac">
                                        <if condition="$vo['article_type'] eq '原创文章'">
                                            <div class="cls ub tx-cblu">{$vo.article_type}</div>
                                        <elseif condition="$vo['article_type'] eq '课程总结'" />
                                            <div class="cls ub tx-cgn">{$vo.article_type}</div>
                                        <elseif condition="$vo['article_type'] eq '热点时评'" />
                                            <div class="cls ub tx-cred">{$vo.article_type}</div>
                                        </if>
                                            <div class="time ub"><span class="tx-c4 iconfont icon-shijian"></span><i class="tx-c8">{$vo.updatetime|date="Y-m-d",###}</i></div>
                                            <div class="number ub ub-ac"><span class="tx-c4 iconfont icon-yanjing1"></span><i class="ub ub-ac tx-c8">{$vo.views}</i></div>
                                        </div>
                                    </div>
                                </a>
                            </li>
							
                        </volist>
                </content>
            </div>
                <ul class="ub ub-ver ub-f1 lists"></ul>
				<if condition="(count($data)) elt 5">
				<li class="checkMore ub ub-ac ub-pc uinn ulev-1 tx-c8 more" href="javascript:;">全部加载完毕...</li>
				<else/>
                <a class="checkMore ub ub-ac ub-pc uinn ulev-1 tx-c8 more" href="javascript:;" onClick="content_new.loadMore();">点击查看更多>></a>
				</if>
        </div>
       
        <!--分页-->
        <div class="asppage24 ub">
            <div class="pager">
                {$pages}
            </div>
        </div>
        <div class=" clear"></div>
        <!--/分页-->                
    </div>
    <!-- /学股权-文章列表-->
     <!-- 页脚 -->
        <template file="Content/footer.php"/>     
    <!-- /页脚 -->

</div>
<!-- /c -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery.js"></script>

<script type="text/javascript">
    //点击加载更多
    var _content = []; //临时存储li循环内容
    var content_new = {
      _default:5, //默认显示个数
      _loading:5,  //每次点击按钮后加载的个数
      init:function(){
        var lis = $(".learnList .hidden li");
        $(".learnList ul.lists").html("");
        for(var n=0;n<content_new._default;n++){
          lis.eq(n).appendTo(".learnList ul.lists");
        }
        
        for(var i=content_new._default;i<lis.length;i++){
          _content.push(lis.eq(i));
        }
        $(".learnList .hidden").html("");
      },
      loadMore:function(){
        var mLis = $(".learnList ul.lists li").length;
        for(var i =0;i<content_new._loading;i++){
          var target = _content.shift();
          if(!target){
            $('.learnList .more').html("<p>全部加载完毕...</p>");
            break;
          }
          $(".learnList ul.lists").append(target);
          $(".learnList ul.lists li").eq(mLis+i).each(function(){
            
          });
        }
      }
    }
    content_new.init();   
</script>

</html>