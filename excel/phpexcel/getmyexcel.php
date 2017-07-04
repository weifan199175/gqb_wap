<?php  
/** 
* PHPExcel 
* 
* Copyright (C) 2006 - 2007 PHPExcel 
* 
* This library is free software; you can redistribute it and/or 
* modify it under the terms of the GNU Lesser General Public 
* License as published by the Free Software Foundation; either 
* version 2.1 of the License, or (at your option) any later version. 
* 
* This library is distributed in the hope that it will be useful, 
* but WITHOUT ANY WARRANTY; without even the implied warranty of 
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU 
* Lesser General Public License for more details. 
* 
* You should have received a copy of the GNU Lesser General Public 
* License along with this library; if not, write to the Free Software 
* Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA 
* 
* @category   PHPExcel 
* @package    PHPExcel 
* @copyright  Copyright (c) 2006 - 2007 PHPExcel ( http://www.codeplex.com/PHPExcel) 
* @license    http://www.gnu.org/licenses/lgpl.txt    LGPL 
* @version    1.5.0, 2007-10-23 
*/  

function getExcel($arr, $title, $number = array())
{
set_time_limit(0);
	date_default_timezone_set("PRC");
	  
	/** Error reporting */  
	error_reporting(E_ALL);  
	  
	/** Include path **/  
	set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');  
	  
	//print_r(dirname(__FILE__));
	  
	/** PHPExcel */  
	require_once dirname(__FILE__) . '/Classes/PHPExcel.php';  
	  
	/** PHPExcel_Writer_Excel2007 */  
	require_once dirname(__FILE__) . '/Classes/PHPExcel/Writer/Excel5.php';  
	
	// Create new PHPExcel object  
	//echo date('H:i:s') . " Create new PHPExcel object\n";  
	$objPHPExcel = new PHPExcel();  
	
	//$objReader = new PHPExcel_Reader_Excel5;
	//$objPHPExcel = $objReader->load(dirname(__FILE__)."/mytest.xls");
	//$objPHPExcel = $objReader->load(dirname(__FILE__)."/purchase order.xls"); 
	
	// Set properties  
	//echo date('H:i:s') . " Set properties\n";  
	//$objPHPExcel->getProperties()->setCreator("Maarten Balliauw");  
	//$objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");  
	//$objPHPExcel->getProperties()->setTitle("Office 2003 XLS Test Document");  
	//$objPHPExcel->getProperties()->setSubject("Office 2003 XLS Test Document");  
	//$objPHPExcel->getProperties()->setDescription("Test document for Office 2003 XLS, generated using PHP classes.");  
	//$objPHPExcel->getProperties()->setKeywords("office 2003 openxml php");  
	//$objPHPExcel->getProperties()->setCategory("Test result file");  
	
	// Add some data  
	//echo date('H:i:s') . " Add some data\n";  
	$objPHPExcel->setActiveSheetIndex(0);
	$start = 65;	//A列 起始
	
	//$objPHPExcel->getActiveSheet()->insertNewRowBefore(15, $rows - 1);
	//$objPHPExcel->getActiveSheet()->setCellValue('G' . (15 + $rows), '=SUM(G15:G' . (15 + $rows - 1) . ')');

	//插入列
	$objPHPExcel->getActiveSheet()->setCellValue('A1', '序号');
	$i = 1;
	$arrt = array();
	foreach($title as $k => $v)
	{
		$objPHPExcel->getActiveSheet()->setCellValue((chr($start + $i)) . '1', $v);
		$i++;
	}
	
	//插入行
	foreach($arr as $k => $v)
	{
		$objPHPExcel->getActiveSheet()->setCellValue('A' . ($k + 2), $k + 1);	//序号
		$i = 1;
		foreach($title as $kt => $vt)
		{
			if(in_array($kt, $number))
			{
				$objPHPExcel->getActiveSheet()->setCellValue((chr($start + $i)) . ($k + 2), $arr[$k][$kt]);
			}
			else
			{
				$objPHPExcel->getActiveSheet()->setCellValueExplicit((chr($start + $i)) . ($k + 2), $arr[$k][$kt], PHPExcel_Cell_DataType::TYPE_STRING);
			}
			$i++;
		}
	}
	/*$objPHPExcel->getActiveSheet()->mergeCells('B' . (15 + $k) . ':C' . (15 + $k));PHPExcel_Cell_DataType::TYPE_STRING
	$style = $objPHPExcel->getActiveSheet()->getStyle('A' . (15 + $rows - 1));
	$objPHPExcel->getActiveSheet()->duplicateStyle($style ,'A' . (15 + $k));
	$objPHPExcel->getActiveSheet()->setCellValue('A' . (15 + $k), $v['order_detail_pid']);*/
	
	// Rename sheet  
	//echo date('H:i:s') . " Rename sheet\n";  
	//$objPHPExcel->getActiveSheet()->setTitle('Simple');  
	
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
	$objPHPExcel->setActiveSheetIndex(0);  
	// Save Excel 2003 file  
	//echo date('H:i:s') . " Write to Excel2003 format\n";  
	$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	//$objWriter->save(str_replace('.php', '.xlsx', __FILE__)); 
	$filename = time() . rand() . '.xls';
	
	
	/*echo "<br/>".__FILE__;
	echo "<br/>".dirname(__FILE__);
	echo "<br/>".dirname(__FILE__) . "./output/";
	echo "<br/>".realpath(dirname(__FILE__) . "./output/");
	echo "<br/>".realpath(dirname(__FILE__) . "./output/") . DIRECTORY_SEPARATOR . $filename;
	*/
	
	$objWriter->save(realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . $filename);  
	
	  
	// Echo done  
	//echo date('H:i:s') . " Done writing file.\r\n";  
	
	return realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . $filename;
}


