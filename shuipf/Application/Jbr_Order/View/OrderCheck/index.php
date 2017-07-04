<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
   <div class="h_a">搜索</div>
  <form method="post" id="order_manage_from">
	    <div class="search_type cc mb10">
	      <div class="mb10"> 
	  
			
			<span class="mr20">&nbsp;&nbsp;核销码：<input name="ordernum" value="" type="text" class="input"/>
			
	         <input value="1" type="hidden" name="url_search"/>
	         <input class="btn" value="搜索" type="button" style="color:red;" id="btn_search"/>
	        </span>
	        
	      </div>
		   
			<input type="hidden" value="1" val="{:U('OrderCheck/index')}" name="url_search" >
			<!--<input type="hidden" value="2" val="{:U('Order/excel')}" name="url_out" >-->
	    </div>
  </form>
   <if condition="!empty($res)">
  
  <form action="{:U('OrderCheck/check')}" method="post">
  <div class="table_list">
  
  <table width="100%" cellspacing="0">
  <tbody>
        <tr>
		
					<th width="100px">场次</th>         	
					<td>{$res['title']}</td>
					<th width="100px">开讲时间</th>         	
					<td>
					   {$res.start_time|date="Y-m-d H:i:s",###}
					</td>
					<th width="100px">讲师</th>         	
					<td>
					   {$res.teacher}
					</td>
				  </tr>
				  <tr>
					<th width="100px">购买人姓名</th>         	
					<td>{$res['truename']}</td>
					<th width="100px">联系方式</th>         	
					<td>{$res['truename']}</td>
					
				  </tr>
				  <tr>
					<th width="100px">状态</th>         	
					<td>{$res['rstatus']}</td>
					<th width="100px">支付方式</th>         	
					<td>{$res['rpay_type']}</td>	
				  </tr>
				  
				  				  
    
				</tbody>
      </table>
     
      <input type="hidden" value="{$verification_code}" name="verification_code" />
  </div>
  
   <button style="color:green;" class="btn" type="submit" >确认核销</button>
  
  
    </div>
  </form>
   </if>
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