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
    <title>股权帮个人中心 社员中心</title>
    <style type="text/css">
/* 以下部分用于我的众筹图标  */
@font-face {
  font-family: 'my_zc';  /* project id 242856 */
  src: url('http://at.alicdn.com/t/font_xejts4tf2agojemi.eot');
  src: url('http://at.alicdn.com/t/font_xejts4tf2agojemi.eot?#iefix') format('embedded-opentype'),
  url('http://at.alicdn.com/t/font_xejts4tf2agojemi.woff') format('woff'),
  url('http://at.alicdn.com/t/font_xejts4tf2agojemi.ttf') format('truetype'),
  url('http://at.alicdn.com/t/font_xejts4tf2agojemi.svg#iconfont') format('svg');
}

.my_zc{
    font-family:"my_zc" !important;
    font-size:16px;font-style:normal;
    -webkit-font-smoothing: antialiased;
    -webkit-text-stroke-width: 0.2px;
    -moz-osx-font-smoothing: grayscale;}
</style>
</head>
<body class="um-vp" style="background: #f4f4f4;">
<!-- c -->
<div class="cBox">
    <!-- 社员中心 -->

    <div class="centerBox ub ub-ver cBox">
        <div class="cTop ub ub-ver">
            <div class="topinfor ub uinn">
                <div class="phto ub ub-pc ub-ac"><img <if condition="$res['userimg'] eq ''"> src="/statics/default/images/logo1.png"<else />src="{$res['userimg']}"</if> alt=""></div>
                <div class="info ub ub-ver ub-f1">
                    <div class="nmlv ub">
                        <div class="nm ub ulev0 ulim">{$res['nickname']}</div>
                        <div class=" level ub ub-ac umar-l">
						<if condition="$res['member_class'] eq 3">
							<span class="ub ub-ac iconfont icon-cnlonghubang tx-red">
							</span>
						<elseif condition="$res['member_class'] eq 4" />
							<span class="ub ub-ac iconfont icon-cnlonghubang tx-cog"></span>
						<elseif condition="$res['member_class'] eq 2" />
							<span class="ub ub-ac iconfont icon-cnlonghubang tx-cblu"></span>
						<elseif condition="$res['member_class'] eq 1" />
							<span class="ub ub-ac iconfont icon-cnlonghubang"></span>
						</if>
						<if condition="$res['member_class'] eq 3">
							<span class="tx-red">{$res['class_name']}</span>
							<else />
							{$res['class_name']}
						</if>
						</div>
                    </div>
                    <!--<div class="tips ub">升级到合伙社员，享更多特权</div>-->
                    <div class="topBt ub">
                        <a class="bt ub umar-r uba uc-a1 ub-pc ub-ac" href="/index.php?m=User&a=rushe">我要入社</a>
                        <a class="bt ub umar-r uba uc-a1 ub-pc ub-ac" id="sign" href="/index.php?m=User&a=sign_before">签到</a>
                    </div>
                </div>
                <a class="go-info ub ub-pc ub-ac iconfont icon-jiantou" href="/index.php?m=User&a=information"></a>
            </div>
            <div class="number ub uinn5">
                <ul class="ub ub-f1">
                    <li class="ub ub-f1 ub-ver ubr">
                        <span class="ub ub-pc ub-ac">{$my_members}</span>
                        <em class="ub ub-pc ub-ac">我的成员</em>
                    </li>
                    <li class="ub ub-f1 ub-ver ubr">
                        <span class="ub ub-pc ub-ac">{$res['total_score']}</span>
                        <em class="ub ub-pc ub-ac">累计积分</em>
                    </li>
                    <li class="ub ub-f1 ub-ver">
                        <span class="ub ub-pc ub-ac">{$res['score']}</span>
                        <em class="ub ub-pc ub-ac">剩余积分</em>
                    </li>
                    <!--<li class="ub ub-f1 ub-ver">
                        <span class="ub ub-pc ub-ac">12</span>
                        <em class="ub ub-pc ub-ac">消息</em>
                    </li>-->
                </ul> 
            </div>
        </div>

        <div class="centerList ub">
            <ul class="ub ub-ver ub-f1">
                <li class="ub ubb ubt uinn5">
                    <a class="ub ub-f1 ub-ac" href="/index.php?m=User&a=order">
                        <span class="ub iconfont icon-dingdan color-bl"></span>
                        <div class="tit ub">我的订单</div>
                        <div class="tcon ub ub-f1 ub-pe">查看全部订单</div>
                        <em class="ub iconfont icon-jiantou"></em>
                    </a>
                </li>
                <li class="other ub ubb umarb2 uinn7">
                    <a class="ub ub-ver ub-f1 ub-ac ub-pc" href="/index.php?m=User&a=order&status=0">
                        <span class="ub iconfont icon-qianbao"></span>
                        <em class="ub uinn">待付款</em>
                        <if condition="$count1 neq 0">
                        <i class="ub uba uabs ub-pc ub-ac">{$count1}</i>
                        </if>
                    </a>
                    <a class="ub ub-ver ub-f1 ub-ac ub-pc" href="/index.php?m=User&a=order&status=1">
                        <span class="ub iconfont icon-daiban"></span>
                        <em class="ub uinn">待使用</em>
                        <if condition="$count2 neq 0">
                        <i class="ub uba uabs ub-pc ub-ac">{$count2}</i>
                        </if>
                    </a>
                    <a class="ub ub-ver ub-f1 ub-ac ub-pc" href="/index.php?m=User&a=order&status=2">
                        <span class="ub iconfont icon-iconfontyishiyong"></span>
                        <em class="ub uinn">已使用</em>
                        <if condition="$count3 neq 0">
                        <i class="ub uba uabs ub-pc ub-ac">{$count3}</i>
                        </if>
                    </a>
                </li>
                <li class="ub uinn5">
                    <a class="ub ub-f1 ub-ac" href="/index.php?m=User&a=score_ranking">
                        <span class="ub iconfont icon-jifen color-og"></span>
                        <div class="tit ub">我的积分</div>
                        <div class="tcon ub ub-f1 ub-pe">剩余积分：{$res['score']}</div>
                        <em class="ub iconfont icon-jiantou"></em>
                    </a>
                </li>
				<li class="ub ubb ubt uinn5">
                    <a class="ub ub-f1 ub-ac" href="/index.php?m=User&a=zc">
                        <span class="ub iconfont my_zc ">&#xe60e;</span>
                        <div class="tit ub">我的众筹</div>
                        <div class="tcon ub ub-f1 ub-pe"></div>
                        <em class="ub iconfont icon-jiantou"></em>
                    </a>
                </li>
				<li class="ub ubb ubt uinn5">
                    <a class="ub ub-f1 ub-ac" href="/index.php?m=User&a=zdq">
                        <span class="ub iconfont my_zc ">&#xe6ae;</span>
                        <div class="tit ub">股权诊断器</div>
                        <div class="tcon ub ub-f1 ub-pe"></div>
                        <em class="ub iconfont icon-jiantou"></em>
                    </a>
                </li>
				<li class="ub ubb uinn5">
                    <a class="ub ub-f1 ub-ac" href="/index.php?m=User&a=task">
                        <span class="ub iconfont icon-woderenwu color-bl2"></span>
                        <div class="tit ub">我的任务</div>
                        <div class="tcon ub ub-f1 ub-pe"></div>
                        <em class="ub iconfont icon-jiantou"></em>
                    </a>
                </li>
                <li class="ub ubb uinn5">
                    <a class="ub ub-f1 ub-ac" href="/index.php?m=User&a=purse">
                        <span class="ub iconfont icon-qianbao color-red"></span>
                        <div class="tit ub">我的钱包</div>
                        <div class="tcon ub ub-f1 ub-pe">余额：¥{$res.commission}</div>
                        <em class="ub iconfont icon-jiantou"></em>
                    </a>
                </li>
                <li class="ub ubb uinn5 umarb2">
                    <a class="ub ub-f1 ub-ac" href="/index.php?m=User&a=my_member">
                        <span class="ub iconfont icon-tuandui color-gn"></span>
                        <div class="tit ub">我的朋友们</div>
                        <div class="tcon ub ub-f1 ub-pe">{$my_members}</div>
                        <em class="ub iconfont icon-jiantou"></em>
                    </a>
                </li>  
                <!--<li class="ub ubb ubt uinn5">
                    <a class="ub ub-f1 ub-ac" href="/index.php?m=User&a=apply_agent">
                        <span class="ub iconfont icon-iconbi color-pk"></span>
                        <div class="tit ub">代理申请</div>
                        <div class="tcon ub ub-f1 ub-pe"></div>
                        <em class="ub iconfont icon-jiantou"></em>
                    </a>
                </li>-->
                <li class="ub ubb uinn5">
                    <a class="ub ub-f1 ub-ac" href="/index.php?m=User&a=invite">
                        <span class="ub iconfont icon-erweima color-bl2"></span>
                        <div class="tit ub">邀请二维码</div>
                        <div class="tcon ub ub-f1 ub-pe"></div>
                        <em class="ub iconfont icon-jiantou"></em>
                    </a>
                </li>  
                <li class="ub ubb uinn5">
                    <a class="ub ub-f1 ub-ac" href="/index.php?m=User&a=electronic_ticket">
                        <span class="ub iconfont icon-menpiao color-og2"></span>
                        <div class="tit ub">电子门票</div>
                        <div class="tcon ub ub-f1 ub-pe"></div>
                        <em class="ub iconfont icon-jiantou"></em>
                    </a>
                </li>
                <li class="ub ubt ubb uinn5">
                    <a class="ub ub-f1 ub-ac" href="/index.php?m=User&a=information">
                        <span class="ub iconfont icon-zhanghuguanli color-bl2"></span>
                        <div class="tit ub">账户管理</div>
                        <div class="tcon ub ub-f1 ub-pe"></div>
                        <em class="ub iconfont icon-jiantou"></em>
                    </a>
                </li>  
                <li class="ub ubb uinn5">
                    <a class="ub ub-f1 ub-ac" href="{:U('User/safe_index')}">
                        <span class="ub iconfont icon-anquanzhongxin color-og2"></span>
                        <div class="tit ub">安全中心</div>
                        <div class="tcon ub ub-f1 ub-pe"></div>
                        <em class="ub iconfont icon-jiantou"></em>
                    </a>
                </li>  

               				
            </ul>
        </div>        
    </div>
    <!-- /社员中心 -->
</div>
<!-- /c -->
    <!-- 页脚 -->
    
    <template file="Content/footer.php"/> 
     
    <!-- /页脚 -->

</body>
<script type="text/javascript" src="/statics/default/js/jquery-1.8.3.min.js"></script>

</html>