/*************************
	获取统计报表
*************************/
function getCountExcel($json, $title, $ProductClassNum)
{
set_time_limit(0);
	date_default_timezone_set("PRC");
	  
	error_reporting(E_ALL);
	 
	set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');  
	  
	require_once dirname(__FILE__) . '/Classes/PHPExcel.php';  
	 
	require_once dirname(__FILE__) . '/Classes/PHPExcel/Writer/Excel5.php';  
	  
	$objPHPExcel = new PHPExcel();
	
	$arr = json_decode($json, true);	//arr{'成交' => list, ...}
	$i = 0;
	//print_r($arr);exit;
	
	foreach($arr as $sTitle => $sheet)
	{
		if(0 != $i)
		{
			$objPHPExcel->createSheet();
		}
		$objPHPExcel->setActiveSheetIndex($i);
		$objPHPExcel->getActiveSheet()->setTitle($sTitle);
		$s = 1;
		foreach($arr[$sTitle]['list'] as $k => $v)
		{
			setContent($objPHPExcel, $s, $arr[$sTitle]['list'][$k], $title, $k);
			$s += 3;
		}
		$arr[$sTitle]['param'][] = $s;
		$arr[$sTitle]['param'][] = $objPHPExcel;
		call_user_func_array($arr[$sTitle]['func'], $arr[$sTitle]['param']);
		$i++;
	}
	$objPHPExcel->setActiveSheetIndex(0);

	$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	
	$filename = $ProductClassNum . iconv('UTF-8', 'GBK', "场次统计表") . '.xls';
	
	$objWriter->save(realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . $filename);    
	
	return realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . $filename;
}

/*************************
	获取时段统计报表
*************************/
function getTimeCountExcel($filename, $json, $title)
{
set_time_limit(0);
	date_default_timezone_set("PRC");
	  
	error_reporting(E_ALL);
	 
	set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');  
	  
	require_once dirname(__FILE__) . '/Classes/PHPExcel.php';  
	 
	require_once dirname(__FILE__) . '/Classes/PHPExcel/Writer/Excel5.php';  
	
	$objReader = new PHPExcel_Reader_Excel5;
	$objPHPExcel = $objReader->load($filename);
	
	//$objPHPExcel = new PHPExcel();
	
	$arr = json_decode($json, true);	//arr{'成交' => list, ...}
	$i = 1;
	//print_r($arr);exit;
	
	/*foreach($arr as $sTitle => $sheet)
	{
		if(0 != $i)
		{
			$objPHPExcel->createSheet();
		}
		$objPHPExcel->setActiveSheetIndex($i);
		$objPHPExcel->getActiveSheet()->setTitle($sTitle);
		$s = 1;
		foreach($arr[$sTitle]['list'] as $k => $v)
		{
			setContent($objPHPExcel, $s, $arr[$sTitle]['list'][$k], $title, $k);
			$s += 3;
		}
		$arr[$sTitle]['param'][] = $s;
		$arr[$sTitle]['param'][] = $objPHPExcel;
		call_user_func_array($arr[$sTitle]['func'], $arr[$sTitle]['param']);
		$i++;
	}*/
	$objPHPExcel->createSheet();
	$objPHPExcel->setActiveSheetIndex(1);
	$objPHPExcel->getActiveSheet()->setTitle('统计结果');
	
	$s = 1;
	setContent($objPHPExcel, $s, $arr['统计结果']['list'][0], $title, '该搜索条件下委托人销售|佣金统计');
	$s += 3;
	
	$arr['统计结果']['param'][] = $s;
	$arr['统计结果']['param'][] = $objPHPExcel;
	call_user_func_array($arr['统计结果']['func'], $arr['统计结果']['param']);
	
	$objPHPExcel->setActiveSheetIndex(0);

	$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	
	$filename = time() . rand() . '.xls';
	
	$objWriter->save(realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . $filename);    
	
	return realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . $filename;
}

