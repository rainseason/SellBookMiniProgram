<?php
/**
 * Created by PhpStorm.
 * User: xgguo1
 * Date: 2018/11/27
 * Time: 16:10
 */

namespace app\api\validate;


class PublishGoods extends BaseValidate
{
    protected $rule = [
        'goods_authors'=>'require|max:20',
        'goods_price'=>'require|number',
        'goods_desc'=>'require',
        'goods_isbn'=>'require',
        'goods_name'=>'require|max:30',
        'goods_publisher'=>'max:20',
        'goods_storage'=>'require|number',
        'type_id'=>'require|number',

    ];

    protected $message = [
        'code'=>'发布失败，提交参数不符合要求！'
    ];

}