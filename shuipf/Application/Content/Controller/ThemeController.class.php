<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 网站前台
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Content\Controller;

use Common\Controller\Base;
use Content\Model\ContentModel;

class ThemeController extends Base {

	//股权博弈专题页
	public function gqby()
	{
	   //获得来源
       $source = I('get.source');
       if($source)
       {
           $this->assign('source',$source);
       }
       $this->display();
	}
	
	//股权博弈专题页
	public function gqby2()
	{
       $this->display();
	}
	
	//股权博弈help页面
	public function biddingHelp()
	{
	    $this ->display();
	}
	
	//ajax 保存数据
	public function ajaxsave()
	{
	    $data = array();
	    $data['company'] = I('company','','string');
	    $data['job'] = I('job','','string');
	    $data['name'] = I('name','','string');
	    $data['mobile'] = I('mobile','','string');
	    $data['source'] = I('source','PC专题页','string');
	    $data['datetime'] = time();
	    if(!isset($data['company']) || empty($data['company']) )
	    {
	        //公司不能为空
	        echo json_encode(array('code'=>1,'msg'=>'请填写你的公司名！'));
	        exit;
	    }else if(!isset($data['job']) || empty($data['job']))
	    {
	        //职位不能为空
	        echo json_encode(array('code'=>1,'msg'=>'请填写你的职位！'));
	        exit;
	    }else if(!isset($data['name']) || empty($data['name']))
	    {
	        //姓名不能为空
	        echo json_encode(array('code'=>1,'msg'=>'请填写你的姓名！'));
	        exit;
	    }else if(!isset($data['mobile']) || empty($data['mobile']))
	    {
	        //手机不能为空
	        echo json_encode(array('code'=>1,'msg'=>'请填写你的手机！'));
	        exit;
	    }else
	    {
	        //验证通过
	        $r = M('t_user')->add($data);
	        if($r)
	        {
	            sendTplSemToXiaoMing($data['name'], date('Y-m-d H:i:s',time()), $data['mobile'], $data['company'], $data['job'], $data['source']);
	            echo json_encode(array('code'=>2,'msg'=>'信息录入成功！'));
	            exit;
	        }
	    }
	}
	

}
