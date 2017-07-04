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
    <style type="text/css">
		    .ub-f1 a{
		    color: #FFFFFF;
		    padding-left: 15px;
		    display: inline-block;
		    height: 20px;
			}
			.rankList .level .ub-pec-blu{
                    color:#ffd64a;
                }
            .rankList .level .ub-petx-red{
            		color:#e60012;
            }
    </style>
    <title>股权帮个人中心 我的-积分排名</title>
</head>
<body class="um-vp" style="background:#f4f4f4;">
<!-- c --> 
<div class="cBox" style="background:#f4f4f4;">
    <!-- 积分排名 -->
    <div class="ub ub-ver mySoreBox">       
        
        <template file="Content/score_header.php" />

        <div class="Ranking ub uinn5 bg-red tx-cf">
            <div class="ub ub-ac ub-f1">我的总积分：<i>{$u.total_score}</i> 分
            	<a href="{:U('User/score_detail')}">积分明细</a>
            </div>
            <div class="ub ub-ac ub-pe">排名：<if condition="$u.paiming elt 200">{$u.paiming}<else/>200+</if></div>
        </div> 
        <div class="rankList">
            <div class="hidden">
                <volist name="data" id="vo" key="k">
                    <li class="ub ubb ubb-d">
                        <div class="rk <if condition="$k gt 4">rk4<else />rk{$k}</if> ub ub-pc tx-cf">{$k}</div>
                        <div class="phto ub ub-ac ub-pc umar-r"><img class="ub" <if condition="$vo['userimg'] eq null"> src="/statics/default/images/logo1.png"<else />src="{$vo['userimg']}" </if> alt=""></div>
                        <div class="ub ub-f1 ub-ver">
                            <div class="name ub umar-b">
                                <div class="nm ub ulev0 ulim uof"><if condition="$vo['truename'] eq ''">{$vo.nickname}<else />{$vo.truename}</if></div>
                                <!-- <div class="nmvip ub ub-f1 ub-ac <if condition="$vo['class_name'] eq '创始社员'">umar-l c-og<elseif condition="$vo['class_name'] eq '注册社员'" />tx-c2<elseif condition="$vo['class_name'] eq '铁杆社员'" />c-blu</if>"><span class="ub ub-ac iconfont icon-cnlonghubang"></span>{$vo.class_name}</div> -->
                            </div>
                            <div class="level ub">
                            <?php
                                //下线成员
                                //一级成员
                                $my_members1=M('distribution')->where('p_parent_id='.$vo['id'])->count('distinct parent_id');
                                $my_members2=M('distribution')->where('p_parent_id='.$vo['id'])->count('member_id');
                                //二级成员
                                $my_members3=M('distribution')->where('parent_id='.$vo['id'])->count('member_id');
                                //var_dump($my_members1);
                                $my_members=$my_members1+$my_members2+$my_members3;
                                //var_dump($my_members);
                            ?>
                                <div class="umb ub ub-ac ub-pe<if condition="$vo['class_name'] eq '创始社员'">tx-red<elseif condition="$vo['class_name'] eq '注册社员'" />tx-c2<elseif condition="$vo['class_name'] eq '铁杆社员'" />c-blu</if>"><span class="ub ub-ac iconfont icon-cnlonghubang"></span>{$vo.class_name}
                                
                                        <!-- <i>{$my_members}</i>名成员 -->
                                </div>
                            </div>
                        </div>
                        <!-- <div class="score ub ub-ver">
                            <div class="nm ub umar-b"><i class="ulev1">{$vo.total_score}</i> <em class="ulev-2">分</em></div>
                            <div class="tip ub ub-ac ulev-1 ub-pc">累计积分</div>
                        </div> -->
                    </li>
                </volist>
            </div>    
            <ul class="ub ub-ver bgc clearfix lists"></ul>
           <li class="tt ub ub-ac ub-pc tx-c8">
                    日排行
                </li>
                <div class="line" style="background-color: #FFFFFF">
                    <volist name="ddata" id="vo" key="k">
                    <li class="ub ubb ubb-d">
                        <div class="rk <if condition="$k gt 4">rk4<else />rk{$k}</if> ub ub-pc tx-cf">{$k}</div>
                       <div class="phto ub ub-ac ub-pc umar-r"><img class="ub" <if condition="$vo['userimg'] eq null"> src="/statics/default/images/logo1.png"<else />src="{$vo['userimg']}" </if> alt=""></div>
                        <div class="ub ub-f1 ub-ver">
                            <div class="name ub umar-b">
                                <div class="nm ub ulev0 ulim uof"><if condition="$vo['truename'] eq ''">{$vo.nickname}<else />{$vo.truename}</if></div>
                                 <!-- <div class="nmvip ub ub-f1 ub-ac <if condition="$vo['class_name'] eq '创始社员'">umar-l c-og<elseif condition="$vo['class_name'] eq '注册社员'" />tx-c2<elseif condition="$vo['class_name'] eq '铁杆社员'" />c-blu</if>"><span class="ub ub-ac iconfont icon-cnlonghubang"></span>{$vo.class_name}</div> -->
                            </div>
                            <div class="level ub">
                            <?php
                                //下线成员
                                //一级成员
                                $my_members1=M('distribution')->where('p_parent_id='.$vo['id'])->count('distinct parent_id');
                                $my_members2=M('distribution')->where('p_parent_id='.$vo['id'])->count('member_id');
                                //二级成员
                                $my_members3=M('distribution')->where('parent_id='.$vo['id'])->count('member_id');
                                //var_dump($my_members1);
                                $my_members=$my_members1+$my_members2+$my_members3;
                                //var_dump($my_members);
                            ?>
                                <!-- <div class="umb ub ub-ac ub-pe">
                                        <i>{$my_members}</i>名成员
                                </div> -->
                                <div class="umb ub ub-ac ub-pe<if condition="$vo['class_name'] eq '创始社员'">tx-red<elseif condition="$vo['class_name'] eq '注册社员'" />tx-c2<elseif condition="$vo['class_name'] eq '铁杆社员'" />c-blu</if>"><span class="ub ub-ac iconfont icon-cnlonghubang"></span>{$vo.class_name}
                                </div>
                            </div>
                        </div>
                        <!-- <div class="score ub ub-ver">
                            <div class="nm ub umar-b"><i class="ulev1">{$vo.total_score}</i> <em class="ulev-2">分</em></div>
                            <div class="tip ub ub-ac ulev-1 ub-pc">今日积分</div>
                        </div> -->
                    </li>
                    
                </volist>
                </div>
            <li class="tt ub ub-ac ub-pc tx-c8">
                    周排行
                </li>
                <div class="lin1" style="background-color: #FFFFFF">
                <volist name="wdata" id="vo" key="k">
                    <li class="ub ubb ubb-d">
                        <div class="rk <if condition="$k gt 4">rk4<else />rk{$k}</if> ub ub-pc tx-cf">{$k}</div>
                        <div class="phto ub ub-ac ub-pc umar-r"><img class="ub" <if condition="$vo['userimg'] eq null"> src="/statics/default/images/logo1.png"<else />src="{$vo['userimg']}" </if> alt=""></div>
                        <div class="ub ub-f1 ub-ver">
                            <div class="name ub umar-b">
                                <div class="nm ub ulev0 ulim uof"><if condition="$vo['truename'] eq ''">{$vo.nickname}<else />{$vo.truename}</if></div>
                                <!-- <div class="nmvip ub ub-f1 ub-ac <if condition="$vo['class_name'] eq '创始社员'">umar-l c-og<elseif condition="$vo['class_name'] eq '注册社员'" />tx-c2<elseif condition="$vo['class_name'] eq '铁杆社员'" />c-blu</if>"><span class="ub ub-ac iconfont icon-cnlonghubang"></span>{$vo.class_name}</div>-->
                            </div>
                            <div class="level ub">
                            <?php
                                //下线成员
                                //一级成员
                                $my_members1=M('distribution')->where('p_parent_id='.$vo['id'])->count('distinct parent_id');
                                $my_members2=M('distribution')->where('p_parent_id='.$vo['id'])->count('member_id');
                                //二级成员
                                $my_members3=M('distribution')->where('parent_id='.$vo['id'])->count('member_id');
                                //var_dump($my_members1);
                                $my_members=$my_members1+$my_members2+$my_members3;
                                //var_dump($my_members);
                            ?>
                                <!-- <div class="umb ub ub-ac ub-pe">
                                        <i>{$my_members}</i>名成员
                                </div> -->
                                <div class="umb ub ub-ac ub-pe<if condition="$vo['class_name'] eq '创始社员'">tx-red<elseif condition="$vo['class_name'] eq '注册社员'" />tx-c2<elseif condition="$vo['class_name'] eq '铁杆社员'" />c-blu</if>"><span class="ub ub-ac iconfont icon-cnlonghubang"></span>{$vo.class_name}
                                </div>
                            </div>
                        </div>
                        <!-- <div class="score ub ub-ver">
                            <div class="nm ub umar-b"><i class="ulev1">{$vo.total_score}</i> <em class="ulev-2">分</em></div>
                            <div class="tip ub ub-ac ulev-1 ub-pc">本周积分</div>
                        </div> -->
                    </li>
                </volist>
                </div>
                <li class="tt ub ub-ac ub-pc tx-c8">
                    月排行
                </li>
                <div class="line" style="background-color: #FFFFFF">
                <volist name="mdata" id="vo" key="k">
                    <li class="ub ubb ubb-d">
                        <div class="rk <if condition="$k gt 4">rk4<else />rk{$k}</if> ub ub-pc tx-cf">{$k}</div>
                        <div class="phto ub ub-ac ub-pc umar-r"><img class="ub" <if condition="$vo['userimg'] eq null"> src="/statics/default/images/logo1.png"<else />src="{$vo['userimg']}" </if> alt=""></div>
                        <div class="ub ub-f1 ub-ver">
                            <div class="name ub umar-b">
                                <div class="nm ub ulev0 ulim uof"><if condition="$vo['truename'] eq ''">{$vo.nickname}<else />{$vo.truename}</if></div>
                                <!-- <div class="nmvip ub ub-f1 ub-ac <if condition="$vo['class_name'] eq '创始社员'">umar-l c-og<elseif condition="$vo['class_name'] eq '注册社员'" />tx-c2<elseif condition="$vo['class_name'] eq '铁杆社员'" />c-blu</if>"><span class="ub ub-ac iconfont icon-cnlonghubang"></span>{$vo.class_name}</div>-->
                            </div>
                            <div class="level ub">
                            <?php
                                //下线成员
                                //一级成员
                                $my_members1=M('distribution')->where('p_parent_id='.$vo['id'])->count('distinct parent_id');
                                $my_members2=M('distribution')->where('p_parent_id='.$vo['id'])->count('member_id');
                                //二级成员
                                $my_members3=M('distribution')->where('parent_id='.$vo['id'])->count('member_id');
                                //var_dump($my_members1);
                                $my_members=$my_members1+$my_members2+$my_members3;
                                //var_dump($my_members);
                            ?>
                            <div class="umb ub ub-ac ub-pe<if condition="$vo['class_name'] eq '创始社员'">tx-red<elseif condition="$vo['class_name'] eq '注册社员'" />tx-c2<elseif condition="$vo['class_name'] eq '铁杆社员'" />c-blu</if>"><span class="ub ub-ac iconfont icon-cnlonghubang"></span>{$vo.class_name}
                                </div>
                                <!-- <div class="umb ub ub-ac ub-pe">
                                        <i>{$my_members}</i>名成员
                                </div> -->
                            </div>
                        </div>
                        <!-- <div class="score ub ub-ver">
                            <div class="nm ub umar-b"><i class="ulev1">{$vo.total_score}</i> <em class="ulev-2">分</em></div>
                            <div class="tip ub ub-ac ulev-1 ub-pc">本月积分</div>
                        </div> -->
                    </li>
                    
                </volist>
                </div>
