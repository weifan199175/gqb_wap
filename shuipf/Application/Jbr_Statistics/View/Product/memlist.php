<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
<link href="{$config_siteurl}statics/css/Base.css" rel="stylesheet" />
<div class="lsList">
	<ul class="lsList_ul">
	<form name="myform" class="J_ajaxForm" action="{:U('memlist')}&id={$lists['memberid']}" method="post">
    	<div class="h_a">基本属性</div>
		   <div class="table_full">
		   <table width="100%" class="table_form contentWrap">
				<tbody>
				
				 <tr>
					<th width="100px">会员编号</th>         	
					<td>{$lists['id']}</td>
					<th width="100px">会员等级</th>         	
					<td>
					{$memtype}
					</td>
					<th width="100px">VIP开通时间</th>         	
					<td>{$lists['vipstartime']}</td>
					<th width="100px">VIP到期时间</th>         	
					<td>{$lists['vipendtime']}</td>
					</td>
				  </tr>
				  <tr>
					<th width="100px">会员账号</th>         	
					<td>{$lists['mobile']}</td>
					<th width="100px">真实姓名</th>         	
					<td>{$lists['truename']}</td>
					<th width="100px">会员邮箱</th>         	
					<td>{$lists['email']}</td>
					<th width="100px">会员电话</th>         	
					<td>{$lists['tel']}
					</td>
				  </tr>
				  <tr>
					<th width="100px">会员性别</th>         	
					<td>{$lists['sex']}</td>
					<th width="100px">会员QQ</th>         	
					<td>{$lists['qq']}</td>
					<th width="100px">登录次数</th>         	
					<td>{$lists['loginnum']}</td>
					<th width="100px">注册时间</th>         	
					<td>{$lists['regtime']}
					</td>
				  </tr>
				  <tr>
					<th width="100px">注册地区</th>         	
					<td>{$lists['regareaname']}</td>
					<th width="100px">注册IP</th>         	
					<td>{$lists['regip']}</td>
					<th width="100px">最后登录时间</th>         	
					<td>{$lists['lastlogintime']}</td>
					<th width="100px">最后登录地区</th>         	
					<td>{$lists['lastloginareaname']}
					</td>
				  </tr>
				  <tr>
					<th width="100px">最后登录IP</th>         	
					<td>{$lists['lastloginip']}</td>
					<th width="100px">注册IP</th>         	
					<td>{$lists['regip']}</td>
					<th width="100px">激活/锁定</th>         	
					<td>{$isok}</td>
					<th width="100px">备注</th>         	
					<td>{$lists['desc']}
					</td>
				  </tr>
				  <tr>
					<th width="80">消费详情</th>
					<td colspan="7">
					<volist name="userorder" id="vo">
						<dd>
						消费时间:{$vo.order_time} &nbsp;&nbsp;&nbsp;&nbsp;
						消费金额:￥{$vo.order_price}&nbsp;&nbsp;&nbsp;&nbsp;  
						消费用途:
						<?php
							$pros='['.$vo['Pros'].']';
							$pros = json_decode($pros,true);
							//print_r($pros);
						?>
						<volist name="pros" id="p">
						{$p.ProTitle}&nbsp;&nbsp;
						</volist>
						</dd>
					</volist>
						
					</td>
				  </tr> 
					<tr>
					<th width="80">留言详情</th>
					<td colspan="7">
						<dd>课程建议:{$jcount}</dd>
						<dd>学员心语:{$xcount}</dd>
						<dd>会员提问:{$tcount}</dd>
						<dd>意见反馈:{$ycount}</dd>
						<dd>会员投稿:{$hcount}</dd>
					</td>
				  </tr> 				  
    
				</tbody>
			  </table>
		   </div>
		   <div class="btn_wrap">
			  <div class="btn_wrap_pd">             
				<a class="current" href="index.php?g=Jbr_Membership&m=Membership&menuid=177">返&nbsp;回 </a>
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
		
	})
	
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
		$(".listBtn").click(function(){
			var membertel=$("#mobilenum").val();
			//var membername=$("#membername").val();
			var memberpass=$("#memberpass").val();
			var email=$("#email").val();
			
			
			                                                      //会员类型为其他类型时的验证
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