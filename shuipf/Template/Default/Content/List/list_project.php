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
    <!-- 项目发布 -->
    <div class="ub ub-ver learnStkBox">
	    <template file="Content/hehuo_header.php"/>
        <div class="programList ub ub-ver bgc">
            <ul class="">
            <?php
			   
			   $list = M('paiqi')->where('status=99')->order('listorder desc,updatetime desc')->select(); 
			   
			   foreach($list as $k=>$v)
			   {
				   $list[$k]['project'] = M('project')->where('status=99 and paiqi_id='.$v['id'])->order('listorder desc,updatetime desc')->select();
				 
			   }
			  
			?> 
			<volist name="list" id="vo">
			   <li class="ubb ubb-d">
                    <div class="title ub">
                        <span class="ub ub-ac ub-pc iconfont icon-icon"></span>
                        <div class="tit ub ub-f1">{$vo.title}</div>
                    </div>
                    <div class="show">
                       
                        <div class="con">
                            <ol>
							<volist name="vo[project]" id="v" key="k">
                            <?php $c = count($vo[project]); ?>  
                                <li <if condition="$k eq $c">class="last"</if>><a href="{$v.url}">{$v.title}</a></li>
							</volist>	
                            </ol>
                        </div>
                    </div>
                </li>
            </volist>    
            </ul>            
        </div>
    </div>
    <!-- /项目发布-->
      <!-- 页脚 -->
        <template file="Content/footer.php"/>     
    <!-- /页脚 -->

</div>
<!-- /c -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery.js"></script>
<script type="text/javascript">
    $(function () {
        $(".programList li .show").hide();
        $(".programList ul li").click(function(){
            //var thisTit=$(this);
            $(this).find(".title span").addClass("icon-jiantouxia").removeClass('icon-icon').parents("li").siblings('li').find('span').removeClass('icon-jiantouxia').addClass("icon-icon");
            $(this).children(".show").slideDown("fast");
            $(this).siblings().children(".show").slideUp("fast");
        })
    });
</script>
</html>