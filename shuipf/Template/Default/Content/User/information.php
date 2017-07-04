<!DOCTYPE html>
<html class="um landscape min-width-240px min-width-320px min-width-480px min-width-768px min-width-1024px">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="/statics/default/css/public.css">
    <link rel="stylesheet" href="/statics/default/css/ui-box.css">
    <link rel="stylesheet" href="/statics/default/css/ui-base.css">
    <link rel="stylesheet" href="/statics/default/css/ui-color.css">
    <link rel="stylesheet" href="/statics/default/css/appcan.control.css">
    <link rel="stylesheet" href="/statics/default/css/iconfont/iconfont.css">
    <link rel="stylesheet" href="/statics/default/css/center.css">
	<script type="text/javascript" src="/statics/default/js/upload.js"></script>
    <title>股权帮个人中心 基本资料</title>
</head>
<body class="um-vp" style="background:#f4f4f4;">
<!-- c -->
<form action="" method="post" >
<div class="cBox">
    <!-- 基本资料 -->
		<div class="ub ub-ver infoBox">        
			<ul class="ub-f1">
				<li class="ub ub-f1 ub-ac ubb uinn7" id="edit_userimg">                
					<a class="ub ub-f1 ub-ac" href="javascript:;">
						<span class="tit ub ulev-1">头像</span>
						<div class="phto ub ub-f1 ub-pe uinn umar-r">
						<if condition="$user['userimg'] eq ''">
							<img id="img" src="/statics/default/images/logo1.png" alt="">
						<else />
							<img id="img" src="{$user.userimg}" alt="">
						</if>
						<input type="hidden" value="{$user.userimg}" id="userimg"  /> 
						</div>              
					</a>
				</li>
				<li class="ub ub-f1 ub-ac ubb uinn6">
					<span class="tit ub ulev-1">姓名</span>
					<div class="infoCon ub ub-f1 ub-pe ulev-1 umar-r0"><input onblur="setCookie('truename',this.value);" class="tx-r" type="text" name="truename" id="truename" value="{$user.truename}" /></div>
					<!-- <em class="ub umar-l iconfont icon-jiantou"></em> -->
				</li>
				<li class="ub ub-f1 ub-ac ubb uinn6">
					<span class="tit ub ulev-1">手机号</span>
					<div class="infoCon ub ub-f1 ub-pe ulev-1 umar-r0">{$user.mobile}</div>      
				</li>
				<li class="ub ub-f1 ub-ac ubb uinn7">
						<span class="tit ub ulev-1">公司</span>
						<div class="infoCon ub ub-f1 ub-pe ulev-1"><input onblur="setCookie('company',this.value);" class="tx-r" type="text" name="company" id="company" value="{$user.company}" /></div>                
				</li>
				<li class="ub ub-f1 ub-ac ubb uinn7">
					<a class="ub ub-f1 ub-ac" href="/index.php?m=User&a=position_choose&back=1">
						<span class="tit ub ulev-1">职位</span>
						<div class="infoCon ub ub-f1 ub-pe ulev-1"><input class="tx-r" type="text" name="position" id="position" readonly="readonly" value="{$user.position}" /></div>
						<em class="ub umar-a ulev-1 iconfont icon-jiantou"></em>
					</a>                 
				</li>
				<li class="ub ub-f1 ub-ac ubb uinn7">
					<a class="ub ub-f1 ub-ac" href="/index.php?m=User&a=industry_choose&back=1">
						<span class="tit ub ulev-1">行业</span>
						<div class="infoCon ub ub-f1 ub-pe ulev-1"><input class="tx-r" type="text" name="industry" id="industry" readonly="readonly" value="{$user.industry}" /></div>
						<em class="ub umar-a ulev-1 iconfont icon-jiantou"></em>
					</a>                 
				</li>
				<li class="ub ub-f1 ub-ac ubb uinn7">
					<a class="ub ub-f1 ub-ac" href="/index.php?m=User&a=area_choose&back=1">
						<span class="tit ub ulev-1">地区</span>
						<div class="infoCon ub ub-f1 ub-pe ulev-1"><input class="tx-r" type="text" name="province_name" id="province_name" value="{$user.province_name}" /><input class="tx-r" type="text" name="city_name" id="city_name" readonly="readonly" value="{$user.city_name}" /></div>
						<em class="ub umar-a ulev-1 iconfont icon-jiantou"></em>
					</a>                 
				</li>
			</ul>
			<!--<a class="btn ub ub-fl umar-b2 uinput" href="javascript:void(0);"><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1" type="submit" id="submit" name="" value="确认"></a>-->      
		</div>
    <!-- /基本资料 -->
</div>
<!-- /c -->
<!-- 页脚 -->
    <div class="ftBtFixed ubt ubb-d">
        <a class="btn ub uinn" href="javascript:void(0);" Onclick="submit();">
            <div class="callbtn ub ub-f1 ub-ac ub-pc tx-cf uc-a3 uinn7 bg-red ulev0">
            	<input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1" type="button" name="" value="修改">
            </div>
        </a>
    </div>
