<?php
/**
 * Created by PhpStorm.
 * User: xgguo1
 * Date: 2018/11/15
 * Time: 19:41
 */

namespace app\api\model;


class NavType extends BaseModel
{
    /**
     * 关联navinfo表
     * @return \think\model\relation\HasMany
     */
    public function items(){
        return $this->hasMany('NavInfo','nav_type_id','nav_type_id');
    }

    /**
     * 根据id获取导航栏信息
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getNavById($id){
        //with('items')一个模型
        $nav = self::with(['items','items.images'])->find($id);//两个模型，嵌套
        return $nav;
    }

}