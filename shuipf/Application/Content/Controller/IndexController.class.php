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

class IndexController extends Base {

    //首页 标题 描述 关键字的优化数据建立
    public function index() 
	{   
	    //跳转
	    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	    $iphone = (strpos($agent, 'iphone')) ? 1 : 0;
	    $ipad = (strpos($agent, 'ipad')) ? 1 : 0;
	    $android = (strpos($agent, 'android')) ? 1 : 0;
	    if($iphone!=1 && $ipad!=1 && $android!=1 && ENV == "product")
	    {
	        if(ENV == "dev"){
	          //PC端设备跳转到PC测试页面
	          echo "<script>window.location.href='http://cs.guquanbang.com'</script>";//这里也可以是网址
	        }else{
	          //PC端设备跳转到PC测试页面
	          echo "<script>window.location.href='http://guquanbang.com'</script>";//这里也可以是网址
	        }    
	    }
	    $this->wx_auto_login();
        $page = isset($_GET[C("VAR_PAGE")]) ? $_GET[C("VAR_PAGE")] : 1;
        $page = max($page, 1);
        //模板处理
        //获取首页模板
        $tp = explode(".", self::$Cache['Config']['indextp']); //self::$Cache 是将站点初始化的数据存入到缓存中，并且放入到这个变量中        
        $template = parseTemplateFile("Index/{$tp[0]}"); //获取当前模板文件的格式
        //dump("Index/{$tp[0]}");die;
        //提取config数据库中的数据
        
        //生成网站首页优化数据
        $SEO = seo('', '', self::$Cache['Config']['siteinfo'], self::$Cache['Config']['sitekeywords']);
       //dump(self::$Cache);die;
        //生成路径
        $urls = $this->Url->index($page);  //这个是调用的什么函数？？？
        //dump($SEO);
        $GLOBALS['URLRULE'] = $urls['page'];
        //dump($GLOBALS['URLRULE']);
        //seo分配到模板
        $this->assign("SEO", $SEO);
        //把分页分配到模板
	$this->assign(C("VAR_PAGE"), $page);
        $this->display("Index:" . $tp[0]);
    }


    //列表
    public function lists() {
        //栏目ID
        $catid = I('get.catid', 0, 'intval');  //默认获取分类id为0 ，过滤类型为intval类型
        //dump($catid);die;
        //分页
        $page = isset($_GET[C("VAR_PAGE")]) ? $_GET[C("VAR_PAGE")] : 1; //获取初始页码
        //获取栏目数据
        $category = getCategory($catid);
        // dump($category);
        if (empty($category)) {
            send_http_status(404);
            exit;
        }
        //栏目扩展配置信息
        $setting = $category['setting'];
        //dump($setting);die;
        //检查是否禁止访问动态页
        if ($setting['listoffmoving']) {
            send_http_status(404);
            exit;
        }
        //生成静态分页数
        $repagenum = (int) $setting['repagenum'];
        if ($repagenum && !$GLOBALS['dynamicRules']) {
            //设置动态访问规则给page分页使用
            $GLOBALS['Rule_Static_Size'] = $repagenum;
            $GLOBALS['dynamicRules'] = CONFIG_SITEURL_MODEL . "index.php?a=lists&catid={$catid}&page=*";
        }
        //父目录
        $parentdir = $category['parentdir'];
        //目录
        $catdir = $category['catdir'];
        //dump($catdir);
        //生成路径
        $category_url = $this->Url->category_url($catid, $page);
        //dump($category_url);
        //取得URL规则
        $urls = $category_url['page'];
        //生成类型为0的栏目
        if ($category['type'] == 0) {
            //栏目首页模板
            $template = $setting['category_template'] ? $setting['category_template'] : 'category';
            //栏目列表页模板
            $template_list = $setting['list_template'] ? $setting['list_template'] : 'list';
            //判断使用模板类型，如果有子栏目使用频道页模板，终极栏目使用的是列表模板
            $template = $category['child'] ? "Category/{$template}" : "List/{$template_list}";
            //去除后缀开始
            $tpar = explode(".", $template, 2);
            //去除完后缀的模板
            $template = $tpar[0];
            unset($tpar);
            $GLOBALS['URLRULE'] = $urls;
        } else if ($category['type'] == 1) {//单页
            $db = D('Content/Page');
            $template = $setting['page_template'] ? $setting['page_template'] : 'page';
            //判断使用模板类型，如果有子栏目使用频道页模板，终极栏目使用的是列表模板
            $template = "Page/{$template}";
            //去除后缀开始
            $tpar = explode(".", $template, 2);
            //去除完后缀的模板
            $template = $tpar[0];
            unset($tpar);
            $GLOBALS['URLRULE'] = $urls;
            $info = $db->getPage($catid);
            $this->assign($category['setting']['extend']);
            $this->assign($info);
        }
//         dump($template);
        //把分页分配到模板
        $this->assign(C("VAR_PAGE"), $page);
        //分配变量到模板 
        $this->assign($category);
        //seo分配到模板
        $seo = seo($catid, $setting['meta_title'], $setting['meta_description'], $setting['meta_keywords']);
        $this->assign("SEO", $seo);
        $this->display($template);
    }

