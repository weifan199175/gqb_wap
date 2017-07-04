<?php
/**
 * 后台地区管理
 * Edit time 2015-02-03
 * Author zh
 */
namespace Admin\Controller;
use Common\Controller\AdminBase;

class AreaController extends AdminBase {
    protected $db;

    public function _initialize() {
        parent::_initialize();
        $this->db = M("Area");
        
    }
    //显示地区
    public function index(){
            if(empty($_POST['area_id'])){
			$res = $this->getArea();
			}else{			   
				//$res=M('area')->where('pid='.$_POST['area_id'])->select();
				$sql1 = "select * from jbr_area where pid=".$_POST['area_id']." ORDER BY convert(area_name using gbk) asc";
				$res = M('area')->query($sql1);
				$str = '<font color="green">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|-';
                foreach($res as $k=>$v){
				    $v['area_name'] = $str.$v['area_name'].'</font>';
                }		
           }    
			//只有省的搜索下拉列表
			 $sql = "select * from jbr_area where pid in(select id from jbr_area where pid =0) ORDER BY convert(area_name using gbk) asc";
			 $lists = M('area')->query($sql);
	   //print_r($lists); exit;
	   $this->assign('lists',$lists);
	   $this->assign('res',$res);
	   $this->display();
}	  
/*
**取出地区及分类
*/
	  public  function getArea(){
	    $id=0;
		$res1=M('area')->where('pid='.$id)->select();
		$res=array();
		$str1 = '<font color="red">&nbsp;&nbsp;|-';
		$str2 = '<font color="green">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|-';
		foreach($res1 as $k=>$v){
		 $res[]=$v;//第一级
		 $res2=M('area')->where('pid='.$v['id'])->select();
		 foreach($res2 as $k1=>$v1){
		     $v1['area_name'] = $str1.$v1['area_name'].'</font>';
			 $res[]=$v1;//第二级
			 $res3=M('area')->where('pid='.$v1['id'])->select();
		 foreach($res3 as $k2=>$v2){
		     $v2['area_name'] = $str2.$v2['area_name'].'</font>';
			 $res[]=$v2;//第三级
           }    
	    }
     }
		return $res;
	}	
/*
** 删除地区
*/	
	function delete(){
		$id = $_GET['id'];
		$row = M('area')->where('id='.$id)->delete();
		if($row){
			$this->success("删除成功",U('Area/index'));	
		}else{
			$this->error("删除失败");
		}
	}
/*
** 增加地区
*/	
	function add(){
	 //有地区和省的下拉列表
		 $res1=M('area')->where(array('pid'=>0))->select();
		 $lists=array();
		 $str1 = '<font color="red">&nbsp;&nbsp;|-';
		 foreach($res1 as $k=>$v){
		 $lists[]=$v;//第一级
		 $res2=M('area')->where('pid='.$v['id'])->select(); 
		 foreach($res2 as $k1=>$v1){
		 $v1['area_name'] = $str1.$v1['area_name'].'</font>';
		 $lists[]=$v1;//第二级	
		   }      
		 }
		if(!empty($_POST)){					
				$result['pid']=$_POST['pid'];
				$result['area_name']=$_POST['area_name'];
				$result['area_title']=$_POST['area_title'];
				$result['area_des']=$_POST['area_des'];
				$result['area_keyword']=$_POST['area_keyword'];
				$result['area_img'] = $_POST['ProductClassImage'];
				if($_POST['yes']!='')//是否禁用
				{
					$result['show_status']=1;
				}
				else
				{
					$result['show_status']=0;
				}
				$r=$this->db->add($result);
				if($r){
					$this->success('添加成功！',U('area/index'));
				}else{
					 $this->error('添加失败！');
				}
			}
			$this->assign('lists',$lists);
			$this->display();
	}
/*
** 修改地区
*/	
	function edit(){
     $id = $_GET['id'];
	 if(!empty($_POST))
			{
				$data['pid'] = $_POST['pid'];
				if($_POST['area_name'] != '')
				{
					$data['area_name'] = $_POST['area_name'];
				}
				if($_POST['yes'] != '')
				{
					$data['show_status'] = 1;
				}
				else
				{
					$data['show_status'] = 0;
				}
				$data['area_img'] = $_POST['ProductClassImage'];
				$data['area_title']=$_POST['area_title'];
				$data['area_des']=$_POST['area_des'];
				$data['area_keyword']=$_POST['area_keyword'];
				$result = $this->db->where('id='.$id)->data($data)->save();
				//echo $this->db->getLastsql();
				if($result !==false)
				{   
					$this->success('修改成功',U('Area/index'));
				}
				else
				{
					 $this->error('修改失败');
				}
			}	
			else
			{	
				//有地区和省的下拉列表
				 // $res1=M('area')->where(array('pid'=>0))->select();
				 // $res=array();
				 // $str1 = '<font color="red">&nbsp;&nbsp;|-';
				 // foreach($res1 as $k=>$v){
				 // $res[]=$v;//第一级
				 // $res2=M('area')->where('pid='.$v['id'])->select(); 
				 // foreach($res2 as $k1=>$v1){
				 // $v1['area_name'] = $str1.$v1['area_name'].'</font>';
				 // $res[]=$v1;//第二级	
		        // }      
		      // }
			    $lists = $this->db->find($id);
		        $this->assign('lists',$lists);
				//$this->assign('res',$res);
				$this->display();
			}	
	}
       /*
		*禁用/启用
		*
		*/
		public function isok()
		{
			$tid = $_POST['tid'];
			$isok = $_POST['isok'];
			if($isok == 0){
				$data['show_status']=1;				
				$result = $this->db->where("id=".$tid)->data($data)->save();
				echo "1";
			}else{
				$data['show_status']=0;
				$this->db->where("id=".$tid)->data($data)->save();
				echo "0";
			}
		}	
		
	//获取地区  
     public function getareas(){
	    $pid=$_GET['pid']; 
	    $sql = "select * from jbr_area where pid=".$pid;
	    $area = M('area')->query($sql);

		if(IS_AJAX){
			echo json_encode($area);
		}else{
		    echo 0;	
		}     
   }	
}

?>