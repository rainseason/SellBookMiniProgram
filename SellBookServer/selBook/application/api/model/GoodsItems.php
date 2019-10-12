<?php
/**
 * Created by PhpStorm.
 * User: xgguo1
 * Date: 2018/11/25
 * Time: 20:24
 */

namespace app\api\model;


class GoodsItems extends BaseModel
{
    protected $hidden = ['goods_status','seller_id','type_id','add_time','update_time'];

    public function images(){
        return $this->hasMany('GoodsImage','goods_id','goods_id');
    }

    public static function getGoodsByStatus(){
        $goods = self::with('images')->where('goods_status','=','2')->select();
        return $goods;
    }

    public static function getGoodsDetailsById($id){
        $goods = self::with('images')->find($id);
        return $goods;
    }
}