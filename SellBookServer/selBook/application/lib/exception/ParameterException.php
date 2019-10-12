<?php
/**
 * Created by PhpStorm.
 * name: 通用参数异常类
 * User: xgguo1
 * Date: 2018/11/8
 * Time: 19:38
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code=400 ;
    public $errorcode=1000;
    public $msg = 'invalid parameters';
}