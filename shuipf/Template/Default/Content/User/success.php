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
    <title>股权帮个人中心 提现明细（成功）</title>
</head>
<body class="um-vp" style="background: #f4f4f4;">
<!-- c -->
<div class="cBox">
    <!-- 提现明细（审核中） -->
    <div class="txBox">
        <div class="txsh ub ub-ver">
            <div class="title ub bgc">
                <a href="/index.php?m=User&a=Present_detail" class="ub ub-ac Left"><em class="iconfont icon-jiantouzuo"></em></a>
                <div class="ub ub-ac ub-pc ub-f1 Mid"><span>提现明细</span></div>                
                <div class="ub zdbt"></div>
            </div>
            <div class="state ub ub-f1 uof">
                <div class="line ub uabs">
                    <div class="le bg-red ub ub-f1"></div>
                    <div class="le bg-red ub ub-f1"></div>
                </div>
                <div class="list ub ub-f1">
                    <div class="ln ub ub-ver ub-ac">
                        <div class="ub red"></div>
                        <div class="jdtt ub tx-red">审核中</div>
                    </div>
                    <div class="ln ub ub-ver ub-ac ub-pc">
                        <div class="ub red"></div>
                        <div class="jdtt ub tx-red">处理中</div>
                    </div>
                    <div class="ln ub ub-ver ub-ac ub-pe">
                        <div class="ub red"></div>
                        <div class="jdtt ub tx-red">成功</div>
                    </div>

                </div>
            </div>
            <div class="stateTips ub bgc">
                <span class="ub ub-ac iconfont icon-jian-copy"></span>恭喜您！您的申请成功啦！
            </div>
            <div class="txList ub ub-ver bgc">
                <div class="title ub tx-c2"><span class="ub tx-red ub-ac iconfont icon-shutiao"></span>提现信息</div>             
                <ul class="txUl ub ub-ver tx-c2">                    
                    <li class="ub ubb ubb ubt ubb-d uinn ub-ac bgc">
                        <div class="tt ub">姓名</div>
                        <div class="con ub ub-f1">
                            <div class="name tx-c8">{$r['truename']}</div>
                        </div>
                    </li>
                    <li class="ub ubb ubb ubb-d uinn ub-ac bgc">
                        <div class="tt ub">账号</div>
                        <div class="con ub ub-f1">
                            <div class="name tx-c8">
                                {$r['account']}
                            </div>
                        </div>
                    </li>
                    <li class="ub ubb ubb ubb-d uinn ub-ac bgc">
                        <div class="tt ub">提现金额</div>
                        <div class="con ub ub-f1">
                            <div class="name tx-c8">
                                {$r['amount']} 元
                            </div>                            
                        </div>
                    </li>
                    <li class="ub ubb ubb ubb-d uinn ub-ac bgc">
                        <div class="tt ub">申请时间</div>
                        <div class="con ub ub-f1">
                            <div class="name tx-c8">
                                {$r[addtime]|substr="###",0,10}
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="txsImg ub ubb ubb-d ub-ac ub-pc uinn5 bgc">
                <img class="ub" src="{$r['voucher']}" alt="">
            </div>            
        </div>         
    </div>
    <!-- /提现明细（审核中） -->
</div>
<!-- /c -->
    <!-- 页脚 -->
    
        <template file="Content/footer.php"/> 
     
    <!-- /页脚 -->
</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">    
</script>
</html>