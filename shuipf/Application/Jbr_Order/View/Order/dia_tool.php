<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <div class="table_list">
  <table width="100%" cellspacing="0">
        <thead>
          <tr>
            <td align="center" >项目名称</td>
			<td align="center" >手机号</td>
			<td align="center" >股东人数</td>
			<td align="center" >股份比例</td>
            <td align="center" >CEO</td>
			<td align="center" >董事会成员</td>
			<td align="center" >全职股东</td>
			<td align="center" >是否有期权池</td>
			<td align="center" >创建时间</td>
			<td align="center" >花费时间</td>
			<td align="center" >诊断类型</td>
			<td align="center" >星级</td>
			<td align="center" >分数</td>
			<td align="center" >状态</td>
			<td align="center" >会员ID</td>
			<td align="center" >订单号</td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td align="center">{$res.project}</td>
			<td align="center">{$res.mobile}</td>
			<td align="center">{$res.partner_num}</td>
			<td align="center">{$res.stock_scale}</td>
			<td align="center">{$res.is_ceo}</td>
			<td align="center">{$res.is_direct}</td>
			<td align="center">{$res.is_full_time}</td>
			<td align="center">{$res.is_pool}</td>
			<td align="center">{$res.datetime}</td>
			<td align="center">{$res.cost_time}秒</td>
			<td align="center">{$res.style}</td>
			<td align="center">{$res.star}</td>
			<td align="center">{$res.score}</td>
			<td align="center">{$res.status}</td>
			<td align="center">{$res.member_id}</td>
			<td align="center">{$res.verification_code}</td>
          </tr>
        </tbody>
      </table>
  </div>
</div>

<script>
setCookie('refersh_time', 0);
function refersh_window() {
    var refersh_time = getCookie('refersh_time');
    if (refersh_time == 1) {
        window.location.reload();
    }
}
setInterval(function(){
	refersh_window()
}, 3000);
</script>
</body>
</html>