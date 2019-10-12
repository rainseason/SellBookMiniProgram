<?php
/**
 * Created by PhpStorm.
 * User: xgguo1
 * Date: 2018/11/25
 * Time: 22:11
 */

namespace app\lib\exception;


class MissException extends BaseException
{
    public $code = 404;
    public $msg = '请求资源不存在！';
    public $errorCode = 404;

}