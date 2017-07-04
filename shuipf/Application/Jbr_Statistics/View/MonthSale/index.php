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
            
            <span class="mr20">&nbsp;&nbsp;年份：				
				<select class="select_2" name="year" style="width:70px;">
					<option value="2016" <if condition="$year eq 2016">selected="selected"</if>>2016</option>
					<option value="2017" <if condition="$year eq 2017">selected="selected"</if>>2017</option>
					<option value="2018" <if condition="$year eq 2018">selected="selected"</if>>2018</option>
					<option value="2019" <if condition="$year eq 2019">selected="selected"</if>>2019</option>
					<option value="2020" <if condition="$year eq 2020">selected="selected"</if>>2020</option>
				</select>
			</span>
             
            <span class="mr20">&nbsp;&nbsp;月份：				
				<select class="select_2" name="month" style="width:50px;">
				<?php for($i=1;$i<=12;$i++){ ?>
					<option value="<?php echo $i; ?>" <if condition="$month eq $i">selected="selected"</if>><?php echo $i; ?></option>
				<?php } ?>
				</select>
			</span>			 
              
                <input class="btn" value="搜　 索" type="button" id="btn_search" style="color:red;"/>  
                
            </div>
                        
            <input type="hidden" value="1" val="{:U('MonthSale/index')}" name="url_search" >
         
        </div>
    </form>
    <!--{/条件搜索}-->
    <div id="main_num" style="height:400px;width:50%; float:left;text-align:center; ">
        
        <table width="450px" height="100px" cellspacing="0" cellpadding="0" border="1">
            <tr>
                <td>编号</td>
                <td>商品名称</td>
                <td>销量(笔)</td>
                <td>销售额(元)</td>
            </tr>
            <tr>
                <td>1</td>
                <td>课程购买</td>
                <td>{$course_count}</td>
                <td>{$course_sale}</td>
            </tr>
            <tr>
                <td>2</td>
                <td>铁杆社员</td>
                <td>{$tg_count}</td>
                <td>{$tg_sale}</td>
            </tr>
            <tr>
                <td>3</td>
                <td>会员充值</td>
                <td>{$charge_count}</td>
                <td>{$charge_sale}</td>
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
    
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>


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