<?php if (!defined('SHUIPF_VERSION')) exit(); ?>
<Admintemplate file="Common/Head"/>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
  <Admintemplate file="Common/Nav"/>
  <div class="h_a">基本信息</div>
  <form class="J_ajaxForm" action="{:U('Membership/add_t_user')}" method="post">
  <div class="table_full">
      <table width="100%">
        <tr>
          <th width="100">姓名</th>
          <td><input type="text" name="name" class="input"></input>
          <span class="gray">请填写客户姓名</span></td>
        </tr>
        <tr>
          <th>手机号</th>
          <td><input type="text" name="mobile" class="input"></input>
          <span class="gray">请填写手机号</span></td>
        </tr>
        <tr>
          <th>记录时间</th>
          <td><input type="text" name="datetime" class="input  J_date" value="<?php echo date("Y-m-d")?>" style="width:80px;"></input>
          <span class="gray">请选择时间</span></td>
        </tr>
        <tr>
          <th>公司名称</th>
          <td><input type="text" name="company" class="input"></input>
          <span class="gray">请填写公司名称</span></td>
        </tr>
        <tr>
          <th>职位</th>
          <td><input type="text" name="job" class="input"></input>
          <span class="gray">请填写职位</span></td>
        </tr>
        <tr>
          <th>渠道</th>
          <td><input type="text" name="source" class="input"></input>
          <span class="gray">请填写渠道</span></td>
        </tr>
        <tr>
          <th>所属省份</th>
          <td><input type="text" name="province" class="input"></input>
          <span class="gray">请填写所属省份</span></td>
        </tr>
        <tr>
          <th>方式</th>
          <td><input type="text" name="way" class="input"></input>
          <span class="gray">请填写方式</span></td>
        </tr>
        <tr>
          <th>请选择课程意向</th>
          <td>
          <select name="is_need">
          <?php foreach ($isNeedList as $k=>$i){?>
          <option value="<?php echo $i?>"><?php echo $i?></option>
          <?php }?>
          </select>
          <span class="gray">请选择课程意向</span></td>
        </tr>
        <tr>
          <th>备注</th>
          <td><textarea name="extra"></textarea>
          <span class="gray">请填写备注（可为空）</span></td>
        </tr>
        <tr>
          <th>请选择所属客服</th>
          <td>
          <select name="kefu">
          <?php foreach ($kefu as $k=>$f){?>
              <option value="<?php echo $f; ?>" <?php echo $f=="乔帅峰"?"selected='selected'":""?>><?php echo $f; ?></option>
          <?php }?>
          </select>
          <span class="gray">请选择所属客服</span></td>
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
</body>
</html>