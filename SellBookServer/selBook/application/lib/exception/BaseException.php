<?php
/**
 * Created by PhpStorm.
 * name: 自定义异常类基类
 * User: xgguo1
 * Date: 2018/11/8
 * Time: 12:26
 */

namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception
{
    public $code = 400;
    public $msg = 'invalid parameters';
    public $errorCode = 999;

    public $shouldToClient = true;

    /**
     * 构造函数统一初始化
     * BaseException constructor.
     * @param array $params
     */
    public function __construct($params = [])
    {
        if (!is_array($params)){//参数不是数组，直接返回
            return;
        }
        if (array_key_exists('code',$params)){
            $this->code = $params['code'];
        }
        if (array_key_exists('msg',$params)){
            $this->msg = $params['msg'];
        }
        if (array_key_exists('errorCode',$params)){
            $this->errorCode = $params['errorCode'];
        }
    }
}

