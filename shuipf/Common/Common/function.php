<?php

/**
  * 获取视频权限
  * return   0 可观看   1  无权限
*/
    function get_video_rbc($user_id,$rbc_id,$video_id)
    {
	
		$rbc = M('video_type')->where('id='.$rbc_id)->find();
		
		$rbc_arr = explode(',',$rbc['authority']);
		//var_dump($rbc_arr);exit;
		
		if($user_id=='')
		{
      // 游客可以观看
		   if(in_array('0',$rbc_arr))
		   {
			   return array('code'=>0,'msg'=>'可观看');exit;
		   }
		   else
		   {
			   return array('code'=>2,'msg'=>'您好！请先登录，谢谢！');exit;
		   }
			
		}
		else
		{
  			$user = M('member')->where('id='.$user_id)->find();
        if(!empty($user)){
            if(in_array($user['member_class'],$rbc_arr))
            {
              return array('code'=>0,'msg'=>'可观看');exit;
            }
            else
            {
              // 判断会员是否使用积分支付过该视频
              $count = M('video_record')->where('member_id='.$_SESSION['userid'].' and video_id='.$video_id)->count();
              if($count>0){
                return array('code'=>0,'msg'=>'可观看');exit;
              }else{
                $score = M('member')->where('id='.$user_id)->getField('score');  //获取当前会员的可用积分
          
                if($score<$rbc['score']){
                  return array('code'=>3,'msg'=>'您的可用积分不足以观看此视频，请立即充值积分以便观看，谢谢！');exit;
                }else{
                  return array('code'=>1,'msg'=>'权限不够，需支付积分观看');exit;
                }
              }
            }

        }else{
          return array('code'=>4,'msg'=>'非法用户，无法观看');exit;
        }
		}  
	  
  }
  

  //生成邀请码
  function generate_invitecode(){
  	$pattern = '0123456789';
  	$l=substr(str_shuffle('ABCDEFGHIJKLOMNOPQRSTUVWXYZ'), 0,1);
    for($i=0;$i<6;$i++)   
    {   
        $key .= $pattern{mt_rand(0,9)};   
    } 
    $code =  $l.$key;  
    do{
        $iscz=M("member")->where("invitation_code='".$code."'")->count();
        if($iscz==0){
          break;
        }else{
          $code =  generate_invitecode();
        }
    }while(1); 
   
    return $code;
  }

  
  /**
     * 简单对称加密算法之加密
     * @param String $string 需要加密的字串
     * @param String $skey 加密EKY
     * @return String
     */
    function encode($string = '', $skey = 'wenzidsf') {
        $strArr = str_split(base64_encode($string));
        $strCount = count($strArr);
        foreach (str_split($skey) as $key => $value)
            $key < $strCount && $strArr[$key].=$value;
        return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr));
    }

    /**
     * 简单对称加密算法之解密
     * @param String $string 需要解密的字串
     * @param String $skey 解密KEY
     * @return String
     */
    function decode($string = '', $skey = 'wenzidsf') {
        $strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $string), 2);
        $strCount = count($strArr);
        foreach (str_split($skey) as $key => $value)
            $key <= $strCount && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
        return base64_decode(join('', $strArr));
    }
?>