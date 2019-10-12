<?php
/**
 * Created by PhpStorm.
 * User: xgguo1
 * Date: 2018/11/25
 * Time: 20:29
 */

namespace app\api\validate;


class IDMustBePositiveInt extends BaseValidate
{
    protected $rule = [
        'id'=>'require|isPositiveInteger'
    ];

    protected $message = [
        'id' => 'id必须为整数，并且非空！'
    ];

}