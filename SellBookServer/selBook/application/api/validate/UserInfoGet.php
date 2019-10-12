<?php
/**
 * Created by PhpStorm.
 * name: 检验学号位数
 * User: xgguo1
 * Date: 2018/11/17
 * Time: 11:16
 */

namespace app\api\validate;


class UserInfoGet extends BaseValidate
{
    //学号验证规则
    protected $rule = [
        'stuId'=>'require|length:10|number',
        'stuPwd'=>'require|isNotEmpty',
    ];

    protected $message = [
        'code'=>'学号或密码格式不正确！'
    ];

}