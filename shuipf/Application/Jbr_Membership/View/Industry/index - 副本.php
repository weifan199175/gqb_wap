<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
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
                    <td align="left">{$vo.industry_name}</td>
                     <td align="center">{$vo.sorts}</td>
                     <td align="center">{$vo.addtime}</td>
                     <td align="center"> 
                    
                      <a href="{:U('Industry/edit',array('id'=>$vo['id']))}" >编辑</a>            
                    | <a class="J_ajax_del" href="{:U('Industry/delete',array('aid'=>$vo['id']))}">删除</a>     
                    </td>
                  </tr> 
                  <!-- 对应行业下的二级分类 -->
                  <volist name="vo['sub']" id="subvo">
                    <tr>
                      
                    <td align="center">{$subvo.id}</td>
                    <td ><font color="red">　　　|——{$subvo.industry_name}</font></td>
                     <td align="center">{$subvo.sorts}</td>
                     <td align="center">{$subvo.addtime}</td>
                     <td align="center">   
                      
                      <a href="{:U('Industry/edit',array('id'=>$subvo['id']))}" >编辑</a>            
                    | <a class="J_ajax_del" href="{:U('Industry/delete',array('aid'=>$subvo['id']))}">删除</a>
                    </td>
                    </tr>
                    </volist>  
                 </volist> 
        </tbody>
      </table>
      <div class="p10">
        <div class="pages"> {$Page} </div>
      </div>
    </div>
</div>

<script src="{$config_siteurl}statics/js/common.js"></script>
</body>
</html>