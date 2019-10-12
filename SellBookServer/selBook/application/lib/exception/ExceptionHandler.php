<?php
/**
 * Created by PhpStorm.
 * name: 自定义异常类处理 需在配置文件中配置
 * User: xgguo1
 * Date: 2018/11/8
 * Time: 20:10
 */

namespace app\lib\exception;


use Exception;
use think\exception\Handle;
use think\Request;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;

    public function render(Exception $e)
    {
        if ($e instanceof BaseException){
            //用户请求造成异常
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        }else{
            // 如果是服务器未处理的异常，将http状态码设置为500，并记录日志
            if(config('app_debug')){
                // 调试状态下需要显示TP默认的异常页面，因为TP的默认页面,便于调试
                return parent::render($e);
            }
            $this->code = 500;
            $this->msg = '服务器内部错误！';
            $this->errorCode = 999;
        }
        //请求成功！
        $request = Request::instance();
        $result = [
            'msg'=>$this->msg,
            'error_code'=>$this->errorCode,
            'request_url'=>$request->url()
        ];
        return json($result,$this->code);
    }


}