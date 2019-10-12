<?php
/**
 * Created by PhpStorm.
 * User: xgguo1
 * Date: 2018/11/25
 * Time: 20:22
 */

namespace app\api\controller\v1;


use app\api\model\GoodsItems;
use app\api\model\GoodsType;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\MissException;

class Goods
{
    /**
     * id=1请求所有商品，根据type_id请求对应商品
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Collection|\think\Model
     * @throws MissException
     * @throws \app\lib\exception\ParameterException
     */
    public function getGoods($id){
        (new IDMustBePositiveInt())->goCheck();
        if ($id==1){
            $goods = GoodsType::getAllGoods();
        }else{
            $goods = GoodsType::getGoodsByTypeId($id);
        }
        if (!$goods){
            throw new MissException([
                'msg'=>'请求商品不存在！',
                'errorCode'=>40004
            ]);
        }
        return $goods;
    }


    /**
     * 遍历商品类型表
     * @return false|\PDOStatement|string|\think\Collection
     * @throws MissException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getGoodsType(){
        $list = GoodsType::getGoodsTypeList();
        if (!$list){
            throw new MissException([
                'msg'=>'请求商品类型异常！',
                'errorCode'=>40005
            ]);
        }
        return $list;

    }

    public function getHotsGoods(){
        $hots = GoodsItems::getGoodsByStatus();
        if (!$hots){
            throw new MissException([
                'msg'=>'请求商品类型异常！',
                'errorCode'=>40005
            ]);
        }
        return $hots;
    }

    public function getGoodsDetails($id){
        (new IDMustBePositiveInt())->goCheck();
        $goods = GoodsItems::getGoodsDetailsById($id);
        if (!$goods){
            throw new MissException([
                'msg'=>'请求商品不存在！',
                'errorCode'=>40004
            ]);
        }
        return $goods;
    }

}