    //内容页
    public function shows() {
        $catid = I('get.catid', 0, 'intval');
        $id = I('get.id', 0, 'intval');
        
        if($catid == "13" && $id== 0){//如果是股权博弈分类下，ID=0就默认访问最新一期股权博弈（用于微信回复3时，自动回复最新一期课程）
            $id=M("courses")->where("catid=".$catid)->order('id desc')->getField("id");
        }
        
        $other_invitation_code = I('get.invitation_code');
        if(!empty($other_invitation_code)){//如果有别人的邀请码
            setcookie('invitation_code',$other_invitation_code,time()+1800);//缓存别人的邀请码（用于注册）
            setcookie('invitation_code_createtime',time(),time()+1800);//缓存别人的邀请码的生成时间（用于注册）
        }
        //获取当前登陆者的邀请码
        if(!empty($_SESSION['userid']))
        {
           $userid = $_SESSION['userid'];
           $invitationData =M('member')->field('invitation_code')->find($userid);
           $invitation_code = $invitationData['invitation_code'];

           $this->assign('invitation_code',$invitation_code);//传递自己的邀请码，用于分享
           
        }
        //dump($invitationData);    
        $page = intval($_GET[C("VAR_PAGE")]);
        $page = max($page, 1);
        //获取当前栏目数据
        $category = getCategory($catid);
       //dump($category);die;
        if (empty($category)) {
            send_http_status(404);
            exit;
        }
		//视频权限控制
		if($catid=='6')
		{
		   /* if($_SESSION['userid']=='')
		   {
			   $this->error('请先登录！','/index.php?m=User&a=index');   
		   } */
           //查询视频权限		  
            $authority = M('video')->where('id='.$id)->getField('authority');
			$video_id = $id;
			$userid = empty($_SESSION['userid'])?'':$_SESSION['userid'];
			$r = get_video_rbc($_SESSION['userid'], $authority, $video_id);  //get_video_rbc 获取该会员是否有查看该视频的权限
            if($r['code']!=0)
			{
			   $this->error('您没有权限或者该视频需要支付积分！','/index.php?a=lists&catid=6');  	
			}
			
		}
		
        //反序列化栏目配置
        $category['setting'] = $category['setting'];
        //检查是否禁止访问动态页
        if ($category['setting']['showoffmoving']) {
            send_http_status(404);
            exit;
        }
        //模型ID
        $modelid = $category['modelid'];  //字段modelid是什么含义
//        dump($category);die;
        $data = ContentModel::getInstance($modelid)->relation(true)->where(array("id" => $id, 'status' => 99))->find();
//        dump(ContentModel::getInstance($modelid)->relation(true));exit;
        if (empty($data)) {
            send_http_status(404);
            exit;
        }
        ContentModel::getInstance($modelid)->dataMerger($data);
        //分页方式
        if (isset($data['paginationtype'])) {
            //分页方式 
            $paginationtype = $data['paginationtype'];
            //自动分页字符数
            $maxcharperpage = (int) $data['maxcharperpage'];
        } else {
            //默认不分页
            $paginationtype = 0;
        }
        //tag
        tag('html_shwo_buildhtml', $data);
        $content_output = new \content_output($modelid);
        //获取字段类型处理以后的数据
        $output_data = $content_output->get($data);
        $output_data['id'] = $id;
        $output_data['title'] = strip_tags($output_data['title']);
        //SEO
        $seo_keywords = '';
        if (!empty($output_data['keywords'])) {
            $seo_keywords = implode(',', $output_data['keywords']);
        }
        $seo = seo($catid, $output_data['title'], $output_data['description'], $seo_keywords);

        //内容页模板
        $template = $output_data['template'] ? $output_data['template'] : $category['setting']['show_template'];
        //去除模板文件后缀
        $newstempid = explode(".", $template);
        $template = $newstempid[0];
        unset($newstempid);
        //分页处理
        $pages = $titles = '';
        //分配解析后的文章数据到模板 
        $this->assign($output_data);
        //seo分配到模板
        $this->assign("SEO", $seo);
        //栏目ID
        $this->assign("catid", $catid);
        //分页生成处理
        //分页方式 0不分页 1自动分页 2手动分页
        if ($data['paginationtype'] > 0) {
            $urlrules = $this->Url->show($data, $page);
            //手动分页
            $CONTENT_POS = strpos($output_data['content'], '[page]');
            if ($CONTENT_POS !== false) {
                $contents = array_filter(explode('[page]', $output_data['content']));
                $pagenumber = count($contents);
                $pages = page($pagenumber, 1, $page, array(
                    'isrule' => true,
                    'rule' => $urlrules['page'],
                        ))->show("default");
                //判断[page]出现的位置是否在第一位 
                if ($CONTENT_POS < 7) {
                    $content = $contents[$page];
                } else {
                    $content = $contents[$page - 1];
                }
                //分页
                $this->assign("pages", $pages);
                $this->assign("content", $content);
            }
        } else {
            $this->assign("content", $output_data['content']);
        }
		//微信分享相关参数
	    $time = time();
            //如果存在邀请码，则分享链接上加上邀请码
            $share_url = 'http://'.$_SERVER['HTTP_HOST'].'/index.php?a=shows&catid='.$catid.'&id='.$id;
            if($invitation_code)
            {
                //拼接邀请码字符串
              $share_url .= '&invitation_code='.$invitation_code;    
            }
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//            dump($url);
//            dump($_SESSION['jsapi_ticket']);
//            dump($share_url);
//	    $signature = sha1('jsapi_ticket='.$_SESSION['jsapi_ticket'].'&noncestr=BogLeUnion&timestamp='.$time.'&url='.$share_url); //源代码
            $signature = sha1('jsapi_ticket='.$_SESSION['jsapi_ticket'].'&noncestr=BogLeUnion&timestamp='.$time.'&url='.$url); //现在代码
	    //dump($signature);
            
	    $this->assign('appid', $this->getAppid());
	    $this->assign('time', $time);
	    $this->assign('share_url', $share_url);
	    $this->assign('signature', $signature);
	    $this->assign('jsapi_ticket', $_SESSION['jsapi_ticket']);
		
        $this->display("Show/{$template}");
    }

