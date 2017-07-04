<!DOCTYPE html>
<html class="um landscape min-width-240px min-width-320px min-width-480px min-width-768px min-width-1024px">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
	<meta name="Keywords" content="{$SEO['keyword']}" />
    <meta name="Description" content="{$SEO['description']}" />
    <meta property="wb:webmaster" content="a8c667bdecd31dce" />
    <link rel="stylesheet" href="/statics/default/css/public.css">
    <link rel="stylesheet" href="/statics/default/css/ui-box.css">
    <link rel="stylesheet" href="/statics/default/css/ui-base.css">
    <link rel="stylesheet" href="/statics/default/css/ui-color.css">
    <link rel="stylesheet" href="/statics/default/css/appcan.control.css">
    <link rel="stylesheet" href="/statics/default/css/iconfont/iconfont.css">
    <script type="text/javascript" src="/statics/default/js/swiper.min.js"></script>
    <link rel="stylesheet" href="/statics/default/css/swiper.min.css">
    <script type="text/javascript" src="/statics/default/js/fastclick.js"></script>
    <link rel="stylesheet" href="/statics/default/css/index.css">
    <title><if condition=" isset($SEO['title']) && !empty($SEO['title']) ">{$SEO['title']}</if>{$SEO['site_title']}</title>
</head>

