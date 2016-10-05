<?php
/**
 * Created by Soon
 * www.so-on.cn
 * Date: 2016/10
 */
define('BASEPATH', dirname(__FILE__));

//引入类文件
include_once('config.php');
include_once('Token.class.php');
include_once('Refresh.class.php');

if (!isset($_GET['type'])){
    exit('error');
}

if(empty(config::get('APPID'))){
      exit('请填写APPID');
}

if(empty(config::get('AppSecret'))){
      exit('请填写AppSecret');
}


if(empty(config::get('tokenPath'))){
      exit('请填写token保存路径');
}

$type = $_GET['type'];
if ($type == 'get') {//获取token
    echo Token::run();
} elseif ($type == 'refresh') {//刷新token
    echo Refresh::run();
} else {
    echo 'error';
}