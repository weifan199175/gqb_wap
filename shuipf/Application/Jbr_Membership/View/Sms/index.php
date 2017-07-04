<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">

<div class="wrap J_check_wrap">
   <Admintemplate file="Common/Nav"/>
   <form class="J_ajaxForm" action="{:U('Sms/index')}" method="post" id="myform">
   <div class="h_a">基本属性</div>
   <div class="table_full">
   <table width="100%" class="table_form contentWrap">
        <tbody>
          <tr style=" position: relative; z-index:9;">
            <th width="80">收件人</th>
            <td>			
			<input type="text" value="" class="input" name="ruser" id="ruser" style="width:400px;"/>
			<span class="red"> 注：多个收件人ID请用英文逗号 " , " 隔开  </span>
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" value="0" name="cbuser" id="cbuser"/>用户组
			<input type="hidden" value="0" name="cuser" id="cuser"/> 
			<div id="guser" style="display:none; float:left;" class="mb10">
			
			<select class="suser" id="suser" name="suser" style="width:100px;">
					<option value="0" >全部</option>
					<volist name="classList" id="vo">
					<option value="{$vo.id}" >{$vo.class_name}</option>
					</volist>         
		    </select>
				
			</div>  
			  
			  </td>
          </tr> 
         
<!--		 
         <tr>
            <th>主题</th>            
            	<td><input type="text" name="title" class="input" id="title" style="width:400px;"></td>          	         
          </tr> -->          
        <tr>
          <th>短信内容</th>
          <td><textarea name="content" rows="2" cols="20" id="content" class="inputtext" style="height:100px;width:500px;"></textarea></td>
        </tr> 
<!--		<tr style=" position: relative; z-index:1;">
          <th>正文</th>
          <td>
			<div id='description_tip'></div><script type="text/plain" id="description" name="content"></script><?php //echo Form::editor('description','full','contents',$catid,1); ?>
		  </td>
        </tr> -->
        </tbody>
      </table>
   </div>
   <div class="btn_wrap">
      <div class="btn_wrap_pd">             
        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">发送</button>
      </div>
    </div>
    </form>
</div>
<script src="{$config_siteurl}statics/js/common.js"></script>
<script type="text/javascript" src="{$config_siteurl}statics/js/content_addtop.js"></script>
 <script type="text/javascript">
	$(function(){
		
		//$("#suser").show();
		
		$("#cbuser").click(function(){
			if($(this).attr("checked")=="checked")
			{			
				$("#ruser").hide();
				$("#guser").show();
				$("#cuser").val("1");
				$(".red").hide();
			}
			else
			{				
				$("#ruser").show();
				$("#guser").hide();
				$("#cuser").val("0");
				$(".red").show();
			}
		});
	})
 </script>
</body>
</html>