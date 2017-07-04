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
			
			<span class="mr20">注册时间：
			<input type="text" name="start_time" class="input length_2 J_date" value="{$stime}" style="width:80px;">-<input type="text" class="input length_2 J_date" name="end_time" value="{$etime}" style="width:80px;">
			</span>	
			<span class="mr20">
			&nbsp;&nbsp;注册来源：<input type="text" name="source" class="input length_2" value="{$source}" style="width:80px;">
			</span>	
			<span class="mr20">&nbsp;&nbsp;会员等级：
			
			<select class="select_2" name="member_class" style="width:100px;">
				<option value="0"  <if condition="$member_class_id eq 0">selected="selected"</if>>全部</option>
				<volist name="classList" id="vo">
				<option value="{$vo.id}" <if condition='$vo.id eq $member_class'>selected="selected"</if> >{$vo.class_name}</option>
				</volist>         
			</select>
			</span>
			
			
			<span class="mr20">
			公司名称：<input type="text" name="company" class="input length_2" value="{$company}" style="width:80px;">
			</span>
			
			<!-- <span class="mr20">所属分社：
			<select class="select_2" name="fenbu_id" style="width:100px;">
				<volist name="fenbu" id="f">
				<option value="{$f.id}" <if condition='$f.id eq $fenbu_id'>selected="selected"</if> >{$f.name}</option>
				</volist>
			</select>
			</span> -->
			
			<span class="mr20">所属客服：
			<select class="select_2" name="kefu_id" style="width:100px;">
				<volist name="kefu" id="f">
				<option value="{$f}" <if condition='$f eq $kefu_id'>selected="selected"</if> >{$f}</option>
				</volist>
			</select>
			</span>

				<span class="mr20">&nbsp;&nbsp;关键字：				
				<select class="select_2" name="keyword_type" style="width:70px;">
					<option value="mobile" <if condition="$keyword_type eq 'mobile'">selected="selected"</if>>账号</option>
					<option value="id" <if condition="$keyword_type eq 'id'">selected="selected"</if>>ID</option>
					
					<option value="email" <if condition="$keyword_type eq 'email'">selected="selected"</if>>邮箱</option>
					<option value="qq" <if condition="$keyword_type eq 'qq'">selected="selected"</if>>QQ</option>
					<option value="truename" <if condition="$keyword_type eq 'truename'">selected="selected"</if>>姓名</option>
				</select>
				</span>
				
				<span class="mr20">
					<input name="keyword" type="text" value="{$keyword}" class="input"/>					
				</span>
				
			<span class="mr20">&nbsp;&nbsp;学员意向：				
			<select class="select_2" name="is_need" style="width:120px;">
				<option value="">全部</option>
                <?php foreach ($isNeedList as $k=>$n){?>
                    <option value="<?php echo $n?>" <?php echo $is_need==$n?"selected='selected'":""?>><?php echo $n?></option>
                <?php }?>
			</select>
			</span>

				<div class="mr20" style="margin-top:3px;">会员状态：
				<select class="select_2" name="keyword_status" style="width:70px;">
					<option value="-1" <if condition="$keyword_status eq '-1'">selected="selected"</if>>全部</option>
					<option value="0" <if condition="$keyword_status eq '0'">selected="selected"</if>>激活</option>
					<option value="1" <if condition="$keyword_status eq '1'">selected="selected"</if>>锁定</option>
					</select>
				
				<input class="btn" value="搜　 索" type="button" id="btn_search" style="color:red;"/>	
				<!-- <input type="button"  value="导出搜索内容" id="btn_out" class="btn"/> -->
			</div>
			</div>
    			<?php if($role_id == 1 || $role_id ==13){?>
				<input class="btn js_saveKefu" value="将√勾选的会员分配给他——>" type="button"/>
				<select id="kefu_list">
    			 <?php foreach ($kefu_list as $e=>$f){?>
    			     <option value="<?php echo $f?>"><?php echo $f?></option>
    			 <?php }?>
				</select>
				<?php }?>
						
			<input type="hidden" value="1" val="{:U('Membership/index')}" name="url_search" >
			<input type="hidden" value="2" val="{:U('Membership/excel')}" name="url_out" >
		</div>
	</form>
	<!--{/条件搜索}-->
	
  
  <div class="table_list">
  <table width="100%" cellspacing="0">
        <thead>
          <tr>
            
            <td width="8%" align="center"><input type="checkbox" id="checkAll">编号(全选)</td>
            <td align="center" width="5%">姓名</td>
			<td align="center" width="12%">账号</td>
			<td align="center" width="12%">公司名称</td>
			<td align="center" width="5%">微信头像</td>
			<td align="center" width="7%">职位</td>
			<td align="center" width="10%">注册时间</td>
			<td align="center" width="5%">会员等级</td>
			<td align="center" width="5%">上级</td>
            <td align="center" width="5%">所属分社</td>
            <td align="center" width="5%">所属客服</td>
            <td align="center" width="5%">课程意向</td>
            <!-- <td align="center" width="5%">用户状态</td> -->
            <td align="center" width="5%">备注</td>
            <td align="center" width="11%">操作</td>
          </tr>
        </thead>
        <tbody>
        <volist name="memberList" id="vo">
          <tr>
			<td align="center"><input type="checkbox" value="{$vo.id}" class="sortMember">{$vo.id}</td>
            <td align="center">{$vo.truename}</td>
			<td align="center">{$vo.mobile}</td>
			<td align="center">{$vo.company}</td>
			<td align="center"><a href="{$vo.userimg}" target="_blank"><img src="{$vo.userimg}" width="40px;"height="40px"></a></td>
			<td align="center">{$vo.position}</td>
			<td align="center">{$vo.regtime}</td>
			<td align="center">{$vo.class_name}</td>
			<td align="center">{$vo.parent_name}</td>
			<td align="center">{$vo.fenbu_name}</td>
			<td align="center">{$vo.ascription}</td>
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
			<!-- <td align="center">
			<if condition="$fenbu_id eq 0">
			<a href="#" class="yn" typeid="{$vo.id}" isok="{$vo.islock}">
			<if condition="$vo[islock] eq 0">激活<else /><font color="red">锁定</font></if>
			</a>
			</if>
			</td> -->
			<td align="center"><textarea>{$vo.state}</textarea></td>
            <td align="center">
            <?php
            $op = array();
            if(\Libs\System\RBAC::authenticate('memlist')){
				$op[] = '<a href="'.U('Membership/memlist',array('id'=>$vo['id'])).'">详情</a>';
			}
			
			if(\Libs\System\RBAC::authenticate('edit')){
				$op[] = '<a href="'.U('Membership/edit',array('id'=>$vo['id'])).'">修改</a>';
			}
			
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
        </volist>
        </tbody>
      </table>
	
      <div class="p10">
        <div class="pages"> {$Page} &nbsp;&nbsp;跳转到第&nbsp;&nbsp;<input type="text" id="sss" style="width:25px;" />&nbsp;&nbsp;页</div>
      </div>
  </div>
  <div class="btn_wrap">
      <div class="btn_wrap_pd">                   
		<a href="index.php?g=Jbr_Membership&m=Membership&menuid=172" class="btn">全部会员</a> 
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
				data: "mobile="+mobile+"&extra="+extra,
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
			$("input[type='checkbox'].sortMember:checked").each(function(){
				id_list.push($(this).val());
			});
			
			var kefu = $("#kefu_list").val();
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
						 alert("意向修改失败~");
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
		
   })
		
$(function(){
		//启用、禁用
		$(".yn").click(function(){
			var tid=$(this).attr("typeid");
			var v=$(this).attr("isok");
			$.ajax({
					type: "POST",
					url: "index.php?g=Jbr_Membership&m=Membership&a=isok",
					data: "isok="+v+"&tid="+tid,
					success: function(msg){					
					 if(msg == '1'){
						$(".yn").each(function(){
							if($(this).attr("typeid") == tid)
							{
								$(this).html("<font color='red'>锁定</font>");
								$(this).attr("isok","1");
							}
						});
					 }else{
						$(".yn").each(function(){
							if($(this).attr("typeid") == tid)
							{
								$(this).html("激活");
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
		$("#btn_out").click(function(){
			var destination = $("input[name='url_out']").attr('val');
			$("#member_manage_from").attr('action', destination);
			$("#member_manage_from").submit();
			return false;
		});
		/*** end ***/
	})
	
	$(function(){
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
</script>
</body>
</html>