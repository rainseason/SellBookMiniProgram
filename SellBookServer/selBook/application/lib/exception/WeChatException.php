<?php
/**
 * Created by PhpStorm.
 * name: 自定义微信异常类
 * User: xgguo1
 * Date: 2018/11/8
 * Time: 12:24
 */

namespace app\lib\exception;


class WeChatException extends BaseException
{
    public $code = 400;
    public $msg = '微信服务器接口调用失败';
    public $errorCode = 999;

}