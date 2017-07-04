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
    <title>股权帮个人中心 发票信息</title>
</head>
<body class="um-vp" style="background: #f4f4f4;">
<!-- c -->
<div class="cBox"> 
    <!-- 发票信息 -->
    <form action="" method="post">
        <div class="invioceBox ub ub-ver">
            <div class="invioceList ub ub-ver ubb ubt">
                <div class="list ub ub-f1 ubb ub-ac uinn3">
                    <span class="ub umar-r">公司抬头</span>
                    <div class="con ub ub-f1 uinput"><input class="ulev1" type="text" name="header" id="header" value="" placeholder="请输入公司抬头"></div>
                </div>
                <div class="list ub ub-f1 ubb uinn7">
                    <span class="ub umar-r">发票内容</span>
                    <div class="con ub ub-f1 uinput"><input class="ulev1" name="content" id="content" type="text" value="" placeholder="请输入发票内容"></div>
                </div>
                <div class="list ub ub-f1 uinn7">
                    <span class="ub umar-r">发票金额</span>
                    <div class="con ub ub-f1"><i>{$o.price}</i> <em>元</em></div>
                </div>
            </div>
            <div class="invioceList ub ub-ver ubb ubt">
                <div class="list ub ub-f1 ubb ub-ac uinn3">
                    <span class="ub umar-r">收件人</span>
                    <div class="con ub ub-f1 uinput"><input class="ulev1" type="text" name="addressee" id="addressee" value="{$u['truename']}" placeholder="请输入收件人的姓名"></div>
                </div>
                <div class="list ub ub-f1 ubb ub-ac uinn3">
                    <span class="ub umar-r">联系电话</span>
                    <div class="con ub ub-f1 uinput"><input class="ulev1" type="text" name="tel" id="tel" value="{$u.mobile}" placeholder="请输入联系人的电话"></div>
                </div>
                <div class="list ub ub-f1 ubb ub-ac uinn3">
                    <span class="ub umar-r">所在地区</span>                
                    <div class="con ub ub-f1 uinput"><input class="ulev1" type="text" name="area" id="area" value="" placeholder="请输入您所在的地区"></div>
                </div>
                <div class="list ub ub-f1 ub-ac uinn3">
                    <span class="ub umar-r">详细地址</span>
                    <div class="con ub ub-f1 uinput"><input class="ulev1" type="text" name="address" id="address" value="" placeholder="请输入收件地址">
                    <input style="display:none;" type="text" name="order_id" id="order_id" value="{$o.order_id}" >
                    </div>
                </div>            
            </div>
            <!--<div class="introduction ub ub-pe uinn5 ulev0"><a href="#">开票说明</a></div>-->
            <a class="btn ub ub-fl umar-b uinput" href=""><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1" type="submit" id="submit" name="" value="提交"></a>        
        </div>
    </form>
    <!-- /发票信息 -->
</div>
<!-- /c -->
    <!-- 页脚 -->
    
        <template file="Content/footer.php"/> 
     
    <!-- /页脚 -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
    $(function(){
    //提交验证
    $('#submit').click(function(){
        var header = $('#header').val();
        var content=$('#content').val();
        var addressee = $('#addressee').val();
        var tel = $('#tel').val();
        var area = $('#area').val();
        var address = $('#address').val();
        var order_id=$('#order_id').val();
        
        //公司抬头
        if(header==''){
            alert('请输入公司抬头');
            return false;
        }

        //收件人
        if(addressee==''){
            alert('请输入收件人姓名');
            return false;
        }

        //手机号验证
        if(tel==''){
            alert('请输入手机号');
            return false;
        }else if(!checkMobile(tel)){
            alert('请输入正确的手机号');
            return false;
        }
        
        //所在地区
        if(area==''){
            alert('请输所在地区');
            return false;
        }
        
        //详细地址
        if(address==''){
            alert('请输入详细地址');
            return false;
        }
        
        var data = new Object();
        data['header'] = header;
        data['content']=content;
        data['addressee'] = addressee;
        data['tel'] = tel;
        data['area'] = area;
        data['address'] = address;
        data['order_id']=order_id;

        $.post('/index.php?m=User&a=tjinvoice',data , function(r){
            if(r==0){
                alert('提交成功');
                return false;
            }else if(r==1){
                alert('信息提交有误');
                return false;
            }else if(r==2){
                alert('该发票信息已经提交过，请勿重复操作！');
                return false;
            }
        },'json');
        
        
        return false;
    })

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
    
})    
</script>

</html>