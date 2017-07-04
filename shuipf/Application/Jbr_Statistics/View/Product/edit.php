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
		   <input type="hidden" value="{$lists['memberid']}" id="memid"/>
		   <table width="100%" class="table_form contentWrap">
				<tbody>
				
				 <tr>
					<th width="100px">会员编号</th>         	
					<td><input type="text" name="memberid" value="{$lists['memberid']}" class="listText" readonly="readonly" id="memberid"/>
					</td>
				  </tr>
				  <tr>
					<th width="80">会员等级</th>
					<td><select name="membertype" id="membertype">			
					<volist name="memtype" id="vo">
					<option value="{$vo.id}" <if condition='$vo.id eq $lists[vip]'>selected="selected"</if> >{$vo.typename}</option>
					</volist>
					</select></td>
				  </tr>        
				  <tr>
				  <th>VIP开通时间</th>
				  <td>
					<input type="text" class="input length_2 J_date" name="vipregtime" value="{$lists['vipregtime']}" style="width:120px;">
			</td>
				  </tr>
				  <tr>
				  <th>VIP到期时间</th>
				  <td>
					<input type="text" class="input length_2 J_date" name="viplosttime" value="{$lists['viplosttime']}" style="width:120px;">
			</td>
				  </tr>
				  <tr>
					<th>会员账号</th>         	
					<td><input type="text" name="membername" value="{$lists['membername']}" class="listText" readonly="readonly" id="membername"/>
					</td>
				  </tr>
				  <tr>
				  <th>真实姓名</th>
				  <td>
					<input type="text" name="truename" value="{$lists['truename']}" class="listText" id="truename"/>
			<span id="errname"></span></td>
				  </tr>
				  
				  <tr >
				  <th>会员密码</th>
					<td>
						<input style="display:none;" type="text" name="memberpass" value="" class="listText" id="memberpass"/>
						<span id="errpass"></span><a id="set_pwd" style="cursor:pointer;">修改</a>
					</td>
				  </tr>
				 
				  <tr>
				  <th>会员性别</th>
				  <td>
					<input  type="text" name="sex" value="{$lists['sex']}" class="listText" id="sex"/>
					</tr>
				  <tr>
				  <th>会员邮箱</th>
				  <td>
					 <input type="text" name="email" value="{$lists['email']}" class="listText" id="email"/>
			<span id="erremail"></span></td>
				  </tr>
				  <th>会员电话</th>
				  <td>
					 <input type="text" name="mobilenum" value="{$lists['mobilenum']}" class="listText" id="mobilenum"/>
				</td>
				  </tr>
				  <th>会员QQ</th>
				  <td>
					 <input type="text" name="qq" value="{$lists['qq']}" class="listText" id="qq"/>
				</td>
				  </tr>
				 <!-- <tr>
				  <th>会员头像</th>
				  <td>
					 <Form function="images" parameter="ProductClassImage,ProductClassImage,'',content"/></td>
				  </tr>-->
				  </tr>
				  <th>登录次数</th>
				  <td>
					 <input type="text" name="loginnum" value="{$lists['loginnum']}" class="listText" id="loginnum" readonly="readonly"/>
				</td>
				  </tr>
				   <tr>
					<th>注册时间</th>         	
					<td><input type="text" name="regtime" value="{$lists['regtime']}" class="listText" readonly="readonly" id="regtime"/>
					</td>
				  </tr>
				   <tr>
					<th>注册地区</th>         	
					<td><input type="text" name="regareaname" value="{$lists['regareaname']}" class="listText" readonly="readonly" id="regareaname"/>
					</td>
				  </tr>
				  <tr>
					<th>注册IP</th>         	
					<td><input type="text" name="regip" value="{$lists['regip']}" class="listText" readonly="readonly" id="regip"/>
					</td>
				  </tr>
				   <tr>
					<th>最后登录时间</th>         	
					<td><input type="text" name="lastlogintime" value="{$lists['lastlogintime']}" class="listText" readonly="readonly" id="lastlogintime"/>
					</td>
				  </tr>
				   <tr>
					<th>最后登录地区</th>         	
					<td><input type="text" name="lastloginareaname" value="{$lists['lastloginareaname']}" class="listText" readonly="readonly" id="lastloginareaname"/>
					</td>
				  </tr>
				  <tr>
					<th>最后登录IP</th>         	
					<td><input type="text" name="lastloginip" value="{$lists['lastloginip']}" class="listText" readonly="readonly" id="lastloginip"/>
					</td>
				  </tr>
				  
				  
				 
				   <tr>
				  <th>激活/锁定</th>
				  <td>
				     <input class="isok" type="radio" value="0" name="no" id="no" <if condition='$lists[islock] eq 0'>checked="checked"</if> />激活
					 <input class="isok" type="radio" value="1" name="yes" id="yes" <if condition='$lists[islock] eq 1'>checked="checked"</if> />锁定
		          </td>
				  </tr>
				<tr>
				  <th>备注</th>
				  <td><input name="desc" type="text" value="{$lists['desc']}" class="listText" /></td>
				</tr>           
				</tbody>
			  </table>
		   </div>
		   <div class="btn_wrap">
			  <div class="btn_wrap_pd">             
				<!--input type="submit" value="确&nbsp;定" class="listBtn" /-->
				
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
		$(".lsList_a").click(function(){
			$(".listFile").click();
			return false;
		});
		
		//控制单选按钮
		$("input:radio").click(function(){
			
			$("input:radio").each(function(){
				$(this).get(0).checked=false;
			});
			$(this).attr("checked","checked");
		});
		
	})
</script>

