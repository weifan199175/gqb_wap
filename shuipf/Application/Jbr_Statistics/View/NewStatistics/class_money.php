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
			<!-- 
			<div class="mr20" style="margin-top:10px;">
				<input class="btn" value="搜　 索" type="button" id="btn_search" style="color:red;"/>	
				<a href="index.php?g=Jbr_Statistics&m=NewStatistics&a=class_student" class="btn">重　 置</a>
			</div>
			</div>
			 -->
		</div>
	</form>
	<!--{/条件搜索}-->
  <div class="table_list">
  
  <!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta charset="utf-8">
    <link rel="icon" href="https://static.jianshukeji.com/highcharts/images/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">	<meta name="description" content="">
	<script src="https://img.hcharts.cn/jquery/jquery-1.8.3.min.js"></script>
	<script src="https://img.hcharts.cn/highcharts/highcharts.js"></script>
	<script src="https://img.hcharts.cn/highcharts/modules/exporting.js"></script>
	<script src="https://img.hcharts.cn/highcharts-plugins/highcharts-zh_CN.js"></script>
</head>
<body>
<div id="container" style="min-width:200px;height:300px"></div>
<script>
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '课程款项统计'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: <?php echo json_encode($data['course'])?>,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: '到场人数',
            data: <?php echo json_encode($data['students'])?>
        }, {
            name: '全款人数',
            data: <?php echo json_encode($data['full_pay_num'])?>
        }, {
            name: '现场成交金额',
            data: <?php echo json_encode($data['site_pay'])?>
        }],
        credits: {
            enabled: false
       }
    });
});

</script>
</body>
</html>
  </div>
  <script src="{$config_siteurl}statics/js/common.js?v"></script>
</div>
</body>
</html>