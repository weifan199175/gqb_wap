<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
<link href="{$config_siteurl}statics/css/Base.css" rel="stylesheet" />
<div class="lsList">
	
	<form name="myform" id="form"  action="{:U('Finance/edit')}" method="post">

   <input type="hidden" name="id" value="{$res.id}" />
    
   <div class="h_a">申请审核</div>
   <div class="table_full">
   <table width="100%" class="table_form contentWrap">
        <tbody>
		
		  <tr>
            <th  width="80">申请人</th>
            
            	<td>{$m.truename}
				</td>         	         
          </tr>	     
          
		  <tr>
            <th>提现金额</th>
            
            	<td>{$res.amount}
				</td>         	         
          </tr>
		  
          <tr>
            <th>联系方式</th>
            <td>{$m.mobile}
              </td>
          </tr>        
        
		
       
            <th>状态</th>
            
            	<td>
				<select name="status" id="status">
					<option value="1"  <if condition='$res[status] eq 1'>selected="selected"</if>>处理中</option>
					<option value="2"  <if condition='$res[status] eq 2'>selected="selected"</if>>拒绝提现</option>
					<option value="3"  <if condition='$res[status] eq 3'>selected="selected"</if>>提现成功</option>
				</select>
				</td>         	         
          </tr>
		  
		 <tr style="display:none;" id="aa">
            <th> <span style="color:red;">*</span> 未通过理由</th>
            
            	<td>
				   <textarea name="reason" id="reason" style="width:300px;">{$res.reason}</textarea>
				</td>         	         
          </tr>
		  <tr style="display:none;" id="bb">
            <th> <span style="color:red;">*</span> 凭证</th>
            
            	<td>
				  <Form function="images" parameter="voucher,voucher,$res['voucher'],content" />
				  <span class="gray"> 双击可以查看图片！</span>
				</td>         	         
          </tr>
		  
        </tbody>
      </table>
   </div>   
   <div class="btn_wrap">
      <div class="btn_wrap_pd">             
        <button class="btn btn_submit mr10" onclick="formSubmit()" type="button">确认审核</button>
      </div>
    </div>		
</form>
</div>
</div>
</div>
<script src="{$config_siteurl}statics/js/common.js"></script>
<script type="text/javascript" src="{$config_siteurl}statics/js/content_addtop.js"></script>
<script>
 $(function () {
      $('#voucher').attr("readOnly",true);
      $("#up").uploadPreview({ Img: "ImgPr", Width: 120, Height: 120 });
    });
	
	
$("#status").change(function(){
    if($("#status option:selected").val()=='2'){
		$("#aa").attr('style','display:');
	}else{
		$("#aa").attr('style','display:none'); 
	}
	
	if($("#status option:selected").val()=='3'){
		$("#bb").attr('style','display:');
	}else{
		$("#bb").attr('style','display:none'); 
	}
	
})	

function formSubmit(){
	if($("#status option:selected").val()=='2'){
		if($("#reason").val()==''){
		   alert("请填写未通过的理由");
          return false; 
        }else{
			$('#form').submit();
		}		
	}else if($("#status option:selected").val()=='3'){
		if($("#voucher").val()==''){
		   alert("请上传转账凭证！");
          return false; 
        }else{
			$('#form').submit();
		}		
	}else{
		$('#form').submit();
	}
}


</script>
</body>
</html>

