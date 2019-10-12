<?php
/**
 * Created by PhpStorm.
 * name: 请求资源为空异常类
 * User: xgguo1
 * Date: 2018/11/16
 * Time: 21:26
 */

namespace app\lib\exception;


class MissException extends BaseException
{
    public $code = 404;
    public $msg = '请求资源没找到！';
    public $errorCode = 404;
}