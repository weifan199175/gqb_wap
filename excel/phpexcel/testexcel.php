<?php  

function getExcel($arr)
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
	/*$objPHPExcel->getActiveSheet()->setCellValue('A1', '序号');
	$i = 1;
	$arrt = array();
	foreach($title as $k => $v)
	{
		$objPHPExcel->getActiveSheet()->setCellValue((chr($start + $i)) . '1', $v);
		$i++;
	}*/
	
	//插入行
	foreach($arr as $k => $v)
	{
		$i = 0;
		foreach($v as $kt => $vt)
		{
			$objPHPExcel->getActiveSheet()->setCellValueExplicit((chr($start + $i)) . ($k + 1), $arr[$k][$kt], PHPExcel_Cell_DataType::TYPE_STRING);
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
	$filename = 'hehe.xls';
	
	
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