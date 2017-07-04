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
				<span class="mr20">选择省名：	
				<select class="select_2" name="area_id" style="width:100px;">
					<option value=""  <if condition="$area_id eq ''">selected="selected"</if>>全部</option>
					<volist name="lists" id="vo">
					<option value="{$vo.id}" <if condition="$vo['id'] eq $area_id">selected="selected"</if> >{$vo.area_name}</option>
					</volist>         
				</select>		
                <span class="mr20">
					<input class="btn" value="搜索" type="button" id="btn_search"/>
				</span>				
			</div>
			
		</div>
	</form>
	<!--{/条件搜索}-->
	
  <form name="myform" class="J_ajaxForm" action="{:U('delete')}" method="post">
  <div class="table_list">
  <table width="100%" cellspacing="0">
   <thead>
          <tr>
            <td width="50"  align="center"><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x" onClick="selectall('tagid[]');">全选</td>
            <td align="center">编号</td>
            <td>地区名称</td>
            <td align="center" width="50">状态</td>
            <td align="center" width="80">相关操作</td>
          </tr>
        </thead>
  <span>注：一级分类（地区分布）默认为黑色，各省名词颜色为<font color="red">红色</font>各市名称为<font color="green">绿色</font></span>
        <tbody>
        <volist name="res" id="vo">
          <tr>
            <td align="center"><input type="checkbox" value="{$vo.id}" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="tagid[]">
			<input type="hidden" mid="{$vo.id}">
			</td>
			<td align="center">{$vo.id}</td>
            <td>{$vo.area_name}</td>
			<td align="center">
			<a href="#" class="yn" typeid="{$vo.id}" isok="{$vo.show_status}">
			<if condition="$vo[show_status] eq 0">不显示<else />显示</if>
			</a>
			</td>
           
            <td align="center">
            <?php
			$op = array();
			if(\Libs\System\RBAC::authenticate('edit')){
				$op[] = '<a href="'.U('Area/edit',array('id'=>$vo['id'])).'">修改</a>';
			}
			if(\Libs\System\RBAC::authenticate('delete')){
				$op[] = '<a class="J_ajax_del" href="'.U('Area/delete',array('id'=>$vo['id'])).'">删除</a>';
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
      	<label class="mr20"><input type="checkbox" class="J_check_all" data-direction="y" data-checklist="J_check_y">全选</label>
       
        <?php
		if(\Libs\System\RBAC::authenticate('delete')){
		?>
        <button class="btn  mr10 J_ajax_submit_btn" type="submit" data-action="{:U('Member/deleteall')}">删除</button>
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
		//启用、禁用
		$(".yn").click(function(){
			var tid=$(this).attr("typeid");
			var v=$(this).attr("isok");
			
			$.ajax({
					type: "POST",
					url: "index.php?g=Admin&m=Area&a=isok",
					data: "isok="+v+"&tid="+tid,
					success: function(msg){					
					 if(msg == '1'){
						$(".yn").each(function(){
							if($(this).attr("typeid") == tid)
							{
								$(this).html("显示");
								$(this).attr("isok","1");
							}
						});								
					 }else{
						$(".yn").each(function(){
							if($(this).attr("typeid") == tid)
							{
								$(this).html("不显示");
								$(this).attr("isok","0");
							}
						});
					 }
				}
			}); 
			return false;
		});
		
		
		/*** 表单提交 及点击按钮时的表单提交地址切换 xr 20140919 start ***/
		//点击搜索
		$("#btn_search").click(function(){
			var destination = $("input[name='url_search']").attr('val');	//获取提交地址
			$("#member_manage_from").attr('action', destination);	//切换提交地址
			$("#member_manage_from").submit();	//提交表单
			return false;
		});
		//点击导出
		// $("#btn_out").click(function(){
			// var destination = $("input[name='url_out']").attr('val');
			// $("#member_manage_from").attr('action', destination);
			// $("#member_manage_from").submit();
			// return false;
		// });
		// /*** end ***/
		
		
	 })
</script>
</body>
</html>