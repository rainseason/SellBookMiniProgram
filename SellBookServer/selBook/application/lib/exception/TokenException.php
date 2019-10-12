<?php
/**
 * Created by PhpStorm.
 * UserInfo: xgguo1
 * Date: 2018/11/10
 * Time: 0:03
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code = 401;
    public $msg = 'Token已过期或者无效Token';
    public $errorCode = 10001;

}