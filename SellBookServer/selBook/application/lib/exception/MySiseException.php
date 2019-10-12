<?php
/**
 * Created by PhpStorm.
 * User: xgguo1
 * Date: 2018/11/18
 * Time: 13:30
 */

namespace app\lib\exception;


class MySiseException extends BaseException
{
    public $code = 400;
    public $msg = 'MySise接口调用异常！';
    public $errorCode = 100002;

}