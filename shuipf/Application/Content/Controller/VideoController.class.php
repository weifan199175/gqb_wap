<?php
namespace Content\Controller;

use Common\Controller\Base;
use Content\Model\ContentModel;
use Common\Model\Model;

class VideoController extends Base {
	
	public function _initialize(){
		parent::_initialize ();
		$this->member=M("member");
	}

	// 判断是否可以查看视频
	public function iscan_see(){
		$authority = I('authority',0,'intval');
		$video_id = I('video_id',0,'intval');
		$userid = empty($_SESSION['userid'])?'':$_SESSION['userid'];
		echo json_encode(get_video_rbc($userid, $authority, $video_id));
                       
	}

	// 异步判断是否可以支付积分来查看视频
	public function pay_score(){
		$video_id=I('video_id');
		M('score_record')->startTrans();
		if(!empty($_SESSION['userid'])){
			$userid = $_SESSION['userid'];
			//获取当前视频所需积分
			$videoinfo = M('video')->where('id='.$video_id)->find();
			$rbc = M('video_type')->where('id='.$videoinfo['authority'])->find();
			//获取当前会员的可用积分
			$score=$this->member->where("id=".$userid)->getField('score');
			$differ = $score - $rbc['score'];
			if($differ<0){
				echo 2;
				exit;
			}else{
				//观看视频扣除积分
				$newscore['score'] = $differ;
				$r=$this->member->where("id=".$userid)->save($newscore);
				// 写入积分记录表
				if($rbc['score']>0){
					$new_data['member_id'] = $userid;
					$new_data['score'] = -$rbc['score'];
					$new_data['score_type'] = '积分消费观看视频';
					$new_data['source'] = $videoinfo['title'];
					$new_data['addtime'] = date('Y-m-d H:i:s',time());
					$new_data['share_type_id'] = null;
					$r2 = M('score_record')->add($new_data);
					// 同时写入消费了积分的视频观看记录表，一个视频只记录一次
					$record['member_id'] = $userid;
					$record['video_id'] = $video_id;
					$record['addtime'] =  date('Y-m-d H:i:s',time());
					$record['use_score'] = $rbc['score'];
					$r3 = M('video_record')->add($record);
				}else{
					$r2 = 1;
					$r3 = 1;
				}
				if($r!==false && $r2!==false && $r3!==false){
					M('score_record')->commit();
					echo 0;exit;
				}else{
					M('score_record')->rollback();
					echo 1;exit;
				}
			}
		}else{
			$this->error('请先登陆');
		}
		
	}
	
      
}