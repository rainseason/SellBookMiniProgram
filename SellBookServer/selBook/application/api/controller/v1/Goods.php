<?php
/**
 * Created by PhpStorm.
 * User: xgguo1
 * Date: 2018/11/20
 * Time: 11:25
 */

namespace app\api\controller\v1;


use app\api\model\GoodsType;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\MissException;

class Goods
{
    /**
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws MissException
     * @throws \app\lib\exception\ParameterException
     */
    public function getGoods($id){
        $validate = new IDMustBePositiveInt();
        $validate->goCheck();
        $goods = GoodsType::getGoodsTypeById($id);
        if (!$goods){
            throw new MissException([
                'msg'=>'请求商品不存在！',
                'errorCode'=>'400003'
            ]);
        }
        return $goods;
    }

    public function getAllGoods(){
        $goods = GoodsType::getAllGoodsDetails();
        if (!$goods){
            throw new MissException([
                'msg'=>'请求商品不存在！',
                'errorCode'=>40004
            ]);
        }
        return $goods;
    }

}