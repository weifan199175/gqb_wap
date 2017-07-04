<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  
	<!--{条件搜索}-->
    <div class="h_a">搜索</div>
    <form method="post" id="funding_manage_from">
		<div class="search_type cc mb10">
			<div class="mb10">
			
			<span class="mr20">
			发起人姓名：<input type="text" name="truename" class="input length_2" value="{$truename}" style="width:80px;">
			</span>	
			<span class="mr20">
			手机号：<input type="text" name="mobile" class="input length_2" value="{$mobile}" style="width:80px;">
			</span>	
			<span class="mr20">众筹课程：
			<select class="select_2" name="courses_id" style="width:100px;">
				<option value="all" >全部</option>
				<volist name="courses" id="vo">
				    <option value="{$vo.id}" <if condition='$vo.id eq $courses_id'>selected="selected"</if> >{$vo.title}</option>
				</volist>         
			</select>
			</span>
			
			<span class="mr20">状态：
			<select class="select_2" name="status" style="width:100px;">
			  <option value="all" <if condition='$status eq "all"'>selected="selected"</if>>全部</option>
	          <option value="0" <if condition='$status eq "0"'>selected="selected"</if>>进行中</option>
			  <option value="1" <if condition='$status eq "1"'>selected="selected"</if>>已完成</option>	
			  <option value="-1" <if condition='$status eq "-1"'>selected="selected"</if>>已过期</option>	
			</select>
			</span>
			
			<div class="mr20" style="margin-top:3px;">
				<input class="btn" value="搜　 索" type="button" id="btn_search" style="color:red;"/>	
			</div>
			</div>
						
			<input type="hidden" value="1" val="{:U('Funding/index')}" name="url_search" >
			<input type="hidden" value="2" val="{:U('Funding/excel')}" name="url_out" >
		</div>
	</form>
  
  
  <form name="myform" class="J_ajaxForm" action="" method="post">
  <div class="table_list">
  <table width="100%" cellspacing="0">
        <thead>
          <tr>
            <td align="center" >活动ID</td>
			<td align="center" >众筹课程</td>
			<td align="center" >发起人</td>
			<td align="center" >联系电话</td>
			<td align="center" >总金额</td>
			<td align="center" >累计金额</td>
			<td align="center" >状态</td>
			<td align="center" >创建时间</td>
			<td align="center" >截止时间</td>
			<td align="center" >更新时间</td>
            <td align="center" width="10%">操作</td>
          </tr>
        </thead>
        <tbody>
        <volist name="funding" id="fb">
          <tr>
            <td align="center">{$fb.id}</td>
			<td align="center">{$fb.title}</td>
			<td align="center">{$fb.truename}</td>
			<td align="center">{$fb.mobile}</td>
			<td align="center">{$fb.price}</td>
			<td align="center">{$fb.total_price}</td>
			<td align="center">{$fb.status}</td>
			<td align="center">{$fb.create_time}</td>
			<td align="center">{$fb.end_time}</td>
			<td align="center">{$fb.updatetime}</td>
            <td align="center">
            <?php
            $op = array();
				$op[] = '<a href="'.U('Funding/order',array('fid'=>$fb['id'])).'">详情</a>';
// 			if(\Libs\System\RBAC::authenticate('del')){
// 				$op[] = '<a href="'.U('Fenbu/del',array('id'=>$fb['id'])).'">删除</a>';
// 			}
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
  </form>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>

<script>
	$(function(){
		
		
		/*** 表单提交 及点击按钮时的表单提交地址切换 xr 20140905 start ***/
		//点击搜索
		$("#btn_search").click(function(){
			var destination = $("input[name='url_search']").attr('val');	//获取提交地址
			$("#funding_manage_from").attr('action', destination);	//切换提交地址
			$("#funding_manage_from").submit();	//提交表单
			return false;
		});
		//点击导出
            $("#btn_out").click(function(){
			var destination = $("input[name='url_out']").attr('val');
			$("#funding_manage_from").attr('action', destination);
			$("#funding_manage_from").submit();
			return false;
		});
		/*** end ***/
		
	})
</script>
</body>
</html>