<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
   <div class="h_a">搜索</div>
  <form method="post" id="order_manage_from">
	    <div class="search_type cc mb10">
	      <div class="mb10"> 
	  
			
			
			<span class="mr20">&nbsp;&nbsp;开始日期：<input  type="text" class="input length_3 J_datetime  date" size="16" value="{$starttime}" id="StartTime" name="starttime" />
			<span class="mr20">&nbsp;&nbsp;结束日期：<input  type="text" class="input length_3 J_datetime  date" size="16" value="{$endtime}" id="EndTime" name="endtime" />
			<span class="mr20">&nbsp;&nbsp;会员姓名：<input name="truename" value="{$truename}" type="text" class="input"/>
	        <span class="mr20">&nbsp;&nbsp;联系电话：<input name="mobile" value="{$mobile}" type="text" class="input"/>
	         <input value="1" type="hidden" name="url_search"/>
	         <input class="btn" value="搜索" type="button" id="btn_search"/>
	        </span>
	       
	      </div>
		    <input type="button"  value="导出搜索内容" id="btn_out" class="btn"/>
			<input type="hidden" value="1" val="{:U('Charge/index')}" name="url_search" >
			<input type="hidden" value="2" val="{:U('Charge/excel')}" name="url_out" >
	    </div>
  </form>
  <form name="myform" class="J_ajaxForm" action="" method="post">
  <div class="table_list">
  <table width="100%" cellspacing="0">
        <thead>
          <tr>
            <!--td width="5%"  align="center">
			<input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x" onClick="selectall('tagid[]');">
			全选</td-->
            <!--td width="5%" align="center">编号</td-->
            <td align="center" width="5%">订单编号</td>
			<td align="center" width="5%">会员名</td>
			<td align="center" width="8%">电话</td>
			<td align="center" width="7%">充值时间</td>
			<td align="center" width="7%">付费方式</td>
			<td align="center" width="5%">充值金额</td>
            <td align="center" width="8%">订单状态</td>  
            <!--
			<td align="center" width="10%">备注</td>   
            <td align="center" width="10%">操作</td> 	
            -->			
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
            <td align="center">{$vo.id}</td>
			<td align="center">{$vo.truename}</td>
            <td align="center">{$vo.mobile}</td>
			<td align="center">{$vo.addtime}</td>
			<td align="center">{$vo.rpay_type}</td>
			<td align="center">{$vo.price}</td>
			<td align="center">{$vo.rstatus}</td>
			<!--
			<td align="center">{$vo.des}</td>
            <td align="center">
            <?php
			// $op = array();
				// if(\Libs\System\RBAC::authenticate('edit')){
					// $op[] = '<a href="'.U('Charge/edit',array('id'=>$vo['id'])).'">修改</a>';
				// }
			  // echo implode(" | ",$op);
			?> 
            </td>
			-->
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
       <!-- <button class="btn  mr10 J_ajax_submit_btn" type="submit" data-action="{:U('Order/deleteall')}">删除</button> -->
        <?php
		}
		?>
      </div>
    </div>
  </form>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>

<script>
	$(function(){
		
		
		/*** 表单提交 及点击按钮时的表单提交地址切换 xr 20140905 start ***/
		//点击搜索
		$("#btn_search").click(function(){
			//var destination = $("input[name='url_search']").attr('val');	//获取提交地址
			//$("#order_manage_from").attr('action', destination);	//切换提交地址
			$("#order_manage_from").submit();	//提交表单
			return false;
		});
		//点击导出
            $("#btn_out").click(function(){
			var destination = $("input[name='url_out']").attr('val');
			$("#order_manage_from").attr('action', destination);
			$("#order_manage_from").submit();
			return false;
		});
		
	})
</script>
</body>
</html>