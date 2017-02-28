<?php
/**
 * Created by Soon
 * www.so-on.cn
 * Date: 2016/10
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Refresh
{
    public static function run($count = 1)
    {
        if ($count > 3) {
            return 0;
        }
        $result = self::refreshToken(++$count);
        if ($result == 1) {
            sleep(1);
            return Token::run(++$count);
        }
        return $result;
    }

    public static function refreshToken($count = 1)
    {
        $path = config::get('tokenPath') . config::get('tokenName');//token保存路径
        $logPath = config::get('tokenPath') . config::get('tokenLogName');//token保存路径
        $flagPath = config::get('tokenPath') . config::get('tokenFlag');//flag保存路径

        $flag = @file_get_contents($flagPath);
        if (intval($flag) == 1) {//直接退出
            return '1';
        } else {//获取token
            @file_put_contents($flagPath, '1',LOCK_EX);//立flag
            $tokenUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . config::get('APPID'). "&secret=" . config::get('AppSecret');
            $json = @file_get_contents($tokenUrl);//获取token
            $result = json_decode($json, true);
            if (isset($result['errcode'])) {//错误处理
                @file_put_contents($logPath, 'refresh    ' . date('Y-m-d h:i:s') . '    ' . $json . PHP_EOL, FILE_APPEND);//保存错误情况
                $accessToken = self::run(++$count);//重试
            } else {
                $token = $result['access_token'];//token
                $accessToken = $token;//在保存前转存一下用于输出
                $tokenExpires = empty(config::get('tokenExpires')) ? $result['expires_in'] : config::get('tokenExpires');
                $token .= " " . (time() + intval($tokenExpires));//有效期
                @file_put_contents($path, $token);//保存
            }
            @file_put_contents($flagPath, '0',LOCK_EX);//去flag
            return $accessToken;
        }
    }
}

