<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
   <Admintemplate file="Common/Nav"/>
   <form class="J_ajaxForm" action="{:U('Management/adminadd')}" method="post" id="myform">
   <div class="h_a">基本属性</div>
   <div class="table_full">
   <table width="100%" class="table_form contentWrap">
        <tbody>
          <tr>
            <th width="80">用户名</th>
            <td><input type="test" name="username" class="input" id="username">
              <span class="gray">请输入用户名</span></td>
          </tr>
          <tr>
            <th>密码</th>
            <td><input type="password" name="password" class="input" id="password" value="">
              <span class="gray">请输入密码</span></td>
          </tr>
          <tr>
            <th>确认密码</th>
            <td><input type="password" name="pwdconfirm" class="input" id="pwdconfirm" value="">
              <span class="gray">请输入确认密码</span></td>
          </tr>
          <tr>
            <th>E-mail</th>
            <td><input type="text" name="email" value="" class="input" id="email" size="30">
              <span class="gray">请输入E-mail</span></td>
          </tr>
          <tr>
            <th>真实姓名</th>
            <td><input type="text" name="nickname" value="" class="input" id="realname">
            <span class="gray">若"所属角色"选择的是"客服专员"，则将真实姓名填写正确，否则无法正常查询</span></td>
          </tr>
          <tr>
          <th>备注</th>
          <td><textarea name="remark" rows="2" cols="20" id="remark" class="inputtext" style="height:100px;width:500px;"></textarea>
          <span class="gray">若"所属角色"选择的是"客服组长"，则将小组下所有的客服人员的姓名填写在备注里，用逗号分隔，例如：张三,李四,王五,赵六</span></td>
        </tr>
          <tr>
            <th>所属角色</th>
            <td>{$role}</td>
          </tr>
          <tr>
          <th>管理分部</th>
          <td>
          <select name="fenbu_id">
                <option value="0" selected="selected">全部</option>
                <option value="0">不相关</option>
                <foreach name="fenbu" item="f">
                <option value="{$f['id']}">{$f['name']}</option>
                </foreach>
          </select>
          </td>
        </tr>
          <tr>
          <th>状态</th>
          <td><select name="status">
                <option value="1">开启</option>
                <option value="0" selected>禁止</option>
          </select></td>
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
</body>
</html>