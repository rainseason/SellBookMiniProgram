<?php
/**
 * Created by PhpStorm.
 * User: xgguo1
 * Date: 2018/11/15
 * Time: 19:42
 */

namespace app\api\model;


use think\Model;

class ImageInfo extends Model
{
    protected $hidden = ['image_id','goods_id','nav_id'];

}