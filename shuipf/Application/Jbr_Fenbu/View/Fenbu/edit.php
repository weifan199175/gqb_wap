<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <div class="h_a">基本信息</div>
  <form class="J_ajaxForm" action="{:U('Fenbu/edit')}" method="post" id="myform">
  <div class="table_full">
      <table width="100%">
        <tr>
          <th width="100">分社名字</th>
          <td><input type="text" name="name" class="input" id="name" value="{$fenbu['name']}"></input>
          <span class="gray">请输入分社名字</span></td>
        </tr>
        <tr>
          <th>邀请码</th>
          <td><input type="text" name="invitation_code" class="input" id="invitation_code" value="{$fenbu['invitation_code']}"></input>
          <span class="gray">请输入邀请码，例如"tianjing"</span></td>
        </tr>
      </table>
    <input type="hidden" name="id" value="{$id}">
  </div>
  <div class="">
      <div class="btn_wrap_pd">             
        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">提交</button>
      </div>
    </div>
    </form>
</div>
<script src="{$config_siteurl}statics/js/common.js?v"></script>
</body>
</html>