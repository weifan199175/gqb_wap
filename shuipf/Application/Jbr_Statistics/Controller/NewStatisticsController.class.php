<?php 
// +----------------------------------------------------------------------
// | 后台新版统计管理
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014
// +----------------------------------------------------------------------
// | Author: zh  2016-12-5
// +----------------------------------------------------------------------

namespace Jbr_Statistics\Controller;

use Common\Controller\AdminBase;

require_once $_SERVER['DOCUMENT_ROOT']."/weixin/lib/WxPay.Api.php";

class NewStatisticsController extends AdminBase{
    
    /**
     * 新版统计
     */
    public function index(){
        $time_type = I("time_type","yesterday","string");//统计的时间类型
        switch ($time_type) {
            case "today"://今天
                $starttime = date("Y-m-d 00:00:00");
                $endtime = date("Y-m-d 23:59:59");
                $HTMLtitle = "股权帮今天数据统计";
            break;
            case "near7"://最近七天
                $starttime = date("Y-m-d 00:00:00",strtotime('- 7day'));
                $endtime = date("Y-m-d 23:59:59",strtotime('- 1day'));
                $HTMLtitle = "股权帮最近7天数据统计";
            break;
            case "near30"://最近三十天
                $starttime = date("Y-m-d 00:00:00",strtotime('- 30day'));
                $endtime = date("Y-m-d 23:59:59",strtotime('- 1day'));
                $HTMLtitle = "股权帮最近30天数据统计";
            break;
            case "thismonth"://这个月
                $starttime = date("Y-m-01 00:00:00");
                $endtime = date('Y-m-d 23:59:59', strtotime("{$starttime} +1 month -1 day"));
                $HTMLtitle = "股权帮本月数据统计";
           break;
            case "free"://自定义时间
                $starttime = I("starttime","","string")." 00:00:00";
                $endtime = I("endtime","","string")." 23:59:59";
                $HTMLtitle = "股权帮".I("starttime","","string")." 至 ".I("endtime","","string")."数据统计";
                $this->assign("starttime",I("starttime","","string"));
                $this->assign("endtime",I("endtime","","string"));
            break;
            default://昨天
                $starttime = date("Y-m-d 00:00:00",strtotime('- 1day'));
                $endtime = date("Y-m-d 23:59:59",strtotime('- 1day'));
                $HTMLtitle = "股权帮昨日数据统计";
            break;
        }

        $this->assign("time_type",$time_type);
        
        /** 订单数据  —start—*/
        $order['class'] = M("order")->where("product_type=1 AND status=1 AND addtime>='{$starttime}' AND addtime<='{$endtime}'")->count();
        $order['weike'] = M("order")->where("product_type=7 AND status=1 AND addtime>='{$starttime}' AND addtime<='{$endtime}'")->count();
        $order['vip'] = M("order")->where("product_id = 0 AND product_type = 16 AND status=1 AND addtime>='{$starttime}' AND addtime<='{$endtime}'")->count();
        $this->assign("order",$order);
        /** 订单数据  —end—*/
        
        
        /**访问量数据 —start—*/
        $views['pv'] = M("statistics")->where("createtime >= '{$starttime}' AND createtime <= '{$endtime}'")->count("id");//访问次数
        $views['uv'] = M("statistics")->where("createtime >= '{$starttime}' AND createtime <= '{$endtime}'")->count('distinct ip');//访问人数
        $this->assign("views",$views);
        /**访问量数据 —end—*/
        
        /** SEM数据汇总 —start—*/
        $source = M("t_user")->where("source != ''")->group("source")->field("source")->select();
        foreach ($source as $k=>$s){
            $sem[$k]['source'] = $s['source'];
            $sem[$k]['num'] = M("t_user")->where("source = '{$s['source']}' AND datetime>=".strtotime($starttime)." AND datetime<=".strtotime($endtime))->count();
        }
//         $sem = M("t_user")->where("source != '' AND datetime>=".strtotime($starttime)." AND datetime<=".strtotime($endtime))->group("source")->field("count(id) AS num,source")->select();
        $this->assign("sem",$sem);
        /** SEM数据汇总 —end—*/

        /** 微信粉丝数统计 ——start—— */
        $wx = json_decode(phpGet("https://api.weixin.qq.com/cgi-bin/user/get?access_token=".getWxAccessToken()),true);
        //粉丝总数
        $fans['total'] = $wx['total'];
        //关注人数
        $fans['add'] = M("wxeventlog")->where("event = 'subscribe' AND datetime >= '{$starttime}' AND datetime <= '{$endtime}'")->count("distinct openid");
        //取关人数
        $fans['del'] = M("wxeventlog")->where("event = 'unsubscribe' AND datetime >= '{$starttime}' AND datetime <= '{$endtime}'")->count("distinct openid");
        //净新增人数
        $fans['num'] = $fans['add']-$fans['del'];
        //注册人数
        $fans['reg'] = M("member")->where("regtime >= '{$starttime}' AND regtime <= '{$endtime}'")->count("id");
        $this->assign("fans",$fans);
        /** 微信粉丝数统计 ——end—— */
        
        /** 自定义菜单统计  ——start——*/
        $menu = json_decode(phpGet("https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".getWxAccessToken()),true);
        $freemenu=array();
        foreach ($menu['menu']['button'] as $k=>$b){
            $freemenu[$k]['menuName']=$b['name'];//自定义菜单的名字
            if($b['type'] == "view"){//跳转页面
                $where = "event='".strtoupper($b['type'])."' AND eventKey='".$b['url']."' AND datetime >= '{$starttime}' AND datetime <= '{$endtime}'";
            }else {
                $where = "event='".strtoupper($b['type'])."' AND eventKey='".$b['key']."' AND datetime >= '{$starttime}' AND datetime <= '{$endtime}'";
            }
            $freemenu[$k]['clickNum'] = M("wxeventlog")->where($where)->count("id");//自定义菜单被点击次数
            $freemenu[$k]['people'] = M("wxeventlog")->where($where)->count("distinct openid");//自定义菜单被点击人数
        }
        $this->assign("freemenu",$freemenu);
        /** 自定义菜单统计  ——end——*/
                
        /** 股权诊断器统计 ——start—— */
        $dia['num'] = M("dia_tool")->where("datetime >= '".strtotime($starttime)."' AND datetime <= '".strtotime($endtime)."'")->count();
        $dia['reg'] = 0;
        $Model = M();
        $member =$Model->query("SELECT * FROM jbr_member WHERE id in ( SELECT DISTINCT member_id FROM jbr_dia_tool ) AND regtime >='{$starttime}' AND regtime <='{$endtime}'");
        foreach ($member as $k=>$m){
            $datetime = M("dia_tool")->where("member_id=".$m['id'])->order("datetime ASC")->getField("datetime");
            if($datetime < $m['regtime']){
                $dia['reg']++;
            }
        }
        $this->assign("dia",$dia);
        /** 股权诊断器统计 ——end—— */
        
        $this->assign("HTMLtitle",$HTMLtitle);
        
        $this->display();
    }
    
