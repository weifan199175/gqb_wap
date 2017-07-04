<?php

// +----------------------------------------------------------------------
// | ShuipFCMS 内容模块自定义函数
// +----------------------------------------------------------------------
// | Copyright (c) 2012-2014 http://www.shuipfcms.com, All rights reserved.
// +----------------------------------------------------------------------
// | Author: 水平凡 <admin@abc3210.com>
// +----------------------------------------------------------------------

/**
 * 错误信息记录方法
 * @param $position 错误出现的地方和位置
 * @param $info 错误的信息
 * @param $extra 备注
 */
function error_savelog($position="",$info="",$extra=""){
    $log = M("errorlog");
    $data = array(
        "position"=>$position,
        "info"=>$info,
        "extra"=>$extra,
        "datetime"=>date("Y-m-d H:i:s", time()),
    );
    $log->add($data);
}

/**
 * 弹出错误信息并跳转的方法
 * @param $content 错误信息
 * @param $url 跳转地址（可为空）
 */
function showErrorInfo($content,$url=""){
    header("Content-type: text/html; charset=utf-8");
    if($url){
        echo "<html><body>
        <h1>{$content}</h1>
        <script>
        setTimeout(function(){window.location.href='{$url}'},2000);
        </script>
        </body></html>";
        exit();
    }else {
        echo "<html><body>
        <h1>{$content}</h1>
        <script>
        setTimeout(function(){history.back()},2000);
        </script>
        </body></html>";
        exit();
    }
}