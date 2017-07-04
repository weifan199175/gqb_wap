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
					<th width="80">规则名称</th>         	
					<td>
						<input type="text" name="name" value="{$lists.name}" class="listText" id="typename"/>
						
					</td>
				  </tr>
				<tr>
				  <th>获得积分</th>
				  <td><input name="get_score" type="text" value="{$lists.get_score}" class="listText" /></td>
				</tr>     
                 
                <tr>
				  <th>每天限制次数</th>
				  <td><input name="max_num_day" type="text" value="{$lists.max_num_day}" class="listText" /></td>
				</tr>                     
				
				<tr>
				  <th>指定任务链接</th>
				  <td><input name="link" type="text" value="{$lists.link}" class="listText" /></td>
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
		/*
		$("input:radio").click(function(){
			
			$("input:radio").each(function(){
				$(this).get(0).checked=false;
			});
			$(this).attr("checked","checked");
		});
		*/
	})
	
</script>
