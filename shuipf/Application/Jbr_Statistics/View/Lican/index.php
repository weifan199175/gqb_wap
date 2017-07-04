<html>
<body>
<form action="" name="form" method="post" enctype="multipart/form-data">
  选择邮件底部统计图：<input type="file" name="file" />
  <input type="submit" name="submit" value="上传" />
</form>
<hr/>
<form action="{:U('Lican/uploadExcel')}" name="form" method="post" enctype="multipart/form-data">
  选择SEM列表的excel：<input type="file" name="file" />
  <input type="submit" name="submit" value="上传" />
</form>
</body>
</html>