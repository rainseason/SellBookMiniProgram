<?php
/**
 * Created by PhpStorm.
 * User: xgguo1
 * Date: 2018/11/20
 * Time: 14:36
 */

namespace app\api\validate;


class AddressNew extends BaseValidate
{
    protected $rule = [
        'address'=>'require|isNotEmpty',
        'tel'=>'require|length:11',
        'isdefault'=>'require|in:0,1',
        'address_id'=>'require',
        'true_name'=>'require'
    ];
//{"address":"广州","tel":"15692437733","isDefault":1,"address_id":2}
}