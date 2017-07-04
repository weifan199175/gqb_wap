<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
   <div class="h_a">操作</div>
  <form method="post" id="order_manage_from">
	    <div class="search_type cc mb10">
	      <div class="mb10"> 
	        <!--
			<span class="mr20">&nbsp;&nbsp;开始日期：<input  type="text" class="input length_3 J_datetime  date" size="16" value="{$stime}" id="StartTime" name="starttime" />
			
			<span class="mr20">&nbsp;&nbsp;结束日期：<input  type="text" class="input length_3 J_datetime  date" size="16" value="{$etime}" id="EndTime" name="endtime" />
			-->
			
	         <input value="1" type="hidden" name="url_search"/>
			 <!--
	         <input class="btn" value="搜索" type="button" style="color:red;" id="btn_search"/>
			 -->
			 <input type="button"  value="导出内容" id="btn_out" class="btn"/>
	        </span>
	      
	      </div>
		   
			<input type="hidden" value="1" val="{:U('ScoreReturn/index')}" name="url_search" >
			<input type="hidden" value="2" val="{:U('ScoreReturn/excel')}" name="url_out" >
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
            <td width="10%" align="center">编号</td>
            
			<td align="center" width="20%">会员姓名</td>
			<td align="center" width="20%">手机号</td>
			<td align="center" width="10%">会员等级</td>
			<td align="center" width="20%">可用积分</td>
			<td align="center" width="20%">总积分</td>
		  
          </tr>
        </thead>
        <tbody>
        <volist name="list" id="vo">
          <tr>
            <!--td align="center"><input type="checkbox" value="{$vo.OrderID}" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="tagid[]">
			<input type="hidden" mid="{$vo.orderID}">
			</td-->
			<td align="center">
			{$vo.id}
			</td>
			<td align="center">{$vo.truename}</td>
			<td align="center">{$vo.mobile}</td>
            <td align="center">{$vo.class_name}</td>
			<td align="center">{$vo.score}</td>
			<td align="center">{$vo.total_score}</td>
			
           
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
			var destination = $("input[name='url_search']").attr('val');	//获取提交地址
			$("#order_manage_from").attr('action', destination);	//切换提交地址
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
		/*** end ***/
		
	})
</script>
</body>
</html>