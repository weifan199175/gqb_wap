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
					<th width="80">视频类别</th>         	
					<td>
						<input type="text" name="type_name" value="{$lists['type_name']}" class="listText" id="type_name"/>
						<input type="hidden" id="hideclassname" value="{$lists['type_name']}"/>
						<span lqq="111" id="errname"></span>
					</td>
				  </tr>
				  
			   <tr>
				  <th>开放人群</th>
				  <td>
				  <?php
						  $arr_id = explode(',',$lists['authority']);
					?>
					<input type="checkbox" typename="游客" value="0" class="chk" onclick="chk();" <?php if(in_array(0, $arr_id)){ ?>checked="checked"<?php } ?> />游客 &nbsp;&nbsp;
					<get sql="select * from jbr_member_class">
							<volist name="data" id="vo">
								<input type="checkbox" typename="{$vo.class_name}" value="{$vo.id}" class="chk" onclick="chk();" <?php if(in_array($vo['id'], $arr_id)){ ?>checked="checked"<?php } ?> />{$vo.class_name} &nbsp;&nbsp;
							</volist>
					</get>
                   <input name="authority" id="authority" type="hidden" value="{$lists.authority}" />
                   <input name="desc" id="desc" type="hidden" value="{$lists.desc}" />
					
				</tr>        
				  
				<tr>
				  <th>非开放人群所需积分</th>
				  <td>
				  <input name="score" type="text" value="{$lists['score']}" class="listText" /></td>
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
<script>
function chk(){
 var pp = '';
 var qq = '';
 $.each($(".chk"),function(i,n){
		if($(".chk").eq(i).attr('checked')=='checked')
		{
			pp += $(this).val()+',';
			qq += $(this).attr('typename')+'+';
		}
		
	});
  pp = pp.substr(0,pp.length-1);	
  qq = qq.substr(0,qq.length-1);
$("#authority").val(pp); 
$("#desc").val(qq); 

}
</script>
</body>
</html>



<script type="text/javascript">
	$(function(){
		$(".lsList_a").click(function(){
			$(".listFile").click();
			return false;
		});
	
	})
</script>
