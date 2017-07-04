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
                
              
                <input class="btn" value="搜　 索" type="button" id="btn_search" style="color:red;"/>  
                
            </div>
                        
            <input type="hidden" value="1" val="{:U('Product/index')}" name="url_search" >
         
        </div>
    </form>
    <!--{/条件搜索}-->
    <div id="main_num" style="height:400px;width:30%; float:left;text-align:center; ">
        
        <table width="450px" height="100px" cellspacing="0" cellpadding="0" border="1">
            <tr>
                <td>编号</td>
                <td>商品名称</td>
                <td>销量(笔)</td>
                <td>销售额(元)</td>
            </tr>
            <tr>
                <td>1</td>
                <td>股权博弈</td>
                <td>{$by_count}</td>
                <td>{$by_sale}</td>
            </tr>
            <tr>
                <td>2</td>
                <td>股权架构</td>
                <td>{$jhy_count_1}</td>
                <td>{$jhy_sale_1}</td>
            </tr>
			 <tr>
                <td>3</td>
                <td>社群运营</td>
                <td>{$jhy_count_2}</td>
                <td>{$jhy_sale_2}</td>
            </tr>
			 <tr>
                <td>4</td>
                <td>爆品战略</td>
                <td>{$jhy_count_3}</td>
                <td>{$jhy_sale_3}</td>
            </tr>
            <tr>
                <td>5</td>
                <td>铁杆社员</td>
                <td>{$tg_count}</td>
                <td>{$tg_sale}</td>
            </tr>
			<!--
            <tr>
                <td>4</td>
                <td>股权架构</td>
                <td>20</td>
                <td>40000</td>
            </tr>
			-->
        </table>
    </div>
    <div id="main"  style="height:500px;width:68.8%;float:right; "></div>
    <div id="main_count"  style="height:500px;width:68.8%;float:right; "></div>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>
<script src="/public/admin/echarts-2.2.7/build/dist/echarts.js"></script>

<script type="text/javascript">
//参数配置
//销量
var by_count = '<?php echo $by_count; ?>';
var jhy_count_1 = '<?php echo $jhy_count_1; ?>';
var jhy_count_2 = '<?php echo $jhy_count_2; ?>';
var jhy_count_3 = '<?php echo $jhy_count_3; ?>';
var tg_count = '<?php echo $tg_count; ?>';
//销售额
var by_sale = '<?php echo $by_sale; ?>';
var jhy_sale_1 = '<?php echo $jhy_sale_1; ?>';
var jhy_sale_2 = '<?php echo $jhy_sale_2; ?>';
var jhy_sale_3 = '<?php echo $jhy_sale_3; ?>';
var tg_sale = '<?php echo $tg_sale; ?>';

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
            'echarts/chart/bar', // 使用柱状图就加载bar模块，按需加载
            'echarts/chart/pie'
        ],
        function (ec) {
            // 基于准备好的dom，初始化echarts图表
            var myChart = ec.init(document.getElementById('main')); 
            var myChart_count = ec.init(document.getElementById('main_count')); 
            
		    option = {
                        title: {
                            text: '商品销售额排名统计图'
                        },
                        tooltip : {
                            trigger: 'axis'
                        },
                        
                        calculable : true,
                        legend: {
                            data:['销售额(单位:元)']
                        },
                        xAxis : [
                            {
                                data: ["股权博弈","股权架构","社群运营","爆品战略","铁杆社员"]
                            }
                        ],
                        yAxis : [
                            {
                                type : 'value',
                                position: 'right'
                            }
                        ],
                        series : [
                            {
                                name:'销售额(单位:元)',
                                type:'bar',
                                data:[by_sale,jhy_sale_1,jhy_sale_2,jhy_sale_3,tg_sale]
                            },

                            {
                                name:'销售额饼状细分',
                                type:'pie',
                                tooltip : {
                                    trigger: 'item',
                                    formatter: '{a} <br/>{b} : {c} ({d}%)'
                                },
                                center: [160,120],
                                radius : [0, 50],
                                itemStyle :　{
                                    normal : {
                                        labelLine : {
                                            length : 20
                                        }
                                    }
                                },
                                data:[
                                    {value:by_sale, name:'股权博弈'},
                                    {value:jhy_sale_1, name:'股权架构'},
								    {value:jhy_sale_2, name:'社群运营'},	
								    {value:jhy_sale_3, name:'爆品战略'},
                                    {value:tg_sale, name:'铁杆社员'}
                                   
                                ]
                            }
                        ]
                    };

                

            var option_count = {
                                title: {
                                    text: '商品销量排名统计图'
                                },
                                tooltip : {
                                    trigger: 'axis'
                                },
                                
                                calculable : true,
                                legend: {
                                    data:['销量(单位:笔)']
                                },
                                xAxis : [
                                    {
                                        data: ["股权博弈","股权架构","社群运营","爆品战略","铁杆社员"]
                                    }
                                ],
                                yAxis : [
                                    {
                                        type : 'value',
                                        position: 'right'
                                    }
                                ],
                                series : [
                                    {
                                        name:'销量(单位:笔)',
                                        type:'bar',
                                        data:[by_count,jhy_count_1,jhy_count_2,jhy_count_3,tg_count]
                                    },

                                    {
                                        name:'销量饼状细分',
                                        type:'pie',
                                        tooltip : {
                                            trigger: 'item',
                                            formatter: '{a} <br/>{b} : {c} ({d}%)'
                                        },
                                        center: [160,120],
                                        radius : [0, 50],
                                        itemStyle :　{
                                            normal : {
                                                labelLine : {
                                                    length : 20
                                                }
                                            }
                                        },
                                        data:[
                                            {value:by_count, name:'股权博弈'},
                                            {value:jhy_count_1, name:'股权架构'},
											{value:jhy_count_2, name:'社群运营'},
											{value:jhy_count_3, name:'爆品战略'},
                                            {value:tg_count, name:'铁杆社员'}
                                          
                                        ]
                                    }
                                ]

                    };
                                        
    
            // 为echarts对象加载数据 
            myChart.setOption(option); 
            myChart_count.setOption(option_count);
        }


    );



</script>
<script>
 
        
        /*** 表单提交 及点击按钮时的表单提交地址切换 xr 20140919 start ***/
        //点击搜索
        $("#btn_search").click(function(){
            var destination = $("input[name='url_search']").attr('val');    //获取提交地址
            $("#member_manage_from").attr('action', destination);   //切换提交地址
            $("#member_manage_from").submit();  //提交表单
            return false;
        });
      
        /*** end ***/
        

    
</script>
</body>
</html>