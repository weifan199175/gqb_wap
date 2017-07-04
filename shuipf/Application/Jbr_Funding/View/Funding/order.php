<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
   <div class="h_a">搜索</div>
  <form method="post" id="order_manage_from">
	    <div class="search_type cc mb10">
	      <div class="mb10"> 
	  
			<span class="mr20">&nbsp;&nbsp;请选择订单状态：
	        <select class="select_2" name="status"style="width:90px;">
	          <option value="all" <if condition='$status eq "all"'>selected="selected"</if>>全部</option>
	          <option value="0" <if condition='$status eq "0"'>selected="selected"</if>>未支付</option>
			  <option value="1" <if condition='$status eq "1"'>selected="selected"</if>>已支付</option>	
			  <option value="2" <if condition='$status eq "2"'>selected="selected"</if>>已退款</option>	
	        </select>	
			</span>
			 <span class="mr20">&nbsp;&nbsp;订单号：<input name="verification_code" value="{$verification_code}" type="text" class="input"/>
			</span>
			<br/>
			<br/>
			<span class="mr20">&nbsp;&nbsp;请选择支付类型：	      
			<select class="select_2" name="pay_type"style="width:90px;">
	          <option value="all">全部</option>
			  <option value="weixin" <if condition="$pay_type eq 'weixin'">selected="selected"</if>>微信</option>	
			  <option value="zhifubao" <if condition="$pay_type eq 'zhifubao'">selected="selected"</if>>支付宝</option>
	        </select>
	        </span>
	        
	        <span class="mr20">&nbsp;&nbsp;父活动ID：<input name="fid" value="{$fid}" type="text" class="input"/>
	         <input class="btn" value="搜索" type="button" style="color:red;" id="btn_search"/>
	        </span>
			
	        <!-- <input type="button"  value="导出搜索内容" id="btn_out" class="btn"/> -->
		
	      </div>
		   
			<input type="hidden" value="1" val="{:U('Funding/order')}" name="url_search" >
			<input type="hidden" value="2" val="{:U('Funding/excelorder')}" name="url_out" >
	    </div>
  </form>
  <form name="myform" class="J_ajaxForm" action="" method="post">
  <div class="table_list">
  <table width="100%" cellspacing="0">
        <thead>
          <tr>
            <td align="center" >父活动ID</td>
            <td align="center" >订单号</td>
            <td align="center" >商户交易号</td>
            <td align="center" >发起人</td>
			<td align="center" >姓名</td>
			<td align="center" >微信昵称</td>
			<td align="center" >微信头像</td>
			<td align="center" >支付金额</td>
			<td align="center" >创建时间</td>
			<td align="center" >更新时间</td>
			<td align="center" >状态</td>
			<td align="center" >支付方式</td>
<!--             <td align="center" width="10%">操作</td> -->
          </tr>
        </thead>
        <tbody>
        <volist name="fundinglog" id="fx">
          <tr>
            <td align="center">{$fx.fid}</td>
            <td align="center">{$fx.verification_code}</td>
            <td align="center">{$fx.transaction_id}</td>
			<td align="center">{$fx.faqiren}</td>
			<td align="center">{$fx.truename}</td>
			<td align="center">{$fx.nickname}</td>
			<td align="center"><a href="{$fx.userimg}" target="_blank"><img src="{$fx.userimg}" width="40px;"height="40px"></a></td>
			<td align="center">{$fx.money}</td>
			<td align="center">{$fx.createtime}</td>
			<td align="center">{$fx.updatetime}</td>
			<td align="center">{$fx.status}</td>
			<td align="center">{$fx.pay_type}</td>
            <td align="center">
            </td>
          </tr>
        </volist>
        </tbody>
      </table>
      <div class="p10">
        <div class="pages"> {$Page} </div>
      </div>
  </div>
  </form>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>

<script>
	$(function(){
		
		
		/*** 表单提交 及点击按钮时的表单提交地址切换 xr 20140905 start ***/
		//点击搜索
		$("#btn_search").click(function(){
			var destination = $("input[name='url_search']").attr('val');	//获取提交地址
			$("#order_manage_from").attr('action', destination);	//切换提交地址
			$("#order_manage_from").submit();	//提交表单
			return false;
		});
		//点击导出
            $("#btn_out").click(function(){
			var destination = $("input[name='url_out']").attr('val');
			$("#order_manage_from").attr('action', destination);
			$("#order_manage_from").submit();
			return false;
		});
		/*** end ***/
		
	})
</script>
</body>
</html>