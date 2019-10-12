<?php
/**
 * Created by PhpStorm.
 * User: xgguo1
 * Date: 2018/11/25
 * Time: 20:25
 */

namespace app\api\model;


class GoodsType extends BaseModel
{
    public $hidden = ['type_desc','add_time','update_time'];

    /**
     * 关联goods_items数据表
     * @return \think\model\relation\HasMany
     */
    public function items(){
        return $this->hasMany('GoodsItems','type_id','type_id');
    }

    /**
     * 根据type_id查找商品
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getGoodsByTypeId($id){
        $goods = self::with(['items','items.images'])->find($id);
        return $goods;
    }

    /**
     * 遍历商品类型数据表
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getGoodsTypeList(){
        $list = self::where('type_id','>','0')->select();
        return $list;
    }

    public static function getAllGoods(){
        $goods = self::with(['items','items.images'])->where('type_id','>','0')->select();
        return $goods;
    }

}