<?php
/**
 * Created by Soon
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class WebToken
{
    public static function run($code)
    {
        return self::getWebOpenid($code);
    }

    public static function getWebOpenid($code)
    {
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token';
        $params = array(
            'appid' => config::get('APPID'),
            'secret' => config::get('AppSecret'),
            'code' => $code,
            'grant_type' => 'authorization_code'
        );
        $result = self::wechatHttp($url, $params);
		
        $result = @json_decode($result, 1);
        if (isset($result['errcode'])) {
            return ERROR_MSG;
        } else if (isset($result['openid'])) {
            return $result['openid'];
        }else {
            return ERROR_MSG;
        }
    }
	 public static function wechatHttp($url, $params, $method = 'GET', $header = array())
    {
        $opts = array(CURLOPT_TIMEOUT => 0, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false, CURLOPT_HTTPHEADER => $header);

        /* 根据请求类型设置特定参数 */
        switch (strtoupper($method)) {
            case 'GET' :
                $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
                //var_dump($opts);
                break;
            case 'POST' :
                $params = http_build_query($params);
                $opts[CURLOPT_URL] = $url;
                $opts[CURLOPT_POST] = 1;
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
            default :
                return 'false';
        }

        /* 初始化并执行curl请求 */
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $data = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ($error)
            return $error;
        return $data;
    }
}
