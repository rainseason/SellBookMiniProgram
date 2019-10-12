<?php
/**
 * Created by PhpStorm.
 * name: user_info数据表模型类 处理简单业务逻辑
 * User: xgguo1
 * Date: 2018/11/8
 * Time: 1:07
 */

namespace app\api\model;


class UserInfo extends BaseModel
{
    /**
     * 关联地址表
     * @return \think\model\relation\HasMany
     */
    public function address(){
        return $this->hasMany('AddressInfo','user_id','user_id');
    }

    public static function getUserByOpenID($openid){
        $result = UserInfo::where('open_id','=',$openid)->find();
        return $result;
    }
}