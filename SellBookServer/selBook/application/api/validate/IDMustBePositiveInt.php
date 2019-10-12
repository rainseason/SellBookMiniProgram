<?php
/**
 * Created by PhpStorm.
 * User: xgguo1
 * Date: 2018/11/16
 * Time: 21:09
 */

namespace app\api\validate;


class IDMustBePositiveInt extends BaseValidate
{
    protected $rule = [
        'id'=>'require|isPositiveInteger',
        ];
    protected $message = [
        'id' => 'id必须为整型，且非空！'
    ];
}