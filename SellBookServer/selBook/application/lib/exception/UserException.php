<?php
/**
 * Created by PhpStorm.
 * User: xgguo1
 * Date: 2018/11/20
 * Time: 15:12
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $errorCode = 400004;
    public $msg = '用户不存在！';

}