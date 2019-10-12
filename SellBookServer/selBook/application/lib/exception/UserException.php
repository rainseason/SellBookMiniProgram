<?php
/**
 * Created by PhpStorm.
 * User: xgguo1
 * Date: 2018/11/28
 * Time: 15:24
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $errorCode = 400004;
    public $msg = '用户不存在！';

}