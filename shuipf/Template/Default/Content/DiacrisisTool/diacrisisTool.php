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
    <script type="text/javascript" src="/statics/default/js/diagnosis.js"></script>
    <link rel="stylesheet" href="/statics/default/css/public.css">
    <link rel="stylesheet" href="/statics/default/css/ui-box.css">
    <link rel="stylesheet" href="/statics/default/css/ui-base.css">
    <link rel="stylesheet" href="/statics/default/css/ui-color.css">
    <link rel="stylesheet" href="/statics/default/css/appcan.control.css">
    <link rel="stylesheet" href="/statics/default/css/iconfont/iconfont.css">
    <link rel="stylesheet" href="/statics/default/css/index.css">
    <link rel="stylesheet" href="/statics/zc/css/reset.min.css">
    <link rel="stylesheet" href="/statics/zc/css/common.min.css">
    <link rel="stylesheet" href="/statics/default/css/diagnosis.min.css?v=1">
</head>
<script>
$(function() {
    FastClick.attach(document.body);
})
</script>

<body>
    <!-- 开始页面 -->
    <div class="welcome page">
        <div class="logo">
            <img src="/statics/default/images/LOGO.png" alt="">
        </div>
<!--       <div class="welcomeTitle">
            <img src="/statics/default/images/welcome.png" alt="">
        </div>-->
       <div class="start">
            <div class="startBtn">
                <img src="/statics/default/images/startBtn.png" alt="">
            </div>
        </div>       
        <div class="welcomeBottom">
            <img src="/statics/default/images/welcomeBottom.png" alt="">
        </div>
    </div>
    <!-- loading页面 -->
    <div class="loading page">
       <div class="loadingPic">
            <img src="/statics/default/images/katong.gif" alt="">
        </div>
	   <div class="loadingMsg" len="0">大数据正在计算中,请您耐心等待</div>
    </div>
    
    <!-- 填写数据页面 -->
    <div class="cover"></div>
    <div class="tip">
        <div class="tipTitle">
        <div>名词解释</div>
        <div class="close">
            <img src="/statics/default/images/close.png" alt="">
        </div>
        </div>
        <div class="tipDiv">
            <div class="tip1">
                <span>股东：</span>即公司的主人，合格的股东通常需要缴纳出资，承担风险并努力创造股权增值
            </div>
            <div class="tip2">
                <span>高管持股计划：</span>为未来引进高级人才而预留的股份，通常有两种表现形式：（1）由创始人先持有而后陆续转让给引进的高级人才；（2）预先设立持股平台，引进的高级人才后续在持股平台持股而间接持有公司股份。
            </div>
        </div>
    </div>
    <div class="important">
        <div class="importantTitle">
            <div>温馨提示</div>
            <div class="close">
                <img src="/statics/default/images/close.png" alt="">
            </div>
        </div>
        <div class="importantDiv">请您尽量填写真实信息，我们将为您免费提供一份股权诊断报告</div>
    </div>
    <div class="nav">
        <div class="navIcon">
            <img src="/statics/default/images/gongsi.png" alt="">
        </div>
        <div class="navTitle">公司信息</div>    
	</div>
    <div class="main">
        <!-- 公司信息 -->
        <div class="companyInfo tab">
            <div class="projectNameDiv">
                <div class="projectName">公司名称:<span style="display:none;" id='prj_name'>名称不能为空！</span></div>
                <input type="text" placeholder="请输入公司名称" id='projectname' value="{$memberInfo.company}">
            </div>
            <div class="nameDiv">
                <div class="projectName">真实姓名:</div>
                <input type="text" placeholder="请输入真实姓名" id='name' value="{$memberInfo.truename}">
            </div>
             <div class="telDiv">
                <div class="projectName">联系方式:<span style="display:none;" id='moblie_name'>联系方式不能为空！</span></div>
                <input type="tel" placeholder="请输入联系方式" id='moblie'  value="{$memberInfo.mobile}">
            </div>
            <div class="identityDiv">
                <div class="identityTitle">
                    身份信息:
                </div>
                <ul class='whatJob'>
                    <li sts="0">创始人</li>
                    <li sts="0">合伙人</li>
                    <li sts="0">经理人</li>
                    <li sts="0">投资人</li>
                </ul>
            </div>
            <div class="peopleNumDiv">
                <div class="peopleNum">股东人数:<img src="/statics/default/images/tip.png" alt=""></div>
                <!-- <div class="numSelect">
                    <span>选择人数</span>
                    <select class="text">
                        <option value="0">选择人数</option>
                        <option value="2">2人</option>
                        <option value="3">3人</option>
                        <option value="4">4人</option>
                        <option value="5">5人</option>
                    </select>
                </div> -->
                <ul class="numList">
                    <li value="1">1人</li>
                    <li value="2">2人</li>
                    <li value="3">3人</li>
                    <li value="4">4人</li>
                    <li value="5">5人</li>
                    <li value="6">6人</li>
                </ul>
            </div>
            <!-- 是否有期权池 -->
            <div class="switchDiv optionDiv" sts="0">
                 <div class="switchDivTitle">
                    是否有高管持股计划:
                    <img src="/statics/default/images/tip.png" alt="">
                </div>
                <ul class="switchDivList">
                    <li sts="0" id='是'>是</li>
                    <li sts="0" id='否'>否</li>
                </ul>
            </div>
        </div>
        <!-- 股东信息 -->
        <div class="nav">
             <div class="navIcon">
                <img src="/statics/default/images/gushixinxi.png" alt="">
            </div>
            <div class="navTitle">股东信息</div>        </div>
        <div class="shareholder tab">
            <!-- 股东份额 -->
            <div class="sharesDiv">
                <div class="sharesTitle inputTitle">
                    <span>当前各股东比例:</span> 
                    <span class="resetBtn">重置比例</span>  
                </div>
                <ul class="sharesList" id='sharesList'>
                     
                </ul>
            </div>
            <!-- 谁是ceo -->
            <div class="ceoDiv">
                <div class="ceoTitle">
                    CEO是谁:
                </div>
                <ul class="ceoList ceoChoose">
                    <!-- <li>
                        古董衣
                    </li> -->
                </ul>
            </div>
            <!-- 谁是董事长 -->
            <div class="bossDiv ceoDiv">
                <div class="ceoTitle bossTitle">
                    董事长是谁:
                </div>
                <ul class="ceoList bossList">
                    <!-- <li>
                        古董衣
                    </li> -->
                </ul>
            </div>
            <!-- 是否是夫妻、血缘 -->
            <!-- <div class="familyDiv">
                <div class="familyTitle">
                    是否是夫妻、血缘:
                </div>
                <ul class="familyList">
                    <li sts="0">
                        古董衣
                    </li>
                </ul>
            </div> -->
            <!-- 是否是全职股东 -->
            <div class="fullDiv">
                <div class="fullTitle">
                    现在全职的股东:
                </div>
                <ul class="fullList">
                    <!-- <li sts="0">
                        古董衣
                    </li> -->
                </ul>
            </div>
            <!-- 出资份额 -->
            <!-- <div class="moneyDiv">
                <div class="moneyTitle inputTitle">
                    <span>出资比例:</span>
                    <span class="resetBtn">重置比例</span>
                </div>
                <ul class="moneyList">
                    <li>
                        <span>股东一啊</span>
                        <input type="text"> %
                    </li>
                </ul>
            </div> -->
            <!-- 是否有董事会 -->
            <!-- <div class="switchDiv" sts="0">
                <div class="switchTitle">是否有董事会</div>
                <i class="myiconfont">&#xe634;</i>
            </div> -->
            <!-- 是否是董事会成员 -->
            <!-- <div class="memberDiv">
                <div class="memberTitle">
                    是否是董事会成员:
                </div>
                <ul class="memberList">
                    <li sts="0">
                        古董衣
                    </li>
                </ul>
            </div> -->
        </div>
        <!-- 提交按钮 -->
        <div class="subBtn" id='submitAll' onclick='submitAll()' >
            <a href="#" id='btn'>提交</a>
        </div>
    </div>
    <input type="hidden" value="<?php echo time()?>" id='nowtime'>
    <input type="hidden" value="<?php echo $member_id?>" id='id'>

    
