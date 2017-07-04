<html>
<body>
<form action="{:U('NewStatistics/uploadExcel')}" name="form" method="post" enctype="multipart/form-data">
  选择总表的excel：<input type="file" name="file" />
  <input type="submit" name="submit" value="上传" />
</form>
<!-- <form action="{:U('NewStatistics/uploadExcel2')}" name="form2"method="post" enctype="multipart/form-data">
  选择每一期的excel：<input type="file" name="file" />
  <input type="submit" name="submit" value="上传" />
</form> -->
</body>
</html>