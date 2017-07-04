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
			  <tr>
			  <th width="80">买家姓名</th>
			  <td>
				<input type="text" name="name" value="" class="listText" id="name"/>
			    <span id="errname"></span></td>
			  </tr>
			  <tr class="member">
			  <th>联系电话</th>
			  <td>
				 <input type="text" name="tel" value="" class="listText" id="tel" />
			     <span id="errtel"></span></td>
			  </tr>
			  <tr>
			  <th>电子邮箱</th>
			  <td>
				 <input type="text" name="email" value="" class="listText" id="email" />
			     <span id="erremail"></span></td>
			  </tr>
			  <tr>
			  <th>QQ号</th>
			  <td>
				 <input type="text" name="qq" value="" class="listText" id="qq" />
			     <span id="errqq"></span></td>
			  </tr>
			   <tr>
				<th>商品名称</th>         	
				<td><input type="text" name="pro_title" value="" class="listText" id="pro_title"/>
					<span id="errtitle"></span>
				</td>
			  </tr>
			   <tr>
			  <th>商品价格</th>
			  <td>
				<input type="text" name="pro_price" value="" class="listText" id="pro_price"/>
				<span id="errprice"></span>
			  </td>
			  </tr>
			  <tr>
			  <th>买家地址</th>
			  <td>
				<input type="text" name="address" value="" class="listText" id="address"/>		
                <span id="errads"></span>				
			  </td>
			  </tr>
			  <tr>
			  <th>支付方式</th>
			  <td>
				<input type="text" name="pay_type" value="" class="listText" id="pay_type"/>		
                <span id="errpay"></span>				
			  </td>
			  </tr>
			  <tr>
					<th>支付状态</th>
						<td> 
						     <select class="select_1" name="status" id="status" style="width:80px">
							   <option  value="1">已付款</option>
							   <option value="0">未付款</option>
							 </select>
							<span id="errst"></span>
						</td>          	         
				  </tr>
			<tr>
			  <th>备注</th>
			  <td><input name="des" type="text" value="" class="listText" id="des"/></td>
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
	$(function(){
	    //验证买家姓名
		$("#name").blur(function(){
			//var regname=/^([a-zA-Z0-9_\u4e00-\u9fa5]){3,19}$/;
			var regname=/^([a-zA-Z0-9\u4e00-\u9fa5\·]{1,10})$/ ;
			if($(this).val()==""){
				$(this).focus();
				$("#errname").html("<font color='red'>请输入买家姓名！</font>");
			}else if(!regname.test($(this).val())){
				$(this).val("");
				$(this).focus();
				$("#errname").html("<font color='red'>请输入由汉字构成的姓名！</font>");
			}else{
				$("#errname").html("");
			}
		}); 
		//验证联系电话
		$("#tel").blur(function(){
			var regtel=/^(1(([35][0-9])|(47)|[8][01236789]))\d{8}$/;
			if($(this).val()==""){
				$(this).focus();
				$("#errtel").html("<font color='red'>请输入会员电话！</font>");
			}else if(!regtel.test($(this).val())){
				$(this).val("");
				$(this).focus();
				$("#errtel").html("<font color='red'>请输入正确的手机号码格式！</font>");
			}else{
				$("#errtel").html("");
			}
		});
		//验证电子邮箱
		$("#email").blur(function(){
			var regmail= /^\w+@\w+\.(com|com\.cn|cn)$/i;
			if($(this).val()==""){
				$(this).focus();
				$("#erremail").html("<font color='red'>请输入电子邮箱！</font>");
			}else if(!regmail.test($(this).val())){
				$(this).val("");
				$(this).focus();
				$("#erremail").html("<font color='red'>请输入正确的电子邮箱格式！</font>");
			}else{
				$("#erremail").html("");
			}
		});
		//提交表单时验证是否为空
		$(".listBtn").click(function(){
			var name=$("#name").val();
			var tel=$("#tel").val();
			var pro_title=$("#pro_title").val();
			var pro_price=$("#pro_price").val();
			var address=$("#address").val();
			var qq=$("#qq").val();
			var pay_type=$("#pay_type").val();
			
			if(name==""){
					$("#name").focus();
					$("#errname").html("<font color='red'>买家姓名不能为空！</font>");
					return false;
			}
			if(tel==""){
					$("#tel").focus();
					$("#errtel").html("<font color='red'>联系电话不能为空！</font>");
					return false;
			}
			
			if(pro_title==""){
					$("#pro_title").focus();
					$("#errtitle").html("<font color='red'>商品名称不能为空！</font>");
					return false;
			}
			if(pro_price==""){
					$("#pro_price").focus();
					$("#errprice").html("<font color='red'>商品价格不能为空！</font>");
					return false;
			}
			if(address==""){
					$("#address").focus();
					$("#errads").html("<font color='red'>买家地址不能为空！</font>");
					return false;
			}
			if(pay_type==""){
					$("#pay_type").focus();
					$("#errpay").html("<font color='red'>支付方式不能为空！</font>");
					return false;
			}
		});
		
	})
</script>