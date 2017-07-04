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
<br/>
<div id="container2" style="min-width:200px;height:300px"></div>
<br/>
<div id="container3" style="min-width:200px;height:300px"></div>
<script>
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '<?php echo $data[0]['course']?>'
        },
        xAxis: {
            categories: <?php echo json_encode($kefu[0])?>
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        legend: {
            align: 'right',
            x: -30,
            verticalAlign: 'top',
            y: 25,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '人'
                   
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 3px black'
                    }
                }
            }
        },
        series: [{
            name: '成交铁杆',
            data: <?php echo json_encode($data[0]['pay_vip'])?>
        }, {
            name: '到课铁杆',
            data: <?php echo json_encode($data[0]['stu_vip'])?>
        }, {
            name: '老学员',
            data: <?php echo json_encode($data[0]['stu_old'])?>
        }, {
            name: '新学员',
            data: <?php echo json_encode($data[0]['stu_new'])?>
        }],
        credits: {
            enabled: false
       }
    });
    $('#container2').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '<?php echo $data[1]['course']?>'
        },
        xAxis: {
            categories: <?php echo json_encode($kefu[1])?>
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        legend: {
            align: 'right',
            x: -30,
            verticalAlign: 'top',
            y: 25,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '人'
                   
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 3px black'
                    }
                }
            }
        },
        series: [{
            name: '成交铁杆',
            data: <?php echo json_encode($data[1]['pay_vip'])?>
        }, {
            name: '到课铁杆',
            data: <?php echo json_encode($data[1]['stu_vip'])?>
        }, {
            name: '老学员',
            data: <?php echo json_encode($data[1]['stu_old'])?>
        }, {
            name: '新学员',
            data: <?php echo json_encode($data[1]['stu_new'])?>
        }],
        credits: {
            enabled: false
       }
    });
    $('#container3').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '<?php echo $data[2]['course']?>'
        },
        xAxis: {
            categories: <?php echo json_encode($kefu[2])?>
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        legend: {
            align: 'right',
            x: -30,
            verticalAlign: 'top',
            y: 25,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '人'
                   
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 3px black'
                    }
                }
            }
        },
        series: [{
            name: '成交铁杆',
            data: <?php echo json_encode($data[2]['pay_vip'])?>
        }, {
            name: '到课铁杆',
            data: <?php echo json_encode($data[2]['stu_vip'])?>
        }, {
            name: '老学员',
            data: <?php echo json_encode($data[2]['stu_old'])?>
        }, {
            name: '新学员',
            data: <?php echo json_encode($data[2]['stu_new'])?>
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