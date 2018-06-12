<?php
use Org\Net\IpLocation;
/*
 * 将含有汉字的数组转化为json
 */
header("Content-Type: text/html; charset=utf-8");
function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
{
    static $recursive_counter = 0;
    if (++$recursive_counter > 1000) {
        die('possible deep recursion attack');
    }
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            arrayRecursive($array[$key], $function, $apply_to_keys_also);
        } else {
            $array[$key] = $function($value);
        }
        if ($apply_to_keys_also && is_string($key)) {
            $new_key = $function($key);
            if ($new_key != $key) {
                $array[$new_key] = $array[$key];
                unset($array[$key]);
            }
        }
    }
    $recursive_counter--;
}

/**************************************************************
 *
*  将数组转换为JSON字符串（兼容中文）
*  @param  array   $array      要转换的数组
*  @return string      转换得到的json字符串
*  @access public
*  @JSON函数，兼容中文，可以将数组转化为json数据格式。
*************************************************************/
function JSON($array) {
    arrayRecursive($array, 'urlencode', true);
    $json = json_encode($array);
    return urldecode($json);
}

/**
 * -默认当前时间
 */
function default_time($time){
	if(!$time){
		return date('Y-m-d',time());
	}else{
		return $time;
	}
}
/**
 * 简单对称加密算法之加密
 * @param String $string 需要加密的字串
 * @param String $skey 加密EKY
 * @author Anyon Zou <zoujingli@qq.com>
 * @date 2013-08-13 19:30
 * @update 2014-10-10 10:10
 * @return String
 */
function encode($string = '', $skey = 'xj_miaolin_boss') {
	$string = $string.'#'." *竴姝�:鎵撳紑鎴戠殑鐢";
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
 * @author Anyon Zou <zoujingli@qq.com>
 * @date 2013-08-13 19:30
 * @update 2014-10-10 10:10
 * @return String
 */
function decode($string = '', $skey = 'xj_miaolin_boss') {
	
    $strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $string), 2);
    $strCount = count($strArr);
    foreach (str_split($skey) as $key => $value)
        $key <= $strCount && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
    return explode('#',base64_decode(join('', $strArr)))[0];
}


/**
 * 另一类对称加密算法
 * @param string $data  需要加密的数据
 * @param string $key   加密密钥
 * @return string
 */
function encode1($data='', $key='gniCSOzZG+HnS9zcFea7SefNGhX')
{
    $key    =   md5($key);
    $x      =   0;
    $len    =   strlen($data);
    $l      =   strlen($key);
    for ($i = 0; $i < $len; $i++)
    {
    if ($x == $l)
    {
    $x = 0;
    }
        $char .= $key{$x};
        $x++;
    }
    for ($i = 0; $i < $len; $i++)
    {
    $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);
    }
    return base64_encode($str);
    }


    /**
     * 加密算法解密
     * @param string $data  需要加密数据
     * @param string $key   需要解密数据
     * @return string
     */
function decode1($data='', $key='gniCSOzZG+HnS9zcFea7SefNGhX')
    {
        $key = md5($key);
        $x = 0;
        $data = base64_decode($data);
        $len = strlen($data);
        $l = strlen($key);
        for ($i = 0; $i < $len; $i++)
        {
        	if ($x == $l)
      		{
        		$x = 0;
        	}
            $char .= substr($key, $x, 1);
            $x++;
        }
        for ($i = 0; $i < $len; $i++)
        {
       		if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1)))
        	{
        		$str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
       		}
        	else
        	{
        		$str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        	}
        }
         return $str;
    }
    /**
     * 阿里大鱼短信接口
     * @param $telphone                 接收短信的手机号
     * @param $params                   短信模版替换内容  （数组）
     * @param string $sign_name         短信模版名
     * @param string $template_code     短信模版ID
     * @return bool                     发送成功失败值
     */
//    function sendSMS($telphone, $params, $sign_name = '注册验证', $template_code = 'SMS_8085113') {
function sendSMS($telphone, $params, $sign_name = '工程部告警信息', $template_code = 'SMS_10370513') {
    $config = C('ALIDAYU_SETTING');
    vendor('Alidayu.Autoloader');
    $c = new \TopClient;
    $c->appkey = $config['ak'];
    $c->secretKey = $config['sk'];
    $req = new \AlibabaAliqinFcSmsNumSendRequest;
    $req->setSmsType("normal");
    $req->setSmsFreeSignName($sign_name);
    //创建随机数
//    $data = [
//        'code' => (string) mt_rand(1000, 9999),
//        'product' => '邓狗大傻逼',
//    ];
    $req->setSmsParam(json_encode($params));
    $req->setRecNum($telphone);
    $req->setSmsTemplateCode($template_code);
    $resp = $c->execute($req);
    if (isset($resp->result->success) && $resp->result->success) {
        return true;
    } else {
        return false;
    }
}