/******************************
	设置某张表格的内容
******************************/
function setContent($objPHPExcel, &$s, $arr, $title, $header)
{
	$testReader = new PHPExcel_Reader_Excel5;
	$testPHPExcel = $testReader->load(dirname(__FILE__) . "/test.xls");

	if(empty($arr))
	{
		//print_r($arr);exit;
		return;
	}
	$start = 65;	//A列 起始
	//$s = 1;	//行起始

	$styleThinBlackBorderOutline = array(
       'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,   //设置border样式
                'color' => array('argb' => 'FF000000')          //设置border颜色
            )
		)
	);
	
	//插入列
	$objPHPExcel->getActiveSheet()->setCellValue('A' . ($s + 1), '序号');
	$objPHPExcel->getActiveSheet()->getStyle('A' . ($s + 1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A' . ($s + 1))->getFill()->getStartColor()->setARGB('FF92D050');
	
	$i = 1;
	$arrt = array();
	foreach($title as $k => $v)
	{
		if(array_key_exists($k, $arr[0]))
		{
			$objPHPExcel->getActiveSheet()->setCellValue((chr($start + $i)) . ($s + 1), $v);
			$objPHPExcel->getActiveSheet()->getStyle((chr($start + $i)) . ($s + 1))->applyFromArray($styleThinBlackBorderOutline);
			
			$objPHPExcel->getActiveSheet()->getStyle((chr($start + $i)) . ($s + 1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$objPHPExcel->getActiveSheet()->getStyle((chr($start + $i)) . ($s + 1))->getFill()->getStartColor()->setARGB('FF92D050');
			$i++;
		}
	}
	
	/************ 标题 ***********/
	$objPHPExcel->getActiveSheet()->mergeCells('A' . $s . ':' . (chr($start + $i - 1)) . $s);
	
	//边框
	$objPHPExcel->getActiveSheet()->getStyle('A' . $s . ':' . (chr($start + $i - 1)) . $s)->applyFromArray($styleThinBlackBorderOutline);
	
	//填充
	$objPHPExcel->getActiveSheet()->getStyle('A' . $s . ':' . (chr($start + $i - 1)) . $s)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A' . $s . ':' . (chr($start + $i - 1)) . $s)->getFill()->getStartColor()->setARGB('10106F10');
	
	//字体 居中
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $s, $header);
	$objStyleA1 = $objPHPExcel->getActiveSheet()->getStyle('A' . $s);
	$objStyleA1->getFont()->setSize(16);
	$objStyleA1->getFont()->setBold(true);
	$objStyleA1->getFont()->getColor()->setARGB('FFFFFFFF');
    $objAlignA1 = $objStyleA1->getAlignment();
	$objAlignA1->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    //左右居中  
    $objAlignA1->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);  //上下居中 
	
	//插入行
	for($i = 0; $i < count($arr); $i++, $s++)
	{
		$objPHPExcel->getActiveSheet()->setCellValue('A' . ($s + 2), $i + 1);	//序号
		$objPHPExcel->getActiveSheet()->getStyle('A' . ($s + 2), $i + 1)->applyFromArray($styleThinBlackBorderOutline);
		
		$j = 1;
		foreach($title as $kt => $vt)
		{
			//if(in_array($kt, $number))
			//{
			//	$objPHPExcel->getActiveSheet()->setCellValue((chr($start + $i)) . ($k + $s + 2), $arr[$k][$kt]);
			//}
			//else
			//{
			if(array_key_exists($kt, $arr[0]))
			{
				if('StartPrice' == $kt || 'TransactionPrice' == $kt || 'S' == $kt || 'CS' == $kt || 'Commission' == $kt || 'Ext1' == $kt)
				{
					$testStyle = $testPHPExcel->getActiveSheet()->getStyle('A1');
					$objPHPExcel->getActiveSheet()->duplicateStyle($testStyle, (chr($start + $j)) . ($s + 2));
					$objPHPExcel->getActiveSheet()->setCellValue((chr($start + $j)) . ($s + 2), $arr[$i][$kt]);
				}
				else if('R' == $kt)
				{
					$testStyle1 = $testPHPExcel->getActiveSheet()->getStyle('B1');
					$objPHPExcel->getActiveSheet()->duplicateStyle($testStyle1, (chr($start + $j)) . ($s + 2));
					$objPHPExcel->getActiveSheet()->setCellValue((chr($start + $j)) . ($s + 2), $arr[$i][$kt]);
				}
				else
				{
					$objPHPExcel->getActiveSheet()->setCellValue((chr($start + $j)) . ($s + 2), $arr[$i][$kt]);
				}
				$objPHPExcel->getActiveSheet()->getStyle((chr($start + $j)) . ($s + 2))->applyFromArray($styleThinBlackBorderOutline);
				$j++;
			}
			//}
		}
	}
}



/******************************************************/
/******************************************************/
/******************************************************/
/******************************************************/
/******************************************************/



function countf1($param1, $param2, $s, $objPHPExcel)
{
	$testReader = new PHPExcel_Reader_Excel5;
	$testPHPExcel = $testReader->load(dirname(__FILE__) . "/test.xls");
	$testStyle1 = $testPHPExcel->getActiveSheet()->getStyle('B1');

	$styleThinBlackBorderOutline = array(
       'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,   //设置border样式
                'color' => array('argb' => 'FF000000')          //设置border颜色
            )
		)
	);

	//合并单元格
	$objPHPExcel->getActiveSheet()->mergeCells('A' . $s . ':C' . $s);
	
	//边框
	$objPHPExcel->getActiveSheet()->getStyle('A' . $s . ':C' . $s)->applyFromArray($styleThinBlackBorderOutline);
	
	//填充
	$objPHPExcel->getActiveSheet()->getStyle('A' . $s . ':C' . $s)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A' . $s . ':C' . $s)->getFill()->getStartColor()->setARGB('10106F10');
	
	//字体 居中
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $s, '汇总统计');
	$objStyleA1 = $objPHPExcel->getActiveSheet()->getStyle('A' . $s);
	$objStyleA1->getFont()->setSize(16);
	$objStyleA1->getFont()->setBold(true);
	$objStyleA1->getFont()->getColor()->setARGB('FFFFFFFF');
    $objAlignA1 = $objStyleA1->getAlignment();
	$objAlignA1->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    //左右居中  
    $objAlignA1->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);  //上下居中*/
	
	$objPHPExcel->getActiveSheet()->setCellValue('B' . ++$s, '数量');
	$objPHPExcel->getActiveSheet()->getStyle('B' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $s, '比例');
	$objPHPExcel->getActiveSheet()->getStyle('C' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->getStyle('A' . $s . ':C' . $s)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A' . $s . ':C' . $s)->getFill()->getStartColor()->setARGB('FF92D050');
	
	$objPHPExcel->getActiveSheet()->setCellValue('A' . ++$s, '成交拍品');
	$objPHPExcel->getActiveSheet()->getStyle('A' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $s, $param1);
	$objPHPExcel->getActiveSheet()->getStyle('B' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $s, $param1 / ($param1 + $param2));
	$objPHPExcel->getActiveSheet()->getStyle('C' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->duplicateStyle($testStyle1, 'C' . $s++);
	
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $s, '流拍拍品');
	$objPHPExcel->getActiveSheet()->getStyle('A' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $s, $param2);
	$objPHPExcel->getActiveSheet()->getStyle('B' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $s, $param2 / ($param1 + $param2));
	$objPHPExcel->getActiveSheet()->getStyle('C' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->duplicateStyle($testStyle1, 'C' . $s++);
}

function countf2($param1, $param2, $param3, $s, $objPHPExcel)
{
	$testReader = new PHPExcel_Reader_Excel5;
	$testPHPExcel = $testReader->load(dirname(__FILE__) . "/test.xls");
	$testStyle = $testPHPExcel->getActiveSheet()->getStyle('A1');
	
	$styleThinBlackBorderOutline = array(
       'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,   //设置border样式
                'color' => array('argb' => 'FF000000')          //设置border颜色
            )
		)
	);

	//合并单元格
	$objPHPExcel->getActiveSheet()->mergeCells('A' . $s . ':D' . $s);
	
	//边框
	$objPHPExcel->getActiveSheet()->getStyle('A' . $s . ':D' . $s)->applyFromArray($styleThinBlackBorderOutline);
	
	//填充
	$objPHPExcel->getActiveSheet()->getStyle('A' . $s . ':D' . $s)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A' . $s . ':D' . $s)->getFill()->getStartColor()->setARGB('10106F10');
	
	//字体 居中
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $s, '汇总统计');
	$objStyleA1 = $objPHPExcel->getActiveSheet()->getStyle('A' . $s);
	$objStyleA1->getFont()->setSize(16);
	$objStyleA1->getFont()->setBold(true);
	$objStyleA1->getFont()->getColor()->setARGB('FFFFFFFF');
    $objAlignA1 = $objStyleA1->getAlignment();
	$objAlignA1->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    //左右居中  
    $objAlignA1->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);  //上下居中*/
	
	$objPHPExcel->getActiveSheet()->setCellValue('B' . ++$s, '数量');
	$objPHPExcel->getActiveSheet()->getStyle('B' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $s, '总成交价');
	$objPHPExcel->getActiveSheet()->getStyle('C' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $s, '平均成交价');
	$objPHPExcel->getActiveSheet()->getStyle('D' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->getStyle('A' . $s . ':D' . $s)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A' . $s . ':D' . $s)->getFill()->getStartColor()->setARGB('FF92D050');
	
	if('' != $param1 && 0 != $param1)
	{
		$objPHPExcel->getActiveSheet()->setCellValue('A' . ++$s, '一万以下拍品');
		$objPHPExcel->getActiveSheet()->getStyle('A' . $s)->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $s, $param1);
		$objPHPExcel->getActiveSheet()->getStyle('B' . $s)->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->setCellValue('C' . $s, '=SUM(F3:F' . (2 + $param1) . ')');
		$objPHPExcel->getActiveSheet()->getStyle('C' . $s)->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->duplicateStyle($testStyle, 'C' . $s);
		$objPHPExcel->getActiveSheet()->setCellValue('D' . $s, '=C' . $s . '/B' . $s);
		$objPHPExcel->getActiveSheet()->getStyle('D' . $s)->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->duplicateStyle($testStyle, 'D' . $s++);
	}
	
	if('' != $param2 && 0 != $param2)
	{
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $s, '一到十万拍品');
		$objPHPExcel->getActiveSheet()->getStyle('A' . $s)->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $s, $param2);
		$objPHPExcel->getActiveSheet()->getStyle('B' . $s)->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->setCellValue('C' . $s, '=SUM(F' . ($param1 + 6)  . ':F' . ($param1 + 5 + $param2) . ')');
		$objPHPExcel->getActiveSheet()->getStyle('C' . $s)->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->duplicateStyle($testStyle, 'C' . $s);
		$objPHPExcel->getActiveSheet()->setCellValue('D' . $s, '=C' . $s . '/B' . $s);
		$objPHPExcel->getActiveSheet()->getStyle('D' . $s)->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->duplicateStyle($testStyle, 'D' . $s++);
	}
	
	if('' != $param3 && 0 != $param3)
	{
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $s, '一万以上拍品');
		$objPHPExcel->getActiveSheet()->getStyle('A' . $s)->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $s, $param3);
		$objPHPExcel->getActiveSheet()->getStyle('B' . $s)->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->setCellValue('C' . $s, '=SUM(F' . ($param1 + $param2 + 9) . ':F' . ($param1 + $param2 + 8 + $param3) . ')');
		$objPHPExcel->getActiveSheet()->getStyle('C' . $s)->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->duplicateStyle($testStyle, 'C' . $s);
		$objPHPExcel->getActiveSheet()->setCellValue('D' . $s, '=C' . $s . '/B' . $s);
		$objPHPExcel->getActiveSheet()->getStyle('D' . $s)->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->duplicateStyle($testStyle, 'D' . $s++);
	}
	
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $s, '所有成交拍品');
	$objPHPExcel->getActiveSheet()->getStyle('A' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $s, $param1 + $param2 + $param3);
	$objPHPExcel->getActiveSheet()->getStyle('B' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $s, '=SUM(C' . ($s - 3) . ':C' . ($s - 1) . ')');
	$objPHPExcel->getActiveSheet()->getStyle('C' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->duplicateStyle($testStyle, 'C' . $s);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $s, '=C' . $s . '/B' . $s);
	$objPHPExcel->getActiveSheet()->getStyle('D' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->duplicateStyle($testStyle, 'D' . $s++);
}

