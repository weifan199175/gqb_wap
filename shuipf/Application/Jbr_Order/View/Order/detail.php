<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
 
  <div class="table_list">
 
  <table width="50%" cellspacing="0">
        <thead>
          <tr>
            <td align="center" width="15%">公司抬头</td>
			<td align="center" width="15%">发票内容</td>
			<td align="center" width="15%">发票金额</td>
			<td align="center" width="15%">收件人</td>
            <td align="center" width="15%">联系电话</td>
			<td align="center" width="15%">所在地区</td>
			<td align="center" width="15%">详细地址</td>
          </tr>
        </thead>
        <tbody>
        
          <tr>
            <td align="center">{$res.header}</td>
			<td align="center">{$res.content}</td>
			<td align="center">{$res.price}</td>
			<td align="center">{$res.addressee}</td>
			<td align="center">{$res.tel}</td>
			<td align="center">{$res.area}</td>
			<td align="center">{$res.address}</td>
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