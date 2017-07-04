<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 后台分社模型
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

namespace Admin\Model;

use Common\Model\Model;

class FenbuModel extends Model {

    //array(验证字段,验证规则,错误提示,[验证条件,附加规则,验证时间])
    protected $_validate = array(
        array('name', 'require', '分社名不能为空！'),
        array('invitation_code', 'require', '邀请码不能为空且唯一！'),
    );
    //array(填充字段,填充内容,[填充条件,附加规则])
    protected $_auto = array(
    );

    /**
     * 插入成功后的回调方法
     * @param type $data 数据
     * @param type $options 表达式
     */
    protected function _after_insert($data, $options) {
    }

}
