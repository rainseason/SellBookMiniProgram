<?php
/**
 * Created by PhpStorm.
 * name: 基类验证器 继承tp5验证器
 * UserInfo: xgguo1
 * Date: 2018/11/8
 * Time: 0:42
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    /**
     * 获取http传入的参数
     * 对参数校验
     * @return bool
     */

    public function goCheck()
    {
        $request = Request::instance();//实例化请求对象
        $params = $request->param();//获取全部请求参数
        $result = $this->batch()->check($params);//batch()批量验证
        if (!$result){//抛出参数错误异常
            $e = new ParameterException([
                'msg'=>$this->error,
            ]);
            throw $e;
        }else{//验证通过
            return true;
        }
    }

    /**
     * 验证是否为正整数
     * isPositiveInterger
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $field
     * @return bool
     */

    protected function isPositiveInteger($value,$rule='',$data = '',$field = ''){
        if (is_numeric($value)&&is_int($value+0)&&($value+0)>0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * isNotEmpty
     * @param $value
     * @param string $rule
     * @param string $data
     * @param string $field
     * @return bool
     */

    protected function isNotEmpty($value,$rule = '',$data = '',$field = ''){
        if (empty($value)){
            return false;
        }else{
            return true;
        }
    }

}