<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <!--{条件搜索}-->
	<!--{/条件搜索}-->
  <div class="table_list">
  <table width="100%" cellspacing="0">
        <thead>
          <tr>
            <td width="6%" align="center">编号</td>
            <td align="center" width="4%">姓名</td>
            <td align="center" width="10%">手机号</td>
			<td align="center" width="10%">问题1</td>
			<td align="center" width="9%">问题2</td>
			<td align="center" width="8%">问题3</td>
			<td align="center" width="8%">问题4</td>
			<td align="center" width="10%">记录时间</td>
			<td align="center" width="5%">所属客服</td>
			<td align="center" width="10%">意向</td>
			<td align="center" width="10%">备注</td>
            <td align="center" width="10%">操作</td>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $k=>$vo){?>
          <tr>
            <td align="center"><?php echo $vo['id']?></td> 
            <td align="center"><?php echo $vo['truename']?></td> 
            <td align="center"><?php echo $vo['mobile']?></td> 
            <td align="center"><?php echo $vo['q_one']?></td> 
            <td align="center"><?php echo $vo['q_two']?></td> 
            <td align="center"><?php echo $vo['q_three']?></td> 
            <td align="center"><?php echo $vo['q_four']?></td> 
			<td align="center"><?php echo date("Y-m-d H:i:s",$vo['createtime'])?></td>
            <td align="center"><?php echo $vo['ascription']?></td> 
            <td align="center">
			<?php if(empty($vo['is_need'])){?>
			    <?php echo $vo['is_need']?>
			<?php }else {?>
                <select class="js_saveisneed" data-mobile="<?php echo $vo['mobile']?>">
                <?php foreach ($isNeedList as $k=>$n){?>
                    <option value="<?php echo $n?>" <?php echo $vo['is_need']==$n?"selected='selected'":""?>><?php echo $n;?></option>
                <?php }?>
                </select>
			<?php }?>
			</td>
            <td align="center"><textarea><?php echo $vo['state']?></textarea></td> 
            <td align="center">
            <?php
            $op = array();
			
				$op[] = '<a href="javascript:void(0)" class="js_saveExtra" data-mobile="'.$vo['mobile'].'">保存备注</a>';
			/*
			if(\Libs\System\RBAC::authenticate('del')){
				$op[] = '<a class="J_ajax_del" href="'.U('Membership/del',array('id'=>$vo['id'])).'">删除</a>';
			}
			*/
			echo implode(" | ",$op);
			?> 
            </td>
          </tr>
        <?php }?>
        </tbody>
      </table>
      <div class="p10">
        <div class="pages"> {$Page} &nbsp;&nbsp;跳转到第&nbsp;&nbsp;<input type="text" id="sss" style="width:25px;" />&nbsp;&nbsp;页</div>
      </div>
  </div>
  <script src="{$config_siteurl}statics/js/common.js?v"></script>
</div>

<script type="text/javascript">
 $(function(){
		$(".js_saveExtra").click(function(){
			var mobile = $(this).data('mobile');
			var extra = $(this).parents('tr').find('textarea').val();
			$.ajax({
				type: "POST",
				url: "index.php?g=Jbr_Membership&m=Membership&a=saveExtra",
				data: "mobile="+mobile+"&extra="+extra+"&tableName=mem_ascrip",
				success: function(res){
					 if(res == "1"){
						 alert("成功！手机号为"+mobile);
					 }else {
						 alert("失败~~~~手机号为"+mobile);
					 }
				}
			}); 
		});
		$(".js_saveKefu").click(function(){
		    //批量分配客服
			var id_list = new Array();
			$("input[type='checkbox'].sortStudent:checked").each(function(){
				id_list.push($(this).val());
			});
			
			var kefu = $("#kefu").val();
			$.ajax({
				type: "POST",
				url: "index.php?g=Jbr_Membership&m=Membership&a=saveKefu",
				data: {id_list:id_list,kefu:kefu,tableName:"mem_ascrip"},
				success: function(res){
					 if(res == "1"){
						 alert("成功！");
					 }else {
						 alert("失败~");
					 }
				}
			}); 
		});
		$(".js_saveisneed").bind('change',function(event){
			var mobile = $(this).data('mobile');
			var is_need = $(this).val();
			$.ajax({
				type: "POST",
				url: "index.php?g=Jbr_Membership&m=Membership&a=saveIsNeed",
				data: {mobile:mobile,is_need:is_need,tableName:"mem_ascrip"},
				success: function(res){
					 if(res == "1"){
						 alert("意向修改成功！");
					 }else {
						 alert("学员意向修改失败~");
					 }
				}
			}); 
		});
	 
	$('#sss').bind('keypress',function(event){
            if(event.keyCode == "13")    
            {
	           var p = /&page=([0-9]+)/;
			   var num = $("#sss").val();
			   var url = $("#sss").siblings('a:first').attr('href')
			   url = url.replace(p,'&page='+num);
			   //alert($("#sss").siblings('a:first').attr('href'));
			   window.location.href=url;
            }
        });

	$('#checkAll').on('click',function(){
		var check = $(this).prop('checked');
		if(check == true){
			$('input:checkbox').each(function(){
				$(this).prop('checked',true);
			});
		}else{
			$('input:checkbox').each(function(){
				$(this).prop('checked',false);
			});
		}
	});
	    
		
   })
		
$(function(){
		
		/*** 表单提交 及点击按钮时的表单提交地址切换 xr 20140919 start ***/
		//点击搜索
		$("#btn_search").click(function(){
			$("input[name='is_excal']").val("0");
			var destination = $("input[name='url_search']").attr('val');	//获取提交地址
			$("#member_manage_from").attr('action', destination);	//切换提交地址
			$("#member_manage_from").submit();	//提交表单
			return false;
		});
		//点击导出
		$("#btn_out").click(function(){
			$("input[name='is_excal']").val("1");
			$("#member_manage_from").submit();
// 			return false;
		});
		/*** end ***/
		
	})
</script>
</body>
</html>