    /**
     * 跳转到上传excel的页面
     */
    public function readyToUploadExcel(){
        $this->display();
    }
    
    /**
     * 上传excel
     */
    public function uploadExcel(){
	    if(IS_POST){
    	    require_once("excel/phpexcel/Classes/PHPExcel/IOFactory.php");
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
            dump($data);exit();
            $sql = "INSERT INTO jbr_student (username,mobile,company,utype,stu_type,source,source_detail,uptime,course,state,inviter,recommend_name,recommend_mobile,course_pay,course_desc,site_pay,site_goods,class_state,memid,oldmobile,kefu,is_need) VALUES ";
            foreach ($data as $k=>$d){
                if(empty($d['姓名']) || empty($d['电话']) ||  empty($d['公司名称'])){
                    continue;
                }
                
                $usename = $d['姓名'];
                $mobile = $d['电话'];
                $company = $d['公司名称'];
                $utype = $d['学员身份'];
                $stu_type = $d['学员类型'];
                $source = $d['来源'];
                $source_detail = $d['具体来源'];
                $uptime = $d['上课时间']." 00:00:00";
                $course = $d['课程名称'];
                $state = $d['备注'];
                $inviter = $d['邀约人'];
                $recommend_name = $d['推荐人姓名'];
                $recommend_mobile = $d['推荐人手机号'];
                $course_pay = $d['课程交费金额'];
                $course_desc = $d['课程交费说明'];
                $site_pay = $d['现场成交金额'];
                $site_goods = $d['现场成交商品'];
                $class_state = $d['到课状态'];
                $memid = M("member")->where("mobile='".$mobile."'")->getField("id");
                if(empty($memid)){
                    $memid="00000000000";
                }
                $oldmobile = "";
                $kefu = "乔帅峰";
                $is_need = "待沟通";
                $sql.=" ('{$usename}','{$mobile}','{$company}','{$utype}','{$stu_type}','{$source}','{$source_detail}','{$uptime}','{$course}','{$state}','{$inviter}','{$recommend_name}','{$recommend_mobile}','{$course_pay}','{$course_desc}','{$site_pay}','{$site_goods}','{$class_state}','{$memid}','{$oldmobile}','{$kefu}','{$is_need}')";
            }
	        $sql = rtrim($sql,",");
	        echo $sql;exit();
	        $Model = M();
	        if($Model->execute($sql)){
	            echo "Successfully!";
	        }else{
	            echo "Failed!";
	        }
         //完成，可以存入数据库了
        }
	}
    /**
     * 上传excel2
     */
//     public function uploadExcel2(){
// 	    if(IS_POST){
//     	    require_once("excel/phpexcel/Classes/PHPExcel/IOFactory.php");
//             $file = $_FILES['file'];//得到传输的数据
//             //得到文件名称
//             $name = $file['name'];
//             //判断是否是通过HTTP POST上传的
//             if(!is_uploaded_file($file['tmp_name'])){
//                 //如果不是通过HTTP POST上传的
//                 return ;
//             }
//             $objPHPExcel = \PHPExcel_IOFactory::load($file['tmp_name']);
//             $sheet = $objPHPExcel->getSheet(0);
            
//             //获取行数与列数,注意列数需要转换
//             $highestRowNum = $sheet->getHighestRow();
//             $highestColumn = $sheet->getHighestColumn();
//             $highestColumnNum = \PHPExcel_Cell::columnIndexFromString($highestColumn);
            
//             //取得字段，这里测试表格中的第一行为数据的字段，因此先取出用来作后面数组的键名
//             $filed = array();
//             for($i=0; $i<$highestColumnNum;$i++){
//                 $cellName = \PHPExcel_Cell::stringFromColumnIndex($i).'1';
//                 $cellVal = $sheet->getCell($cellName)->getValue();//取得列内容
//                 $filed []= $cellVal;
//             }
        
//             //开始取出数据并存入数组
//             $data = array();
//             for($i=2;$i<=$highestRowNum;$i++){//ignore row 1
//                 $row = array();
//                 for($j=0; $j<$highestColumnNum;$j++){
//                     $cellName = \PHPExcel_Cell::stringFromColumnIndex($j).$i;
//                     $cellVal = $sheet->getCell($cellName)->getValue();
//                     $row[ $filed[$j] ] = $cellVal;
//                 }
//                 $data []= $row;
//             }
//             foreach ($data as $k=>$d){
//                 if(empty($d['姓名']) || empty($d['电话']) ||  empty($d['课程名称'])){
//                     continue;
//                 }
                
//                 $log = M("student")->where("username='{$d['姓名']}' AND mobile='".preg_replace('# #', '',$d['电话'])."' AND course='{$d['课程名称']}'")->find();
//                 if(empty($log)){
//                    continue;
//                 }
//                 $params['company']=$d['公司名称'];
//                 $params['stu_type']=($d['已交费']==3800 || $d['已交费']==1900)?"新学员":"老学员";
//                 $params['source']=$d['来源']=="无"?"":$d['来源'];
//                 $params['source_detail']=$d['具体来源']=="无"?"":$d['具体来源'];
//                 $params['inviter']=$d['邀约人'];
//                 $params['course_pay']=$d['已交费'];
//                 $params['site_pay']=$d['现场成交金额'];
//                 $params['site_goods']=$d['现场成交产品'];
//                 $params['class_state']=$d['是否到场']=="是"?"到课":"转库存";
//                 M("student")->where("id=".$log['id'])->save($params);
//             }
// 	            echo "Successfully!";
//          //完成，可以存入数据库了
//         }
// 	}