    //tags标签
    public function tags() {
        $tagid = I('get.tagid', 0, 'intval');
        $tag = I('get.tag', '', '');
        $where = array();
        if (!empty($tagid)) {
            $where['tagid'] = $tagid;
        } else if (!empty($tag)) {
            $where['tag'] = $tag;
        }
        //如果条件为空，则显示标签首页
        if (empty($where)) {
            $key = 'Tags_Index_index';
            $dataCache = S($key);
            if (empty($dataCache)) {
                $data = M('Tags')->order(array('hits' => 'DESC'))->limit(100)->select();
                if (!empty($data)) {
                    //查询每个tag最新的一条数据
                    $tagsContent = M('TagsContent');
                    foreach ($data as $k => $r) {
					    $url = $this->Url->tags($r);
                        $data[$k]['url'] = $url['url'];
                        $data[$k]['info'] = $tagsContent->where(array('tag' => $r['tag']))->order(array('updatetime' => 'DESC'))->find();
                    }
                    //进行缓存
                    S($key, $data, 3600);
                }
            } else {
                $data = $dataCache;
            }
            $SEO = seo('', '标签');
            //seo分配到模板
            $this->assign("SEO", $SEO);
            $this->assign('list', $data);
            $this->display("Tags/index");
            return true;
        }
        //分页号
        $page = isset($_GET[C("VAR_PAGE")]) ? $_GET[C("VAR_PAGE")] : 1;
        //根据条件获取tag信息
        $info = M('Tags')->where($where)->find();
        if (empty($info)) {
            $this->error('抱歉，沒有找到您需要的内容！');
        }
        //访问数+1
        M('Tags')->where($where)->setInc("hits");
        //更新最后访问时间
        M('Tags')->where($where)->save(array("lasthittime" => time()));
        $this->assign($data);
        $Urlrules = cache('Urlrules');
        //取得tag分页规则
        $urlrules = $Urlrules[self::$Cache['Config']['tagurl']];
        if (empty($urlrules)) {
            $urlrules = 'index.php?g=Tags&tagid={$tagid}|index.php?g=Tags&tagid={$tagid}&page={$page}';
        }
        $GLOBALS['URLRULE'] = str_replace('|', '~', str_replace(array('{$tag}', '{$tagid}'), array($info['tag'], $info['tagid']), $urlrules));
        $SEO = seo();
        //seo分配到模板
        $this->assign("SEO", $SEO);
        //把分页分配到模板
        $this->assign(C("VAR_PAGE"), $page);
        $this->assign($info);
        $this->display("Tags/tag");
    }
	
	
	//微信分享成功回调处理
	public function share_success()
	{
		if(IS_AJAX){
			
			$data = I('post.');
			//$_SESSION['userid'] = 1;
		    if($_SESSION['userid']=='')
			{
			   echo json_encode(array('code'=>1,'msg'=>'尚未登录，登录后分享可获得积分！'));exit;	
			}
			//查询积分规则和每日最多获取积分次数
			$rule = M('score_rules')->where('id='.$data['share_type'])->find();
			//查询当前用户当日分享记录
			$rec = M('score_record')->where('member_id='.$_SESSION['userid'].' and share_type_id ='.$data['share_type'].' and addtime>="' . date('Y-m-d 00:00:00', time()) . '" and addtime<="' . date('Y-m-d 23:59:59"'))->select();
			
			//echo M('score_record')->getLastsql();die;
			
			if((int)count($rec)<(int)$rule['max_num_day'] && $_SESSION['userid'])  //未超过每日最大获得积分数   
			{
				$param = array('member_id'=>$_SESSION['userid'],
				               'score'=>$rule['get_score'],
							   'score_type'=>'分享奖励',
							   'source'=>$rule['name'],
							   'share_type_id'=>$data['share_type'],
							   'addtime'=>date('Y-m-d H:i:s',time())
							   );
				//添加积分记录
                $r = M('score_record')->add($param);
                //增加会员积分
				if($r)
				{ 
			        //可用积分
				   	M('member')->where('id='.$_SESSION['userid'])->setInc('score',$rule['get_score']);
					//累计积分
					M('member')->where('id='.$_SESSION['userid'])->setInc('total_score',$rule['get_score']);
				}
				
			}
			
			echo  json_encode(array('code'=>0,'share_num'=>count($rec)));exit;
		}
		
	}
	
	//课程列表页
	public  function courselist()
	{
// 	    $data = M('courses')->where('start_time>'.time())->select();
// 	    $courselist = array();
// 	    //获取今年的初始的时间戳
// 	    $thismonth = date('m');
//         $thisyear = date('Y');
//         $startDay = $thisyear . '-' . $thismonth . '-1';
//         $endDay = $thisyear . '-' . $thismonth . '-' . date('t', strtotime($startDay));
//         $b_time  = strtotime($startDay);//当前月的月初时间戳
//         $e_time  = strtotime($endDay);//当前月的月末时间戳
//         $start1Day = $thisyear . '-' . ($thismonth+1) . '-1';
//         $end1Day = $thisyear . '-' . ($thismonth+1) . '-' . date('t', strtotime($startDay));
//         $b1_time  = strtotime($start1Day);//下月的月初时间戳
//         $e1_time  = strtotime($end1Day);//下月的月末时间戳
//         echo date('Y-m-d H:i:s',$b1_time);
//         echo date('Y-m-d H:i:s',$e1_time);
//         foreach($data as $k=>$v)
//         {
//         }
        
	    $this ->display();
	}
}
