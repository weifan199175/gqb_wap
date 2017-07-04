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
    <title>股权帮个人中心 社员服务-直播路演（表单）</title>
</head>
<body class="um-vp" style="background: #f4f4f4;">

<!-- c -->
<div class="sBox"> 
    <!-- 社员服务 -->
    <div class="ub ub-ver">
        <template file="Content/service_header.php"/>
        
        <!-- 直播路演（表单） -->
        <form action="" method="post" id="applyforms">
        <div class="classBox zxForm bgc">    
              <h5 class="ub ub-ac ub-pc ubt ubb-d tx-c2">直播路演申请</h5>
              <div class="zxfm ub">
                <ul class="ub ub-ver ub-f1">
                    <li class="ub ub-ver">
                        <div class="tt ub">姓名</div>
                        <div class="ub uinput uc-a1">
                            <input type="text" name="truename" value="{$member['truename']}" placeholder="请输入姓名" id="truename" value="{$member['truename']}">
                        </div>
                    </li>
                    <li class="ub ub-ver">
                        <div class="tt ub">电话</div>
                        <div class="ub uinput uc-a1">
                            <input type="text" name="mobile" id="mobile" value="{$member['mobile']}" placeholder="请输入电话或手机号">
                        </div>
                    </li>
                    <li class="ub ub-ver">
                        <div class="tt ub">公司名称</div>
                        <div class="ub uinput uc-a1">
                            <input type="text" name="company" id="company" value="{$member['company']}" placeholder="请输入公司名称">
                        </div>
                    </li>
                    <li class="ub ub-ver">
                        <div class="tt ub">行业</div>
                        <div class="ub uinput uc-a1">
                            <input type="text" name="industry" id="industry" value="{$member['industry']}" placeholder="互联网">
                        </div>
                    </li>
                    <li class="ub ub-ver">
                        <div class="tt ub">路演项目名称</div>
                        <div class="ub uinput uc-a1">
                            <input type="text" name="project_title" id="project_title" value="" placeholder="">
                        </div>
                    </li>
                    <li class="ub ub-ver">
                        <div class="tt ub">路演项目简介</div>
                        <div class="ub uinput uc-a1">
                            <textarea name="description" id="description" cols="30" rows="10"></textarea>
                        </div>
                    </li>                    
                </ul>                
              </div>
              <a class="btn ub ub-fl umar-b2 uinput" onclick="save_data();"><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1 tx-cf" type="button" name="" value="提交"></a>

        </div>
    </form>
        <!-- /直播路演（表单） -->                               
    </div>
    <!-- /社员服务-->   
</div>
<!-- /c -->

<!--弹出层-->
<div class="PopUp uc-a3">
    <div class="PopUp_box ub ub-ver ub">
       <div class="contUp ub" id="t1">
            申请成功！
       </div>
       <a class="btn ub uinn" href="javascript:void(0);">
            <div class="callbtn ub ub-f1 ub-ac ub-pc tx-cf uc-a3 uinn7 bg-red ulev0" id="t2">                
                确定
            </div>
        </a>
    </div>
</div>
<!--/弹出层-->

<!-- jQuery 遮罩层 -->
<div class="fullbg"></div>
<!-- end jQuery 遮罩层 -->

</body>
<script type="text/javascript" src="/statics/default/js/jquery.js"></script>
<script type="text/javascript" src="/statics/default/js/swiper.min.js"></script>
<script src="/statics/default/js/ff.js" type="text/javascript"></script>
<script type="text/javascript">
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true
    });

    function save_data(){
        var truename = $('#truename').val();
        var company = $('#company').val();
        var industry = $('#industry').val();
        var mobile = $('#mobile').val();
        var project_title = $('#project_title').val();
        var description = $('#description').val();
        if(truename==''){
            alert('请输入姓名');
            return false;
        }else if(company==''){
            alert('请输入公司名称');
            return false;
        }else if(industry==''){
            alert('请输入行业');
            return false; 
        }else if(mobile==''){
            alert('请输入电话或手机号 ');
            return false;
        }else if((project_title.length<1) || (project_title.length>50)){
            alert('请输入项目名称 ');
            return false;
        }else if((description.length<1) || (description.length>50)){
            alert('请输入项目描述 ');
            return false;
        }else{
            $.ajax({
                url:"{:U('Liveshowapply/save_apply')}",
                type:'post',
                data:$('#applyforms').serialize(),
                success:function(msg){
                    if(msg==1){
                        $(".PopUp").animate({opacity:"show"},300);
                        $(".fullbg").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"block"});
                        
                        $("#t2").click(function(){
                            window.location.href='/index.php?m=User&a=index';
                        })
                    }else{
                        $("#t1").html("申请失败！");
                        $(".PopUp").animate({opacity:"show"},300);
                        $(".fullbg").css({"width":pageWidth()+"px","height":pageHeight()+"px",display:"block"});
                        
                        $("#t2").click(function(){
                            window.location.href='/index.php?m=User&a=index';
                        })
                    }
                   
                }
            });  
        }
       
    }
</script>
</html>