<!-- 			<if condition="(count($data)) elt 5"> -->
<!-- 					<li class="checkMore ub ub-ac ub-pc uinn ulev-1 tx-c8 more" href="javascript:;">全部加载完毕...</li> -->
<!-- 			<else/>
				<a class="checkMore ub ub-ac ub-pc uinn ulev-1 tx-c8 more" href="javascript:;" onClick="content_new.loadMore();">点击查看更多>></a>
			</if> -->
        </div>
<!--         <a class="btn ub ubt uinput" href="/index.php?m=User&a=rushe"><input class="ub-f1 ub-ac ub-pc ulev-3 uc-a1" type="submit" name="" value="申请加入"></a>               -->
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
    //点击加载更多
    var _content = []; //临时存储li循环内容
    var content_new = {
      _default:5, //默认显示个数
      _loading:5,  //每次点击按钮后加载的个数
      init:function(){
        var lis = $(".rankList .hidden li");
        $(".rankList ul.lists").html("");
        for(var n=0;n<content_new._default;n++){
          lis.eq(n).appendTo(".rankList ul.lists");
        }
        
        for(var i=content_new._default;i<lis.length;i++){
          _content.push(lis.eq(i));
        }
        $(".rankList .hidden").html("");
      },
      loadMore:function(){
        var mLis = $(".rankList ul.lists li").length;
        for(var i =0;i<content_new._loading;i++){
          var target = _content.shift();
          if(!target){
            $('.rankList .more').html("<p>全部加载完毕...</p>");
            break;
          }
          $(".rankList ul.lists").append(target);
          $(".rankList ul.lists li").eq(mLis+i).each(function(){
            
          });
        }
      }
    }
    content_new.init();   
</script>

</html>