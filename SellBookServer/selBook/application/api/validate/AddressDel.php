<?php
/**
 * Created by PhpStorm.
 * User: xgguo1
 * Date: 2018/11/21
 * Time: 16:55
 */

namespace app\api\validate;


class AddressDel extends BaseValidate
{
    protected $rule = [
        'address_id' => 'require|isPositiveInteger'
    ];

    protected $message = [
        'address_id'=>'address_id必须为整数，并且非空！'
    ];
}