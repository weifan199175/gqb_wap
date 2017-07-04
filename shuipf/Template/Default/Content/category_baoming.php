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
    <title>社员服务-上课报名</title>
</head>
<body class="um-vp" style="background: #f4f4f4;">

<!-- c -->

<div class="sBox"> 
    <!-- 社员服务 -->
    <div class="ub ub-ver UPmemberBox">
        
        <!-- banner -->
        <div class="banner swiper-container mar-b7">
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
		<!-- title -->
            
            <template file="Content/service_header.php"/>

        <!-- /title -->
        <!-- 最新课程 -->
        <div class="classBox">    
            <a class="title ub ubt ubb ubb-d uinn5" href="javascript:;">
                <div class="ub ub-f1 ulev0">
                    <span class="ub ub-ac tx-red iconfont icon-juxing184"></span>
                    <em class="tx-c2">最新课程</em>
                </div>                
            </a>
            <ul class="classList">
            <position action="position" posid="4" num="3" return="data">		
		    <volist name="data" id="vo">  
			  <li class="ub ubb ubb-d uinn">
                    <a class="ub ub-f1" href="{$vo.data.url}" >
                        <div class="img ub ub-ac uof"><img src="{$vo.data.thumb}" alt=""></div>
                        <div class="con ub ub-f1 ub-ver">
                            <h5 class="ub umar-b tx-c2 uof">{$vo.data.title}</h5>
                            <div class="info ub tx-cred">
                                <span class="ub ub-ac iconfont icon-boshimao-copy"></span>
                                <em class="ub ub-ac">讲师：<i>{$vo.data.teacher}</i></em>
                            </div> 
                            <div class="info ub">
                                <span class="ub tx-c4 iconfont icon-shijian"></span>
                                <em class="ub ub-ac tx-c8">时间：<i>{$vo.data.start_time|date="m",###}月{$vo.data.start_time|date="d",###}日</i></em>
                            </div>
                            <div class="info ub">
                                <span class="ub tx-c4 iconfont icon-xiao31"></span>
                                <em class="ub tx-c8 ub-ac">地点：<i>{$vo.data.city}</i></em>
                            </div>
                            <?php
                                $where['id']=$vo['id'];
                                //var_dump($where['id']);exit;
                                $enter_num=M('courses')->where($where)->getField('enter_num',true);
                                //var_dump($enter_num);
                                //查询是否报名
                                $res=M('order')->where(array('member_id' =>$_SESSION['userid'] ,'status'=>1,'product_id'=>$vo['id'] ))->find();
                                //echo M('order')->getLastSql();
                                //var_dump($res);exit;
                            ?>
                            <div class="info ub">
                                <span class="ub tx-c4 iconfont icon-ren1"></span>
                                    <em class="ub tx-c8 ub-ac">名额：<i><em class
                                    ="tx-red">{$enter_num[0]}</em> / {$vo.data.max_num}</i></em>
                            </div>
                            <if condition="isset($res)&&!empty($res)">
                                <div class="bmbtn ub ub-ac ub-pc uba uc-a1 tx-a">报名成功</div>
                            <elseif condition="$enter_num[0] lt $vo['data']['max_num']" />
                                <div class="click_upOut bmbtn ub ub-ac ub-pc uba uc-a1 tx-cgn">申请报名</div>
                            <elseif condition="$enter_num[0] eq $vo['data']['max_num']" />
                                <div class="bmbtn ub ub-ac ub-pc uba uc-a1 tx-a">名额已满</div>
                            </if>
                        </div>
                    </a>
                </li>
            </volist>
            </position>		
			
			 
				
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