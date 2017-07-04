<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<link href="{$config_siteurl}statics/css/Base.css" rel="stylesheet" />
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
   <Admintemplate file="Common/Nav"/>
   <form  class="J_ajaxForm" action="{:U('Industry/add')}" method="post" id="myform">
  
   <div class="h_a">行业分类基本属性</div>
   <div class="table_full">
   <table width="100%" class="table_form contentWrap">
        <tbody>
          <tr>
            <th width="100">行业顶级分类名：</th>
            <td>
                  <select name="pid" id="pid"  style="width:200px;" >
                    <option value="0">顶级分类</option>
                    <volist name="firstlist" id="vb">
                    <option value="{$vb['id']}">{$vb['industry_name']}</option>
                    </volist>
                  </select>
             </td>
          </tr>
          <tr>
              <th>行业分类名称：</th>
              <td><input type="text" name="industry_name" id="industry_name" class="input" style="width:200px;" value="">
               <span class="gray">若不选择行业的顶级分类，则该填写的行业名是顶级分类，否则是二级分类</span>
              </td>
          </tr>
     
          <tr>
          <th>行业的简介：</th>
          <td><textarea name="desc" rows="2" cols="20" id="decs" class="inputtext" style="height:100px;width:500px;"></textarea>
          </td>
        </tr>
       
        <tr>
        <th width="100">排序号：</th>
          <td>
         <input type="text" name="sorts" id="sorts" class="input" value="" placeholder="请填写数字">      　
          <span class="gray">排序号从小到大排序</span> 
          </td>
        </tr>
                   
        </tbody>
      </table>
   </div>
   <div class="btn_wrap">
      <div class="btn_wrap_pd">     
        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">添加</button>
      </div>
    </div>
    </form>
</div>
<script src="{$config_siteurl}statics/js/common.js"></script>
<script type="text/javascript" src="{$config_siteurl}statics/js/content_addtop.js"></script>
</body>
</html>
<script type="text/javascript">
    $(function () {
      $('#thumb_pic').attr("readOnly",true);
      $("#up").uploadPreview({ Img: "ImgPr", Width: 120, Height: 120 });
    });

   // 获取对于的行业下的一级
  /* function changedegree(){
    // 遍历checkbox，找出已经选中的学历
    var arr=[];
    $(".checkboxs:checked").each(function () {
       arr.push($(this).val());
    });
    var degree_id = arr.join(',');
    $('#degree_id').val(degree_id);
    if(degree_id==''){
      alert('请勾选一个或多个学历！');
      return false;
    }
  }

     // 根据选择的一级分类是否显示学历
    function isshow(){
     var pid = $('#pid').val();
     if(pid==0){
      $('#degreeid').show();
     }else{
      $('#degreeid').hide();
     }
    }*/
</script>