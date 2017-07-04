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
    <title>股权帮个人中心 我的-积分排名</title>
</head>
<body class="um-vp" style="background:#f4f4f4;">
<!-- c --> 
<div class="cBox" style="background:#f4f4f4;">
    <!-- 积分排名 -->
    <div class="ub ub-ver mySoreBox">       
        
        <template file="Content/score_header.php" />

        <div class="myTowerList">
            <ul class="ub ub-ver">
                <li class="tt ub ub-ac ub-pc tx-c8">
                    日常任务
                </li>
                <li class="lit ub ubb ub-f1 bgc">
                    <div class="tow ub ub-f1 uof ub-ac">
                        <div class="Tt ttTl ub uabs ub-ac">
                            <span class="ub tx-cog2 iconfont icon-dian"></span><em class="ub ub-ac ub-f1">签到</em>
                        </div>
                    </div>
                    <?php
					   $s=M('score_rules')->where('id=2')->find();
                    ?>
                    <if condition="$sign eq null">
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttCon ub uabs ub-ac tx-c8">
                                <span class="iconfont icon-jifen"></span><em>+ {$s.get_score}</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttState ub uabs ub-ac ub-pe">
                                <em class="ub">未完成</em>
                                <a class="ub ub-pe" href="/index.php?m=User&a=sign_before">点击前往</a>
                            </div>
                        </div>
                    <else />
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttCon ub uabs ub-ac tx-cog2">
                                <span class="iconfont icon-jifen"></span><em>+ {$s.get_score}</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttState ub uabs ub-ac ub-pe">
                                <span class="ub tx-cgn iconfont icon-dui"></span><em class="ub">已完成</em>
                            </div>
                        </div>
                    </if>
                </li>
				<?php
					$v=M('score_rules')->where('id=3')->find();
                ?>
                <if condition="empty($video)">
				
                    <li class="lit ub ubb bgc">
                        <div class="tow ub ub-f1 uof ub-ac">
                            <div class="Tt ttTl ub uabs ub-ac">
                                <span class="ub tx-c8 iconfont icon-dian"></span><em class="ub ub-f1">分享视频</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttCon ub uabs ub-ac tx-c8">
                                <span class="iconfont icon-jifen"></span><em>+ {$v.get_score}</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttState ub uabs ub-ac ub-pe">
                                <em class="ub">未完成</em>
                               
                                <if condition="$v['link']">
                                    <a class="ub ub-pe" href="{$v.link}">点击前往</a>
                                <else />
                                    <a class="ub ub-pe" href="{:getCategory(6,'url')}">点击前往</a>
                                </if>
                            </div>
                        </div>
                    </li>
                <else />
                    <li class="lit ub ubb bgc">
                        <div class="tow ub ub-f1 uof ub-ac">
                            <div class="Tt ttTl ub uabs ub-ac">
                                <span class="ub tx-c8 iconfont icon-dian"></span><em class="ub ub-f1">分享视频</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttCon ub uabs ub-ac tx-cog2">
                                <span class="iconfont icon-jifen"></span><em>+ {$v.get_score}</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttState ub uabs ub-ac ub-pe">
                                <span class="ub tx-cgn iconfont icon-dui"></span><em class="ub">已完成</em>
                            </div>
                        </div>
                    </li>
                </if>
                <?php
				   $c = M('score_rules')->where('id=4')->find();
				?>
                <if condition="empty($course)">
                    <li class="lit ub ubb bgc">
                        <div class="tow ub ub-f1 uof ub-ac">
                            <div class="Tt ttTl ub uabs ub-ac">
                                <span class="ub tx-c8 iconfont icon-dian"></span><em class="ub ub-f1">分享课程</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttCon ub uabs ub-ac tx-c8">
                                <span class="iconfont icon-jifen"></span><em>+ {$c.get_score}</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttState ub uabs ub-ac ub-pe">
                                <em class="ub">未完成</em>
                            
                                <if condition="!empty($c['link'])">
                                    <a class="ub ub-pe" href="{$c.link}">点击前往</a>
                                <else />
                                    <a class="ub ub-pe" href="{:getCategory(13,'url')}">点击前往</a>
                                </if>
                            </div>
                        </div>
                    </li>
                <else />
                    <li class="lit ub ubb bgc">
                        <div class="tow ub ub-f1 uof ub-ac">
                            <div class="Tt ttTl ub uabs ub-ac">
                                <span class="ub tx-c8 iconfont icon-dian"></span><em class="ub ub-f1">分享课程</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttCon ub uabs ub-ac tx-cog2">
                                <span class="iconfont icon-jifen"></span><em>+ {$c.get_score}</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttState ub uabs ub-ac ub-pe">
                                <span class="ub tx-cgn iconfont icon-dui"></span><em class="ub">已完成</em>
                            </div>
                        </div>
                    </li>
                </if>
                <?php
					$g = M('score_rules')->where('id=5')->find();
				?>
                <if condition="empty($guandian)">
                    <li class="lit ub ubb bgc">
                        <div class="tow ub ub-f1 uof ub-ac">
                            <div class="Tt ttTl ub uabs ub-ac">
                                <span class="ub tx-c8 iconfont icon-dian"></span><em class="ub ub-f1">分享观点</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttCon ub uabs ub-ac tx-c8">
                                <span class="iconfont icon-jifen"></span><em>+ {$g.get_score}</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttState ub uabs ub-ac ub-pe">
                                <em class="ub">未完成</em>
                               
                                <if condition="$g['link']">
                                    <a class="ub ub-pe" href="{$g.link}">点击前往</a>
                                <else />
                                    <a class="ub ub-pe" href="{:getCategory(2,'url')}">点击前往</a>
                                </if>
                            </div>
                        </div>
                    </li>
                <else />
                    <li class="lit ub ubb bgc">
                        <div class="tow ub ub-f1 uof ub-ac">
                            <div class="Tt ttTl ub uabs ub-ac">
                                <span class="ub tx-c8 iconfont icon-dian"></span><em class="ub ub-f1">分享观点</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttCon ub uabs ub-ac tx-cog2">
                                <span class="iconfont icon-jifen"></span><em>+ {$g.get_score}</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttState ub uabs ub-ac ub-pe">
                                <span class="ub tx-cgn iconfont icon-dui"></span><em class="ub">已完成</em>
                            </div>
                        </div>
                    </li>
                </if>

                <?php
					$f = M('score_rules')->where('id=6')->find();
				?>
                <if condition="empty($guquanbang)">
                    <li class="lit ub ubb bgc">
                        <div class="tow ub ub-f1 uof ub-ac">
                            <div class="Tt ttTl ub uabs ub-ac">
                                <span class="ub tx-c8 iconfont icon-dian"></span><em class="ub ub-f1">分享二维码</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttCon ub uabs ub-ac tx-c8">
                                <span class="iconfont icon-jifen"></span><em>+ {$f.get_score}</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttState ub uabs ub-ac ub-pe">
                                <em class="ub">未完成</em>
                                
                                <if condition="$f['link']">
                                    <a class="ub ub-pe" href="{$f.link}">点击前往</a>
                                <else />
                                    <a class="ub ub-pe" href="/index.php?m=User&a=invite">点击前往</a>
                                </if>
                            </div>
                        </div>
                    </li>
                <else />
                    <li class="lit ub ubb bgc">
                        <div class="tow ub ub-f1 uof ub-ac">
                            <div class="Tt ttTl ub uabs ub-ac">
                                <span class="ub tx-c8 iconfont icon-dian"></span><em class="ub ub-f1">分享二维码</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttCon ub uabs ub-ac tx-cog2">
                                <span class="iconfont icon-jifen"></span><em>+ {$f.get_score}</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttState ub uabs ub-ac ub-pe">
                                <span class="ub tx-cgn iconfont icon-dui"></span><em class="ub">已完成</em>
                            </div>
                        </div>
                    </li>
                </if>
				<li class="lit ub ubb bgc">
                        <div class="tow ub ub-f1 uof ub-ac">
                            <div class="Tt ttTl ub uabs ub-ac">
                                <span class="ub tx-c8 iconfont icon-dian"></span><em class="ub ub-f1">点赞</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttCon ub uabs ub-ac tx-c8">
                                <span class="iconfont icon-jifen"></span><em>+ 2</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttState ub uabs ub-ac ub-pe">
                                <span class="ub tx-cgn iconfont icon-dui"></span><em class="ub">暂未开通</em>
                            </div>
                        </div>
                    </li>
					<li class="lit ub ubb bgc">
                        <div class="tow ub ub-f1 uof ub-ac">
                            <div class="Tt ttTl ub uabs ub-ac">
                                <span class="ub tx-c8 iconfont icon-dian"></span><em class="ub ub-f1">担任课程顾问</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttCon ub uabs ub-ac tx-c8">
                                <span class="iconfont icon-jifen"></span><em>+ 2</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttState ub uabs ub-ac ub-pe">
                                <span class="ub tx-cgn iconfont icon-dui"></span><em class="ub">暂未开通</em>
                            </div>
                        </div>
                    </li>
					<li class="lit ub ubb bgc">
                        <div class="tow ub ub-f1 uof ub-ac">
                            <div class="Tt ttTl ub uabs ub-ac">
                                <span class="ub tx-c8 iconfont icon-dian"></span><em class="ub ub-f1">赞助</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttCon ub uabs ub-ac tx-c8">
                                <span class="iconfont icon-jifen"></span><em>+ 2</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttState ub uabs ub-ac ub-pe">
                                <span class="ub tx-cgn iconfont icon-dui"></span><em class="ub">暂未开通</em>
                            </div>
                        </div>
                    </li>
					<li class="lit ub ubb bgc">
                        <div class="tow ub ub-f1 uof ub-ac">
                            <div class="Tt ttTl ub uabs ub-ac">
                                <span class="ub tx-c8 iconfont icon-dian"></span><em class="ub ub-f1">评论</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttCon ub uabs ub-ac tx-c8">
                                <span class="iconfont icon-jifen"></span><em>+ 2</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttState ub uabs ub-ac ub-pe">
                                <span class="ub tx-cgn iconfont icon-dui"></span><em class="ub">暂未开通</em>
                            </div>
                        </div>
                    </li>
                <li class="tt ub ub-ac ub-pc tx-c8">
                    特殊任务
                </li>
				 <?php
					$z = M('score_rules')->where('id=1')->find();
				?>
                <li class="lit ub ubb ub-f1 bgc">
                    <div class="tow ub ub-f1 uof ub-ac">
                        <div class="Tt ttTl ub uabs ub-ac">
                            <span class="ub tx-cog2 iconfont icon-dian"></span><em class="ub ub-ac ub-f1">成为普通社员</em>
                        </div>
                    </div>
                    <div class="tow ub ub-f1 uof">
                        <div class="Tt ttCon ub uabs ub-ac tx-cog2">
                            <span class="iconfont icon-jifen"></span><em>+ {$z.get_score}</em>
                        </div>
                    </div>
                    <div class="tow ub ub-f1 uof">
                        <div class="Tt ttState ub uabs ub-ac ub-pe">
                            <span class="ub tx-cgn iconfont icon-dui"></span><em class="ub">已完成</em>
                        </div>
                    </div>
                </li>
                <?php
					$w = M('score_rules')->where('id=7')->find();
				?>
                <if condition="$_SESSION['member_class'] eq 1">
                    <li class="lit ub ubb bgc">
                        <div class="tow ub ub-f1 uof ub-ac">
                            <div class="Tt ttTl ub uabs ub-ac">
                                <span class="ub tx-c8 iconfont icon-dian"></span><em class="ub ub-f1">成为注册社员</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttCon ub uabs ub-ac tx-c8">
                                <span class="iconfont icon-jifen"></span><em>+ {$w.get_score}</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttState ub uabs ub-ac ub-pe">
                                <em class="ub">未完成</em>
                                <a class="ub ub-pe" href="/index.php?m=User&a=perfect_information">点击前往</a>
                            </div>
                        </div>
                    </li>
                <else />
                    <li class="lit ub ubb bgc">
                        <div class="tow ub ub-f1 uof ub-ac">
                            <div class="Tt ttTl ub uabs ub-ac">
                                <span class="ub tx-c8 iconfont icon-dian"></span><em class="ub ub-ac ub-f1">成为注册社员</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttCon ub uabs ub-ac tx-cog2">
                                <span class="iconfont icon-jifen"></span><em>+ {$w.get_score}</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttState ub uabs ub-ac ub-pe">
                            <span class="ub tx-cgn iconfont icon-dui"></span><em class="ub">已完成</em>
                        </div>
                        </div>
                    </li>
                </if>    
                 <if condition="$_SESSION['member_class'] neq 4">
                    <li class="lit ub ubb bgc">
                        <div class="tow ub ub-f1 uof ub-ac">
                            <div class="Tt ttTl ub uabs ub-ac">
                                <span class="ub tx-c8 iconfont icon-dian"></span><em class="ub ub-f1">成为铁杆社员</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttCon ub uabs ub-ac tx-c8">
                                <span class="iconfont icon-jifen"></span><em>+ 3000</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttState ub uabs ub-ac ub-pe">
                                <em class="ub">未完成</em>
                                <a class="ub ub-pe" href="/index.php?m=User&a=rushe">点击前往</a>
                            </div>
                        </div>
                    </li>
                <else />
                    <li class="lit ub ubb bgc">
                        <div class="tow ub ub-f1 uof ub-ac">
                            <div class="Tt ttTl ub uabs ub-ac">
                                <span class="ub tx-c8 iconfont icon-dian"></span><em class="ub ub-ac ub-f1">成为铁杆社员</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttCon ub uabs ub-ac tx-cog2">
                                <span class="iconfont icon-jifen"></span><em>+ 3000</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttState ub uabs ub-ac ub-pe">
                            <span class="ub tx-cgn iconfont icon-dui"></span><em class="ub">已完成</em>
                        </div>
                        </div>
                    </li>
                </if>   
                 <li class="lit ub ubb bgc">
                        <div class="tow ub ub-f1 uof ub-ac">
                            <div class="Tt ttTl ub uabs ub-ac">
                                <span class="ub tx-c8 iconfont icon-dian"></span><em class="ub ub-f1">推荐朋友成为普通社员</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttCon ub uabs ub-ac tx-c8">
                                <span class="iconfont icon-jifen"></span><em>+ 10</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttState ub uabs ub-ac ub-pe">
                               
                                <a class="ub ub-pe" href="/index.php?m=User&a=invite">点击前往</a>
                            </div>
                        </div>
                    </li>
                     <li class="lit ub ubb bgc">
                        <div class="tow ub ub-f1 uof ub-ac">
                            <div class="Tt ttTl ub uabs ub-ac">
                                <span class="ub tx-c8 iconfont icon-dian"></span><em class="ub ub-f1">推荐朋友成为注册社员</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttCon ub uabs ub-ac tx-c8">
                                <span class="iconfont icon-jifen"></span><em>+ 50</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttState ub uabs ub-ac ub-pe">
                               
                                <a class="ub ub-pe" href="/index.php?m=User&a=invite">点击前往</a>
                            </div>
                        </div>
                    </li>
                    <li class="lit ub ubb bgc">
                        <div class="tow ub ub-f1 uof ub-ac">
                            <div class="Tt ttTl ub uabs ub-ac">
                                <span class="ub tx-c8 iconfont icon-dian"></span><em class="ub ub-f1">推荐朋友成为铁杆社员</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttCon ub uabs ub-ac tx-c8">
                                <span class="iconfont icon-jifen"></span><em>+ 3000</em>
                            </div>
                        </div>
                        <div class="tow ub ub-f1 uof">
                            <div class="Tt ttState ub uabs ub-ac ub-pe">
                               <!-- <em class="ub">未完成</em>-->
                                <a class="ub ub-pe" href="/index.php?m=User&a=rushe">点击前往</a>
                            </div>
                        </div>
                    </li>					
            </ul>
            <!--<a class="checkMore ub ub-ac ub-pc uinn ulev-1 tx-c8" href="">点击查看更多>></a>-->
        </div>                 
    </div>
    <!-- /积分排名 -->
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