	/**
	 * 上课学员统计
	 */
	public function class_student(){
	    $courses = M("student")->group("course")->order("uptime DESC")->field("course")->limit(3)->select();
	    foreach ($courses as $k=>$c){
	        $data[$k]['title'] = $c['course'];
	        $data[$k]['old_stu'] = M("student")->where("course='{$c['course']}' AND stu_type='老学员'")->count("id");
	        $data[$k]['new_stu'] = M("student")->where("course='{$c['course']}' AND stu_type='新学员'")->count("id");
	        $data[$k]['zjs'] = M("student")->where("course='{$c['course']}' AND source='转介绍'")->count("id");
	        $data[$k]['source'] = M("student")->where("course='{$c['course']}' AND source='渠道'")->count("id");
	        $data[$k]['none'] = M("student")->where("course='{$c['course']}' AND source='网络自转化'")->count("id");
	    }
	    $this->assign("data",$data);
	    $this->display();
	}
	
	/**
	 * 课程款项统计
	 */
	public function class_money(){
	    $courses = M("student")->where("uptime > '2016-09-24 00:00:00'")->group("course")->order("uptime DESC")->field("course")->limit(20)->select();
	    foreach ($courses as $k=>$c){
	        $data['course'][$k] = $c['course'];
	    }
	    foreach ($data['course'] as $k=>$c){
	        $data['students'][$k] = (int)M("student")->where("course='{$c}' AND class_state='到课'")->count("id");//到场人数统计
	        $data['full_pay_num'][$k] = (int)M("student")->where("course='{$c}' AND course_desc='全款付费'")->count("id");//全款人数统计
	        $data['site_pay'][$k] = (int)M("student")->where("course='{$c}' AND site_pay > 0")->sum("site_pay");//现场成交统计
	    }
	    $this->assign("data",$data);
	    $this->display();
	}
	
