<?php
/**
 * Created by PhpStorm.
 * name: user数据表模型类 处理简单业务逻辑
 * UserInfo: xgguo1
 * Date: 2018/11/8
 * Time: 1:07
 */

namespace app\api\model;


class UserInfo extends BaseModel
{
    public function items(){
        return $this->hasMany('GoodsItems','seller_id','user_id');
    }
    public static function getUserByOpenID($openid){
        $result = UserInfo::where('open_id','=',$openid)->find();
        return $result;
    }

    public static function getUserByStuId($stuid,$stupwd){
        $result = UserInfo::where('stu_id','=',$stuid)->where('stu_pwd','=',$stupwd)->find();
        return $result;
    }

}