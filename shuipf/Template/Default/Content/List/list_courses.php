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
    <title><if condition=" isset($SEO['title']) && !empty($SEO['title']) ">{$SEO['title']}</if>{$SEO['site_title']}</title>
</head>
<body class="um-vp" style="background: #f4f4f4;">
<!-- c -->
<div class="sBox"> 
    <!-- 社员服务 -->
    <div class="ub ub-ver UPmemberBox">
       
        <!-- banner -->
        <div class="banner swiper-container">
            <div class="swiper-wrapper">
                <content action="lists" catid="18" order="listorder DESC" moreinfo="1">
				<volist name="data" id="vo">
					<div class="swiper-slide"><a <if condition="$vo['islink'] eq 1">href="{$vo.url}"<else />href="javascript:;"</if>><img src="{$vo.img}" alt=""></a></div>
				</volist>
				</content>	
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
        </div>
        <!-- /banner -->
		
		 <!-- nav -->
            <template file="Content/service_header.php"/>
        <!-- /nav -->
		
        <!-- 最新课程 -->
        <div class="classBox">
        <content action="lists" catid="$catid"  order="updatetime DESC,listorder DESC">   
                <ul class="classList">
                    <volist name="data" id="vo">
                        <li class="ub ubb ubt ubb-d uinn">
                            <a class="ub ub-f1" href="{$vo.url}">
                                <div class="img ub ub-ac uof"><img src="{$vo.thumb}" alt=""></div>
                                <div class="con ub ub-f1 ub-ver">
                                    <h5 class="ub umar-b tx-c2 uof">{$vo.title}</h5>
                                    <div class="info ub tx-cred">
                                        <span class="ub ub-ac iconfont icon-boshimao-copy"></span>
                                        <em class="ub ub-ac">讲师：<i>{$vo.teacher}</i></em>
                                    </div> 
                                    <div class="info ub">
                                        <span class="ub tx-c4 iconfont icon-shijian"></span>
                                        <em class="ub ub-ac tx-c8">时间：<i>{$vo.start_time|date="Y年m月d日",###}-{$vo.end_time|date="d",###}日</i></em>
                                    </div>
                                    <div class="info ub">
                                        <span class="ub tx-c4 iconfont icon-xiao31"></span>
                                        <em class="ub tx-c8 ub-ac">地点：<i>{$vo.city}</i></em>
                                    </div>
                                    <?php
									    //$_SESSION['userid'] = 1;
                                        //查询是否报名
                                        $res=M('order')->where(array('member_id' =>$_SESSION['userid'] ,'product_id'=>$vo['id'] ))->find();
                                         
                                    ?>
                                    <div class="info ub">
                                        <span class="ub tx-c4 iconfont icon-ren1"></span>
                                        <em class="ub tx-c8 ub-ac">名额：<i><em class
                                        ="tx-red">{$vo.enter_num}</em> / {$vo.max_num}</i></em>
                                    </div>
									<?php  if(time()>$vo['end_time']){ ?>
                                        <div class="bmbtn ub ub-ac ub-pc uba uc-a1 tx-a">已结束</div>
									<?php }else if(time()>=$vo['start_time'] && time()<=$vo['end_time']){ ?>
									    <div class="bmbtn ub ub-ac ub-pc uba uc-a1 tx-a">进行中</div>
                                    <?php }else if($vo['enter_num'] >= $vo['max_num']){ ?>
                                        <div class="bmbtn ub ub-ac ub-pc uba uc-a1 tx-a">名额已满</div>
                                     <?php }else if($res['status']>=1){?>
                                        <div class="bmbtn ub ub-ac ub-pc uba uc-a1 tx-a">已报名</div>
									<?php }else{ ?>	
									    <div class="click_upOut  bmbtn ub ub-ac ub-pc uba uc-a1 tx-cgn">申请报名</div>
                                    <?php } ?>
                                </div>
                            </a>
                        </li>
                    </volist>    
                </ul>
            </content>  

            <a class="checkMore ub ub-ac ub-pc uinn ulev-1 tx-c8 more" href="javascript:;" onClick="content_new.loadMore();">点击查看更多>></a>
                     
        </div>
        <!-- /最新课程 -->                               
    </div>
    <!-- /社员服务-->
    <!-- 页脚 -->
     <template file="Content/footer.php"/>     
    <!-- /页脚 -->
</div>
<!-- /c -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery.js"></script>
<script type="text/javascript" src="/statics/default/js/swiper.min.js"></script>
<script type="text/javascript">
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true
    });

      //点击加载更多
    var _content = []; //临时存储li循环内容
    var content_new = {
      _default:5, //默认显示个数
      _loading:5,  //每次点击按钮后加载的个数
      init:function(){
        var lis = $(".classBox ul li");
        $(".classBox ul").html("");
        for(var n=0;n<content_new._default;n++){
          lis.eq(n).appendTo(".classBox ul");
        }
        
        for(var i=content_new._default;i<lis.length;i++){
          _content.push(lis.eq(i));
        }
      
      },
      loadMore:function(){
        var mLis = $(".classBox ul li").length;
        for(var i =0;i<content_new._loading;i++){
          var target = _content.shift();
          if(!target){
            $('.classBox .more').html("<p>全部加载完毕...</p>");
            break;
          }
          $(".classBox ul").append(target);
          $(".classBox ul li").eq(mLis+i).each(function(){
            
          });
        }
      }
    }
    content_new.init(); 
</script>
</html>