<?php
/**
 * Created by PhpStorm.
 * User: xgguo1
 * Date: 2018/11/20
 * Time: 11:26
 */

namespace app\api\model;


class GoodsType extends BaseModel
{
    protected $hidden = ['description'];

    /**
     * 关联goods_info表
     * 一对多
     * @return \think\model\relation\HasMany
     */
    public function goods(){
        return $this->hasMany('GoodsInfo','goods_type_id','goods_type_id');
    }

    public static function getGoodsTypeById($id){
        $goods = self::with(['goods','goods.images'])->find($id);
        return $goods;
    }

    public static function getAllGoodsDetails(){
        $goods = self::with(['goods','goods.images'])->where('goods_type_id','>','0')->select();
        return $goods;
    }
}