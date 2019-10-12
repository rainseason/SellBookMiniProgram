<?php
/**
 * Created by PhpStorm.
 * User: xgguo1
 * Date: 2018/11/20
 * Time: 11:26
 */

namespace app\api\model;


class GoodsInfo extends BaseModel
{
    protected $hidden = ['state','image_id','goods_type_id'];

    /**
     * 关联image_info数据表
     * 一对一
     * @return \think\model\relation\HasOne
     */
    public function images(){
        return $this->hasOne('ImageInfo','image_id','image_id');
    }

}