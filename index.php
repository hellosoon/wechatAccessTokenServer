<?php
/**
 * Created by Soon
 * www.so-on.cn
 * Date: 2016/10
 */
define('BASEPATH', dirname(__FILE__));
define('ERROR_MSG','error');
//引入类文件
include_once('config.php');
include_once('Token.class.php');
include_once('Refresh.class.php');

if (!isset($_GET['type'])){
    exit(ERROR_MSG);
}

//为了简化处理，这里没有使用json，所以就不带错误原因了
if(empty(config::get('APPID'))){
      exit(ERROR_MSG);
}

if(empty(config::get('AppSecret'))){
      exit(ERROR_MSG);
}


if(empty(config::get('tokenPath'))){
      exit(ERROR_MSG);
}

$type = $_GET['type'];
if ($type == 'get') {//获取token
    echo Token::run();
} elseif ($type == 'refresh') {//刷新token
    echo Refresh::run();
} else {
    echo ERROR_MSG;
}