	/**
	 * 客服邀约统计
	 */
	public function kefu(){
	    $courses = M("student")->where("course IS NOT NULL")->group("course")->order("uptime DESC")->field("course")->limit(3)->select();//课程列表
//         $inviter = M("student")->where("inviter IS NOT NULL AND course in ('{$courses[0]['course']}','{$courses[1]['course']}','{$courses[2]['course']}')")->field("inviter")->group("inviter")->select();//邀约人列表
	    foreach ($courses as $k=>$c){
	        $inviter = M("student")->where("inviter IS NOT NULL AND course = '{$c['course']}'")->field("inviter")->group("inviter")->select();//邀约人列表
	    
            foreach ($inviter as $y=>$i){
                $kefu[$k][] = $i['inviter'];
            }
	        $data[$k]['course'] = $c['course'];
	        foreach ($inviter as $y=>$i){
	            $data[$k]['pay_vip'][$y]=(int)M("student")->where("course='{$c['course']}' AND inviter='{$i['inviter']}' AND site_goods LIKE '%铁杆%'")->count("id");//成交铁杆
	            $data[$k]['stu_vip'][$y]=(int)M("student")->where("course='{$c['course']}' AND inviter='{$i['inviter']}' AND utype='铁杆社员' AND class_state='到课'")->count("id");//到课铁杆
	            $data[$k]['stu_old'][$y]=(int)M("student")->where("course='{$c['course']}' AND inviter='{$i['inviter']}' AND stu_type='老学员'")->count("id");//老学员
	            $data[$k]['stu_new'][$y]=(int)M("student")->where("course='{$c['course']}' AND inviter='{$i['inviter']}' AND stu_type='新学员'")->count("id");//老学员
	        }
	    }
	    $this->assign("data",$data);
	    $this->assign("kefu",$kefu);
	    $this->display();
	}
}