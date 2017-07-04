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
    <title>股权帮个人中心 我的朋友们</title>
</head>
<body class="um-vp" style="background: #f4f4f4;">
<!-- c -->
<div class="cBox">
    <!-- 我的成员 -->
    <div class="memberBox">
        <div class="member ub ub-ver">
            <div class="title ub">
                <a href="/index.php?m=User&a=index" class="ub ub-ac Left"><em class="iconfont icon-jiantouzuo"></em></a>
                <div class="ub ub-ac ub-pc ub-f1 Mid"><span>我的朋友</span></div>
                <div class="ub uinn5"></div>
            </div>
            <div class="memberList ub ubt ubb-d ub-ver bgc">               
                <ul class="ub ub-ver">
                    <volist name="my_members" id="vo">
                        <li class="ub uinn5 ubb ubb-d">
                            <div class="phto ub ub-ac ub-pc umar-r"><img class="ub" <if condition="$vo['userimg'] eq null">src="/statics/default/images/logo1.png"<else />src="{$vo['userimg']}"</if> alt=""></div>
                            <div class="ub ub-f1 ub-ver">
                                <div class="name ub umar-b">
                                    <div class="nm ub ulev0 ulim uof">{$vo.nickname}</div>
                                    <div class="nmvip ub ub-f1 ub-ac umar-l <if condition="$vo['class_name'] eq '铁杆社员'">c-blu<elseif condition="$vo['class_name'] eq '注册社员'" />c-gy<elseif condition="$vo['class_name'] eq '普通社员'" /></if>"><span class="ub ub-ac iconfont icon-cnlonghubang"></span>{$vo.class_name}</div>
                                </div>
                                <div class="level ub">
                                    <div class="le ub uba ub-ac ub-pc">{$vo.level}</div>
                                    <div class="umb ub ub-ac ub-pe">【<i>{$vo.member_count}</i>名成员】</div>
                                </div>
                            </div>
                            <div class="score ub ub-ver">
                                <div class="nm ub umar-b"><i class="ulev1">{$vo.total_score}</i> <em class="ulev-2">分</em></div>
                                <div class="tip ub ub-ac ulev-1 ub-pc">累计积分</div>
                            </div>
                        </li>
                    </volist>                       
                </ul>
                <a class="btn ub ubt uinput" href="/index.php?m=User&a=invite_members"><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1" type="submit" name="" value="邀请社员"></a>
            </div>            
        </div>         
    </div>
    <!-- /我的成员 -->
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