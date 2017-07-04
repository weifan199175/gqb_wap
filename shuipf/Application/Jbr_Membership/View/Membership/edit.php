<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
<link href="{$config_siteurl}statics/css/Base.css" rel="stylesheet" />
<div class="lsList">
	<ul class="lsList_ul">
	<form name="myform" class="J_ajaxForm" id="ff" action="{:U('edit')}&id={$lists['memberid']}" method="post">
    	<div class="h_a">基本属性</div>
		   <div class="table_full">
		   <input type="hidden" value="{$lists['id']}" id="id"/>
		   <table width="100%" class="table_form contentWrap">
				<tbody>
				 <tr>
					<th width="100px">会员编号</th>         	
					<td>{$lists['id']}</td>
				  </tr>
				  <tr>
					<th width="80">会员等级</th>
					<td><select name="member_class" id="membertype">			
					<volist name="memtype" id="vo">
					<option value="{$vo.id}" <if condition='$vo[id] eq $lists[member_class]'>selected="selected"</if> >{$vo.class_name}</option>
					</volist>
					</select></td>
				  </tr>        
				  <tr>
				  <th>VIP开通时间</th>
				  <td>
					<input type="text" class="input length_2 J_date" name="vipstartime" value="{$lists['vipstartime']}" style="width:120px;">
				</td>
				  </tr>
				  <tr>
				  <th>VIP到期时间</th>
				  <td>
					<input type="text" class="input length_2 J_date" name="vipendtime" value="{$lists['vipendtime']}" style="width:120px;">
			</td>
				  </tr>
				  <tr>
					<th>会员账号</th>         	
					<td>{$lists['mobile']}
					</td>
				  </tr>
				  <tr>
				  <th>真实姓名</th>
				  <td>{$lists['truename']}</td>
				  </tr>
				  <tr>
				 
				  </tr>
				
				  <tr>
					<th>注册时间</th>         	
					<td>{$lists['regtime']}
					</td>
				  </tr>
				   <tr>
					<th>邀请码</th>         	
				<td>{$lists['invitation_code']}</td>
				  </tr>
				
				
				   <tr>
				  <th>状态</th>
				  <td>
				  	<select name="islock" style="width:80px;">
				  		<option value="1" <if condition='$lists[islock] eq 1'>selected="selected"</if>>锁定</option>
				  		<option value="0" <if condition='$lists[islock] eq 0'>selected="selected"</if>>激活</option>
				  	</select>
		          </td>
				  </tr>
				  <tr>
				  <th>是否增加积分</th>         	
				<td>
				<input type='radio' name='is_score' value='1'>是
				<input type='radio' name='is_score' value='0' checked>否
				</td>
				  </tr>
				  </tr> 
				</tbody>
			  </table>
		   </div>
		   <div class="btn_wrap">
			  <div class="btn_wrap_pd"> 
				<input type="button" value="确&nbsp;定" class="listBtn" id="tj" />
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
	
		//提交表单时验证是否为空
		$("#tj").click(function(){
			$.ajax({
				url:"index.php?g=Jbr_Membership&m=Membership&a=edit&id="+$("#id").val(),
				type:"post",
				data:$("#ff").serialize(),
				success:function(data){
					if(data=="ok")
					{
						alert('修改成功');
						window.location.href='index.php?g=Jbr_Membership&m=Membership&menuid=177';
					}
					else
					{
						alert('更新失败!');
					}
				}
			});
		});
	})
</script>