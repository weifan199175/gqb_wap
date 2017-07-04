<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
	
	<!--{条件搜索}-->
   <div class="h_a">搜索</div>
	<form method="post" id="member_manage_from">
		<div class="search_type cc mb10">
			<div class="mb10">
			
			<span class="mr20">时间：
			<input type="text" name="start_time" class="input length_2 J_date" value="{$stime}" style="width:80px;">-<input type="text" class="input length_2 J_date" name="end_time" value="{$etime}" style="width:80px;">
				
				<!--<span class="mr20">&nbsp;&nbsp;会员等级：
				
				<select class="select_2" name="member_class" style="width:100px;">
					<option value="0"  <if condition="$member_class_id eq 0">selected="selected"</if>>全部</option>
					<volist name="classList" id="vo">
					<option value="{$vo.id}" <if condition='$vo.id eq $member_class'>selected="selected"</if> >{$vo.class_name}</option>
					</volist>         
				</select>-->
				
				<span class="mr20">&nbsp;&nbsp;商品名称：				
				
				<span class="mr20">
					<input name="keyword" type="text" value="{$keyword}" class="input"/>					
				</span>
				<!--<span class="mr20">会员状态：
				<select class="select_2" name="keyword_status" style="width:70px;">
					<option value="-1" <if condition="$keyword_status eq '-1'">selected="selected"</if>>全部</option>
					<option value="0" <if condition="$keyword_status eq '0'">selected="selected"</if>>激活</option>
					<option value="1" <if condition="$keyword_status eq '1'">selected="selected"</if>>锁定</option>
					</select>-->
				<input class="btn" value="搜　 索" type="button" id="btn_search" style="color:red;"/>	
				<input type="button"  value="导出搜索内容" id="btn_out" class="btn"/>	
			</div>
						
			<input type="hidden" value="1" val="{:U('Membership/index')}" name="url_search" >
			<input type="hidden" value="2" val="{:U('Membership/excel')}" name="url_out" >
		</div>
	</form>
	<!--{/条件搜索}-->
	<div id="main_num" style="height:400px;width:30.8%; float:left;text-align:center; ">
		
		<table width="500px" height="100px" cellspacing="0" cellpadding="0" border="1">
			<tr>
				<td>编号</td>
				<td>商品名称</td>
				<td>销量(笔)</td>
				<td>销售额(元)</td>
			</tr>
			<tr>
				<td>1</td>
				<td>股权博弈</td>
				<td>5</td>
				<td>10000</td>
			</tr>
			<tr>
				<td>2</td>
				<td>爆品战略</td>
				<td>10</td>
				<td>20000</td>
			</tr>
			<tr>
				<td>3</td>
				<td>社群运营</td>
				<td>15</td>
				<td>30000</td>
			</tr>
			<tr>
				<td>4</td>
				<td>股权架构</td>
				<td>20</td>
				<td>40000</td>
			</tr>
		</table>
	</div>
  	<div id="main"  style="height:300px;width:68.8%;float:right; "></div>
	<div id="main_count"  style="height:300px;width:68.8%;float:right; "></div>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>
<script src="/public/admin/echarts-2.2.7/build/dist/echarts.js"></script>

<script type="text/javascript">

//var d = new Date();
//	var year = d.getFullYear();
//	var o_year = '';
//	for(i = year; i >= 2015; i--){
//		o_year += "<option value='"+i+"'>"+i+"年</option>";
//	}
	
//	$("#year").html(o_year);

//	var names		=	<?php echo $names; ?>;
//	var data_sum	=	<?php echo $data_sum; ?>;
//	var data_count	=	<?php echo $data_count; ?>;
//	var year		=	<?php echo $year; ?>;
//	var des			=	'<?php echo $des; ?>';
	// 路径配置
	require.config({
		paths: {
			echarts: '/public/admin/echarts-2.2.7/build/dist'
		}
	});
	
	// 使用
	require(
		[
			'echarts',
			'echarts/chart/bar' // 使用柱状图就加载bar模块，按需加载
		],
		function (ec) {
			// 基于准备好的dom，初始化echarts图表
			var myChart = ec.init(document.getElementById('main')); 
			var myChart_count =	ec.init(document.getElementById('main_count')); 
			var option = {
						title: {
			                text: '2016年商品销售额排名统计'
			            },
			            tooltip: {},
			            legend: {
			                data:['销售额']
			            },
			            xAxis: {
			                data: ["股权博弈","爆品战略","社群运营","股权架构"]
			            },
			            yAxis: {},
			            series: [
			            	{name: '销售额',type: 'bar',data: [10000, 20000, 30000, 40000]}
			            ]


					};

			var option_count = {
						title: {
			                text: '2016年商品销量排名统计'
			            },
			            tooltip: {},
			            legend: {
			                data:['销量']
			            },
			            xAxis: {
			                data: ["股权博弈","爆品战略","社群运营","股权架构"]
			            },
			            yAxis: {},
			            series: [
			            	{name: '月销售额',type: 'bar',data: [5, 10, 15, 19]}
			            	
			            ]

					};
										
	
			// 为echarts对象加载数据 
			myChart.setOption(option); 
			myChart_count.setOption(option_count);
		}


	);




function search(){
	var param = '';
	var year_search	=	$('#year').val();
	if(year == '' ){
		top.$.messager.alert('提示信息', '请输入查询时间！', 'warning');
		return false;
	}
	var type_search = 'isofficial';
	if($('#zdy').combobox('getValue') == "ss1"){
		type_search = 'all';
	}else if ($('#zdy').combobox('getValue') == "ss2"){
		type_search = 'isofficial';
	}else{
		type_search = 'noofficial';
	}
	param = '?type='+type_search+'&year='+year_search;
	window.location.href='/admin/index.php/Statistics/MonthSell/index.html'+param;
}

