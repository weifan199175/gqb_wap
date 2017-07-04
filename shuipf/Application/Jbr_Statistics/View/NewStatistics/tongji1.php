<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo $HTMLtitle; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
<style>
.table {
	width: 100%;
	margin-bottom: 20px;
}

.table th, .table td {
	padding: 8px;
	line-height: 20px;
	text-align: left;
	vertical-align: top;
	border-top: 1px solid #dddddd;
}

.table th {
	font-weight: bold;
}

.table thead th {
	vertical-align: bottom;
}

.table caption+thead tr:first-child th, .table caption+thead tr:first-child td,
	.table colgroup+thead tr:first-child th, .table colgroup+thead tr:first-child td,
	.table thead:first-child tr:first-child th, .table thead:first-child tr:first-child td
	{
	border-top: 0;
}

.table tbody+tbody {
	border-top: 2px solid #dddddd;
}

.table .table {
	background-color: #ffffff;
}

.table-condensed th, .table-condensed td {
	padding: 4px 5px;
}

.table-bordered {
	border: 1px solid #dddddd;
	border-collapse: separate;
	;
	;
	;
	;
	;
}

.table-bordered th, .table-bordered td {
	border-left: 1px solid #dddddd;
}

.table-bordered caption+thead tr:first-child th, .table-bordered caption+tbody tr:first-child th,
	.table-bordered caption+tbody tr:first-child td, .table-bordered colgroup+thead tr:first-child th,
	.table-bordered colgroup+tbody tr:first-child th, .table-bordered colgroup+tbody tr:first-child td,
	.table-bordered thead:first-child tr:first-child th, .table-bordered tbody:first-child tr:first-child th,
	.table-bordered tbody:first-child tr:first-child td {
	border-top: 0;
}

.table-bordered thead:first-child tr:first-child &gt ; th:first-child,
	.table-bordered tbody:first-child tr:first-child &gt ; td:first-child {
	-webkit-border-top-left-radius: 4px;
	border-top-left-radius: 4px;
	-moz-border-radius-topleft: 4px;
}

.table-bordered thead:first-child tr:first-child &gt ; th:last-child,
	.table-bordered tbody:first-child tr:first-child &gt ; td:last-child {
	-webkit-border-top-right-radius: 4px;
	border-top-right-radius: 4px;
	-moz-border-radius-topright: 4px;
}

.table-bordered thead:last-child tr:last-child &gt ; th:first-child,
	.table-bordered tbody:last-child tr:last-child &gt ; td:first-child,
	.table-bordered tfoot:last-child tr:last-child &gt ; td:first-child {
	-webkit-border-bottom-left-radius: 4px;
	border-bottom-left-radius: 4px;
	-moz-border-radius-bottomleft: 4px;
}

.table-bordered thead:last-child tr:last-child &gt ; th:last-child,
	.table-bordered tbody:last-child tr:last-child &gt ; td:last-child,
	.table-bordered tfoot:last-child tr:last-child &gt ; td:last-child {
	-webkit-border-bottom-right-radius: 4px;
	border-bottom-right-radius: 4px;
	-moz-border-radius-bottomright: 4px;
}

.table-bordered tfoot+tbody:last-child tr:last-child td:first-child {
	-webkit-border-bottom-left-radius: 0;
	border-bottom-left-radius: 0;
	-moz-border-radius-bottomleft: 0;
}

.table-bordered tfoot+tbody:last-child tr:last-child td:last-child {
	-webkit-border-bottom-right-radius: 0;
	border-bottom-right-radius: 0;
	-moz-border-radius-bottomright: 0;
}

.table-bordered caption+thead tr:first-child th:first-child,
	.table-bordered caption+tbody tr:first-child td:first-child,
	.table-bordered colgroup+thead tr:first-child th:first-child,
	.table-bordered colgroup+tbody tr:first-child td:first-child {
	-webkit-border-top-left-radius: 4px;
	border-top-left-radius: 4px;
	-moz-border-radius-topleft: 4px;
}

.table-bordered caption+thead tr:first-child th:last-child,
	.table-bordered caption+tbody tr:first-child td:last-child,
	.table-bordered colgroup+thead tr:first-child th:last-child,
	.table-bordered colgroup+tbody tr:first-child td:last-child {
	-webkit-border-top-right-radius: 4px;
	border-top-right-radius: 4px;
	-moz-border-radius-topright: 4px;
}

.table-striped tbody &gt ; tr:nth-child(odd) &gt ; td, .table-striped tbody 
	 &gt ; tr:nth-child(odd) &gt ; th {
	background-color: #f9f9f9;
}

.table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
	background-color: #f5f5f5;
}

.table td.span1, .table th.span1 {
	float: none;
	width: 44px;
	margin-left: 0;
}

.table td.span2, .table th.span2 {
	float: none;
	width: 124px;
	margin-left: 0;
}

.table td.span3, .table th.span3 {
	float: none;
	width: 204px;
	margin-left: 0;
}

.table td.span4, .table th.span4 {
	float: none;
	width: 284px;
	margin-left: 0;
}

.table td.span5, .table th.span5 {
	float: none;
	width: 364px;
	margin-left: 0;
}

.table td.span6, .table th.span6 {
	float: none;
	width: 444px;
	margin-left: 0;
}

