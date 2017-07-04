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
<!--     <link rel="stylesheet" href="/statics/default/css/swiper.min.css"> -->
    <link rel="stylesheet" href="/statics/default/css/service.css">
    <link rel="stylesheet" href="/statics/default/css/index.css">
    <title>课程中心</title>
</head>
<body class="um-vp" style="background: #f4f4f4;">

<!-- c -->

<div class="sBox"> 
    <!-- 社员服务 -->
    <div class="ub ub-ver UPmemberBox">
        <!-- title -->
            
            

        <!-- /title -->
        <!-- banner 
        <div class="banner swiper-container mar-b7 baomingBanner">
            <div class="swiper-wrapper">
                <content action="lists" catid="18" order="listorder DESC" moreinfo="1">
				<volist name="data" id="vo">
					<div class="swiper-slide"><a <if condition="$vo['islink'] eq 1">href="{$vo.url}"<else />href="javascript:;"</if>><img src="{$vo.img}" alt=""></a></div>
				</volist>
				</content>		
            </div>
            <!-- Add Pagination 
            <div class="swiper-pagination"></div>
        </div> -->
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



  

        <!-- 最新课程 -->
        <div class="classBox">    
            <a class="title ub ubt ubb ubb-d uinn5" href="javascript:;">
                <div class="ub ub-f1 ulev0">
                    <span class="ub ub-ac tx-red iconfont icon-juxing184"></span>
                    <em class="tx-c2">课程中心</em>
                </div>                
            </a>
            <ul class="classList">
            <?php $sql = "start_time>".time();?>
            <content action="lists" catid="13"  return="data" where="$sql" order='start_time'>		
		    <volist name="data" id="vo">  
			  <li class="ub ubb ubb-d uinn">
                    <a class="ub ub-f1" href="{$vo.url}" >
                        <div class="img ub ub-ac uof"><img src="{$vo.thumb}" alt=""></div>
                        <div class="con ub ub-f1 ub-ver">
                            <h5 class="ub umar-b tx-c2 uof">{$vo.title}</h5>
                            <div class="info ub tx-cred">
                                <span class="ub ub-ac iconfont icon-boshimao-copy"></span>
                                <em class="ub ub-ac">讲师：<i>{$vo.teacher}</i></em>
                            </div> 
                            <div class="info ub">
                                <span class="ub tx-c4 iconfont icon-shijian"></span>
                                <em class="ub ub-ac tx-c8">时间：<i>{$vo.start_time|date="m",###}月{$vo.start_time|date="d",###}日</i></em>
                            </div>
                            <div class="info ub">
                                <span class="ub tx-c4 iconfont icon-xiao31"></span>
                                <em class="ub tx-c8 ub-ac">地点：<i>{$vo.city}</i></em>
                            </div>
                            <?php
                                $where['id']=$vo['id'];
                                $enter_num=M('courses')->where($where)->getField('enter_num');
                                //查询是否报名
                                $res=M('order')->where(array('member_id' =>$_SESSION['userid'] ,'status'=>1,'product_id'=>$vo['id']))->find();
                            ?>
                            <div class="info ub">
                                <span class="ub tx-c4 iconfont icon-ren1"></span>
                                <!-- 屏蔽名额 
                                    <em class="ub tx-c8 ub-ac">名额：<i><em class
                                    ="tx-red">{$enter_num[0]}</em> / {$vo.max_num}</i></em>-->
                                    <em class="ub tx-c8 ub-ac">名额：<i>{$vo.max_num}</i></em>
                            </div>
                            
                            <if condition="(isset($res)) AND (!empty($res))"><!-- 若已经报名 -->
                                <div class="bmbtn ub ub-ac ub-pc uba uc-a1 tx-a">报名成功</div>
                            <else/><!-- 没有报名 -->
                                <if condition="time() egt $vo['end_time']"><!-- 已经结束了 -->
                                    <div class="bmbtn ub ub-ac ub-pc uba uc-a1 tx-a">已结束</div>
                                <else/>
                                    <if condition="$vo['max_num'] elt $enter_num"><!-- 满员了 -->
                                        <div class="bmbtn ub ub-ac ub-pc uba uc-a1 tx-a">名额已满</div>
                                    <else/>
                                        <div class="click_upOut bmbtn ub ub-ac ub-pc uba uc-a1 tx-cgn">申请报名</div>
                                    </if>
                                </if>
                            </if>
                            
                        </div>
                    </a>
                </li>
            </volist>
            </content>
            <content action="lists" catid="14"  return="data" order='start_time' where="$sql">		
		    <volist name="data" id="vo">  
			  <li class="ub ubb ubb-d uinn">
                    <a class="ub ub-f1" href="{$vo.url}" >
                        <div class="img ub ub-ac uof"><img src="{$vo.thumb}" alt=""></div>
                        <div class="con ub ub-f1 ub-ver">
                            <h5 class="ub umar-b tx-c2 uof">{$vo.title}</h5>
                            <div class="info ub tx-cred">
                                <span class="ub ub-ac iconfont icon-boshimao-copy"></span>
                                <em class="ub ub-ac">讲师：<i>{$vo.teacher}</i></em>
                            </div> 
                            <div class="info ub">
                                <span class="ub tx-c4 iconfont icon-shijian"></span>
                                <em class="ub ub-ac tx-c8">时间：<i>{$vo.start_time|date="m",###}月{$vo.start_time|date="d",###}日</i></em>
                            </div>
                            <div class="info ub">
                                <span class="ub tx-c4 iconfont icon-xiao31"></span>
                                <em class="ub tx-c8 ub-ac">地点：<i>{$vo.city}</i></em>
                            </div>
                            <?php
                                $where['id']=$vo['id'];
                                //var_dump($where['id']);exit;
                                $enter_num=M('courses')->where($where)->getField('enter_num');
                                //var_dump($enter_num);
                                //查询是否报名
                                $res=M('order')->where(array('member_id' =>$_SESSION['userid'] ,'status'=>1,'product_id'=>$vo['id'] ))->find();
                                //echo M('order')->getLastSql();
                                //var_dump($res);exit;
                            ?>
                            <div class="info ub">
                                <span class="ub tx-c4 iconfont icon-ren1"></span>
                                    <!-- 屏蔽名额 
                                    <em class="ub tx-c8 ub-ac">名额：<i><em class
                                    ="tx-red">{$enter_num[0]}</em> / {$vo.max_num}</i></em>-->
                                    <em class="ub tx-c8 ub-ac">名额：<i>{$vo.max_num}</i></em>
                            </div>
                            
                            
                            <if condition="(isset($res)) AND (!empty($res))"><!-- 若已经报名 -->
                                <div class="bmbtn ub ub-ac ub-pc uba uc-a1 tx-a">报名成功</div>
                            <else/><!-- 没有报名 -->
                                <if condition="time() egt $vo['end_time']"><!-- 已经结束了 -->
                                    <div class="bmbtn ub ub-ac ub-pc uba uc-a1 tx-a">已结束</div>
                                <else/>
                                    <if condition="$vo['max_num'] elt $enter_num"><!-- 满员了 -->
                                        <div class="bmbtn ub ub-ac ub-pc uba uc-a1 tx-a">名额已满</div>
                                    <else/>
                                        <div class="click_upOut bmbtn ub ub-ac ub-pc uba uc-a1 tx-cgn">申请报名</div>
                                    </if>
                                </if>
                            </if>
                        </div>
                    </a>
                </li>
            </volist>
            </content>	
			
			 
				
            </ul>        
        </div>
        <!-- /最新课程 -->                               
    </div>
    <!-- /社员服务-->
    <!-- 页脚 -->
    <template file="Content/footer.php"/> 
    <!-- /页脚 -->
</div>
<input type="hidden" value="" id="openid" />
<!-- /c -->
<!--弹出层-->
<div class="PopUp uc-a3">
    <div class="PopUp_box ub ub-ver ub">
       <div class="contUp ub">
            您好，您还不是股权帮的注册社员，请先
           注册后再申请报名，谢谢！
       </div>
       <a class="btn ub uinn" href="#">
            <div class="callbtn ub ub-f1 ub-ac ub-pc tx-cf uc-a3 uinn7 bg-red ulev0">                
                立即注册
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
<script type="text/javascript" src="/statics/default/js/swiper.min.js"></script>
<script type="text/javascript">
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true
    });
</script>

<!-- 弹出层 -->
<script src="/statics/default/js/ff.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){

	
    $(".fullbg").click(function(){
        $(".PopUp").animate({opacity:"hide"},100);
        $(".fullbg").hide();
    });
});
var openid = $("#openid").val();

function cl(url)
{
	alert(url);
   if(openid=='')
	{
		
	    $(".PopUp").animate({opacity:"show"},300);
        $(".fullbg").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"block"});	
	}else{
		alert(22);return;
	}
	
}



</script>
<!-- /弹出层 -->
</html>