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
	        <select class="select_2" name="orderstatu"style="width:90px;">
	          <option value="all" <if condition='$orderstatu eq "all"'>selected="selected"</if>>全部</option>
	          <option value="0" <if condition='$orderstatu eq "0"'>selected="selected"</if>>待支付</option>
			  <option value="1" <if condition='$orderstatu eq "1"'>selected="selected"</if>>已支付</option>	
			  <option value="2" <if condition='$orderstatu eq "2"'>selected="selected"</if>>已使用</option>	
	        </select>	
			</span>
			 <span class="mr20">&nbsp;&nbsp;核销码：<input name="ordernum" value="{$ordernum}" type="text" class="input"/>
			</span>
			<span class="mr20">&nbsp;&nbsp;开始日期：<input  type="text" class="input length_3 J_datetime  date" size="16" value="{$stime}" id="StartTime" name="starttime" />
			</span>
			<span class="mr20">&nbsp;&nbsp;结束日期：<input  type="text" class="input length_3 J_datetime  date" size="16" value="{$etime}" id="EndTime" name="endtime" />
			</span>
			<br/>
			<br/>
			<span class="mr20">&nbsp;&nbsp;请选择服务类型：	      
			<select class="select_2" name="product_type"style="width:90px;">
	          <option value="0" <if condition='$product_type eq "0"'>selected="selected"</if>>全部</option>
	          
			  <option value="1" <if condition="$product_type eq 1">selected="selected"</if>>课程</option>	
			  <option value="16" <if condition="$product_type eq 16">selected="selected"</if>>铁杆社员</option>
			  <option value="4" <if condition="$product_type eq 4">selected="selected"</if>>股权诊断器</option>
			  <option value="7" <if condition="$product_type eq 7">selected="selected"</if>>9块9微课</option>
	        </select>
	        </span>
	        
			<span class="mr20">&nbsp;&nbsp;请选择分社：	      
			<select class="select_2" name="fenbu_id" style="width:80px;">
			    <volist name="fenbu" id="f">
				    <option value="{$f.id}" <if condition='$f.id eq $fenbu_id'>selected="selected"</if> >{$f.name}</option>
				</volist>  
	        </select>
	        </span>
	        
	        <span class="mr20">&nbsp;&nbsp;课程（服务项目）名称：<input name="title" value="{$title}" type="text" class="input"/>
	         <input value="1" type="hidden" name="url_search"/>
	         <input class="btn" value="搜索" type="button" style="color:red;" id="btn_search"/>
	        </span>
			
			<?php if($_SESSION['jbr_admin_id'] == 1 || $_SESSION['jbr_admin_id'] == 5){?>
	        <input type="button"  value="导出搜索内容" id="btn_out" class="btn"/>
			<?php }?>
		
	      </div>
		   
			<input type="hidden" value="1" val="{:U('Order/index')}" name="url_search" >
			<input type="hidden" value="2" val="{:U('Order/excel')}" name="url_out" >
	    </div>
  </form>
  <form name="myform" class="J_ajaxForm" action="" method="post">
  <div class="table_list">
  <table width="100%" cellspacing="0">
        <thead>
          <tr>
            <!--td width="5%"  align="center">
			<input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x" onClick="selectall('tagid[]');">
			全选</td-->
            <!--td width="5%" align="center">编号</td-->
            <td align="center" width="10%">订单号（核销码）</td>
			<td align="center" width="10%">会员姓名</td>
			<td align="center" width="10%">会员电话</td>
			<td align="center" width="15%">服务项目</td>
			<td align="center" width="8%">下单时间</td>
			<td align="center" width="8%">开讲时间</td>
			<td align="center" width="7%">支付方式</td>
			<td align="center" width="7%">订单总价</td>
		    <!--td align="center" width="6%">服务项目</td-->
		    <td align="center" width="5%">是否索要发票</td>
            <td align="center" width="5%">订单状态</td>  			
            <td align="center" width="10%">操作</td>
          </tr>
        </thead>
        <tbody>
        <volist name="orderList" id="vo">
          <tr>
            <!--td align="center"><input type="checkbox" value="{$vo.OrderID}" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="tagid[]">
			<input type="hidden" mid="{$vo.orderID}">
			</td-->
			<!--td align="center">
			{$vo.orderID}
			</td-->
            <td align="center">{$vo.verification_code}</td>
			<td align="center">{$vo.truename}</td>
			<td align="center">{$vo.mobile}</td>
			<td align="center">{$vo.title}</td>
            <td align="center">{$vo.addtime}</td>
			<td align="center">{$vo.c_start_time|date="Y-m-d H:i:s",###}</td>
			<td align="center">{$vo.rpay_type}</td>
			<td align="center">{$vo.price}</td>
			<td align="center"><if condition="$vo['for_invoice'] eq 1">是<else />否</if></td>
			<td align="center">{$vo.rstatus}</td>
            <td align="center">
            <?php
			$op = array();
		    
			    if(\Libs\System\RBAC::authenticate('detail')){
					$op[] = '<a href="'.U('Order/detail',array('id'=>$vo['id'])).'">查看详情</a>';
				}
				
				if($vo['pay_type']!=3 && $vo['rstatus']=='已过期'){
					if(\Libs\System\RBAC::authenticate('edit')){
					   $op[] = '<a href="'.U('Order/edit',array('id'=>$vo['id'])).'">场次调整</a>';
				    }
				}
				
				
			
			echo implode(" | ",$op);
			?> 
            </td>
          </tr>
        </volist>
        </tbody>
      </table>
      <div class="p10">
        <div class="pages"> {$Page} </div>
      </div>
  </div>
  <div class="btn_wrap">
      <div class="btn_wrap_pd">             
      	<!--label class="mr20"><input type="checkbox" class="J_check_all" data-direction="y" data-checklist="J_check_y">全选</label-->
       
        <?php
		if(\Libs\System\RBAC::authenticate('delete')){
		?>
       <!-- <button class="btn  mr10 J_ajax_submit_btn" type="submit" data-action="{:U('Order/deleteall')}">删除</button> -->
        <?php
		}
		?>
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