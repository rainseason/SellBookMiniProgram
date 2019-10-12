<?php
/**
 * Created by PhpStorm.
 * name: 用户控制器
 * User: xgguo1
 * Date: 2018/11/8
 * Time: 22:57
 */

namespace app\api\controller\v1;

use \app\api\model\UserInfo as UserInfoModel;


class User
{
    public function getUser($id){
        $user = UserInfoModel::getUserByOpenID($id);
    }

}