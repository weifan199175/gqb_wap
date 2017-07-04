<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
   <!--div class="h_a">搜索</div>
  <form method="post" id="order_manage_from">
	    <div class="search_type cc mb10">
	      <div class="mb10"> 
	  
			<span class="mr20">&nbsp;&nbsp;请选择订单状态：	       
	        <select class="select_2" name="orderstatu"style="width:70px;">
	          <option value="all" <if condition='$orderstatu eq all'>selected="selected"</if>>全部</option>
	          <option value="NO_PAY" <if condition='$orderstatu eq 0'>selected="selected"</if>>未支付</option>	
			  <option value="YES_SEND" <if condition='$orderstatu eq 1'>selected="selected"</if>>已发货</option>	
			  <option value="YES_PAY" <if condition='$orderstatu eq 2'>selected="selected"</if>>已付款</option>	
			  <option value="END" <if condition='$orderstatu eq 3'>selected="selected"</if>>完成</option>	
	        </select>	
			 <span class="mr20">&nbsp;&nbsp;订单编号<input name="onum" value="{$onum}" type="text" class="input"/>
			<span class="mr20">&nbsp;&nbsp;开始日期：<input  type="text" class="input length_3 J_datetime  date" size="16" value="{$starttime}" id="StartTime" name="starttime" />
			
			<span class="mr20">&nbsp;&nbsp;结束日期：<input  type="text" class="input length_3 J_datetime  date" size="16" value="{$endtime}" id="EndTime" name="endtime" />
	        <span class="mr20">&nbsp;&nbsp;收货人电话：<input name="mtel" value="{$mtel}" type="text" class="input"/>
	         <input class="btn" value="搜索" type="button" id="btn_search"/>
	        </span>
	       
	      </div>
		 
	    </div>
  </form-->
  <form name="myform" class="J_ajaxForm" action="" method="post">
  <div class="table_list">
  <table width="100%" cellspacing="0">
        <thead>
          <tr>
            <!--td width="5%"  align="center"><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x" onClick="selectall('tagid[]');">全选</td-->
            <!--td width="5%" align="center">编号</td-->
            <td align="center" width="10%">订单编号</td>
			 <td align="center" width="8%">收货人电话</td>
			  <td align="center" width="7%">收货人姓名</td>
			    <td align="center" width="7%">订单总价</td>
				<td align="center" width="6%">下单时间</td>
				<td align="center" width="7%">配送方式</td>
				<td align="center" width="7%">支付方式</td>
				<td align="center" width="7%">发货地址</td>
				
            <td align="center" width="8%">订单状态</td>  		
            <td align="center" width="10%">操作</td>
          </tr>
        </thead>
        <tbody>
        <volist name="orderList" id="vo">
          <tr>
            <!--td align="center"><input type="checkbox" value="{$vo.OrderID}" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="tagid[]">
			<input type="hidden" mid="{$vo.orderID}">
			</td-->
			<!--td align="center">
			{$vo.orderID}
			</td-->
            <td align="center">{$vo.order_num}</td>
            <td align="center">{$vo.customer_tel}</td>
			<td align="center">{$vo.customer}</td>
			<td align="center">{$vo.order_price}</td>
			<td align="center">{$vo.order_time}</td>
			<td align="center">{$vo.send_type}</td>
			<td align="center">{$vo.pay_type}</td>
			<td align="center">{$vo.Addr}</td>
			
			<td align="center">
			<a href="#" class="yn" typeid="{$vo.orderID}" isok="{$vo.rstatus}">
			<if condition="$vo[order_status] eq 0">待审核<else />通过</if>
			</a>
			</td>
            <td align="center">
            <?php
			$op = array();
			
			 if(\Libs\System\RBAC::authenticate('delete')){
				$op[] = '<a class="J_ajax_del" href="'.U('Order/th_del',array('id'=>$vo['orderID'])).'">删除</a>';
			}
			echo implode(" | ",$op);
			?> 
            </td>
          </tr>
        </volist>
        </tbody>
      </table>
      <div class="p10">
        <div class="pages"> {$Page} </div>
      </div>
  </div>
  <div class="btn_wrap">
      <div class="btn_wrap_pd">             
      	<!--label class="mr20"><input type="checkbox" class="J_check_all" data-direction="y" data-checklist="J_check_y">全选</label-->
       
        <?php
		if(\Libs\System\RBAC::authenticate('delete')){
		?>
       <!--button class="btn  mr10 J_ajax_submit_btn" type="submit" data-action="{:U('Order/deleteall')}">删除</button-->
        <?php
		}
		?>
      </div>
    </div>
  </form>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>
<script src="{$config_siteurl}statics/js/ua/jquery.ua.js?v"></script>
<script>
	$(function(){
		//审核申请退货的订单
		$(".yn").click(function(){
			var tid=$(this).attr("typeid");
			var v=$(this).attr("isok");
			$.ajax({
					type: "POST",
					url: "index.php?g=JBR_Order&m=Order&a=isok",
					data: "isok="+v+"&tid="+tid,
					success: function(msg){					
					 if(msg == '1'){
						$(".yn").each(function(){
							if($(this).attr("typeid") == tid)
							{
								$(this).html("通过");
								$(this).attr("isok","1");
							}
						});							
					 }else{
						$(".yn").each(function(){
							if($(this).attr("typeid") == tid)
							{
								$(this).html("待审核");
								$(this).attr("isok","0");
							}
						});
					 }
				}
			}); 
			return false;
		});
		
	
		
	 })
</script>

</body>
</html>