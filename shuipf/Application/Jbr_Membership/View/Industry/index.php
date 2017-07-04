<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
   <link type="text/css" rel="stylesheet" href="/statics/jbr_admin/css/base.css" />
   <link type="text/css" rel="stylesheet" href="/statics/jbr_admin/css/index.css" />
   <link type="text/css" rel="stylesheet" href="/statics/jbr_admin/css/admin_style.css" />
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <div style="margin-top:2px;margin-bottom:2px;">注：一级行业分类默认为黑色，二级行业分类默认为<font color="red">红色</font></div>
    <div class="table_list">
      <table width="100%" cellspacing="0">
        <thead>
          <tr>
            <td align="center" width="60">ID</td>
            <td align="center" width="150">行业名称</td>
            <td align="center" width="80">排序号</td>
            <td align="center" width="100">创建时间</td>
            <td align="center" width="150">管理操作</td>
          </tr>
        </thead>
        <tbody>
          
		       <volist name="industrylist" id="vo">
			   <tr>
				<td align="center">{$vo.id}</td>
				<td class="Title" align="left"><div class="tt">{$vo.industry_name}</div></td>
				 <td align="center">{$vo.sorts}</td>
				 <td align="center">{$vo.addtime}</td>
				 <td align="center"> 
				     <a href="{:U('Industry/edit',array('id'=>$vo['id']))}" >编辑</a>            
                    | <a class="J_ajax_del" href="{:U('Industry/delete',array('aid'=>$vo['id']))}">删除</a>
				</td>
			  </tr> 
			  <!-- 对应行业下的二级分类 -->
			  <tr class="subTableBox">
				<td colspan="5">
				  <table class="subTable" width="100%" cellspacing="0">
					<volist name="vo['sub']" id="subvo">
					<tr>
					  <td align="center" style="width:13%;">{$subvo.id}</td>
					  <td align="left" style="width:25%;"><font color="red ttwo">|——{$subvo.industry_name}</font></td>
					  <td align="center" style="width:15%;">{$subvo.sorts}</td>
					  <td align="center" style="width:20%;">{$subvo.addtime}</td>
					  <td align="center">
						 <a href="{:U('Industry/edit',array('id'=>$subvo['id']))}" >编辑</a>            
                       | <a class="J_ajax_del" href="{:U('Industry/delete',array('aid'=>$subvo['id']))}">删除
					  </td>
					</tr>
                    </volist>
				  </table>
				</td>
				</tr>
		    </volist>
        </tbody>
      </table>
      <div class="p10">
        <div class="pages"> {$Page} </div>
      </div>
    </div>
</div>

<script src="{$config_siteurl}statics/js/common.js"></script>
<script type="text/javascript" src="/statics/jbr_admin/js/jquery.js"></script>
<script type="text/javascript" src="/statics/jbr_admin/js/base.js"></script>
<script type="text/javascript" src="/statics/jbr_admin/js/jquery.SuperSlide.2.1.js"></script>

<script language="javascript">
  $(".subTable tr:odd").addClass("odd");    //加奇行样式 
  $(".subTable tr:even").addClass("even");  //加偶行样式 

$(function(){
  $(".Title").click(function(){
    var SH= $(this).parents("tr").next(".subTableBox");
    $(this).children('.tt').toggleClass("up");
    $(this).parents("tr").next(".subTableBox").slideToggle().parents('tr').siblings('tr').children('.subTableBox').hide();
  });
})
</script>
</body>
</html>