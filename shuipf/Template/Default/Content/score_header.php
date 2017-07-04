<div class="mySore ub ub-ver tx-cf">
            <div class="ub">
                <div class="tt ub ub-pc">当前积分为：</div>
                <div class="number ub ub-ver ub-f1 ub-ac ub-pc">
                    <em class="nm ub ub-ac ub-pc"><i>{$u.score}</i></em>                    
                </div>
                <div class="rules ub"><span class="ub iconfont icon-icontishiwenhao"></span><a class="ub tx-cf" href="{:getCategory(10,'url')}">积分规则</a></div>
            </div>
            <div class="scr ub ub-pc ub-ac">累计积分为：<i>{$u.total_score}</i></div>
        </div>
        <div class="scoreClass ub ubb ubb-d">
            <div class='tit <if condition="CONTROLLER_NAME EQ 'User' AND ACTION_NAME EQ 'score_ranking'">current</if> ub ub-f1 ub-ac ub-pc'><a class="ub ub-ac ub-pc" href="/index.php?m=User&a=score_ranking">积分排行</a></div>
            
			<div class='tit <if condition="CONTROLLER_NAME EQ 'User' AND ACTION_NAME EQ 'task'">current</if> ub ub-f1 ub-ac ub-pc'><a class="ub ub-ac ub-pc" href="/index.php?m=User&a=task">赚积分</a></div>
           
			<div class='tit <if condition="CONTROLLER_NAME EQ 'User' AND ACTION_NAME EQ 'score_exchange'">current</if> ub ub-f1 ub-ac ub-pc'><a class="ub ub-ac ub-pc" href="/index.php?m=User&a=score_exchange">积分兑换</a></div>
        </div>