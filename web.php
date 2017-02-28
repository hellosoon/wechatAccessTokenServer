<?php
/**
 * Created by Soon
 */
define('BASEPATH', dirname(__FILE__));
define('ERROR_MSG', 'error');

//引入类文件
include_once('config.php');
include_once('WebToken.class.php');

if (!isset($_GET['code'])){
    exit(ERROR_MSG);
}

$code = $_GET['code'];
if ($code) {//获取token
    echo WebToken::run($code);
} else {
    echo ERROR_MSG;
}