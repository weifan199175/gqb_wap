<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<style type="text/css">
	body, html,#allmap {width: 100%;height: 100%;overflow: hidden;margin:0;font-family:"微软雅黑";}
	</style>
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=百度密钥"></script>
	<title>公司地址</title>
</head>
<body>
	<div id="allmap"></div>
</body>
</html>
<script type="text/javascript">
	// 百度地图API功能
	var map = new BMap.Map("allmap");
	var point = new BMap.Point(116.320367,40.041556);
	map.centerAndZoom(point, 18);
	var marker = new BMap.Marker(point);  // 创建标注
	map.addOverlay(marker);               // 将标注添加到地图中
	marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
	var label = new BMap.Label("伯格联合（北京）科技有限公司",{offset:new BMap.Size(20,-10)});
	marker.setLabel(label);
	map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
	map.addEventListener("click",function(e){
		alert(e.point.lng + "," + e.point.lat);
	});
</script>
