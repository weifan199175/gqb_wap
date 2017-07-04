<!DOCTYPE html>
<html lang="en">

<head>
    <title>股权设计</title>
    <meta charset="UTF-8">
    <!--     <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no"> -->
    <meta http-equiv=”X-UA-Compatible” content=”IE=edge,chrome=1″/>
    <script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
    <script src="http://g.tbcdn.cn/mtb/lib-flexible/0.3.4/??flexible_css.js,flexible.js"></script>
    <script type="text/javascript" src="/statics/default/js/fastclick.min.js"></script>
    <script src="https://cdn.bootcss.com/velocity/1.5.0/velocity.min.js"></script>
    <script src="https://cdn.bootcss.com/Swiper/3.4.2/js/swiper.jquery.min.js"></script>
    <link rel="stylesheet" href="/statics/default/css/public.css">
    <link rel="stylesheet" href="/statics/default/css/ui-box.css">
    <link rel="stylesheet" href="/statics/default/css/ui-base.css">
    <link rel="stylesheet" href="/statics/default/css/ui-color.css">
    <link rel="stylesheet" href="/statics/default/css/appcan.control.css">
    <link rel="stylesheet" href="/statics/default/css/iconfont/iconfont.css">
    <link rel="stylesheet" href="/statics/default/css/index.css">
    <link rel="stylesheet" href="/statics/zc/css/reset.min.css">
    <link rel="stylesheet" href="/statics/zc/css/common.min.css">
    <link href="https://cdn.bootcss.com/Swiper/3.4.2/css/swiper.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/statics/Themegyby/css/bidding.min.css">
</head>
<script>
$(function() {
    FastClick.attach(document.body);
})
</script>
<body>
    <div class="banner">
        <img src="/statics/Themegyby/images/biddingBanner.jpg" alt="">
    </div>
    <div class="q">
        <img src="/statics/Themegyby/images/yourQ.jpg" alt="">
     <div class="inputsDiv">
        <div class="inputsTitle">
            填写信息，免费咨询
        </div>
        <div class="inputsTitle2">
            目前已有<span>2341</span>个报名
        </div>
        <ul class="inputs">
            <li>
                <input type="text" placeholder="公司名称*必填*" id='company1'>
            </li>
            <li>
                <input type="text" placeholder="职位*必填*" id='job1'>
            </li>
            <li>
                <input type="text" placeholder="姓名*必填*" id='name1'>
            </li>
            <li>
                <input type="text" placeholder="电话*必填*" id='mobile1'>
            </li>
        </ul>
        <div class="inputsBtn" onclick='submit(1)'>
            <a href="javascript:void(0)">
                提交
            </a>
        </div>
    </div>
        <a href="/index.php/content/theme/biddingHelp">
            <img src="/statics/Themegyby/images/q1.jpg" alt="">
        </a>
        <a href="/index.php/content/theme/biddingHelp">
            <img src="/statics/Themegyby/images/q2.jpg" alt="">
        </a>
        <a href="/index.php/content/theme/biddingHelp">
            <img src="/statics/Themegyby/images/q3.jpg" alt="">
        </a>
    </div>
    <div class="why">
        <img src="/statics/Themegyby/images/why.jpg" alt="">
    </div>
    <div class="course">
        <img src="/statics/Themegyby/images/biddingCourse.jpg" alt="">
    </div>
    <div class="teacher">
        <img src="/statics/Themegyby/images/biddingTeacher.jpg" alt="">
    </div>
    <div class="company">
        <img src="/statics/Themegyby/images/company.jpg" alt="">
    </div>
    <div class="thx">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="/statics/Themegyby/images/thx1.jpg" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="/statics/Themegyby/images/thx2.jpg" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="/statics/Themegyby/images/thx3.jpg" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="/statics/Themegyby/images/thx4.jpg" alt="">
                </div>
                <div class="swiper-slide">
                    <img src="/statics/Themegyby/images/thx5.jpg" alt="">
                </div>
            </div>
            <!-- 如果需要分页器 -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div class="showCourse">
        <img src="/statics/Themegyby/images/showCourse.jpg" alt="">
    </div>
    <div class="inputsDiv">
        <div class="inputsTitle">
            本期限报60人，名额有限，报完为止
        </div>
        <div class="inputsTitle2">
            截止今天现还有<span>18</span>个空缺
        </div>
        <ul class="inputs">
            <li>
                <input type="text" placeholder="公司名称*必填*" id='company2'>
            </li>
            <li>
                <input type="text" placeholder="职位*必填*" id='job2'>
            </li>
            <li>
                <input type="text" placeholder="姓名*必填*" id='name2'>
            </li>
            <li>
                <input type="text" placeholder="电话*必填*" id='mobile2'>
            </li>
        </ul>
        <div class="inputsBtn" onclick='submit(2)'>
            <a href="javascript:void(0)">
                提交
            </a>
        </div>
    </div>
    <div class="copyright">
        <p>Copyright @ 2012-2017 伯格联合（北京）科技有限公司</p>
        <p>版权所有 京ICP备17021916号-1</p>
        <p>联系电话：400-027-9828 微信：股权帮 </p>
        <p>股权交流QQ群：293765589</p>
        <p>地址： 北京市海淀区上地东路35号院2号楼2层2-206</p>
    </div>
     <!-- foote开始 -->
    <script>
