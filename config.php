<?php
/**
 * Created by Soon
 * www.so-on.cn
 * Date: 2016/10
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class config{
    private static $config = array(
        'APPID' => '',
        'AppSecret' => '',
        'tokenExpires' => '',
        'tokenPath' => '',
        'tokenName' => 'accesstoken.txt',
        'tokenFlag' => 'accesstokenflag.txt',
        'tokenLogName' => 'accesstokenlog.txt',
    );
    public static function get($index = ''){
        return self::$config[$index];
    }
}
