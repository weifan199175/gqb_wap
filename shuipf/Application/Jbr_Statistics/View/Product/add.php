<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
<link href="{$config_siteurl}statics/css/Base.css" rel="stylesheet" />
<div class="lsList">
	<ul class="lsList_ul">
	<form name="myform" class="J_ajaxForm" action="{:U('add')}" method="post">
    	<div class="h_a">基本属性</div>
	   <div class="table_full">
	   <table width="100%" class="table_form contentWrap">
			<tbody>
			       
			 <tr class="member">
				<th width="80">会员等级</th>				
					<td>
					<select class="select_2" name="member_class_id" style="width:100px;">
					
					<volist name="classList" id="vo">
					<option value="{$vo.id}" >{$vo.typename}</option>
					</volist>         
					</select>
					</td>          	         
			  </tr>			 
			  <tr>
			  <th>会员账号</th>
			  <td>
				<input type="text" name="membername" value="" class="listText" id="membername"/>
			<span id="errname"></span></td>
			  </tr>
			   <tr class="member">
			  <th>会员密码</th>
			  <td>
				 <input type="text" name="memberpass" value="" class="listText" id="memberpass" />
			     <span id="errpass"></span></td>
			  </tr>
			   <tr>
				<th>会员电话</th>         	
				<td><input type="text" name="membertel" value="" class="listText" id="membertel"/>
					<span id="errtel" lqq="111"></span>
				</td>
			  </tr>
			   <tr>
			  <th>会员性别</th>
			  <td>
				<input class="sex" type="radio" value="1" name="man" id="man" checked="checked"/>男
		        <input class="sex" type="radio" value="0" name="woman" id="woman"/>女</td>
			  </tr>
			   <tr>
			  <th>会员邮箱</th>
			  <td>
				<input type="text" name="email" value="" class="listText" id="email"/>
				<span id="erremail"></span>
			  </td>
			  </tr>
			  <tr>
			  <th>会员头像</th>
			  <td>
				<Form function="images" parameter="ProductClassImage,ProductClassImage,'',content" />
			  </td>
			  </tr>
			  <tr>
			  <th>会员QQ</th>
			  <td>
				<input type="text" name="qq" value="" class="listText" id="qq"/>				
			  </td>
			  </tr>
			  <tr>
			  <th>真实姓名</th>
			  <td>
				<input type="text" name="truename" value="" class="listText" id="truename"/>				
			  </td>
			  </tr>
			  <tr>
			  <th>是否锁定</th>
			  <td>
				<span>
				<input class="isok" type="radio" value="1" name="yes" id="yes" checked="checked"/>是
				<input class="isok" type="radio" value="0" name="no" id="no"/>否
				</span>				
			  </td>
			  </tr>
			<tr>
			  <th>备注</th>
			  <td><input name="remarks" type="text" value="" class="listText" id="remarks"/></td>
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


<script type="text/javascript" src="{$config_siteurl}statics/js/content_addtop.js"></script>
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
		$(".isok").click(function(){
			
			$(".isok").each(function(){
				$(this).get(0).checked=false;
			});
			$(this).attr("checked","checked");
		});
		
		//控制单选按钮
		$(".sex").click(function(){
			
			$(".sex").each(function(){
				$(this).get(0).checked=false;
			});
			$(this).attr("checked","checked");
		});
		
	})
	
</script>
<script type="text/javascript">
	$(function(){
	
		/* ajax 通过保证金获取会员等级 */
		matchMemberClass($("#margin").val());
	
		//根据会员类型显示或隐藏表单元素
		$("#membertype").change(function(){
			var select=$(this).children('option:selected').val();//这就是selected的值 
			if(select!=0){
				$(".member").hide(); 
				$("#yes").removeAttr("checked");
				$("#no").attr("checked","checked");
			}else{
				$(".member").show(); 
			}
		});
		//表单元素键盘按下时的验证
		//验证会员号码
		$("#membertel").blur(function(){
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
							$("#errtel").attr("lqq",'111');
							$("#listBtn").attr("disabled",true);
						}else{
							$("#errtel").attr("lqq",'222');
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
		//验证会员密码
		$("#memberpass").blur(function(){
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
		}); 
		//验证会员邮箱
		$("#email").blur(function(){
			var regemail= /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
			if($(this).val()!==""){
				$(this).val("");
				$(this).focus();
				$("#erremail").html("<font color='red'>你输入的邮箱地址格式不正确，请重新输入！</font>");
			}
			else{
				$("#erremail").html("");
			}
		}); 
		//验证会员保证金
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
			}
			
			/* ajax 通过保证金获取会员等级 */
			matchMemberClass($(this).val());
			
		});
		//提交表单时验证是否为空
		$(".listBtn").click(function(){
			var membertel=$("#membertel").val();
			var membername=$("#membername").val();
			var memberpass=$("#memberpass").val();
			var email=$("#email").val();
			var margin=$("#margin").val();
			var lqq = $("#errtel").attr("lqq");
			
			if($(membertype).children('option:selected').val()==0){    //会员类型为无时的验证
				if(membertel==""){
					$("#membertel").focus();
					$("#errtel").html("<font color='red'>请输入会员电话！</font>");
					return false;
				}else if(lqq == '111'){						
					$("#errtel").html("<font color='red'>对不起，该手机号码已存在，请输入其他手机号码！</font>");	
					return false;					
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
				
				if(membername==""){
					$("#membername").focus();
					$("#errname").html("<font color='red'>请输入3-19个由汉字和字母或者数字构成的昵称！</font>");
					return false;
				}

				if(memberpass==""){
					$("#memberpass").focus();
					$("#errpass").html("<font color='red'>请输入6-20位包含字母、数字、下划线字符长度的密码！</font>");
					return false;
				}
				
				if(margin==""){
					$("#margin").focus();
					$("#errmargin").html("<font color='red'>请输入会员保证金！</font>");
					return false;
				}else{
					matchMemberClass($("#margin").val());
				}
			}else{                                                       //会员类型为其他类型时的验证
				if(membertel==""){
					$("#membertel").focus();
					$("#errtel").html("<font color='red'>请输入会员电话！</font>");
					return false;
				}else if(lqq == '111'){						
					$("#errtel").html("<font color='red'>对不起，该手机号码已存在，请输入其他手机号码！</font>");	
					return false;					
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
				
			}

		});
		
		/* ajax 通过保证金获取会员等级 */
		function matchMemberClass(price)
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
		
	})
</script>