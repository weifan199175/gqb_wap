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
			
			<span class="mr20">记录时间：
			 <input type="text" name="start_time" class="input length_2 J_date" value="{$start_time}" style="width:80px;">-<input type="text" class="input length_2 J_date" name="end_time" value="{$end_time}" style="width:80px;">
			</span>	
			
			<span class="mr20">
			&nbsp;&nbsp;姓名：<input type="text" name="name" class="input length_2" value="{$name}" style="width:80px;">
			</span>	
			<span class="mr20">
			&nbsp;&nbsp;手机号：<input type="text" name="mobile" class="input length_2" value="{$mobile}" style="width:100px;">
			</span>	
			<span class="mr20">
			&nbsp;&nbsp;公司名称：<input type="text" name="company" class="input length_2" value="{$company}" style="width:100px;">
			</span>	
			<span class="mr20">
			&nbsp;&nbsp;职位：<input type="text" name="job" class="input length_2" value="{$job}" style="width:100px;">
			</span>	

			<span class="mr20">&nbsp;&nbsp;意向：				
			<select class="select_2" name="is_need" style="width:80px;">
				<option value="">全部</option>
                <?php foreach ($isNeedList as $k=>$n){?>
                    <option value="<?php echo $n?>" <?php echo $is_need==$n?"selected='selected'":""?>><?php echo $n?></option>
                <?php }?>
			</select>
			</span>
			
			<span class="mr20">&nbsp;&nbsp;所属客服：
			<select class="select_2" name="kefu" style="width:120px;">
				<option value="">全部</option>
                <?php foreach ($kefu_list as $k=>$n){?>
                    <option value="<?php echo $n?>" <?php echo $kefu==$n?"selected='selected'":""?>><?php echo $n?></option>
                <?php }?>
			</select>
			</span>
			<div class="mr20" style="margin-top:10px;">
			
			<span class="mr20">&nbsp;&nbsp;所属渠道：				
                <?php foreach ($source_list as $k=>$n){?>
                <label><input name="source[]" type="checkbox" value="<?php echo $n?>" <?php echo in_array($n, $source)?"checked='checked'":""?> /><?php echo $n?></label> 
                <?php }?>
			</span>
			
			<span class="mr20">&nbsp;&nbsp;省份：				
			<select class="select_2" name="province" style="width:100px;">
				<option value="">全部</option>
                <?php foreach ($province_list as $k=>$n){?>
                    <option value="<?php echo $n?>" <?php echo $province==$n?"selected='selected'":""?>><?php echo $n?></option>
                <?php }?>
			</select>
			</span>
			
			<span class="mr20">&nbsp;&nbsp;方式：				
			<select class="select_2" name="way" style="width:100px;">
				<option value="">全部</option>
                <?php foreach ($way_list as $k=>$n){?>
                    <option value="<?php echo $n?>" <?php echo $way==$n?"selected='selected'":""?>><?php echo $n?></option>
                <?php }?>
			</select>
			</span>
			
			<span class="mr20">
			&nbsp;&nbsp;备注：<input type="text" name="extra" class="input length_2" value="{$extra}" style="width:160px;">
			</span>	
			
				<input class="btn" value="搜　 索" type="button" id="btn_search" style="color:red;"/>	
				<a href="index.php?g=Jbr_Membership&m=Membership&a=t_user" class="btn">重　 置</a>
				<?php if($_SESSION['jbr_admin_id'] == 1 || $_SESSION['jbr_admin_id'] == 5){?>
				<input type="button"  value="导出搜索内容" id="btn_out" class="btn"/>
				<?php }?>
			</div>
			</div>
			<?php if($role_id == 1 || $role_id ==13){?>
				<input class="btn js_saveKefu" value="将√勾选的学员分配给他——>" type="button"/>
				<select id="kefu">
    			 <?php foreach ($kefu_list as $e=>$f){?>
    			     <option value="<?php echo $f?>"><?php echo $f?></option>
    			 <?php }?>
				</select>
			<?php }?>
						
			<input type="hidden" value="0" name="is_excal">
			<input type="hidden" value="1" val="{:U('Membership/t_user')}" name="url_search" >
		</div>
	</form>
	<!--{/条件搜索}-->
  <div class="table_list">
  <table width="100%" cellspacing="0">
        <thead>
          <tr>
            
            <td width="8%" align="center"><input type="checkbox" id="checkAll">编号(全选)</td>
            <td align="center" width="5%">姓名</td>
			<td align="center" width="10%">手机号</td>
			<td align="center" width="10%">公司名称</td>
			<td align="center" width="9%">职位</td>
			<td align="center" width="10%">渠道</td>
			<td align="center" width="9%">省份</td>
			<td align="center" width="5%">方式</td>
			<td align="center" width="5%">记录时间</td>
			<td align="center" width="7%">课程意向</td>
			<td align="center" width="7%">所属客服</td>
            <td align="center" width="5%">备注</td>
            <td align="center" width="10%">操作</td>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($t_user as $k=>$vo){?>
          <tr>
            <td align="center"><input type="checkbox" value="<?php echo $vo['id']?>" class="sortUser"><?php echo $vo['id']?></td> 
            <td align="center"><?php echo $vo['name']?></td> 
            <td align="center"><?php echo $vo['mobile']?></td> 
            <td align="center"><?php echo $vo['company']?></td> 
			<td align="center"><?php echo $vo['job']?></td>
			<td align="center"><?php echo $vo['source']?></td>
            <td align="center"><?php echo $vo['province']?></td> 
            <td align="center"><?php echo $vo['way']?></td> 
            <td align="center"><?php echo date("Y-m-d",$vo['datetime'])?></td> 
            <td align="center">
                <select class="js_saveisneed" data-mobile="<?php echo $vo['mobile']?>">
                <?php foreach ($isNeedList as $k=>$n){?>
                    <option value="<?php echo $n?>" <?php echo $vo['is_need']==$n?"selected='selected'":""?>><?php echo $n?></option>
                <?php }?>
                </select>
            </td> 
            <td align="center"><?php echo $vo['kefu']?></td> 
            <td align="center"><textarea><?php echo $vo['extra']?></textarea></td> 
            <td align="center">
            <?php
            $op = array();
            if($role_id == 1){
                $op[] = '<a href="'.U('Membership/edit_t_user',array('id'=>$vo['id'])).'">编辑</a>';
            }
			$op[] = '<a href="javascript:void(0)" class="js_saveExtra" data-mobile="'.$vo['mobile'].'">保存备注</a>';
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
				data: "mobile="+mobile+"&extra="+extra+"&tableName=t_user",
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
			$("input[type='checkbox'].sortUser:checked").each(function(){
				id_list.push($(this).val());
			});
			
			var kefu = $("#kefu").val();
			$.ajax({
				type: "POST",
				url: "index.php?g=Jbr_Membership&m=Membership&a=saveKefu",
				data: {id_list:id_list,kefu:kefu,tableName:"t_user"},
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
				data: {mobile:mobile,is_need:is_need,tableName:"t_user"},
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
			$('input:checkbox.sortUser').each(function(){
				$(this).prop('checked',true);
			});
		}else{
			$('input:checkbox.sortUser').each(function(){
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