<body style="background-color: #f4f4f4;">
    <!-- banner -->
    <!--<div class="banner swiper-container">
        <div class="swiper-wrapper">
		<content action="lists" catid="18" order="listorder DESC" moreinfo="1">
		<volist name="data" id="vo">
            <div class="swiper-slide">
            <a <if condition="$vo['islink'] eq 1">href="{$vo.url}"<else />href="javascript:;"</if>><img src="{$vo.img}" alt=""></a></div>
		</volist>
		</content>	
       
        </div>
        //Add Pagination
        <div class="swiper-pagination"></div>
    </div>-->
    <div class="banner swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
            <a href="javascript:;"><img src="/statics/default/images/banner0623.jpg" alt=""></a></div>      
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
    <!-- /banner -->
 
 
    <!-- nav -->
    <div class="navBox ub ubb ub-cd">
        <div class="nav ub ubr ub-cd uinn">
            <a class="ub ub-f1 ub-ver ub-ac ub-pc" href="{:getCategory(7,'url')}">
                <span class="ub tx-cblu iconfont icon-zhishichanquanguanli"></span>
                <div class="ub tx-c2">课程中心</div>
            </a>
        </div>
        <div class="nav ub ubr ub-cd uinn">
            <a class="ub ub-f1 ub-ver ub-ac ub-pc" href="{:getCategory(6,'url')}">
                <span class="ub tx-cred iconfont icon-wsmp-equityout"></span>
                <div class="ub tx-c2">学股权</div>
            </a>
        </div>
		<div class="nav ub ubr ub-cd uinn">
            <a class="ub ub-f1 ub-ver ub-ac ub-pc" href="{:getCategory(16,'url')}">
                <span class="ub tx-cog iconfont icon-huiyuanfuwu"></span>
                <div class="ub tx-c2">铁杆社员</div>
            </a>
        </div>
        
        
        <if condition="$_SESSION['userid'] neq ''">
            <div class="nav ub ubr ub-cd uinn">
                <a class="ub ub-f1 ub-ver ub-ac ub-pc" href="/index.php?m=User&a=task">
                    <span class="ub tx-cgn iconfont icon-woderenwu color-bl2"></span>
                    <div class="ub tx-c2">我的任务</div>
                </a>
            </div>
        <else />
            <div class="nav ub ubr ub-cd uinn">
                <a class="ub ub-f1 ub-ver ub-ac ub-pc" href="/index.php?m=User&a=index">
                    <span class="ub tx-cgn iconfont icon-zhuce-copy"></span>
                    <div class="ub tx-c2">注册</div>
                    
                </a>
            </div>
        </if>
    </div>
    <!-- /nav -->

   

    <!-- 股权资讯 -->
    <div class="stockNewsBox">
	  
        <a class="title ub ubt ubb ub-cd uinn5" href="{:getCategory(19,'url')}">
            <div class="ub ub-f1 ulev0">
                <span class="ub ub-ac tx-cred iconfont icon-juxing184"></span>
                <em class="tx-c2">今日焦点</em>
            </div>
            <div class="more ub tx-c4">
                <em class="ub ub-ac">更多</em>
                <span class="ub ub-ac iconfont icon-jiantou"></span>
            </div>
        </a>
		
        <ul class="stockNewsList">
		<position action="position" posid="5" num="2" return="data">		
		<volist name="data" id="vo">
            <li class="ub ubb ub-cd uinn">
                <a class="ub ub-f1" href="{$vo.data.url}">
                    <div class="img ub ub-ac uof">
                        <img src="{$vo.data.thumb}" alt="">
                    </div>
                    <div class="con ub ub-f1 ub-ver">
                        <h5 class="tx-c2 uof">{$vo.data.title}</h5>
                        <div class="info ub">
                            <span class="time ub ub-ac tx-c8">{$vo.data.updatetime|date="Y.m.d",###}</span>
                            <div class="number ub ub-ac tx-c8"><em class="ub ub-ac iconfont icon-yanjing"></em><span><?php echo zhh($vo['id']); ?></span></div>
                        </div>                         
                    </div>
                </a>
            </li>
        </volist>
		</position>
		
        </ul>
    </div>
    <!-- /股权资讯 -->

	 <!-- 精选课程 -->
    <div class="classBox">  
   
        <a class="title ub ubt ubb ub-cd uinn5" href="{:getCategory(7,'url')}">
            <div class="ub ub-f1 ulev0">
                <span class="ub ub-ac tx-cred iconfont icon-juxing184"></span>
                <em class="tx-c2">精选课程</em>
            </div>
            <div class="more ub tx-c4">
                <em class="ub ub-ac">更多</em>
                <span class="ub ub-ac iconfont icon-jiantou"></span>
            </div>
        </a>
	
        <ul class="classList topLine">
        <!--股权博弈最新课程一门-->
        <content action="lists" catid="13" num="1" return="data" order='start_time DESC'>		
		<volist name="data" id="vo">
            <li class="ub ubb ub-cd uinn">
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
                            <em class="ub ub-ac tx-c8">时间：<i>{$vo.start_time|date="m月d日",###}-{$vo.end_time|date="d",###}日</i></em>
                        </div>
                        <div class="info ub">
                            <span class="ub tx-c4 iconfont icon-xiao31"></span>
                            <em class="ub tx-c8 ub-ac">地点：<i>{$vo.city}</i></em>
                        </div>
						<?php if(time()>$vo[end_time]){ ?>
                        <div class="bmbtn ub ub-ac ub-pc uba uc-a1 tx-cgn"><span class="ub iconfont icon-baoming"></span> 已结束</div>
                        <?php }else if(time()>=$vo[start_time] && time()<=$vo[end_time]){ ?>
						 <div class="bmbtn ub ub-ac ub-pc uba uc-a1 tx-cgn"><span class="ub iconfont icon-baoming"></span> 进行中</div>
						<?php }else{ ?>
						<div class="bmbtn ub ub-ac ub-pc uba uc-a1 tx-cblu"><span class="ub iconfont icon-baoming"></span> 报名中</div>
						<?php } ?>
                    </div>
                </a>
            </li>
            
		</volist>	
        </content>	
        <!--进化3门-->
        <position action="position" posid="4" num="3" return="data">		
		<volist name="data" id="vo">
            <li class="ub ubb ub-cd uinn">
                <a class="ub ub-f1" href="<?php echo $vo['data']['url']?>">
                    <div class="img ub ub-ac uof"><img src="<?php echo $vo['data']['thumb']?>" alt=""></div>
                    <div class="con ub ub-f1 ub-ver">
                        <h5 class="ub umar-b tx-c2 uof"><?php echo $vo['data']['title']?></h5>
                        <div class="info ub tx-cred">
                            <span class="ub ub-ac iconfont icon-boshimao-copy"></span>
                            <em class="ub ub-ac">讲师：<i><?php echo $vo['data']['teacher']?></i></em>
                        </div> 
                        <div class="info ub">
                            <span class="ub tx-c4 iconfont icon-shijian"></span>
                            <em class="ub ub-ac tx-c8">时间：<i><?php echo date('m月d日',strtotime($vo['data']['start_time']))?>-<?php echo date('d',strtotime($vo['data']['end_time']))?>日</i></em>
                        </div>
                        <div class="info ub">
                            <span class="ub tx-c4 iconfont icon-xiao31"></span>
                            <em class="ub tx-c8 ub-ac">地点：<i><?php echo $vo['data']['city']?></i></em>
                        </div>
						<?php if(time()>strtotime($vo[data][end_time])){ ?>
                        <div class="bmbtn ub ub-ac ub-pc uba uc-a1 tx-cgn"><span class="ub iconfont icon-baoming"></span> 已结束</div>
                        <?php }else if(time()>=strtotime($vo[data][start_time]) && time()<=strtotime($vo[data][end_time])){ ?>
						 <div class="bmbtn ub ub-ac ub-pc uba uc-a1 tx-cgn"><span class="ub iconfont icon-baoming"></span> 进行中</div>
						<?php }else{ ?>
						<div class="bmbtn ub ub-ac ub-pc uba uc-a1 tx-cblu"><span class="ub iconfont icon-baoming"></span> 报名中</div>
						<?php } ?>
                    </div>
                </a>
            </li>    
		</volist>	
        </position>
        </ul>    
    </div>
    <!-- /精选课程 -->
    
    <!-- 最新资讯 -->
    <div class="stockNewsBox indexNews">
	  
        <a class="title ub ubt ubb ub-cd uinn5" href="{:getCategory(2,'url')}">
            <div class="ub ub-f1 ulev0">
                <span class="ub ub-ac tx-cred iconfont icon-juxing184"></span>
                <em class="tx-c2">最新资讯</em>
            </div>
            <div class="more ub tx-c4">
                <em class="ub ub-ac">更多</em>
                <span class="ub ub-ac iconfont icon-jiantou"></span>
            </div>
        </a>
		
        <ul class="stockNewsList">
		<get sql="select * from jbr_article where catid=2 order by updatetime DESC" num='8'>		
		<volist name="data" id="vo">
            <li class="ub ubb ub-cd uinn">
                <a class="ub ub-f1" href="{$vo.url}">
                    <div class="img ub ub-ac uof"><img src="{$vo.thumb}" alt=""></div>
                    <div class="con ub ub-f1 ub-ver">
                        <h5 class="ub tx-c2 uof">{$vo.title}</h5>
                        <div class="info ub">
                            <span class="time ub ub-ac tx-c8">{$vo.updatetime|date="Y.m.d",###}</span>
                            <div class="number ub ub-ac tx-c8"><em class="ub ub-ac iconfont icon-yanjing"></em><span><?php echo zhh($vo['id']); ?></span></div>
                        </div>                         
                    </div>
                </a>
            </li>           
          </volist>
		</get>
		
        </ul>
    </div>
    <!-- /股权观点 -->
    
    <div class="indexPic">
        <img src="" alt="">
    </div>
	
    <!-- 页脚 -->
	<div class="ftBtFixed ubt ubb-d">
	<?php if($_SESSION['userid']==''){ ?>  
		<!-- <a class="btn ub uinn" href="javascript:void(0);"  Onclick="join();">
            <div class="callbtn ub ub-f1 ub-ac ub-pc tx-cf uc-a3 uinn7 bg-red ulev0">
                申请加入
            </div>
        </a> -->
	<?php } ?>
        <!-- 底部操作开始 -->
        <!-- 
        <div class="navBox ub ubb ub-cd footerNav">
            <div class="nav ub ubr ub-cd uinn footerNav footerNav1">
                <a class="ub ub-f1 ub-ver ub-ac ub-pc" href="tel:4000279828">
                    <span class="ub tx-cblu myiconfont">&#xe61b;</span>
                </a>
            </div>
            <div class="nav ub ubr ub-cd uinn footerNav footerNav2">
                <a class="ub ub-f1 ub-ver ub-ac ub-pc" href="#">
                    <span class="ub tx-cred myiconfont">&#xe63e;</span>
                </a>
            </div>
            <div class="nav ub ubr ub-cd uinn footerNav footerNav3">
                <a class="ub ub-f1 ub-ver ub-ac ub-pc" href="#">
                    <span class="ub tx-cog myiconfont">&#xe60b;</span>
                </a>
            </div>
            <div class="nav ub ubr ub-cd uinn footerNav footerNav4">
                <a class="ub ub-f1 ub-ver ub-ac ub-pc" href="/statics/map.php">
                    <span class="ub tx-cog myiconfont">&#xe640;</span>
                </a>
            </div>
        </div> -->
        <!-- /底部操作结束 -->
    </div>


    <template file="Content/footer.php"/> 
     
    <!-- /页脚 -->



</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
<script>
    $(function(){
        FastClick.attach(document.body); 
        $(".footerNav2").on("click",function(){
            $(".indexPic img").attr('src', '/statics/default/images/index.jpg');
            $(".indexPic").show();
        });
        $(".footerNav3").on("click",function(){
            $(".indexPic img").attr('src', '/statics/default/images/index2.jpg');
            $(".indexPic").show();
        });
        $(".indexPic").on("click",function(){
            $(this).hide();
        });
    })
</script>
<script>  
function join()
{
	window.location.href="/index.php?m=User&a=reg";
}
</script>

</html>