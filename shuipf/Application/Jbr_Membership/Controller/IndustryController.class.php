<?php 
// +----------------------------------------------------------------------
// | 后台的行业管理
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014
// +----------------------------------------------------------------------
// | Author: zh
// +----------------------------------------------------------------------
namespace Jbr_Membership\Controller;

use Common\Controller\AdminBase;

class IndustryController extends AdminBase{
    
    public function _initialize(){
        parent::_initialize ();
        $this->industry = D("industry");
      
    }
    
    
    /**
      * 行业列表
      */
    public function index(){

        if (IS_POST) {
            $this->redirect('index', $_POST);
        }
        
        $firstindustry = $this->industry->where('pid=0')->order('sorts asc')->select();
        
        if(!empty($firstindustry)){
            // 取一级行业下的子行业
            foreach ($firstindustry as $k => $v) {
                $map['pid'] = $v['id'];
                $firstindustry[$k]['sub'] = $this->industry->where($map)->order('sorts asc')->select();
				
            }
        }
       //print_r($firstindustry);die;
        
        $this->assign("industrylist", $firstindustry);
        $this->display();
    }
  
    // 获取一级行业分类
    public function firstlist(){
        $firstlist = $this->industry->field('id,industry_name')->where('pid=0')->order('sorts asc')->select(); 
        $this->assign('firstlist',$firstlist);
    }
    
    //添加行业的分类
    public function add() {
        
       
        
        if (IS_POST){
            $_POST['addtime'] = date('Y-m-d H:i:s',time());
            
		    $r = $this->industry->add($_POST);
		  
            if ($r) {
                $this->success("添加行业成功！", U('Industry/index'));
            } else {
                $error = $this->industry->getError();
                $this->error($error ? $error : '添加失败！', U('Industry/index'));
            }
        } else {       
		     // 获取一级行业分类
			$this->firstlist();
			
            $this->display();
        }
    }
   
    //编辑行业分类信息
   public function edit()
   {
        $id = I('request.id', 0, 'intval');
       
        // 获取一级行业分类
        $this->firstlist();
        if (empty($id)) {
            $this->error("请选择需要编辑的信息！");
        }
      
        if(IS_POST)
		{
            
			
			$r = $this->industry->where('id='.$_POST['id'])->data($_POST)->save();
			
            if (false !== $r) {
                $this->success("更新成功！", U("Industry/index"));
            } else {
                $error = $this->industry->getError();
                $this->error($error ? $error : '修改失败！');
            }
        }else{
            $data = $this->industry->find($id);
            if (empty($data)) {
                $this->error('该信息不存在！');
            }
           
           
            $this->assign("data", $data);
            $this->display();
        }
    }

   
    public function delete(){
        
        // 删除单个信息
        $id = I('get.aid', 0, 'intval');
        if (empty($id)) {
            $this->error("没有指定删除对象！");
        }
        
        // 教师选课表
        $pid = $this->industry->where('id='.$id)->getField('pid');
        if($pid==0){
            // 一级栏目
            $sub_industry = $this->industry->where('pid='.$id)->count();
            if($sub_industry){
                $this->error('该行业下有子行业！故不能删除！');
                exit;
            }
        }else{

                //删除该行业
                //执行删除
                $status = $this->industry->delete($id);  
                // 若行业关联其他表里面有数据，则不提示不能删除

                if($status){     
                    $this->success("删除成功！",U('Industry/index'));
                }else{
                    $this->error('删除失败！');
                    exit;
                }     
            
        }       
    }


    
    
}