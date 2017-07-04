<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
   <div class="h_a">搜索</div>
  <form method="post" id="order_manage_from">
		<div class="search_type cc mb10">
			<div class="mb10">
			<span class="mr20">所属分社：
			<select class="select_2" name="fenbu_id" style="width:100px;">
				<volist name="fenbu" id="f">
				<option value="{$f.id}" <if condition='$f.id eq $fenbu_id'>selected="selected"</if> >{$f.name}</option>
				</volist>         
			</select>
			</span>
				
				<input class="btn" value="搜　 索" type="button" id="btn_search" style="color:red;"/>	
				<!-- <input type="button"  value="导出搜索内容" id="btn_out" class="btn"/>	 -->
			</div>
						
			<input type="hidden" value="1" val="{:U('Fenbu/log')}" name="url_search" >
			<input type="hidden" value="2" val="{:U('Fenbu/excel')}" name="url_out" >
		</div>
  </form>
  <form name="myform" class="J_ajaxForm" action="" method="post">
  <div class="table_list">
  <table width="100%" cellspacing="0">
        <thead>
          <tr>
            <td align="center" >编号</td>
			<td align="center" >姓名</td>
			<td align="center" >提成比例</td>
			<td align="center" >获得金额</td>
			<td align="center" >收入分社</td>
			<td align="center" >订单编号</td>
			<td align="center" >创建时间</td>
            <!-- <td align="center" width="10%">操作</td> -->
          </tr>
        </thead>
        <tbody>
        <volist name="fenxiaolog" id="fx">
          <tr>
            <td align="center">{$fx.id}</td>
			<td align="center">{$fx.truename}</td>
			<td align="center">{$fx.point}</td>
			<td align="center">{$fx.money}</td>
			<td align="center">{$fx.name}</td>
			<td align="center"><a target="_blank" href='{:U("Jbr_Order/Order/index","ordernum=".$fx["verification_code"])}'>{$fx.verification_code}</a></td>
			<td align="center">{$fx.datetime}</td>
            <td align="center">
            </td>
          </tr>
        </volist>
        </tbody>
      </table>
      <div class="p10">
        <div class="pages"> {$Page} </div>
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