function countf3($param1, $param2, $param3, $s, $objPHPExcel)
{
	$testReader = new PHPExcel_Reader_Excel5;
	$testPHPExcel = $testReader->load(dirname(__FILE__) . "/test.xls");
	$testStyle = $testPHPExcel->getActiveSheet()->getStyle('A1');
	
	/*$testReader1 = new PHPExcel_Reader_Excel5;
	$testPHPExcel1 = $testReader1->load(dirname(__FILE__) . "/test.xls");
	$testStyle1 = $testPHPExcel1->getActiveSheet()->getStyle('B1');*/
	
	$styleThinBlackBorderOutline = array(
       'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,   //设置border样式
                'color' => array('argb' => 'FF000000')          //设置border颜色
            )
		)
	);

	//合并单元格
	$objPHPExcel->getActiveSheet()->mergeCells('A' . $s . ':E' . $s);
	
	//边框
	$objPHPExcel->getActiveSheet()->getStyle('A' . $s . ':E' . $s)->applyFromArray($styleThinBlackBorderOutline);
	
	//填充
	$objPHPExcel->getActiveSheet()->getStyle('A' . $s . ':E' . $s)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A' . $s . ':E' . $s)->getFill()->getStartColor()->setARGB('10106F10');
	
	//字体 居中
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $s, '汇总统计');
	$objStyleA1 = $objPHPExcel->getActiveSheet()->getStyle('A' . $s);
	$objStyleA1->getFont()->setSize(16);
	$objStyleA1->getFont()->setBold(true);
	$objStyleA1->getFont()->getColor()->setARGB('FFFFFFFF');
    $objAlignA1 = $objStyleA1->getAlignment();
	$objAlignA1->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);    //左右居中  
    $objAlignA1->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);  //上下居中*/
	
	$objPHPExcel->getActiveSheet()->setCellValue('B' . ++$s, '数量');
	$objPHPExcel->getActiveSheet()->getStyle('B' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $s, '总溢价');
	$objPHPExcel->getActiveSheet()->getStyle('C' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $s, '平均溢价');
	$objPHPExcel->getActiveSheet()->getStyle('D' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->setCellValue('E' . $s, '平均溢价率');
	$objPHPExcel->getActiveSheet()->getStyle('E' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->getStyle('A' . $s . ':E' . $s)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A' . $s . ':E' . $s)->getFill()->getStartColor()->setARGB('FF92D050');
	
	if('' != $param1 && 0 != $param1)
	{
		$objPHPExcel->getActiveSheet()->setCellValue('A' . ++$s, '一万以下拍品');
		$objPHPExcel->getActiveSheet()->getStyle('A' . $s)->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $s, $param1);
		$objPHPExcel->getActiveSheet()->getStyle('B' . $s)->applyFromArray($styleThinBlackBorderOutline);
		$testStyle = $testPHPExcel->getActiveSheet()->getStyle('A1');
		$objPHPExcel->getActiveSheet()->duplicateStyle($testStyle, 'C' . $s);
		$objPHPExcel->getActiveSheet()->setCellValue('C' . $s, '=SUM(F3:F' . (2 + $param1) . ')-SUM(E3:E' . (2 + $param1) . ')');
		$objPHPExcel->getActiveSheet()->getStyle('C' . $s)->applyFromArray($styleThinBlackBorderOutline);
		$testStyle = $testPHPExcel->getActiveSheet()->getStyle('A1');
		$objPHPExcel->getActiveSheet()->duplicateStyle($testStyle, 'D' . $s);
		$objPHPExcel->getActiveSheet()->setCellValue('D' . $s, '=C' . $s . '/B' . $s);
		$objPHPExcel->getActiveSheet()->getStyle('D' . $s)->applyFromArray($styleThinBlackBorderOutline);
		$testStyle1 = $testPHPExcel->getActiveSheet()->getStyle('B1');
		$objPHPExcel->getActiveSheet()->duplicateStyle($testStyle1, 'E' . $s);
		$objPHPExcel->getActiveSheet()->setCellValue('E' . $s, '=AVERAGE(G3:G' . (2 + $param1) . ')');
		$objPHPExcel->getActiveSheet()->getStyle('E' . $s++)->applyFromArray($styleThinBlackBorderOutline);
	}
	
	if('' != $param2 && 0 != $param2)
	{
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $s, '一到十万拍品');
		$objPHPExcel->getActiveSheet()->getStyle('A' . $s)->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $s, $param2);
		$objPHPExcel->getActiveSheet()->getStyle('B' . $s)->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->setCellValue('C' . $s, '=SUM(F' . ($param1 + 6) . ':F' . ($param1 + 5 + $param2) . ')-SUM(E' . ($param1 + 6) . ':E' . ($param1 + 5 + $param2) . ')');
		$objPHPExcel->getActiveSheet()->getStyle('C' . $s)->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->duplicateStyle($testPHPExcel->getActiveSheet()->getStyle('A1'), 'C' . $s);
		$objPHPExcel->getActiveSheet()->setCellValue('D' . $s, '=C' . $s . '/B' . $s);
		$objPHPExcel->getActiveSheet()->getStyle('D' . $s)->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->duplicateStyle($testPHPExcel->getActiveSheet()->getStyle('A1'), 'D' . $s);
		$objPHPExcel->getActiveSheet()->setCellValue('E' . $s, '=AVERAGE(G' . ($param1 + 6) . ':G' . ($param1 + 5 + $param2) . ')');
		$objPHPExcel->getActiveSheet()->duplicateStyle($testPHPExcel->getActiveSheet()->getStyle('B1'), 'E' . $s);
		$objPHPExcel->getActiveSheet()->getStyle('E' . $s++)->applyFromArray($styleThinBlackBorderOutline);
	}
	
	if('' != $param3 && 0 != $param3)
	{
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $s, '一万以上拍品');
		$objPHPExcel->getActiveSheet()->getStyle('A' . $s)->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $s, $param3);
		$objPHPExcel->getActiveSheet()->getStyle('B' . $s)->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->setCellValue('C' . $s, '=SUM(F' . ($param1 + 9) . ':F' . ($param1 + $param2 + 8 + $param3) . ')-SUM(E' . ($param1 + 9) . ':E' . ($param1 + $param2 + 8 + $param3) . ')');
		$objPHPExcel->getActiveSheet()->getStyle('C' . $s)->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->duplicateStyle($testPHPExcel->getActiveSheet()->getStyle('A1'), 'C' . $s);
		$objPHPExcel->getActiveSheet()->setCellValue('D' . $s, '=C' . $s . '/B' . $s);
		$objPHPExcel->getActiveSheet()->getStyle('D' . $s)->applyFromArray($styleThinBlackBorderOutline);
		$objPHPExcel->getActiveSheet()->duplicateStyle($testPHPExcel->getActiveSheet()->getStyle('A1'), 'D' . $s);
		$objPHPExcel->getActiveSheet()->setCellValue('E' . $s, '=AVERAGE(G' . ($param1 + $param2+ 9) . ':G' . ($param1 + $param2 + 8 + $param3) . ')');
		$objPHPExcel->getActiveSheet()->duplicateStyle($testPHPExcel->getActiveSheet()->getStyle('B1'), 'E' . $s);
		$objPHPExcel->getActiveSheet()->getStyle('E' . $s++)->applyFromArray($styleThinBlackBorderOutline);
	}
	
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $s, '所有成交拍品');
	$objPHPExcel->getActiveSheet()->getStyle('A' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $s, $param1 + $param2 + $param3);
	$objPHPExcel->getActiveSheet()->getStyle('B' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $s, '=SUM(C' . ($s - 3) . ':C' . ($s - 1) . ')');
	$objPHPExcel->getActiveSheet()->getStyle('C' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->duplicateStyle($testPHPExcel->getActiveSheet()->getStyle('A1'), 'C' . $s);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $s, '=C' . $s . '/B' . $s);
	$objPHPExcel->getActiveSheet()->getStyle('D' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->duplicateStyle($testPHPExcel->getActiveSheet()->getStyle('A1'), 'D' . $s);
	$objPHPExcel->getActiveSheet()->setCellValue('E' . $s, '=AVERAGE(G3:G' . ($param1 + 2) . ',G' . ($param1 + 6) . ':G' . ($param1 + $param2 + 5) . ',G' . ($param1 + $param2+ 9) . ':G' . ($param1 + $param2 + 8 + $param3) . ')');
	$objPHPExcel->getActiveSheet()->duplicateStyle($testPHPExcel->getActiveSheet()->getStyle('B1'), 'E' . $s);
	$objPHPExcel->getActiveSheet()->getStyle('E' . $s++)->applyFromArray($styleThinBlackBorderOutline);
	
}

