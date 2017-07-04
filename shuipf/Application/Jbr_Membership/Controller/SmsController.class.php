<?php 
// +----------------------------------------------------------------------
// | 会员类型
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014
// +----------------------------------------------------------------------
// | Author: zh 2016-10-19
// +----------------------------------------------------------------------

namespace Jbr_Membership\Controller;

use Common\Controller\AdminBase;
use Admin\Service\User;
use Common\Controller\SmsApi;

class SmsController extends AdminBase{	
		
		
		public $membertype=null;
		public $record=null;
		public $member=null;
		public function _initialize(){
		parent::_initialize ();
			
			$this->membertype=M("memberClass");
			$this->record=M("sms_record");
			$this->member=M("member");
	}

		/*
		*列表
		*
		*/
		public function index()
		{	
		    
			if(!empty($_POST)){			
				
				//print_r($_POST);die;
				
				
				if($_POST['cuser']!='0')
				{
					$u="全部会员";
					switch($_POST['suser'])
					{
						case 0:
						$u="全部社员";break;
						case 1:
						$u="注册社员";break;
						case 2:
						$u="铁杆社员";break;
						case 3:
						$u="合伙社员";break;
						case 4:
						$u="普通社员";break;
					}
					$this->record->receiveusers=$u;
				}
				else
				{
					$this->record->receiveusers=$_POST['ruser'];
				}
				
				$this->record->content=$_POST['content'];
				$userInfo = User::getInstance()->getInfo();
				$this->record->writeuser=$userInfo['username'];
				
				$result = $this->record->add();
				
				if($result)
				{
				    if($_POST['cuser']!='0')          // 分用户组发送
					{
					    if($_POST['suser']=='0')    //全部发送
						{
							$t = $this->member->query("select mobile from jbr_member where islock=0");
							$mobiles = $this->m_atos($t);
							//发送短信
						    $r = $this->send_sms("【股权帮】".$_POST['content'],$mobiles);
					    } 
						else   //给某一组发送
						{                      
							$t = $this->member->query("select mobile from jbr_member where islock=0 and member_class=".$_POST['suser']);
							$mobiles = $this->m_atos($t);
							//发送短信
							$r = $this->send_sms("【股权帮】".$_POST['content'],$mobiles);
		                    
							
						}
					}
					else      //指定ID发送
					{
						$i = $_POST['ruser'];
						$t = $this->member->query("select mobile from jbr_member where id in(".$i.")");
						
						$mobiles = $this->m_atos($t);
						
						//发送短信
						$r = $this->send_sms("【股权帮】".$_POST['content'],$mobiles);
					}		
 					
					//根据返回状态码判断发送结果 
					print_r($r);die;
					if($r[1]=='0'){
						$this->success('发送成功',U('Sms/smslist'));
					}else{
						print_r($r);die;
						//$this->error('发送失败');
					}
					
					
				}
				else
				{
					 $this->error('发送失败');
				}
				
				
			}
			else
			{			
				$classList = $this->membertype->select();
				$this->assign("classList", $classList);
				$this->display();
			}
		}
	
    //将查询手机号数组转为字符串    
 	function m_atos($arr)
	{
	   foreach($arr as $k=>$v){
			$e[$k] = $v[mobile];
	    }	
		$str = implode(',',$e);
		return $str;
	}
	
//短信发送
	function send_sms($content,$mobile)
	{
		//echo $content.$mobile;die;
		$clapi  = new SmsApi();
		$result = $clapi->sendSMS($mobile, $content,'true');
		$result = $clapi->execResult($result);
		return $result;
		
	}
	
	
	//发件箱
    public function smslist()
	{
		
		$count = $this->record->count();
		$page = $this->page($count, 8);
		$show = $page->show();// 分页显示输出
		
		$lists=$this->record->limit($page->firstRow . ',' . $page->listRows)->order('senddate desc')->select();

		$this->assign("Page", $show);
		
		$this->assign('lists',$lists);			
		$this->display();
		
		
		
		
	}	
	   	
}