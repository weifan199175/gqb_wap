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
    <title>股权帮个人中心 我的钱包-提现明细</title>
</head>
<body class="um-vp" style="background: #f4f4f4;">
<!-- c -->
<div class="cBox">
    <!-- 提现明细 -->
    <div class="cashBox">
        <div class="cash ub ub-ver">
            <div class="title ub">
                <a href="/index.php?m=User&a=purse" class="ub ub-ac Left"><em class="iconfont icon-jiantouzuo"></em></a>
                <div class="ub ub-ac ub-pc ub-f1 Mid"><span>提现明细</span></div>
                <div class="ub uinn5"></div>
            </div>
            <div class="cashList ub">               
                <table class="cashList ub" width="100%" border="0" cellspacing="0">
                    <tbody class="ub ub-f1 ub-ver">
                        <tr class="tit ub"> 
                            <th class="ub ub-f1 ubr sc-border"><div class="subs ub ub-ac ub-pc uabs">时间</div></th> 
                            <th class="ub ub-f1 ubr sc-border" ><div class="subs ub ub-ac ub-pc uabs">金额</div></th> 
                            <th class="ub ub-f1 ubr sc-border" ><div class="subs ub ub-ac ub-pc uabs">状态</div></th>
                            <th class="ub ub-f1"><div class="subs ub ub-ac ub-pc uabs">操作</div></th>
                        </tr>
                    <volist name="data" id="vo">
                        <tr class="cashCon ub ubb"> 
                            <td class="time ub ub-f1"><div class="subs ub  ub-ac ub-pc uabs">{$vo[addtime]|substr="###",0,10}</div></td> 
                            <td class="money ub ub-f1"><div class="subs ub  ub-ac ub-pc uabs">{$vo.amount}</div></td> 
                            <td class="state ub ub-f1"><div class="subs ub  ub-ac ub-pc uabs <if condition="$vo['rstatus'] eq '待审核'">color-og<elseif condition="$vo['rstatus'] eq '处理中'"/>color-blu<elseif condition="$vo['rstatus'] eq '已拒绝'" />color-red<elseif condition="$vo['rstatus'] eq '提现成功'" />color-grn</if>"><span>{$vo.rstatus}</span></div></td>
                            <td class="check ub ub-f1">
                                <div class="subs ub  ub-ac ub-pc uabs">
                                <if condition="$vo['rstatus'] eq '待审核'">
                                    <a class="ub uba uc-a3" href="/index.php?m=User&a=review&id={$vo.id}">查看详情</a>
                                <elseif condition="$vo['rstatus'] eq '处理中'" />
                                    <a class="ub uba uc-a3" href="/index.php?m=User&a=processing&id={$vo.id}">查看详情</a>
                                <elseif condition="$vo['rstatus'] eq '已拒绝'" />
                                    <a class="ub uba uc-a3" href="/index.php?m=User&a=fail&id={$vo.id}">查看详情</a>
                                <elseif condition="$vo['rstatus'] eq '提现成功'" />
                                    <a class="ub uba uc-a3" href="/index.php?m=User&a=success&id={$vo.id}">查看详情</a>
                                </if>
                                </div>
                            </td> 
                        </tr>
                    </volist>                               
                    </tbody> 
                </table> 
            </div>
            
        </div>         
    </div>
    <!-- /提现明细 -->
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