</body>
<script type="text/javascript">
var data = new Object();
var arr1 = new Array(); //arr1 存入股东占股比 sum1 存放占股比总数
var arr2 = new Array(); //arr2存放全职股东
var arr5 = new Array(); //arr5 存放董事会成员信息
var flag = 0; //定义flag 默认为0

//手机验证
function checkMobile( s ){   
 var regu =/^1[34578]{1}\d{9}$/; 
  var re = new RegExp(regu); 
     if (re.test(s)) { 
          return true; 
         }else{ 
           return false; 
        } 
}

function getValue(){
 arr2 = new Array();
 data['name'] = $('#name').val();
 data['project'] = $('#projectname').val();
 data['mobile'] = $('#moblie').val();
 data['partner_num'] = $('.numList').find("li[class^='thisli']").val();
 data['datetime'] = $('#nowtime').val();
 data['member_id']=$('#id').val();
 
 //获取谁是ceo
 data['is_ceo'] = $('.ceoList').find("li[class^='thisli']").html();
 //获取谁是董事长
 data['is_direct']  = $('.bossList').find("li[class^='thisli']").html();
 //获取是否有期权
 data['is_pool'] = $('.switchDivList').find("li[sts^='1']").attr('id');
 if(data['is_pool'] == undefined )
 {
	 data['is_pool'] = '否';
 }

 //获取用户的职业，便于注册
 data['job'] = $('.whatJob').find("li[class^='thisli']").html();
 //arr1 存入股东占股比 sum1 存放占股比总数
 for(var i=1; i<=data['partner_num'];i++)
  {
	arr1[i-1] =$('#sharesList').find("input[name^='股东"+i+"']").val();		
  }
 data['stock_scale'] = arr1; 
 //获取全职股东 arr2存放全职股东 	
 $('.fullList').find("li[class^='thisli']").each(function(index,data){
	   arr2[index] = $(data).text();
 });
 data['is_full_time'] = arr2;
}

