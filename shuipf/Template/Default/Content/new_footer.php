<div class="footer ubt ubb-d">
        <div class="ftNav ub">
            <a class="<if condition="ACTION_NAME NEQ 'courselist' AND CONTROLLER_NAME NEQ 'User' AND $catid NEQ 8">current</if> ub ub-ver ub-ac ub-pc tx-c4" href="/index.php">
                <em class="gqblogo ub"></em>
                <span class="ub">首页</span>
            </a>
            <!--<a class="ub ub-ver ub-ac ub-pc tx-c4" href="#">
                <em class="gqblogo ub"></em>
                <span class="ub">股权帮</span>
            </a>-->
            <a class="<if condition="CONTROLLER_NAME EQ User">current</if> ub ub-ver ub-ac ub-pc tx-c4" href="/index.php?m=User&amp;a=index">
                <em class="ub iconfont icon-ren"></em>
                <span class="ub">我的</span>
            </a>
            <a class="<if condition="ACTION_NAME EQ 'courselist' AND CONTROLLER_NAME EQ 'Index' ">current</if> ub ub-ver ub-ac ub-pc tx-c4" href="/index.php?m=index&a=courselist">
                <em class="ub iconfont icon-zhishichanquanguanli"></em>
                <span class="ub">课程列表</span>
            </a>
        </div>
    </div>