</form>
    <template file="Content/footer.php"/> 
     
    <!-- /页脚 -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
    checkcookie();

	function setCookie(name,value)
	{
		var Days = 30;
		var exp = new Date();
		exp.setTime(exp.getTime() + Days*24*60*60*1000);
		document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
	}
	function getCookie(name)
	{
		var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
		if(arr=document.cookie.match(reg))
		return unescape(arr[2]);
		else
		return null;
	}
	function checkcookie(){
		if(getCookie('userimg') != '' && getCookie('userimg') != undefined){
			$('#userimg').val(getCookie('userimg'));
			$('#img').attr('src',getCookie('userimg'));
		}
		if(getCookie('truename') != '' && getCookie('truename') != undefined){
			$('#truename').val(getCookie('truename'));
		}
		if(getCookie('company') != '' && getCookie('company') != undefined){
			$('#company').val(getCookie('company'));
		}
		if(getCookie('position') != '' && getCookie('position') != undefined){

			$('#position').val(getCookie('position'));
			//console.info(getCookie('position'));
		}
		if(getCookie('industry') != '' && getCookie('industry') != undefined){
			$('#industry').val(getCookie('industry'));
		}
		if(getCookie('province_name') != '' && getCookie('province_name') != undefined){
			$('#province_name').val(getCookie('province_name'));
		}
		if(getCookie('city_name') != '' && getCookie('city_name') != undefined){
			$('#city_name').val(getCookie('city_name'));
		}
	}
	function delCookie(name){  
			        var exp = new Date();  
			        exp.setTime(exp.getTime() - 1);  
			        var cval=getCookie(name);  
			        if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString();  

	}


//提交修改	
function submit()
{
	
	
	var userimg = $('#userimg').val();
	var truename = $('#truename').val();
	var company = $('#company').val();
	var position = $('#position').val();
	var industry = $('#industry').val();
	var province_name = $('#province_name').val();
	var city_name=$('#city_name').val();
	
	//姓名验证
	if(truename==''){
		alert('请输入您的真实姓名');
		return false;
	}
	//公司验证
	if(company==''){
		alert('请输入公司名称');
		return false;
	}
	//职位选择
	if(position==''){
		alert('请选择职位');
		return false;
	}
	
	//行业选择
	if(industry==''){
		alert('请选择行业');
		return false;
	}
	
	//省市选择
	if(province_name==''){
		alert('请选择地区');
		return false;
	}
	
	var data = new Object();
	data['userimg'] = userimg;
	data['truename'] = truename;
	data['company'] = company;
	data['position'] = position;
	data['industry'] = industry;
	data['province_name']=province_name;
	data['city_name']=city_name;

	// $.post('/index.php?m=User&a=userinformation',data , function(r){
	// 	if(r==0){
	// 		alert('资料修改完成');
	// 		delCookie('userimg');
	// 		delCookie('truename');
	// 		delCookie('company');
	// 		delCookie('position');
	// 		delCookie('industry');
	// 		delCookie('province_name');
	// 		delCookie('city_name');
	// 		window.location.href='/index.php?m=User&a=index';
	// 	}else if(r==1){
	// 	   alert('您没有做任何修改,返回社员中心');
	// 	   window.location.href='/index.php?m=User&a=index';
	// 	}
	// },'json');

	$.ajax({
            type:"POST",
            url:"/index.php?m=User&a=userinformation",
            data:data,
            dataType:"json",
            success:function(r){
                if(r==0){
			alert('资料修改完成');
			delCookie('userimg');
			delCookie('truename');
			delCookie('company');
			delCookie('position');
			delCookie('industry');
			delCookie('province_name');
			delCookie('city_name');
			window.location.href='/index.php?m=User&a=index';
		}else if(r==1){
		   alert('您没有做任何修改,返回社员中心');
		   window.location.href='/index.php?m=User&a=index';
		}},
        });
	
	return false;
   
}
	
	



/****  图片上传  by zh  ****/	
   var uploader = new plupload.Uploader({ //实例化一个plupload上传对象
            browse_button : 'edit_userimg',
            multi_selection: false,
            url: '/index.php?m=Message&a=upload',
            file_data_name : 'Filedata'
        });
        uploader.init(); //初始化
        //添加文件判断并上传
        uploader.bind('FilesAdded',function(uploader,files){
            if(files.length>=1) {
                if (files[0].size >(3*1048576)) {
                    alert("你选择的文件超过了3MB,所以没有上传哦");
                } else {
                    uploader.start();
                    /*if (avatar.length >0) {
                        update_list_rx.html('上传中...');
                    }*/ 
                }
            }
        })

        //文件上传完成后返回信息
       uploader.bind('FileUploaded', function(uploader,file,responseObject){
			
			var responseObject = eval('('+responseObject.response+ ')');
			
			if(responseObject.tag){
					$("#img").attr('src', String(responseObject.preview));
                    $("#userimg").val(String(responseObject.save));
					setCookie('userimg',String(responseObject.preview));
				}else{
					alert(responseObject.msg);
				}
            
        })
/****   图片上传  ****/			


</script>

</html>