<script type="text/javascript">
	
		
		//控制单选按钮
		
		
		/*//控制单选按钮
		$(".sex").click(function(){
			
			$(".sex").each(function(){
				$(this).get(0).checked=false;
			});
			$(this).attr("checked","checked");
		});
		*/
		
	
	
</script>
<script type="text/javascript">
	$(function(){
	
		
		$("#set_pwd").live('click', function(){
			var isset = $("#memberpass").css("display");
			
			if("none" == isset){
				$(this).html("取消");
				$("#memberpass").css("display", "block");
				$("#errpass").css("display","block");
			}else{
				$(this).html("修改");
				$("#memberpass").css("display", "none");
				$("#errpass").css("display","none");
			}
		});
		
		//matchMemberClass($("#margin").val());
	
		//根据会员类型显示或隐藏表单元素
		/*$("#membertype").change(function(){
			var select=$(this).children('option:selected').val();//这就是selected的值 
			if(select!=0){
				$(".member").hide(); 
				$("#yes").removeAttr("checked");
				$("#no").attr("checked","checked");
			}else{
				$(".member").show(); 
			}
		});*/
		//表单元素失去焦点时的验证
		//验证会员号码
		/* $("#membertel").blur(function(){
			var regtel=/^(1(([35][0-9])|(47)|[8][01236789]))\d{8}$/;
			if($(this).val()==""){
				$(this).focus();
				$("#errtel").html("<font color='red'>请输入会员电话！</font>");
			}else if(!regtel.test($(this).val())){
				$(this).val("");
				$(this).focus();
				$("#errtel").html("<font color='red'>请输入正确的手机号码格式！</font>");
			}else{
				var membertel=$(this).val();
				//ajax判断手机号码是否重复
				$.ajax({
					type: "POST",
					url: "index.php?g=JBR_Member&m=Member&a=chkmembertel",
					data: "membertel="+membertel,
					success: function(msg){
						if(msg=='1'){
							$(this).val("");
							$(this).focus();
							$("#errtel").html("<font color='red'>对不起，该手机号码已存在，请输入其他手机号码！</font>");
						}else{
							$("#errtel").html("");
						}
					}	
				});
			}	
		}); 
		//验证会员昵称
		$("#membername").blur(function(){
			var regname=/^([a-zA-Z0-9_\u4e00-\u9fa5]){3,19}$/;
			if($(this).val()==""){
				$(this).focus();
				$("#errname").html("<font color='red'>请输入3-19个由汉字和字母或者数字构成的昵称！</font>");
			}else if(!regname.test($(this).val())){
				$(this).val("");
				$(this).focus();
				$("#errname").html("<font color='red'>请输入3-19个由汉字和字母或者数字构成的昵称！</font>");
			}else{
				$("#errname").html("");
			}
		}); 
		
		
		
		/**/
		//验证会员密码
		/*$("#memberpass").live('blur', function(){
			var regpass=/^(\w){6,20}$/;
			if($(this).val()==""){
				$(this).focus();
				$("#errpass").html("<font color='red'>请输入6-20位包含字母、数字、下划线字符长度的密码！</font>");
			}else if(!regpass.test($(this).val())){
				$(this).val("");
				$(this).focus();
				$("#errpass").html("<font color='red'>请输入6-20位包含字母、数字、下划线字符长度的密码！</font>");
			}else{
				$("#errpass").html("");
			}
		}); */
		//验证会员邮箱
		
		/*$("#email").blur(function(){
			var regemail= /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
			if($(this).val()!==""){
				$(this).val("");
				$(this).focus();
				$("#erremail").html("<font color='red'>你输入的邮箱地址格式不正确，请重新输入！</font>");
			}
			else{
				$("#erremail").html("");
			}
		});*/
		/*//验证会员保证金
		$("#margin").keyup(function(){
			var regmargin=/^\d*$/;
			if($(this).val()==""){
				$(this).focus();
				$("#errmargin").html("<font color='red'>请输入会员保证金！</font>");
			}else if(!regmargin.test($(this).val())){
				$(this).val("");
				$(this).focus();
				$("#errmargin").html("<font color='red'>请输入数字！</font>");
			}
			else{
				$("#errmargin").html("");
				matchMemberClass($(this).val());
			}
			
		});
		*/
		//提交表单时验证是否为空
		$("#tj").click(function(){
			//var membertel=$("#mobilenum").val();
			//var membername=$("#membername").val();
			//var memberpass=$("#memberpass").val();
			//var email=$("#email").val();
			
			//var $url="{:U('edit')}&id="+$("#memid").val();
			$.ajax({
				url:"index.php?g=Jbr_Membership&m=Membership&a=edit&id="+$("#memid").val(),
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
			});                                                     //会员类型为其他类型时的验证
				/*if(membertel==""){
					$("#membertel").focus();
					$("#errtel").html("<font color='red'>请输入会员电话！</font>");
					return false;
				}
				
				if(membername==""){
					$("#membername").focus();
					$("#errname").html("<font color='red'>请输入5-20个以字母开头、可带数字、“_”、“.”的字符！</font>");
					return false;
				}
				
				if(email==""){
					$("#email").focus();
					$("#erremail").html("<font color='red'>请输入您常用的邮箱地址！</font>");
					return false;
				}
				*/
			

		});
		
		/* ajax 通过保证金获取会员等级 */
		/*function matchMemberClass(price)
		{
			$.ajax({
				url:"index.php?g=JBR_Member&m=Member&a=matchMemberClass",
				type:"post",
				data:"price=" + price,
				dataType:"json",
				success:function(msg){
					//alert(msg.MemberClassID);
					$("#mcn").html(msg.ClassName);
					$("#memberclass").val(msg.MemberClassID);
				}
			});
		}
		*/
	})
</script>