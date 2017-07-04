  <!-- 悬浮按钮，需要时调用 -->
    <!--
   <div class="ftBtFixed ubt ub-d">
       
		<a class="btn ub uinn" href="javascript:void(0);">
            <div class="callbtn ub ub-f1 ub-ac ub-pc tx-cf uc-a3 uinn7 bg-red ulev0">
                <span class="iconfont icon-dianhua"></span>
                电话咨询
            </div>
        </a>
    </div>
	-->
	
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
            <a class="<if condition="CONTROLLER_NAME EQ User">current</if> ub ub-ver ub-ac ub-pc tx-c4" href="/index.php?m=User&a=index">
                <em class="ub iconfont icon-ren"></em>
                <span class="ub">我的</span>
            </a>
			<!-- 帮助中心 -->
            <!-- <a class="<if condition="$catid eq 8">current</if> ub ub-ver ub-ac ub-pc tx-c4" href="{:getCategory(8,'url')}">
                <em class="ub iconfont icon-bangzhuzhongxin"></em>
                <span class="ub">帮助中心</span>
            </a>-->
            <!-- 课程列表 -->
            <a class="<if condition="ACTION_NAME EQ 'courselist' AND CONTROLLER_NAME EQ 'Index' ">current</if> ub ub-ver ub-ac ub-pc tx-c4" href="/index.php?m=index&a=courselist">
                <em class="ub iconfont icon-zhishichanquanguanli"></em>
                <span class="ub">课程列表</span>
            </a>
			
        </div> 
    </div>    
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?94281a48e806197dc9aaf24da30269f1";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>