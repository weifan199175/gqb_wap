<?php
// +----------------------------------------------------------------------
// | 李灿传统计图专用控制器
// +----------------------------------------------------------------------
namespace Jbr_Statistics\Controller;

use Common\Controller\AdminBase;
class LicanController extends AdminBase{
		
	public function _initialize(){
	  parent::_initialize ();
	}
	
	/**
	 * 上传日报周报用的图
	 */
	public function index(){
	    if(IS_POST){
	        $file = $_FILES['file'];//得到传输的数据
	        //得到文件名称
	        $name = $file['name'];
	        $type = strtolower(substr($name,strrpos($name,'.')+1)); //得到文件类型，并且都转化成小写
	        $allow_type = array('jpg','jpeg','png'); //定义允许上传的类型
	        //判断文件类型是否被允许上传
	        if(!in_array($type, $allow_type)){
	            //如果不被允许，则直接停止程序运行
	            return ;
	        }
	        //判断是否是通过HTTP POST上传的
	        if(!is_uploaded_file($file['tmp_name'])){
	            //如果不是通过HTTP POST上传的
	            return ;
	        }
	        $upload_path = SITE_PATH."d/upload/"; //上传文件的存放路径
	        //开始移动文件到相应的文件夹
	        
	        if(move_uploaded_file($file['tmp_name'],$upload_path."lican.jpg")){
	            echo "Successfully!";
	        }else{
	            echo "Failed!";
	        }
	    }
	    $this->display();
	    
	}
	
	/**
	 * 上传Excel
	 */
	public function uploadExcel(){
	    require_once("excel/phpexcel/Classes/PHPExcel/IOFactory.php");
	    if(IS_POST){
            $file = $_FILES['file'];//得到传输的数据
            //得到文件名称
            $name = $file['name'];
            //判断是否是通过HTTP POST上传的
            if(!is_uploaded_file($file['tmp_name'])){
                //如果不是通过HTTP POST上传的
                return ;
            }
            $objPHPExcel = \PHPExcel_IOFactory::load($file['tmp_name']);
            $sheet = $objPHPExcel->getSheet(0);
            
            //获取行数与列数,注意列数需要转换
            $highestRowNum = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $highestColumnNum = \PHPExcel_Cell::columnIndexFromString($highestColumn);
            
            //取得字段，这里测试表格中的第一行为数据的字段，因此先取出用来作后面数组的键名
            $filed = array();
            for($i=0; $i<$highestColumnNum;$i++){
                $cellName = \PHPExcel_Cell::stringFromColumnIndex($i).'1';
                $cellVal = $sheet->getCell($cellName)->getValue();//取得列内容
                $filed []= $cellVal;
            }
        
            //开始取出数据并存入数组
            $data = array();
            for($i=2;$i<=$highestRowNum;$i++){//ignore row 1
                $row = array();
                for($j=0; $j<$highestColumnNum;$j++){
                    $cellName = \PHPExcel_Cell::stringFromColumnIndex($j).$i;
                    $cellVal = $sheet->getCell($cellName)->getValue();
                    $row[ $filed[$j] ] = $cellVal;
                }
                $data []= $row;
            }
            
            $rs = M("t_user")->field("mobile")->select();
            foreach ($rs as $k=>$r){
                $mobile_list[]=$r['mobile'];
            }
            
            $sql = "INSERT INTO jbr_t_user (company,mobile,datetime,job,name,source,province,way,is_need,extra) VALUES ";
            foreach ($data as $k=>$d){
                $name = $d['姓名'];
                $mobile = $d['电话'];
                $company = $d['公司名称'];
                $job = $d['职位'];
                $province = $d['省份'];
                $source = $d['渠道'];
                $way = $d['方式'];
                $datetime = strtotime($d['提交时间']);
                $is_need = in_array($d['学员意向'], array("待沟通","高意向","待强化","低意向","无意向"))?$d['学员意向']:"待沟通";
                $extra = $d['备注'];
                if(!empty($mobile) && !in_array($mobile, $mobile_list)){//如果当前新增的手机号不在数据库里，才能新增（避免重复）
                    $sql.=" ('{$company}','{$mobile}','{$datetime}','{$job}','{$name}','{$source}','{$province}','{$way}','{$is_need}','{$extra}'),";
                }
            }
	        $sql = rtrim($sql,",");
	        $Model = M();
	        if($Model->execute($sql)){
	            echo "Successfully!";
	        }else{
	            echo "Failed!";
	        }
         //完成，可以存入数据库了
    }
	}
}