<?php
/**
 * Created by Soon
 * www.so-on.cn
 * Date: 2016/10
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Token
{
    public static function run($count = 1)
    {
        return self::getToken(++$count);
    }

    public static function getToken($count = 1)
    {
        $path = config::get('tokenPath') . config::get('tokenName');//token保存路径
        $logPath = config::get('tokenPath') . config::get('tokenLogName');//token保存路径
        if(!file_exists($path)){//文件不存在的情况
            @file_put_contents($path,'0');
        }
        $content = @file_get_contents($path);
        $content = isset($content) ? $content : '';
        $Access_Token = explode(" ", $content);
        if (count($Access_Token) != 2) {//为了防止意外
            @file_put_contents($logPath, 'gettoken     ' . date('Y-m-d h:i:s') . '    ' . $content . PHP_EOL, FILE_APPEND);//保存错误情况
            return Refresh::run(++$count);
        } else if (time() - trim($Access_Token[1]) > 0) {//过期重新获取
            return Refresh::run(++$count);
        } else {//检验正确则返回文件中的token
            return $Access_Token[0];
        }
    }
}
