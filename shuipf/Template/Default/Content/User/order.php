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
    <title>股权帮个人中心 我的订单-全部订单</title>
</head>
<body class="um-vp" style="background:#f4f4f4;">
<!-- c -->
<div class="cBox">
    <!-- 我的订单 --> 
    <div class="ub ub-ver allOrderBox">
        <div class="orderClass ub ubb ubb-d">
            <div class="tit <if condition="$_GET['status'] eq null">current</if> ub ub-f1 uinn5 ub-ac ub-pc"><a href="/index.php?m=User&a=order">全部</a></div>
            <div class="tit <if condition="$_GET['status'] eq '0'">current</if> ub ub-f1 uinn5 ub-ac ub-pc"><a href="/index.php?m=User&a=order&status=0">待支付</a></div>
            <div class="tit <if condition="$_GET['status'] eq '1'">current</if> ub ub-f1 uinn5 ub-ac ub-pc"><a href="/index.php?m=User&a=order&status=1">已支付</a></div>
            <!--<div class="tit ub ub-f1 uinn5 ub-ac ub-pc"><a href="#">待使用</a></div>-->
            <div class="tit <if condition="$_GET['status'] eq '2'">current</if> ub ub-f1 uinn5 ub-ac ub-pc"><a href="/index.php?m=User&a=order&status=2">已使用</a></div>
        </div>  
        <div class="allOrderList">
            <div class="hidden">
                <if condition="$data neq null">
                    <volist name="data" id="vo">
                    
                        <li class="bgc">
                            <div class="title ub ubb ubt ubb-d uinn">
                                    <a class="ub ub-f1 tx-c2" href="">{:getCategory($vo[catid],'catname')}</a>
                               <span class="ub">{$vo.rstatus}</span>
                            </div>
                            <div class="con ub ubb ubb-d uinn">
                                <div class="ub orderImg"><a href="/index.php?m=User&a=orderdetails&id={$vo['id']}"><img src="{$vo.course.thumb}" alt=""></a></div>
                                <div class="rtinfo ub ub-f1 ub-ver uof">
                                    <h5 class="tt ub"><a href="/index.php?m=User&a=orderdetails&id={$vo['id']}">{$vo.course.title}</a></h5>
                                    <div class="price ub">总价：<i>¥<if condition="$vo['price'] neq '0'">{$vo.price}<else />{$vo.score}</if></i></div>
                                        <if condition="$vo[rstatus] eq '待支付'">
                                            <div class="orderbtn ub">
                                                <form action="" method="post">
                                                <if condition="$vo['pay_type'] neq 5"><!-- 如果是众筹订单，则不允许他取消 -->
                                                    <span class="cancle ub ub-ac ub-pc uba ub-c1 uc-a1"><a href="javascript:void(0);" class="quxiao" >取消订单</a></span>
                                            	</if>
                                                    <input type="hidden" name="id" id="id" value="{$vo['id']}" >
                                                </form>
                                                <if condition="$vo['price'] eq $vo['course']['price']">
                                                    <if condition="$vo['pay_type'] neq 5"><!-- 如果是众筹订单，则不允许他从此渠道支付 -->
                                                      <a class="ub ub-ac ub-pc uba ub-c1 uc-a1" href="/index.php/Content/WeixinPay/confirm_order.html?&order_num={$vo.verification_code}">付款</a>
                                                	</if>
                                            	<else />
                                                    <if condition="$vo['pay_type'] neq 5"><!-- 如果是众筹订单，则不允许他从此渠道支付 -->
                                                        <a class="ub ub-ac ub-pc uba ub-c1 uc-a1" href="/index.php/Content/WeixinPay/confirm.html?&order_num={$vo.verification_code}">付款</a>
                                                	</if>
                                            	</if>
                                            </div>
                                            <elseif condition="$vo[rstatus] eq '待使用'" />
                                                <div class="orderbtn ub">
                                                    <a class="ub ub-ac ub-pc uba ub-c1 uc-a1" href="/index.php?m=User&a=orderdetails&id={$vo['id']}">查看详情</a>
                                                </div>
                                            <else/>
                                                <div class="orderbtn ub">
                                                    <a class="ub ub-ac ub-pc uba ub-c1 uc-a1" href="/index.php?m=User&a=orderdetails&id={$vo['id']}">查看详情</a>
                                                </div>
                                        </if>
                                </div>
                            </div>
                        </li>
                    </volist> 
                <else />
                    <li class="ub ub-ac ub-pc uinn" style="text-align:center;color:#999;">没有更多订单信息</li>
                </if>  
            </div>
            <ul class="ub ub-ver bgc clearfix lists"></ul>
            <if condition="$data neq null">
				<if condition="(count($data)) elt 5">
						<li class="checkMore ub ub-ac ub-pc uinn ulev-1 tx-c8 more" href="javascript:;">全部加载完毕...</li>
					<else/>
					<a class="checkMore ub ub-ac ub-pc uinn ulev-1 tx-c8 more " href="javascript:;" onClick="content_new.loadMore();">点击查看更多>></a>
				</if>
            </if>
        </div>              
    </div>
    <!-- /我的订单 -->
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
    $('.quxiao').live('click',function(){
    //alert(11);
        var id=$("#id").val();

        var data = new Object();
        data['id']=id;
        $.post('/index.php?m=User&a=userquxiao',data , function(r){
            if(r==0){
                alert('订单取消成功');
                document.location.reload();
                return false;
            }else if(r==1){
                alert('订单取消失败');
                return false;
            }
        },'json');
        
        return false;
    })
    
})
</script>
<script type="text/javascript">
    //点击加载更多
    var _content = []; //临时存储li循环内容
    var content_new = {
      _default:5, //默认显示个数
      _loading:5,  //每次点击按钮后加载的个数
      init:function(){
        var lis = $(".allOrderList .hidden li");
        $(".allOrderList ul.lists").html("");
        for(var n=0;n<content_new._default;n++){
          lis.eq(n).appendTo(".allOrderList ul.lists");
        }
        
        for(var i=content_new._default;i<lis.length;i++){
          _content.push(lis.eq(i));
        }
        $(".allOrderList .hidden").html("");
      },
      loadMore:function(){
        var mLis = $(".allOrderList ul.lists li").length;
        for(var i =0;i<content_new._loading;i++){
          var target = _content.shift();
          if(!target){
            $('.allOrderList .more').html("<p>全部加载完毕...</p>");
            break;
          }
          $(".allOrderList ul.lists").append(target);
          $(".allOrderList ul.lists li").eq(mLis+i).each(function(){
            
          });
        }
      }
    }
    content_new.init();   
</script>

</html>