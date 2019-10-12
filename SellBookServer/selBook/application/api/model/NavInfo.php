<?php
/**
 * Created by PhpStorm.
 * User: xgguo1
 * Date: 2018/11/15
 * Time: 19:40
 */

namespace app\api\model;


class NavInfo extends BaseModel
{
    //设置隐藏字段
    protected $hidden = ['nav_id','images_id','nav_type_id','state'];

    /**
     * 关联images表
     * @return \think\model\relation\HasOne
     */
    public function images(){
        return $this->hasOne('ImageInfo','image_id','image_id');
    }

}