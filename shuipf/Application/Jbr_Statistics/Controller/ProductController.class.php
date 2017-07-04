<?php 
// +----------------------------------------------------------------------
// | 会员
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014
// +----------------------------------------------------------------------
// | Author: xcp
// +----------------------------------------------------------------------

namespace Jbr_Statistics\Controller;

use Common\Controller\AdminBase;

class ProductController extends AdminBase{
		
		public function _initialize(){
		parent::_initialize ();
			$this->order=M("order");
			
		}
		
		/*
		*	商品销量统计
		*	2016-11-30 edit by zh 添加条件筛选
		*/
		public function index()
		{
			//查询起止时间
			$stime = I("start_time", '', 'string') ? " and addtime >= '" .  I("start_time") . "'" : "";
			$etime = I("end_time", '', 'string') ? " and addtime <= '" .  I("end_time") . "'" : "";
			
			if($_POST){
				$this->redirect('index', $_POST);
			}
            //echo $stime;die;
			//股权博弈销量--销售额
			$by_count = $this->order->where('product_type=1 and status>=1 and product_id in (select id from jbr_courses where catid=13)'.$stime.$etime)->count();
			
			$by_sale = $this->order->where('product_type=1 and status>=1 and product_id in (select id from jbr_courses where catid=13)'.$stime.$etime)->field('sum(price) as sale')->select();
			//echo $this->order->getLastSql();die;
			//新物种进化营销量--销售额
			//股权架构
			$jhy_count_1 = $this->order->alias('o')->join('jbr_courses c on c.id=o.product_id')->where("o.product_type=1 and o.status>=1 and c.title='股权架构'".$stime.$etime)->count();
			//echo $this->order->getLastSql();die;
			$jhy_sale_1 = $this->order->alias('o')->join('jbr_courses c on c.id=o.product_id')->where("o.product_type=1 and o.status>=1 and c.title='股权架构'".$stime.$etime)->field('sum(price) as sale')->select();
			//社群运营
			$jhy_count_2 = $this->order->alias('o')->join('jbr_courses c on c.id=o.product_id')->where("o.product_type=1 and o.status>=1 and c.title='社群运营'".$stime.$etime)->count();
			$jhy_sale_2 = $this->order->alias('o')->join('jbr_courses c on c.id=o.product_id')->where("o.product_type=1 and o.status>=1 and c.title='社群运营'".$stime.$etime)->field('sum(price) as sale')->select();
			
			//爆品战略
			$jhy_count_3 = $this->order->alias('o')->join('jbr_courses c on c.id=o.product_id')->where("o.product_type=1 and o.status>=1 and c.title='爆品战略'".$stime.$etime)->count();
			$jhy_sale_3 = $this->order->alias('o')->join('jbr_courses c on c.id=o.product_id')->where("o.product_type=1 and o.status>=1 and c.title='爆品战略'".$stime.$etime)->field('sum(price) as sale')->select();
			//echo $this->order->getLastSql();die;
			
			//铁杆社员销售量--销售额
			$tg_count = $this->order->where('product_type=16 and status=1'.$stime.$etime)->count();
			$tg_sale = $this->order->where('product_type=16 and status=1'.$stime.$etime)->field('sum(price) as sale')->select();
			//echo $tg_sale[0]['sale'];die;
			//var_dump($jhy_sale);die;
			
			$this->assign("stime", I("start_time", '', 'string'));
			$this->assign("etime", I("end_time", '', 'string'));
				
			$this->assign('by_count',$by_count);
			$this->assign("jhy_count_1", $jhy_count_1);
			$this->assign("jhy_count_2", $jhy_count_2);
			$this->assign("jhy_count_3", $jhy_count_3);
			$this->assign("tg_count", $tg_count);
			$this->assign('by_sale',($by_sale[0]['sale']!=''?$by_sale[0]['sale']:0));
			$this->assign("jhy_sale_1", ($jhy_sale_1[0]['sale']!=''?$jhy_sale_1[0]['sale']:0));
			$this->assign("jhy_sale_2", ($jhy_sale_2[0]['sale']!=''?$jhy_sale_2[0]['sale']:0));
			$this->assign("jhy_sale_3", ($jhy_sale_3[0]['sale']!=''?$jhy_sale_3[0]['sale']:0));
			$this->assign("tg_sale", ($tg_sale[0]['sale']!=''?$tg_sale[0]['sale']:0));
			
			$this->display();
		}
		
		
		
		
	}