function countf4($param1, $s, $objPHPExcel)
{
	$styleThinBlackBorderOutline = array(
       'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,   //设置border样式
                'color' => array('argb' => 'FF000000')          //设置border颜色
            )
		)
	);
	
	$objPHPExcel->getActiveSheet()->setCellValue('E' . $s, '总竞价次数');
	$objPHPExcel->getActiveSheet()->getStyle('E' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->setCellValue('F' . $s, '=SUM(F3:F' . ($param1 + 2) . ')');
	$objPHPExcel->getActiveSheet()->getStyle('F' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->setCellValue('E' . ($s + 1), '平均竞价次数');
	$objPHPExcel->getActiveSheet()->getStyle('E' . ($s + 1))->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->setCellValue('F' . ($s + 1), '=AVERAGE(F3:F' . ($param1 + 2) . ')');
	$objPHPExcel->getActiveSheet()->getStyle('F' . ($s + 1))->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->getStyle('E' . $s . ':E' . ($s + 1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('E' . $s . ':E' . ($s + 1))->getFill()->getStartColor()->setARGB('FF92D050');
	
}

function countf5($param1, $s, $objPHPExcel)
{
	$testReader = new PHPExcel_Reader_Excel5;
	$testPHPExcel = $testReader->load(dirname(__FILE__) . "/test.xls");
	$testStyle = $testPHPExcel->getActiveSheet()->getStyle('A1');

	$styleThinBlackBorderOutline = array(
       'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,   //设置border样式
                'color' => array('argb' => 'FF000000')          //设置border颜色
            )
		)
	);
	
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $s, '本场次销售总额');
	$objPHPExcel->getActiveSheet()->getStyle('D' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->duplicateStyle($testPHPExcel->getActiveSheet()->getStyle('A1'), 'E' . $s);
	$objPHPExcel->getActiveSheet()->setCellValue('E' . $s, '=SUM(D3:D' . ($param1 + 2) . ')');
	$objPHPExcel->getActiveSheet()->getStyle('E' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . ($s + 1), '本场次佣金总额');
	$objPHPExcel->getActiveSheet()->getStyle('D' . ($s + 1))->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->duplicateStyle($testPHPExcel->getActiveSheet()->getStyle('A1'), 'E' . ($s + 1));
	$objPHPExcel->getActiveSheet()->setCellValue('E' . ($s + 1), '=SUM(E3:E' . ($param1 + 2) . ')');
	$objPHPExcel->getActiveSheet()->getStyle('E' . ($s + 1))->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->getStyle('D' . $s . ':D' . ($s + 1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('D' . $s . ':D' . ($s + 1))->getFill()->getStartColor()->setARGB('FF92D050');
}

function countf6($param1, $s, $objPHPExcel)
{
	$objPHPExcel->setActiveSheetIndex(1);
	$testReader = new PHPExcel_Reader_Excel5;
	$testPHPExcel = $testReader->load(dirname(__FILE__) . "/test.xls");
	$testStyle = $testPHPExcel->getActiveSheet()->getStyle('A1');

	$styleThinBlackBorderOutline = array(
       'borders' => array(
            'outline' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,   //设置border样式
                'color' => array('argb' => 'FF000000')          //设置border颜色
            )
		)
	);
	
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $s, '该搜索条件下销售总额');
	$objPHPExcel->getActiveSheet()->getStyle('D' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->duplicateStyle($testPHPExcel->getActiveSheet()->getStyle('A1'), 'E' . $s);
	$objPHPExcel->getActiveSheet()->setCellValue('E' . $s, '=SUM(D3:D' . ($param1 + 2) . ')');
	$objPHPExcel->getActiveSheet()->getStyle('E' . $s)->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . ($s + 1), '该搜索条件下佣金总额');
	$objPHPExcel->getActiveSheet()->getStyle('D' . ($s + 1))->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->duplicateStyle($testPHPExcel->getActiveSheet()->getStyle('A1'), 'E' . ($s + 1));
	$objPHPExcel->getActiveSheet()->setCellValue('E' . ($s + 1), '=SUM(E3:E' . ($param1 + 2) . ')');
	$objPHPExcel->getActiveSheet()->getStyle('E' . ($s + 1))->applyFromArray($styleThinBlackBorderOutline);
	$objPHPExcel->getActiveSheet()->getStyle('D' . $s . ':D' . ($s + 1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('D' . $s . ':D' . ($s + 1))->getFill()->getStartColor()->setARGB('FF92D050');
}