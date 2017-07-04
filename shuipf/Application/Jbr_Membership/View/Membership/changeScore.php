<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <div class="h_a">基本信息</div>
  <form class="J_ajaxForm" action="" method="post">
  <div class="table_full">
      <table width="100%">
        <tr>
          <th width="100">用户ID</th>
          <td><input type="text" name="userId" class="input" id="userId"></input>
          <span class="gray">请输入用户ID（必填）</span><button class="btn" type="button" onclick="selectScore()">查询积分</button></td>
        
        </tr>
        <tr>
          <th>变动积分</th>
          <td><input type="text" name="score" class="input"></input>
          <span class="gray">正数表示增加，负数表示减少（必填）</span></td>
        </tr>
        <tr>
          <th>变动理由</th>
          <td><input type="text" name="reason" class="input"></input>
          <span class="gray">用于展示在用户的积分日志中（必填）</span></td>
        </tr>
        <tr>
          <th>分享类型ID</th>
          <td><input type="text" name="share_type_id" class="input"></input>
          <span class="gray">对应表中share_type_id字段（可为空）</span></td>
        </tr>
        <tr>
          <th>消费者ID</th>
          <td><input type="text" name="consumer_id" class="input"></input>
          <span class="gray">对应表中consumer_id（可为空）</span></td>
        </tr>
        <tr>
          <th>openid</th>
          <td><input type="text" name="openid" class="input"></input>
          <span class="gray">对应表中openid（可为空）</span></td>
        </tr>
      </table>
    
  </div>
  <div class="">
      <div class="btn_wrap_pd">             
        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">提交</button>
      </div>
    </div>
    </form>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>
<script>
function selectScore(){
	var userId = $("#userId").val();
	$.ajax({
		type: "POST",
		url: "index.php?g=Jbr_Membership&m=Membership&a=changeScore",
		data: {userId:userId,func:"selectScore"},
		success: function(res){
			alert(res);
		}
	}); 
}
</script>
</body>
</html>