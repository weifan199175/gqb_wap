<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <form name="myform" class="J_ajaxForm" action="{:U('delete')}" method="post">
  <div class="table_list">
  <table width="100%" cellspacing="0">
        <thead>
          <tr>
            <td width="6%"  align="center"><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x" onClick="selectall('tagid[]');">全选</td>
            <td align="center" width="10%">发件人</td>            
			<td align="center" width="20%">标题</td>
			<td align="center" width="30%">内容</td>
			<td align="center" width="20%">收件人</td>
			<td align="center" width="10%">发送时间</td>
           <!-- <td align="center" width="15%">是否处理</td>  -->         
            <td align="center" width="7%">操作</td>
          </tr>
        </thead>
        <tbody>
        <volist name="lists" id="vo">
          <tr>
            <td width="50"><input type="checkbox" value="{$vo.id}" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="tagid[]">
			<input type="hidden" mid="{$vo.id}">
			{$vo.id}
			</td>
			<td align="center">{$vo.writeusers}</td>
            <td align="center">{$vo.title}</td>
            <td align="center">{$vo.content}</td>
			 <td align="center">{$vo.receiveusers}</td>
			  <td align="center">{$vo.senddate}</td>
			<!--<td align="center">
			<a href="#" class="yn" typeid="{$vo.id}" isok="{$vo.isok}" <if condition="$vo[isok] eq 1"> style="color:red;"</if>>
			<if condition="$vo[isok] eq 0">否<else />是</if>
			</a>
			</td> -->
           
            <td align="center">
            <?php
			$op = array();
			/*if(\Libs\System\RBAC::authenticate('edit')){
				$op[] = '<a href="'.U('MemberType/edit',array('id'=>$vo['id'])).'">修改</a>';
			}*/
			if(\Libs\System\RBAC::authenticate('del')){
				$op[] = '<a class="J_ajax_del" href="'.U('ListEmail/del',array('id'=>$vo['id'])).'">删除</a>';
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
		if(\Libs\System\RBAC::authenticate('deleteall')){
		?>
        <button class="btn  mr10 J_ajax_submit_btn" type="submit" data-action="{:U('ListEmail/deleteall')}">删除</button>
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
	/*
		//启用、禁用
		$(".yn").click(function(){
			var tid=$(this).attr("typeid");
			var v=$(this).attr("isok");
			
			$.ajax({
					type: "POST",
					url: "index.php?g=Jbr_Message&m=FanKui&a=isok",
					data: "isok="+v+"&tid="+tid,
					success: function(msg){	
					
					 if(msg == '1'){
						$(".yn").each(function(){
							if($(this).attr("typeid") == tid)
							{
								$(this).html("是");
								$(this).attr("isok","1");
							}
						});
												
					 }else{
						$(".yn").each(function(){
							if($(this).attr("typeid") == tid)
							{
								$(this).html("否");
								$(this).attr("isok","0");
							}
						});
					 }
				}
			}); 
			return false;
		});
	})*/
</script>
</body>
</html>