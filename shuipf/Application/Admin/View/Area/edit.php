<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
<link href="{$config_siteurl}statics/css/Base.css" rel="stylesheet" />  
  <div class="h_a">地区编辑</div>
  <form action="{:U('edit')}&id={$lists['id']}" method="post" class="J_ajaxForm">
  <div class="table_full"> 
  <table width="100%"  class="table_form">
      <tbody>
			  <!--<tr>
			    <th>上级名称</th>
				<td>
				<select class="select_2" name="pid" style="width:100px;">
					<option value=""  <if condition="$pid eq ''">selected="selected"</if>>全部</option>
					<volist name="res" id="vo">
					<option value="{$vo.id}" <if condition="$vo['id'] eq $pid">selected="selected"</if> >{$vo.area_name}</option>
					</volist>         
				</select>
				 <span id="errpid"></span>
                </td>				
			  </tr>-->        
			  <input type="hidden" name="pid" value="{$lists[pid]}" />
			  <tr>
			  <th>地区名称</th>
			  <td>
				<input type="text" name="area_name" value="{$lists[area_name]}" class="listText" id="area_name"/>
			    <span id="errname"></span>
				</td>
			  </tr>
			   <tr>
	           <th>区域图片</th>
	            <td><Form function="images" parameter="ProductClassImage,ProductClassImage,$lists['area_img'],Content"/><span class="gray"> 双击可以查看图片！</span></td>          	         
               </tr>
			  <tr>
			  <th>是否显示</th>
			  <td>
				<span>
				<input class="isok" type="radio" value="1" name="yes" id="yes" <if condition='$lists[show_status] eq 1'>checked="checked"</if>  checked="checked"/>是
				<input class="isok" type="radio" value="0" name="no" id="no" <if condition='$lists[show_status] eq 0'>checked="checked"</if> />否
				</span>
			  </td>
			  </tr>
			  <tr>
			  <th>省市专题标题</th>
			  <td>
				<input type="text" name="area_title" value="{$lists[area_title]}" class="listText" id="area_title"/>
			    
				</td>
			  </tr>
			  <tr>
			  <th>省市专题描述</th>
			  <td>
				<input type="text" name="area_des" value="{$lists[area_des]}" class="listText" id="area_des"/>
			    
				</td>
			  </tr>
			  <tr>
			  <th>省市专题keyword</th>
			  <td>
				<input type="text" name="area_keyword" value="{$lists[area_keyword]}" class="listText" id="area_keyword"/>
			    
				</td>
			  </tr>
			</tbody>
  </div>
        <div class="btn_wrap">
		  <div class="btn_wrap_pd">             
			<input type="submit" value="确&nbsp;定" class="listBtn" />
		  </div>
		 </div>
  </form>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>
<script type="text/javascript" src="{$config_siteurl}statics/js/content_addtop.js"></script>
<script type="text/javascript">
	$(function(){
		
		//控制单选按钮
		$(".isok").click(function(){
			
			$(".isok").each(function(){
				$(this).get(0).checked=false;
			});
			$(this).attr("checked","checked");
		});
		
	})
	
</script>
<script type="text/javascript">
	$(function(){
		//提交表单时验证是否为空
		$(".listBtn").click(function(){
			//var pid=$("#pid").val();
			var area_name=$("#area_name").val();
			var reg=/^[\u4e00-\u9fa5]{0,}$/;
				/*if(pid==""){
					$("#pid").focus();
					$("#errpid").html("<font color='red'>请选择地区或省名称！</font>");
					return false;
				}*/
				if(area_name==""){
					$("#area_name").focus();
					$("#errname").html("<font color='red'>请输入地区名称！</font>");
				}else if(!reg.test(area_name)){
					$("#area_name").val("");
					$("#area_name").focus();
					$("#errname").html("<font color='red'>请输入正确的地区名称！</font>");
					return false;
				}
			});
	})		
</script>
</body>
</html>