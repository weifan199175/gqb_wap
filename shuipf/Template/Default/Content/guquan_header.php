
<content action="category" catid="1"  order="listorder ASC" >
	<div class="learnTit ub ubb ubb-d">
		<volist name="data" id="vo">
	        <div class="tit <if condition='$catid eq "$vo[catid]"'>current</if> ub ub-f1 ub-ac ub-pc"><a class="ub ub-ac ub-pc" href="{$vo.url}">{$vo.catname}</a></div>
	    </volist>
	</div>
</content>