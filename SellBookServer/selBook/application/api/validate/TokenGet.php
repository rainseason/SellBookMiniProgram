<?php
/**
 * Created by PhpStorm.
 * name: token验证器
 * User: xgguo1
 * Date: 2018/11/8
 * Time: 0:38
 */

namespace app\api\validate;


/**
 * 继承基类验证器
 */

class TokenGet extends BaseValidate
{
    /**
     * 验证规则
     * 必填而且是非空
     * @var array
     */
    protected $rule = [
        'code'=>'require|isNotEmpty'
    ];

    /**
     * 错误信息
     * @var array
     */
    protected $message = [
        'code' => '获取code失败，无法获取token'
    ];
}