function btn_out(){
	var data = new Object();

	var url='/admin/index.php/Statistics/MonthSell/index.html?print_out=1';
	$('#waitdialog').attr('style','display:"";');
	$('#waitdialog').html("<img src='/public/admin/images/loading.jpg' style='float:left; width:70px;height:70px;'/><div style='float:left; font-size:20px;'>系统正在处理报表,<br/>请不要离开页面,耐心等待!</div>");
	
	$('#waitdialog').dialog({    
		title: '等待下载',    
		width: 400,    
		height: 110,    
		closed: false,    
		cache: false,      
		modal: true   
	});
	
	//var year_search	=	<?php echo $year; ?>;
	if(year_search != '' ){
		url += '&year='+year_search;
	}else{
		url += '&year='+year;
	}
	var type_search = 'isofficial';
	if($('#zdy').combobox('getValue') == "ss1"){
		type_search = 'all';
	}else if ($('#zdy').combobox('getValue') == "ss2"){
		type_search = 'isofficial';
	}else{
		type_search = 'noofficial';
	}
	url += '&type='+type_search;
	
	$.ajax({
		url:url,
		type:'get',
		success:function(msg){
			$('#waitdialog').dialog({      //关闭等待下载dialog弹出框
				closed: true
			});
			if(msg == 'false'){
				top.$.messager.alert('提示信息', '您选择的搜索条件查询的数据为空.', 'warning');
				return false;
			}
			if(true == $.ua.isIe){         //判断是否是IE浏览器
				$('#linkdialog').html("<div style='float:left; font-size:20px;'><a href='/User/User/downloadExcel.html?filename=" + msg +"'>下载链接</a></div>");
				$('#waitdialog').dialog({    
					title: '您的浏览器不支持直接下载，请点击此链接下载！',    
					width: 400,    
					height: 200,    
					closed: false,    
					cache: false,       
					modal: true   
				});	
			}else{
				window.location.href = "/admin/index.php/Statistics/ProductSell/downloadExcel.html?filename=" + msg; 
			}
		}
	});		
	return false;
}



</script>
<script>
	$(function(){
	
		//启用、禁用
		$(".yn").click(function(){
			var tid=$(this).attr("typeid");
			var v=$(this).attr("isok");
			
			$.ajax({
					type: "POST",
					url: "index.php?g=Jbr_Membership&m=Membership&a=isok",
					data: "isok="+v+"&tid="+tid,
					success: function(msg){					
					 if(msg == '1'){
						$(".yn").each(function(){
							if($(this).attr("typeid") == tid)
							{
								$(this).html("<font color='red'>锁定</font>");
								$(this).attr("isok","1");
							}
						});
												
					 }else{
						$(".yn").each(function(){
							if($(this).attr("typeid") == tid)
							{
								$(this).html("激活");
								$(this).attr("isok","0");
							}
						});
					 }
				}
			}); 
			return false;
		});
		
		
		/*** 表单提交 及点击按钮时的表单提交地址切换 xr 20140919 start ***/
		//点击搜索
		$("#btn_search").click(function(){
			var destination = $("input[name='url_search']").attr('val');	//获取提交地址
			$("#member_manage_from").attr('action', destination);	//切换提交地址
			$("#member_manage_from").submit();	//提交表单
			return false;
		});
		//点击导出
		$("#btn_out").click(function(){
			var destination = $("input[name='url_out']").attr('val');
			$("#member_manage_from").attr('action', destination);
			$("#member_manage_from").submit();
			return false;
		});
		/*** end ***/
		
	})
	
	$(function(){
		$("#timeup").click(function(){
			$("#time").val("asc");
			$("#vip").val("");
			$("#dj").val("");
			$("#loginnum").val("");
			$("#member_manage_from").submit();
		});
		
		$("#timedown").click(function(){
			$("#time").val("desc");
			$("#vip").val("");
			$("#dj").val("");
			$("#loginnum").val("");
			$("#member_manage_from").submit();
		});
	})
	
	$(function(){
		$("#vipup").click(function(){
			$("#vip").val("asc");
			$("#time").val("");
			$("#dj").val("");
			$("#loginnum").val("");
			$("#member_manage_from").submit();
		});
		
		$("#vipdown").click(function(){
			$("#vip").val("desc");
			$("#time").val("");
			$("#dj").val("");
			$("#loginnum").val("");
			$("#member_manage_from").submit();
		});
	})
	
	$(function(){
		$("#djup").click(function(){
			$("#dj").val("asc");
			$("#time").val("");
			$("#vip").val("");
			$("#loginnum").val("");
			$("#member_manage_from").submit();
		});
		
		$("#djdown").click(function(){
			$("#dj").val("desc");
			$("#time").val("");
			$("#vip").val("");
			$("#loginnum").val("");
			$("#member_manage_from").submit();
		});
	})
	
	$(function(){
		$("#loginup").click(function(){
			$("#loginnum").val("asc");
			$("#time").val("");
			$("#vip").val("");
			$("#dj").val("");
			$("#member_manage_from").submit();
		});
		
		$("#logindown").click(function(){
			$("#loginnum").val("desc");
			$("#time").val("");
			$("#vip").val("");
			$("#dj").val("");
			$("#member_manage_from").submit();
		});
	})
</script>
</body>
</html>