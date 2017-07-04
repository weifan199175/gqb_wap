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

<div id="container" style="min-width:385px;height:400px;display:inline-block;"></div>
<div id="container2" style="min-width:385px;height:400px;display:inline-block;"></div>
<div id="container3" style="min-width:385px;height:400px;display:inline-block;"></div>

	<script>
	$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column',
            width:370
        },
        title: {
            text: '<?php echo $data[0]['title']?>'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [
                '<?php echo $data[0]['title']?>',
            ],
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
            '<td style="padding:0"><b>{point.y}人</b></td></tr>',
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
            name: '老学员',
            data: [<?php echo $data[0]['old_stu']?>]
        }, {
            name: '新学员',
            data: [<?php echo $data[0]['new_stu']?>]
        }, {
            name: '学员（转介绍）',
            data: [<?php echo $data[0]['zjs']?>]
        }, {
            name: '学员（渠道）',
            data: [<?php echo $data[0]['source']?>]
        }, {
            name: '学员（网络自转化）',
            data: [<?php echo $data[0]['none']?>]
        }],
        credits: {
            enabled: false
       }
    });
    
    $('#container2').highcharts({
        chart: {
            type: 'column',
            width:370
        },
        title: {
            text: '<?php echo $data[1]['title']?>'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [
                '<?php echo $data[1]['title']?>',
            ],
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
            '<td style="padding:0"><b>{point.y}人</b></td></tr>',
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
            name: '老学员',
            data: [<?php echo $data[1]['old_stu']?>]
        }, {
            name: '新学员',
            data: [<?php echo $data[1]['new_stu']?>]
        }, {
            name: '学员（转介绍）',
            data: [<?php echo $data[1]['zjs']?>]
        }, {
            name: '学员（渠道）',
            data: [<?php echo $data[1]['source']?>]
        }, {
            name: '学员（网络自转化）',
            data: [<?php echo $data[1]['none']?>]
        }],
        credits: {
        	text: '',
        	href: ''
    	}
    });
    
    $('#container3').highcharts({
        chart: {
            type: 'column',
            width:370
        },
        title: {
            text: '<?php echo $data[2]['title']?>'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [
                '<?php echo $data[2]['title']?>',
            ],
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
            '<td style="padding:0"><b>{point.y}人</b></td></tr>',
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
            name: '老学员',
            data: [<?php echo $data[2]['old_stu']?>]
        }, {
            name: '新学员',
            data: [<?php echo $data[2]['new_stu']?>]
        }, {
            name: '学员（转介绍）',
            data: [<?php echo $data[2]['zjs']?>]
        }, {
            name: '学员（渠道）',
            data: [<?php echo $data[2]['source']?>]
        }, {
            name: '学员（网络自转化）',
            data: [<?php echo $data[2]['none']?>]
        }],
        credits: {
        	text: '',
        	href: ''
    	}
    });
});
</script>
</body></html>
  </div>
  <script src="{$config_siteurl}statics/js/common.js?v"></script>
</div>
</body>
</html>