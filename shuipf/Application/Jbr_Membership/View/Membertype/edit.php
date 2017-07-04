<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
<link href="{$config_siteurl}statics/css/Base.css" rel="stylesheet" />
<div class="lsList">
	<ul class="lsList_ul">
	<form name="myform" class="J_ajaxForm" action="{:U('edit')}&id={$lists['id']}" method="post">
    	<div class="h_a">基本属性</div>
		   <div class="table_full">
		   <table width="100%" class="table_form contentWrap">
				<tbody>			        
				  
				  <tr>
					<th width="80">等级名称</th>         	
					<td>
						<input type="text" name="class_name" value="{$lists['class_name']}" class="listText" id="class_name"/>
						<input type="hidden" id="hideclassname" value="{$lists['class_name']}"/>
						<span lqq="111" id="errname"></span>
					</td>
				  </tr>
				<tr>
				  <th>一次性充值金额</th>
				  <td>
				  <input name="charge_money" type="text" value="{$lists['charge_money']}" class="listText" /></td>
				</tr> 
				<tr>
				  <th>备注</th>
				  <td>
				  <textarea name="desc" class="listText" />{$lists['desc']}</textarea></td>
				</tr>           
				</tbody>
			  </table>
		   </div>
		   <div class="btn_wrap">
			  <div class="btn_wrap_pd">             
				<input type="submit" value="确&nbsp;定" class="listBtn" />
			  </div>
			</div>
			
		</form>
    </ul>
</div>
</div>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>
</body>
</html>

<script type="text/javascript">
	 $(function () {
            $("#up").uploadPreview({ Img: "ImgPr", Width: 120, Height: 120 });
        });
</script>
<script type="text/javascript">
	$(function(){
		$(".lsList_a").click(function(){
			$(".listFile").click();
			return false;
		});
		
		//控制单选按钮
		/*$("input:radio").click(function(){
			
			$("input:radio").each(function(){
				$(this).get(0).checked=false;
			});
			$(this).attr("checked","checked");
		});
		*/
	})
</script>
<script type="text/javascript">
	$(function(){
		//表单元素键盘按下时的验证
		//验证类型名称
		/*$("#typename").keyup(function(){
			if($(this).val()==""){
				$(this).focus();
				$("#errname").html("<font color='red'>类型名称不能为空！</font>");
			}else if($("#hideclassname").val()==$(this).val()){
				$("#errname").attr("lqq",'222');
				$("#errname").html("");
			}else{
				var membertypename=$(this).val();
				//ajax判断等级名称是否重复
				$.ajax({
					type: "POST",
					url: "index.php?g=JBR_Membership&m=Membertype&a=chkmembertypte",
					data: "membertypename="+membertypename,
					success: function(msg){
						if(msg=='1'){
							$(this).val("");
							$(this).focus();
							$("#errname").html("<font color='red'>对不起，该会员类型名称已存在，请输入其他类型名称！</font>");
							$("#errname").attr("lqq",'111');
							$("#listBtn").attr("disabled",true);
						}else{
							$("#errname").attr("lqq",'222');
							$("#errname").html("");
						} 
					}	
				});
			}
			
		});
	
		//提交表单时验证是否为空
		$(".listBtn").click(function(){
			var typename=$("#typename").val();
			var lqq = $("#errname").attr("lqq");
			
				if(typename==""){
					$("#typename").focus();
					$("#errname").html("<font color='red'>类型名称不能为空！</font>");
					return false;
				}else if(lqq == '111'){						
					$("#errname").html("<font color='red'>对不起，该会员类型名称已存在，请输入其他类型名称！</font>");	
					return false;					
				}
				else{
					var membertypename=$(this).val();
					//ajax判断等级名称是否重复
					$.ajax({
						type: "POST",
						url: "index.php?g=Jbr_Membership&m=Membertype&a=chkmembertypte",
						data: "membertypename="+membertypename,
						success: function(msg){
							if(msg=='1'){
								$(this).val("");
								$(this).focus();
								$("#errname").html("<font color='red'>对不起，该会员类型名称已存在，请输入其他类型名称！</font>");
								
							}else{
								$("#errname").html("");
							} 
						}	
					});
				}

		});
	
	})*/
</script>