//     var mySwiper = new Swiper('.thx .swiper-container', {
//         direction: 'horizontal',
//         loop: true,

//         // 如果需要分页器
//         pagination: '.swiper-pagination',

//     });
//     // 定时器
//     var peopleNum = $(".inputsTitle2 span").text();
//     var startDay = new Date();
//     var thisDay = startDay.getDate();
//     switch (true) {
//         case thisDay >= 1 && thisDay < 5:
//             peopleNum = 46;
//             $(".inputsTitle2 span").text(peopleNum);
//             break;
//         case thisDay >= 5 && thisDay < 10:
//             peopleNum = 33;
//             $(".inputsTitle2 span").text(peopleNum);
//             break;
//         case thisDay >= 10 && thisDay < 16:
//             peopleNum = 19;
//             $(".inputsTitle2 span").text(peopleNum);
//             break;
//         case thisDay >= 16 && thisDay < 20:
//             peopleNum = 8;
//             $(".inputsTitle2 span").text(peopleNum);
//             break;
//         case thisDay >= 20 && thisDay <= 31:
//             peopleNum = 5;
//             $(".inputsTitle2 span").text(peopleNum);
//             break;
//     }
    </script>
<!-- <script> 
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?f3ce42d326589dee4677415b54c456df";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
<script>
var _hmt = _hmt || []; (function() { var hm = document.createElement("script"); hm.src = "https://hm.baidu.com/hm.js?f3ce42d326589dee4677415b54c456df"; var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(hm, s); })();
</script> 
<script type="text/javascript" charset="utf-8" async src="http://lxbjs.baidu.com/lxb.js?sid=10725355"></script>-->
<script type="text/javascript">

        function submit(n)
        {
        	var data = new Object();
        	 data['company'] = $('#company'+n).val();
        	 data['job'] = $('#job'+n).val();
        	 data['name'] = $('#name'+n).val();
        	 data['mobile'] = $('#mobile'+n).val();
        	 data['source'] = 'fenghuang';
        	 if(data['company'] == null || data['company'] == undefined || data['company'] =='' )
        	 {   			 
        		 alert('请填写公司名！');
        		 return false;
        	 }
        	 if(data['job'] == null || data['job'] == undefined || data['job'] =='')
        	 {   			 
        		 alert('请填职位！');
        		 return false;
        	 }
        	 if(data['name'] == null || data['name'] == undefined || data['name'] =='')
        	 {   			 
        		 alert('请填姓名！');
        		 return false;
        	 }
        	 if(data['mobile'] == null || data['mobile'] == undefined || data['mobile'] =='')
        	 {   			 
        		 alert('手机号码不能为空！');
        		 return false;
        	 }else if(!checkmobile(data['mobile']))
        	 {
        		 alert('请输入正确的手机号码！');
        		 return false;
        	 }
        	 //ajax提交数据
        	 $.ajax({
        		 type:'POST',
        		 dataType:'json',
        		 url:'/index.php/content/theme/ajaxsave',
        		 data:data,
        		 success:function(msg)
        		 {
        			 if(msg.code == 1)
        			 {
        				 alert(msg.msg);
        			 }else if(msg.code==2)
        			 {
        				 alert(msg.msg);
        			 }
        		 }
        	 });
        }

    	  
    	//验证手机号码
          function checkmobile(phone)
          {
          	var regu = /^1[34578]{1}\d{9}$/;
          	var re   = new RegExp(regu);
          	if(re.test(phone))
          	{
          		return true;
          	}else{
          		return false;
          	}
          }
    </script>
</html>