.table td.span7, .table th.span7 {
	float: none;
	width: 524px;
	margin-left: 0;
}

.table td.span8, .table th.span8 {
	float: none;
	width: 604px;
	margin-left: 0;
}

.table td.span9, .table th.span9 {
	float: none;
	width: 684px;
	margin-left: 0;
}

.table td.span10, .table th.span10 {
	float: none;
	width: 764px;
	margin-left: 0;
}

.table td.span11, .table th.span11 {
	float: none;
	width: 844px;
	margin-left: 0;
}

.table td.span12, .table th.span12 {
	float: none;
	width: 924px;
	margin-left: 0;
}

.table tbody tr.success td {
	background-color: #dff0d8;
}

.table tbody tr.error td {
	background-color: #f2dede;
}

.table tbody tr.warning td {
	background-color: #fcf8e3;
}

.table tbody tr.info td {
	background-color: #d9edf7;
}

.table-hover tbody tr.success:hover td {
	background-color: #d0e9c6;
}

.table-hover tbody tr.error:hover td {
	background-color: #ebcccc;
}

.table-hover tbody tr.warning:hover td {
	background-color: #faf2cc;
}

.table-hover tbody tr.info:hover td {
	background-color: #c4e3f3;
}
.my_user_important td {
	width: 240px !important;
	word-break: break-all !important;
	text-align: left;
}
.table_list td{
	height:auto;
}
h2{
	font-size:20px;
}
strong{
    font-size:16px;
}
.table th, .table td{
	text-align:center;
}
</style>

<body>
<div style="width: 720px; margin: 0 auto;">
	<h2 style="text-align: center;"><?php echo $HTMLtitle; ?></h2>
	
	<table class="table table-bordered table-hover table-condensed table-striped">
		<tbody>
			<tr>
				<td colspan=6><strong>订单数据：</strong></td>
			</tr>
			<tr>
				<td>课程订单数据</td>
				<td><?php echo $order['class']?>（单）</td>
				<td>9.9微课：</td>
				<td><?php echo $order['weike']?>（单）</td>
				<td>铁杆社员订单数</td>
				<td><?php echo $order['vip']?>（单）</td>
			</tr>
		</tbody>
	</table>
	<table class="table table-bordered table-hover table-condensed table-striped">
		<tbody>
			<tr>
				<td colspan="6"><strong>访问量数据：</strong></td>
			</tr>
			<tr>
				<td>访问人数</td>
				<td><?php echo $views['uv']?>（人）</td>
				<td>访问次数</td>
				<td><?php echo $views['pv']?>（次）</td>
			</tr>
		</tbody>
	</table>
	<table class="table table-bordered table-hover table-condensed table-striped">
		<tbody>
			<tr>
				<td colspan="6"><strong>SEM数据汇总:</strong></td>
			</tr>
			<?php if(!empty($sem)){?>
			<tr>
			<?php foreach ($sem as $k=>$s){?>
				<td><?php echo $s['source']==""?"无":$s['source']?></td>
			<?php }?>
			</tr>
			<tr>
			<?php foreach ($sem as $k=>$s){?>
				<td><?php echo $s['num']?>（条）</td>
			<?php }?>
			</tr>
			<?php }else {?>
			    <td>无</td>
			<?php }?>
		</tbody>
	</table>
	<table class="table table-bordered table-hover table-condensed table-striped">
		<tbody>
			<tr>
				<td colspan="6"><strong>微信粉丝数据:</strong></td>
			</tr>
			<tr>
				<td>粉丝总人数</td>
				<td>关注人数</td>
				<td>取关人数</td>
				<td>新增人数</td>
				<td>网站注册人数</td>
			</tr>
			<tr>
				<td><?php echo $fans['total']?>（人）</td>
				<td><?php echo $fans['add']?>（人）</td>
				<td><?php echo $fans['del']?>（人）</td>
				<td><?php echo $fans['num']?>（人）</td>
				<td><?php echo $fans['reg']?>（人）</td>
			</tr>
		</tbody>
	</table>

	<table class="table table-bordered table-hover table-condensed table-striped my_user_important">
		<tbody>
			<tr>
				<td colspan="4"><strong>自定义菜单数据:</strong></td>
			</tr>
			<?php if(!empty($freemenu)){?>
			<tr>
				<td>菜单名称</td>
				<td>点击人数</td>
				<td>点击次数</td>
			</tr>
    			<?php foreach ($freemenu as $k=>$f){?>
    			<tr>
    				<td><?php echo $f['menuName']?></td>
    				<td><?php echo $f['people']?>（人）</td>
    				<td><?php echo $f['clickNum']?>（次）</td>
    			</tr>
    			<?php }?>
			<?php }else {?>
			    <tr><td colspan="4">无</td></tr>
			<?php }?>
		</tbody>
	</table>
	<table class="table table-bordered table-hover table-condensed table-striped">
		<tbody>
			<tr>
				<td colspan="4"><strong>股权诊断器数据:</strong></td>
			</tr>
			<tr>
				<td>诊断项目数</td>
				<td><?php echo $dia['num']?>（个）</td>
				<td>注册人数</td>
				<td><?php echo $dia['reg']?>（人）</td>
			</tr>
		</tbody>
	</table>	
</div>