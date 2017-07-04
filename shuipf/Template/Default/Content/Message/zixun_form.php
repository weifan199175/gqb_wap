<!DOCTYPE html>
<html class="um landscape min-width-240px min-width-320px min-width-480px min-width-768px min-width-1024px">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="/statics/default/css/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="/statics/default/css/public.css">
    <link rel="stylesheet" href="/statics/default/css/ui-box.css">
    <link rel="stylesheet" href="/statics/default/css/ui-base.css">
    <link rel="stylesheet" href="/statics/default/css/ui-color.css">
    <link rel="stylesheet" href="/statics/default/css/appcan.control.css">
    <link rel="stylesheet" href="/statics/default/css/iconfont/iconfont.css">
    <link rel="stylesheet" href="/statics/default/css/swiper.min.css">
    <link rel="stylesheet" href="/statics/default/css/service.css">
    <title>股权帮个人中心 社员服务-股权咨询（表单）</title>
</head>
<body class="um-vp" style="background: #f4f4f4;">
<!-- c -->
<div class="sBox"> 
    <!-- 社员服务 -->
    <div class="ub ub-ver">
        <!-- title -->
            <template file="Content/service_header.php"/>
        <!-- /title -->
        <?php $user=M('member')->where('id='.$_SESSION['userid'])->find(); ?>
        <!-- 股权咨询（表单） -->
        <div class="classBox zxForm bgc">    
              <h5 class="ub ub-ac ub-pc ubt ubb-d tx-c2">咨询内容</h5>
              <div class="zxfm ub">
                <ul class="ub ub-ver ub-f1">
				<form id="myform">
                    <li class="ub ub-ver">
                        <div class="tt ub">姓名</div>
                        <div class="ub uinput uc-a1">
                            <input type="text" name="name" id="name" value="{$user.truename}" placeholder="{$user.truename}">
                        </div>
                    </li>
                    <li class="ub ub-ver">
                        <div class="tt ub">电话</div>
                        <div class="ub uinput uc-a1">
                            <input type="text" name="mobile" id="mobile" value="{$user.mobile}" placeholder="{$user.mobile}">
                        </div>
                    </li>
                    <li class="ub ub-ver">
                        <div class="tt ub">公司名称</div>
                        <div class="ub uinput uc-a1">
                            <input type="text" name="company" id="company" value="{$user.company}" placeholder="{$user.company}">
                        </div>
                    </li>
                    <li class="ub ub-ver">
                        <div class="tt ub">行业</div>
                        <div class="ub uinput uc-a1">
                            <input type="text" name="industry" id="industry" value="{$user.industry}" placeholder="{$user.industry}">
                        </div>
                    </li>
					
                    <li class="ub ub-ver">
                        <div class="tt ub">内容</div>
                        <div class="ub uinput uc-a1">
                            <textarea name="content" id="content" cols="30" rows="10"></textarea>
                        </div>
                    </li>        
				</form>	
                </ul>                
              </div>
              <a class="btn ub ub-fl umar-b2 uinput" href="javascript:;" onclick="tijiao();"><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1 tx-cf" type="button" name="" value="提交"></a>
              <input type="hidden" value="<?php echo $_GET['zx_id']; ?>" id="zx_id" />
        </div>
        <!-- /股权咨询（表单） -->                               
    </div>
    <!-- /社员服务-->   
</div>
<!-- /c -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery.js"></script>
<script type="text/javascript" src="/statics/default/js/swiper.min.js"></script>
<script type="text/javascript">
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true
    });
</script>

<script type="text/javascript">
    function tijiao(){
        //alert(11);
        var name=$("#name").val();
        var mobile=$("#mobile").val();
        var company=$("#company").val();
        var industry=$("#industry").val();
        var content=$("#content").val();

        if(name==''){
            alert('请输入您的姓名');return false;
        }

        var regtel = /^1[34578]{1}\d{9}$/;
        //手机号验证
        if(mobile==''){
            alert('请输入手机号');
            return false;
        }else if(!regtel.test(mobile)){
            alert('请输入正确的手机号');
            return false;
        }

        if(company==''){
            alert('请输入公司名称');return false;
        }

        if(industry==''){
            alert('请输入行业名称');return false;
        }

        if(content==''){
            alert('请填写您要咨询的内容');return false;
        }
        var zx_id = $("#zx_id").val();
        var data = new Object();
        data['name']=name;
        data['mobile']=mobile;
        data['company']=company;
        data['industry']=industry;
        data['content']=content;
        var url = '/index.php?m=Message&a=addzixun_form';
        $.post(url, data, function (r){
        if(r=='0'){
            alert('申请提交成功！');
			window.location.href="/index.php?a=shows&catid=17&id="+zx_id;
        }else if(r=='2'){
            alert('您已申请该咨询产品，工作人员将在2个工作日内与您取得联系，请耐心等待！');return;
        }else{
			 alert("数据有误！");return;
		}
        
            
           
    },'json');
    return;
    }
</script>
</html>