//股份比例补全
$('#sharesList').on('change','input',function(){
	getValue();
    //获取所有股份的和
    var sumDate = 0;
	for(var i=1; i<=data['partner_num'];i++)
	{
		arr1[i-1] =$('#sharesList').find("input[name^='股东"+i+"']").val();
		if(arr1[i-1] == '')
		{
			arr1[i-1] = 0
		}
		sumDate =sumDate+parseFloat(arr1[i-1]); 		
	}
	var date = new Array();  //存放有数据数组
	//判断输入框是否有空的
	$.each(arr1,function(k,v){
       if(v =='')
       {
           date[k] = k; //存入空的数组
       }
	});
	var datelen = 0;
	for(var j in date)
    {
	    datelen++;
	}
	//如果最后只剩下一个空的input输入框，则自动补全其值
	if(datelen == 1 & sumDate<100)
	{
		//获取空数据的下标
		var i =parseInt(date.join(''))+1;
		//获取补全的值
		var differ = 100-sumDate;
		//将补全的值放入到输入框中
		$('#sharesList').find("input[name^='股东"+i+"']").val(differ)
	}else if(datelen == 0 & sumDate != 100)
    {
	    var sum_one = 0;
		for(var i=1; i<=data['partner_num']-1;i++)
		{
			arr1[i-1] =$('#sharesList').find("input[name^='股东"+i+"']").val();
			if(arr1[i-1] == '')
			{
				arr1[i-1] = 0
			}
			sum_one =sum_one+parseFloat(arr1[i-1]); 		
		}		
	    //如果用户在填完了之后修改了其中某一个值，则自动补满其他的框
		$('#sharesList').find("input[name^='股东"+data['partner_num']+"']").val(100-sum_one)
	}
// 	else if(sumDate >100)
// 	{
// 		alert('请填写正确比例！');
// 		return false;
// 	}
});





//验证股东信息 
function test()
{
	var sum1 = 0;
	getValue();
	//检验公司信息是否填写完整
	if(data['project'] == '')
	{
		alert("请在‘公司信息’栏中填写项目名称！"); 
		return 0;
	}
	if(!checkMobile(data['mobile']))
	{
		alert("请在‘公司信息’栏中填写正确的联系方式！"); 
		return 0;
	}
	for(var i=1; i<=data['partner_num'];i++)
	{
		arr1[i-1] =$('#sharesList').find("input[name^='股东"+i+"']").val();
		if(arr1[i-1]=='' | arr1[i-1]=='0')
		{
           alert('请填写合适的占股比！');
           return 0;
		}
		sum1 =sum1+parseFloat(arr1[i-1]); 		
	}

	if(sum1<100 && data['partner_num']=='1' )
    {
	    //一个人的股份默认为100%
	    alert('一个人股份默认为100%！');
	    return 0;
	}
	if(sum1<0 || sum1>101){
		alert('请填写正确的股比，以便正确诊断！');
		return 0;
	}
}

//提交按钮
function submitAll()
{
	getValue();
	flag = test();	
	if(flag!='0'){
 	//ajax 提交数据
	$.ajax({
		url:'/index.php/content/DiacrisisTool/analyse',
		data:data,
	    dataType:'json',
	    type: 'POST',
	    cache:false,
	    async: false,
	    beforeSend:function()
        {   //触发ajax请求开始时执行
            $('#submitAll').attr('onclick','javascript:void();');//改变提交按钮上的文字并将按钮设置为不可点击
        }, 
        success:function(r)
        {
        	if(r.code == '0' || r.code == '1')
            {   
           	 //显示计算等待页面
	           	  
         	   $(".loading").show();      	   
                //返回结果后，隐藏计算页面
                //跳转到支付页面和结果显示页面
         	   setTimeout(function(){window.location.href='/index.php/Content/DiacrisisTool/DiaResult?id='+r.id;},3000);
             } 
	    }     
	})
	}	
}
   
    
// 	$('#submitAll').click(function(){	
// 		getValue();
// 		flag = test();	
// 		if(flag!='0'){
// 	 	//ajax 提交数据
// 		$.ajax({
// 			url:'/index.php/content/DiacrisisTool/analyse',
// 			data:data,
// 		    dataType:'json',
// 		    type: 'POST',
// 		    cache:false,
// 		    async: false,
// 		    beforeSend:function()
// 	        {   //触发ajax请求开始时执行
// 	            $('#submitAll').attr('onclick','javascript:void();');//改变提交按钮上的文字并将按钮设置为不可点击
// 	        }, 
// 	        success:function(r)
// 	        {
// 	        	if(r.code == '0' || r.code == '1')
// 	            {   
// 	           	 //显示计算等待页面
		           	  
// 	         	   //$(".loading").show();     	   
// 	                //返回结果后，隐藏计算页面
// 	                //跳转到支付页面和结果显示页面
// 	         	   //setTimeout(function(){window.location.href='/index.php/Content/DiacrisisTool/DiaResult?id='+r.id;},3000);
// 	             } 
// 		    }     
// 		})
// 		}
// 	})
		
</script>
</html>
