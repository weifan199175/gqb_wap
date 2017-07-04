<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
<link href="{$config_siteurl}statics/css/Base.css" rel="stylesheet" />
<div class="lsList">
	<ul class="lsList_ul">
	<form name="myform" class="J_ajaxForm"  method="post">
    	<div class="h_a">基本属性</div>
		   <div class="table_full">
		   <table width="100%" class="table_form contentWrap">
				<tbody>	
				<tr>
					<th width="120">申请人姓名</th>         	
					<td>{$data.truename}</td>
				</tr>
				<tr>
				  <th>公司</th>
				  <td>{$data.company}</td>
				</tr> 
				<tr>
				  <th>行业</th>
				  <td>{$data.industry}</td>
				</tr> 
				<tr>
					<th width="80">关联会员id</th>         	
					<td><a href="/index.php?g=Jbr_Membership&m=Membership&a=memlist&id={$data['member_id']}">{$data.member_id}</a></td>
				</tr>
				<tr>
				  <th>直播路演项目名称</th>
				  <td>{$data.project_title}</td>
				</tr> 
				<tr>
				  <th>直播路演项目描述</th>
				  <td>
				  <textarea name="desc" class="listText" readonly=true />{$data.description}</textarea></td>
				</tr> 
				<tr>
				  <th>申请时间</th>
				  <td>{$data.apply_time}</td>
				</tr>           
				</tbody>
			  </table>
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
