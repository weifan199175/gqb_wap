<!DOCTYPE html>
<html lang="en">

<head>
<title>股权诊断器</title>
<meta charset="UTF-8">
<!--     <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"> -->
<meta http-equiv=”X-UA-Compatible” content=”IE=edge,chrome=1″/>
<script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
<script src="http://g.tbcdn.cn/mtb/lib-flexible/0.3.4/??flexible_css.js,flexible.js"></script>
<script type="text/javascript" src="/statics/default/js/fastclick.min.js"></script>
<script src="https://cdn.bootcss.com/velocity/1.5.0/velocity.min.js"></script>
<link rel="stylesheet" href="/statics/default/css/public.css">
<link rel="stylesheet" href="/statics/default/css/ui-box.css">
<link rel="stylesheet" href="/statics/default/css/ui-base.css">
<link rel="stylesheet" href="/statics/default/css/ui-color.css">
<link rel="stylesheet" href="/statics/default/css/appcan.control.css">
<link rel="stylesheet" href="/statics/default/css/iconfont/iconfont.css">
<link rel="stylesheet" href="/statics/default/css/index.css">
<link rel="stylesheet" href="/statics/zc/css/reset.min.css">
<link rel="stylesheet" href="/statics/zc/css/common.min.css">
<link rel="stylesheet" href="/statics/default/css/download.min.css?v=1">
<style>
body {
    padding-bottom: 2.666667rem;
}
</style>
</head>
<script>
$(function() {
    FastClick.attach(document.body);
})
</script>

<body>
<!-- 提交问题 -->
<div class="fileDiv">
<div class="fileTitle">相关合伙模板下载</div>
<p>选择您需要的模板下载：</p>
<ul class="files">
<li>
<div class="filePic" sts=0 value='1'>
<img src="/statics/default/images/file.jpg" alt="" class="file">
<img src="/statics/default/images/chooseFile.png" alt="" class="thisFile">
</div>
<div class="fileName">XX有限公司股东投资合作协议</div>
</li>
<li>
<div class="filePic" sts=0 value='2'>
<img src="/statics/default/images/file.jpg" alt="" class="file">
<img src="/statics/default/images/chooseFile.png" alt="" class="thisFile">
</div>
<div class="fileName">股权代持协议(模板)</div>
</li>
<li>
<div class="filePic" sts=0 value='3'>
<img src="/statics/default/images/file.jpg" alt="" class="file">
<img src="/statics/default/images/chooseFile.png" alt="" class="thisFile">
</div>
<div class="fileName">XX管理公司增资扩股协议(模板)</div>
</li>
<li>
<div class="filePic" sts=0 value='4'>
<img src="/statics/default/images/file.jpg" alt="" class="file">
<img src="/statics/default/images/chooseFile.png" alt="" class="thisFile">
</div>
<div class="fileName">XX管理公司之股权转让协议</div>
</li>
<li>
<div class="filePic" sts=0 value='5'>
<img src="/statics/default/images/file.jpg" alt="" class="file">
<img src="/statics/default/images/chooseFile.png" alt="" class="thisFile">
</div>
<div class="fileName">XX有限公司章程_模板</div>
</li>
<li>
<div class="filePic" sts=0 value='6'>
<img src="/statics/default/images/file.jpg" alt="" class="file">
<img src="/statics/default/images/chooseFile.png" alt="" class="thisFile">
</div>
<div class="fileName">一致行动人协议(模板)</div>
</li>
</ul>
<div class="emailDiv">
<input type="email" placeholder="请填写邮箱，我们将为你发送所需模板" class="email" >
</div>
<input type="hidden" class="member_id" value={$member_id} >
<div class="fileBtn"><a href="javascript:void(0);" onclick = 'submit()'>提交</a></div>
</div>
<!-- foote开始 -->
<div class="footer ubt ubb-d">
<div class="ftNav ub">
<a class="current ub ub-ver ub-ac ub-pc tx-c4" href="/index.php">
<em class="gqblogo ub"></em>
<span class="ub">首页</span>
</a>
<!--<a class="ub ub-ver ub-ac ub-pc tx-c4" href="#">
<em class="gqblogo ub"></em>
<span class="ub">股权帮</span>
</a>-->
<a class=" ub ub-ver ub-ac ub-pc tx-c4" href="/index.php?m=User&amp;a=index">
<em class="ub iconfont icon-ren"></em>
<span class="ub">我的</span>
</a>
<a class=" ub ub-ver ub-ac ub-pc tx-c4" href="/index.php?a=lists&amp;catid=8">
<em class="ub iconfont icon-bangzhuzhongxin"></em>
<span class="ub">帮助中心</span>
</a>
</div>
</div>
<script>
$(".files li").click(function() {
    var sts = $(this).find('.filePic').attr("sts");
    if (sts == 0) {
        $(this).find(".thisFile").show();
        $(this).find(".filePic").addClass('fileShadow');
        $(this).find('.filePic').attr("sts",1);
    }else if(sts==1){
        $(this).find(".thisFile").hide();
        $(this).find(".filePic").removeClass('fileShadow');
        $(this).find('.filePic').attr("sts",0);
    }
});

function submit(){
  var data = new Object();
  var info = new Object();
  $('.files').find("div[sts^='1']").each(function(index,data){
	   info[index] = $(data).attr('value');
  });
  data['email'] = $('.email').val();
  if(data['email'] =="")
  {
   alert("邮箱不能为空");
   return false;
  }
  if(!data['email'].match(/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/))
  {
   alert("格式不正确！请重新输入");
   $(".email").focus();
   return false;
  }
  if($.isEmptyObject(info))
  {
	  //如果用户未选择下载某个文件
	  alert('请选择文件！');	  
  }else
  {
	  data['info'] = info;
	  data['member_id'] = $('.member_id').val();
	  $.ajax({
		  url:'/index.php/content/diacrisisTool/down_email',
		  type:"POST",
	      data:data,
	      dataType:"json",
	      success:function(r)
	      {
		      if(r.code=='-1')
			  {
				  //用户未登录
				  alert('请先登录！');
				  window.location.href='/index.php/content/user/login';
		      }else if(r.code == '1')
			  {
				  //提交成功
				  window.location.href='/index.php/content/diacrisisTool/askSuccess?id={$id}&type=1';
		       }else if(r.code == '-2')
			   {
				   alert(r.msg);
				   return false;
			    }
			      
	      }
	  })  
  }
  
}
</script>
</body>

</html>
