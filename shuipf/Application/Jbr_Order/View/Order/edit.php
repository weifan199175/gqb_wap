<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
<link href="{$config_siteurl}statics/css/Base.css" rel="stylesheet" />
<div class="lsList">
	
	<form name="myform" class="Z_ajaxForm" action="{:U('edit')}&id={$lists['id']}" method="post">
    	<div class="h_a">场次调整</div>
   <div class="table_full">
   <table width="100%" class="table_form contentWrap">
        <tbody>
          <tr>
            <th width="80">当前场次</th>
            <td>{$kc.title}（开讲时间：{$kc.start_time|date="Y-m-d H:i:s",###}）
              </td>
          </tr>        
        
		   <tr>
            <th>调整到</th>
            
            	<td>
				<if condition="empty($course)">
				    暂无可调整的场次!
				<else />
				<select name="product_id">
				<volist name="course" id="vo">		
					<option value="{$vo.id}" >{$vo.title}（开讲时间：{$vo.start_time|date="Y-m-d H:i:s",###}）</option>					
				</volist>	
				</select>
				</if>
				</td>         	         
          </tr>
	
		  
        </tbody>
      </table>
   </div>
   <div class="btn_wrap">
      <div class="btn_wrap_pd">             
        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">修改</button>
      </div>
    </div>		
</form>
</div>
</div>
</div>

</body>
</html>

