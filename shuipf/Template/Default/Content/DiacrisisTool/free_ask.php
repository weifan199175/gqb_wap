<!DOCTYPE html>
<html lang="en">

<head>
    <title>提交问题</title>
    <meta charset="UTF-8">
    <!--     <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"> -->
    <meta http-equiv=”X-UA-Compatible” content=”IE=edge,chrome=1″/>
    <script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
    <script src="http://g.tbcdn.cn/mtb/lib-flexible/0.3.4/??flexible_css.js,flexible.js"></script>
    <script type="text/javascript" src="/statics/default/js/fastclick.min.js"></script>
    <script src="https://cdn.bootcss.com/velocity/1.5.0/velocity.min.js"></script>
<!--    <script src="/statics/default/js/diagnosisSuccess.min.js"></script>-->
    <link rel="stylesheet" href="/statics/default/css/public.css">
    <link rel="stylesheet" href="/statics/default/css/ui-box.css">
    <link rel="stylesheet" href="/statics/default/css/ui-base.css">
    <link rel="stylesheet" href="/statics/default/css/ui-color.css">
    <link rel="stylesheet" href="/statics/default/css/appcan.control.css">
    <link rel="stylesheet" href="/statics/default/css/iconfont/iconfont.css">
    <link rel="stylesheet" href="/statics/default/css/index.css">
    <link rel="stylesheet" href="/statics/zc/css/reset.min.css">
    <link rel="stylesheet" href="/statics/zc/css/common.min.css">
    <link rel="stylesheet" href="/statics/default/css/askPage.min.css">
</head>

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
    <div class="askDiv">
        <div class="askTitle">企业问题反馈</div>
        <ul class="askes">
            <li>
                <div class="question">
                    1.您与其他股东之间存在哪些问题想要咨询？
                </div>
                <div class="inputDiv">
                    <textarea name="" id="q1" cols="30" rows="3" placeholder="请输入您的问题"></textarea>
                </div>
                
            </li>
            <li>
                <div class="question">
                    2.您有哪些股权分配问题想要咨询？
                </div>
                <div class="inputDiv">
                    <textarea name="" id="q2" cols="30" rows="3" placeholder="请输入您的问题"></textarea>
                </div>
            </li>
            <li>
                <div class="question">
                    3.您的企业是否有其他股权问题想要咨询？
                </div>
                <div class="inputDiv">
                    <textarea name="" id="q3" cols="30" rows="3" placeholder="请输入您的问题"></textarea>
                </div>
            </li>
            <li>
                <div class="question">
                    4.您需要股权帮为您提供什么帮助？ 
                </div>
                <div class="inputDiv">
                    <textarea name="" id="q4" cols="30" rows="3" placeholder="请输入您的问题"></textarea>
                </div>
            </li>
        </ul>
        <div class="askBtn" id='submit'><a href="javascript:void(0)">提交</a></div>
    </div>
    <input type='hidden' id='userid' value="{$userid}">
    <input type='hidden' id='id' value="{$id}">
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
</body>

</html>

<script type='text/javascript'>
var id = $('#id').val();
var userid = $('#userid').val();
$('#submit').click(function(){
   var data = new Object(); 
   var flag = 0;  
   data['q_one'] = $('#q1').val();
   data['q_two'] = $('#q2').val();
   data['q_three'] = $('#q3').val();
   data['q_four'] = $('#q4').val();
   data['member_id'] = userid;
   data['dia_id'] = id
   if(data['member_id'] == '')
   {
	   alert('请先登录！');
	   window.location.href = '/inde.php/content/user/login';
   }else if(data['dia_id'] == '')
   {
	   alert('非法进入！');
	   window.location.href = '/index.php';
    }

   if(data['q_one'] == '')
   {
	   flag ++;
	}
   if(data['q_two'] == '')
   {
	   flag ++;
	}
   if(data['q_three'] == '')
   {
	   flag ++;
	}
   if(data['q_four'] == '')
   {
	   flag ++;
   }
   console.log(flag);
   if(flag==4)
   {
	   //至少提一个问题
	   alert('请至少提一个问题！');return;
   } 

   //ajax,提交问题
   $.ajax({
      url:'/index.php/content/diacrisisTool/ajaxSaveQuestion',
      data:data,
      type:"POST",
      dataType:'json',
      success:function(r)
      {
          if(r.code==1)
          {
              //提交成功
              window.location.href = '/index.php/content/DiacrisisTool/askSuccess?type=2&id='+data['dia_id'];
          }else if(r.code==-1)
          {
              //用户未登录
              alert('请登录后再提交！');
              window.location.href = '/inde.php/content/user/login';
          }else if(r.code==-2)
          {
              //没有传递诊断记录ID
              alert('请先诊断后再来提交问题！');
              window.location.href = '/inde.php/content/DiacrisisTool/diacrisisTool';
          }else if(r.code==-3)
          {
              //数据库中没有诊断记录ID
              alert('请先诊断后再来提交问题！');
              window.location.href = '/inde.php/content/DiacrisisTool/diacrisisTool';
          }else if(r.code==-4)
          {
              //诊断记录ID不是属于当前登陆者
              alert('您不是这条记录的所有者！');
              window.location.href = '/inde.php/content/DiacrisisTool/diacrisisTool';
          }
          else if(r.code==-5)
          {
              //提交失败！
              alert('提交失败，请稍后再试！');
              return;
          }
       }
   });  
});

</script>