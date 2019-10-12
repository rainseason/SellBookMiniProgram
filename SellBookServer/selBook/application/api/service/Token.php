<?php
/**
 * Created by PhpStorm.
 * 令牌逻辑处理基类
 * UserInfo: xgguo1
 * Date: 2018/11/9
 * Time: 22:26
 */

namespace app\api\service;


use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    /**
     * 生成令牌函数
     * @return string
     */
    public static function generateToken(){
        //32位数字组成无意义得随机字符串
        $randChars = getRandChar(32);//getRandChar()通用，所以放common.php
        //三组字符串进行md5加密
        $timestamp = $_SERVER['REQUEST_TIME'];
        //salt 盐加密 从配置文件读取
        $salt = config('secure.token_salt');

        return md5($randChars.$timestamp.$salt);
    }

    public static function validateToken(){
        $request = Request::instance();
        $token = $request->param()['token'];
        $res = Cache::get($token);
        if (!$res){
            throw new TokenException();
        }else{
            return true;
        }
    }

    public static function getUidByToken(){
        $uid = self::getUserInfoByVar('uid');
        return $uid;
    }

    public static function getUserInfoByVar($key){
        $request = Request::instance();
        $token = $request->header('token');//从头部获取token
        $res = Cache::get($token);
        if (!$res){//获取失败
            throw new TokenException();
        }else{
            if (!is_array($res)){
                $res = json_decode($res,true);
            }
            if (array_key_exists($key,$res)){
                return $res[$key];
            }else{
                throw new Exception("根据token获取的变量不存在！");
            }
        }

    }
}