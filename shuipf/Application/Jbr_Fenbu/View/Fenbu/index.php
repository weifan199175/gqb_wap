<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
   <div class="h_a"><!-- 搜索 --></div>
  <form method="post" id="order_manage_from">
	    <div class="search_type cc mb10">
	      <div class="mb10"> 
	      </div>
	    </div>
  </form>
  <form name="myform" class="J_ajaxForm" action="" method="post">
  <div class="table_list">
  <table width="100%" cellspacing="0">
        <thead>
          <tr>
            <td align="center" >分社ID</td>
			<td align="center" >分社名称</td>
			<td align="center" >现有金额</td>
			<td align="center" >累计金额</td>
			<td align="center" >邀请码</td>
			<td align="center" >创建时间</td>
			<td align="center" >更新时间</td>
            <td align="center" width="10%">操作</td>
          </tr>
        </thead>
        <tbody>
        <volist name="fenbulist" id="fb">
          <tr>
            <td align="center">{$fb.id}</td>
			<td align="center">{$fb.name}</td>
			<td align="center">{$fb.price}</td>
			<td align="center">{$fb.total_price}</td>
            <td align="center"><a target="_blank" href="/index.php?m=User&a=reg&fenbu_code={$fb.invitation_code}">{$fb.invitation_code}</a>（点击跳转到该分社股东注册地址）</td>
			<td align="center">{$fb.datetime}</td>
			<td align="center">{$fb.updatetime}</td>
            <td align="center">
            <?php
            $op = array();
            if(\Libs\System\RBAC::authenticate('edit')){
				$op[] = '<a href="'.U('Fenbu/edit',array('id'=>$fb['id'])).'">修改</a>';
			}
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