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
    <link rel="stylesheet" href="/statics/default/css/center.css">
    <title>股权帮个人中心 我的钱包-余额提现</title>
</head>
<body class="um-vp" style="background: #f4f4f4;">
<!-- c -->
<div class="cBox">
    <!-- 余额提现 -->
    <div class="balanceBox">
        <div class="cash ub ub-ver">
            <div class="title ub">
                <a href="#" class="ub ub-ac Left"><em class="iconfont icon-jiantouzuo"></em></a>
                <div class="ub ub-ac ub-pc ub-f1 Mid"><span>余额提现</span></div>                
                <div class="ub zdbt"><a class="tx-c2" href="/index.php?m=User&a=Present_detail" id="">明细</a></div>
            </div>
            <div class="balanceIng ub ub-ver">
                <div class="tit ub ub-ac ub-pc tx-cf">可提现余额</div>
                <div class="number ub ub-ac ub-pc tx-cf">
                    <em>{$_GET['purse']}</em><i>元</i>
                </div>
            </div>
            <div class="balanceList ub ub-ver">
                <form action="" method="post">               
                    <ul class="zfChose ub ub-ver ub-f1 bgc">
                        <li class="ub ubb ubb-d uinn5">
                            请选择提现方式        
                        </li>
                        <li class="chose ub ub-ver ubb ubb-d">
						  <!--
                            <div class="ub ub-f1 uinn5 ub-ac ubb ubb-d">
                                <div class="ub zfImg"><img src="/statics/default/images/zf1.png" alt=""></div>
                                <div class="con ub ub-ver ub-f1">
                                    <h5 class="ub uof tx-c4">微信支付</h5>
                                    <span class="ub tx-c8">推荐安装微信5.0及以上版本的使用</span>
                                </div>
                                <div class="ub radiobox">
                                    <input type="radio" name="out_way" id="out_way" value="微信支付" />
                                </div>
                            </div>
						  -->	
                            <div class="ub ub-f1 uinn5 ub-ac ubb ubb-d">
                                <div class="ub zfImg"><img src="/statics/default/images/zf2.png" alt=""></div>
                                <div class="con ub ub-ver ub-f1">
                                    <h5 class="ub uof tx-c4">银联支付</h5>
                                    <span class="ub tx-c8">支持工行、建行、农行、招行等银行大额支付</span>
                                </div>
                                <div class="ub radiobox">
                                    <input type="radio" name="out_way" id="out_way" value="银行卡" />
                                </div>
                            </div>
                            <div class="ub ub-f1 uinn5 ub-ac">
                                <div class="ub zfImg"><img src="/statics/default/images/zf3.png" alt=""></div>
                                <div class="con ub ub-ver ub-f1">
                                    <h5 class="ub uof tx-c4">支付宝支付</h5>
                                    <span class="ub tx-c8">推荐有支付宝账号用户使用</span>
                                </div>
                                <div class="ub radiobox">
                                    <input type="radio" name="out_way" id="out_way" value="支付宝" />
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul class="balanceIpt ub ub-ver tx-c2">
                        <li class="tips ub tx-red uinn">
                            <span class="ub iconfont icon-tishi"></span>
                            <em class="ub ub-f1">您所提现金额我们将以线下转账方式转到您选择的账户，请及时查看，谢谢！</em>
                        </li>
                        <li class="ub ubb ubb ubt ubb-d uinn ub-ac bgc">
                            <div class="tt ub">姓名</div>
                            <div class="con ub ub-f1 ub-pe">
                                <div class="name">{$u.truename}</div>
                            </div>
                        </li>
                        <li class="ub ubb ubb ubb-d uinn ub-ac bgc">
                            <div class="tt ub">账号</div>
                            <div class="con ub ub-f1 ub-pe">
                                <div class="name uinput ub-f1">
                                    <input type="text" name="account" id="account" value="" placeholder="请输入您要提现的银行卡（或支付宝）账号">
                                </div>
                            </div>
                        </li>
                        <li class="ub ubb ubb ubb-d uinn ub-ac bgc">
                            <div class="tt ub">提现金额</div>
                            <div class="con ub ub-f1 ub-pe">
                                <div class="name uinput ub-f1">
                                    <input class="" type="text" name="amount" id="amount" value="" placeholder="请输入您要提现的金额 ">
                                </div>
                                <span class="ub umar-l">元</span>
                            </div>
                        </li>
                        <li class="ub ubb ubb ubb-d uinn ub-ac bgc">
                            <div class="tt ub">备注</div>
                            <div class="con ub ub-f1 ub-pe">
                                <div class="name uinput ub-f1">
                                    <input type="text" name="beizhu" id="beizhu" value="" placeholder="请输入您要备注的内容（20字以内）">
                                </div>
                            </div>
                        </li>
                    </ul>
                    <a class="btn ub ub-fl umar-b2 uinput" href=""><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1 tx-cf" type="submit" id="submit" name="" value="确认提交"></a>
                </form>
                <input type="hidden" id="commission" value="{$u.commission}">
            </div>            
        </div>         
    </div>
    <!-- /余额提现 -->
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
        var out_way = $('input:radio[name="out_way"]:checked').val();
        var account = $('#account').val();
        var amount = $('#amount').val();
        var beizhu = $('#beizhu').val();
        var commission = $('#commission').val();

        if(commission<500){
    		alert("可提现金额要大于500才能提现哦~");
            return false;
        }
        
        //提现方式
        if(out_way==null){
            alert('请选择提现方式');
            return false;
        }

        //提现账号
        var regamount = /^(\d{16}|\d{19})$|^[a-zA-Z\d_]{5,}$|^1[34578]{1}\d{9}$/;
        if(account==''){
            alert('请填写提现账号');
            return false;
        }else if(!regamount.test(account)){
            alert('请填写正确的银行卡（微信或支付宝）账号');
            return false;
        }
         var re = /^[0-9]*[1-9][0-9]*$/ ;  
        //提现金额
        if(amount==''){
            alert('请填写提现金额');
            return false;
        }else if(!re.test(amount)){
            alert('请填写正确的金额！');
            return false;
        }
        
        
        var data = new Object();
        data['out_way'] = out_way;
        data['account'] = account;
        data['amount'] = amount;
        data['beizhu'] = beizhu;

        $.post('/index.php?m=User&a=usertixian',data , function(r){
            if(r.code==0){
                alert('提交成功,请您去明细中查看处理结果');
                window.location.href="/index.php?m=User&a=purse";
            }else{
                alert(r.msg);
                return false;
            }
        },'json');
        
        return false;
    })


})
</script>
</html>