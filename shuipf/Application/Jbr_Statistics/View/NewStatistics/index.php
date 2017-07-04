<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<style>
/* 新增样式*/
.timeDiv{
	display:inline-block;
	height:28px;
	line-height:28px;
	padding:0 4px;
	cursor:pointer;
	border-radius:2px;
}
.thisTime{
	color:#fff;
	background:#4DAAFC;
}
</style>

<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <!--{条件搜索}-->
    <div class="h_a">搜索</div>
	<form method="post" id="member_manage_from">
		<div class="search_type cc mb10">
			<div class="mb10">
			<span class="mr20">&nbsp;&nbsp;时间：
			<input type="hidden" name="time_type" value="<?php echo $time_type?>">
			<div class="timeDiv <?php echo $time_type=="today"?"thisTime":""?>" data-timetype="today">今天</div>
			<div class="timeDiv <?php echo $time_type=="yesterday"?"thisTime":""?>" data-timetype="yesterday">昨天</div>
			<div class="timeDiv <?php echo $time_type=="near7"?"thisTime":""?>" data-timetype="near7">最近7天</div>
			<div class="timeDiv <?php echo $time_type=="near30"?"thisTime":""?>" data-timetype="near30">最近30天</div>
			<div class="timeDiv <?php echo $time_type=="thismonth"?"thisTime":""?>" data-timetype="thismonth">本月</div>
			<div class="timeDiv <?php echo $time_type=="free"?"thisTime":""?>" data-timetype="free">自定义时间</div>
			</span>
			
			<span class="mr20" id="free" style="<?php echo $time_type=="free"?"":"display: none;"?>">时间段：
			     <input type="text" name="starttime" class="input length_2 J_date" value="{$starttime}" style="width:80px;">
			     -
			     <input type="text" class="input length_2 J_date" name="endtime" value="{$endtime}" style="width:80px;">
			</span>	
			

			
			
			<!-- <div class="mr20" style="margin-top:10px;"> -->
				<input class="btn" value="搜　 索" type="button" id="btn_search" style="color:red;"/>	
				<a href="index.php?g=Jbr_Statistics&m=NewStatistics&a=index" class="btn">重　 置</a>
			<!-- </div> -->
			</div>
			
		</div>
	</form>
	<!--{/条件搜索}-->
  <div class="table_list">
  <?php include_once(PROJECT_PATH.'/Application/Jbr_Statistics/View/NewStatistics/tongji1.php');?>
  </div>
  <script src="{$config_siteurl}statics/js/common.js?v"></script>
</div>

<script type="text/javascript">
$(function(){
		/*** 表单提交 及点击按钮时的表单提交地址切换 xr 20140919 start ***/
		//点击搜索
		$("#btn_search").click(function(){
			$("input[name='is_excal']").val("0");
			var destination = $("input[name='url_search']").attr('val');	//获取提交地址
			$("#member_manage_from").attr('action', destination);	//切换提交地址
			$("#member_manage_from").submit();	//提交表单
			return false;
		});
		//点击导出
		$("#btn_out").click(function(){
			$("input[name='is_excal']").val("1");
			$("#member_manage_from").submit();
// 			return false;
		});
		/*** end ***/
		$(".timeDiv").click(function(){
			$(this).addClass("thisTime");
			$(this).siblings(".timeDiv").removeClass("thisTime");
			var time_type = $(this).data("timetype")
			$("input[name='time_type']").val(time_type);
 			if(time_type != "free"){
 				$("#free").hide();
 			}else {
 				$("#free").show();
 			}
		});
	})
</script>
</body>
</html>