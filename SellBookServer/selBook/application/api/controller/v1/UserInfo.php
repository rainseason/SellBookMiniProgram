<?php
/**
 * Created by PhpStorm.
 * UserInfo: xgguo1
 * Date: 2018/11/8
 * Time: 22:57
 */

namespace app\api\controller\v1;

use app\api\service\Token;
use app\api\service\UserInfoDeal;
use app\api\validate\UserInfoGet;


class UserInfo
{
    public function getUserByStuId($stuId='',$stuPwd=''){
        (new UserInfoGet())->goCheck();
        $uid = Token::getUidByToken();
        $uid = (int)$uid;
        $user = new UserInfoDeal($stuId,$stuPwd,$uid);
        $result = $user->get();
        if($result){
            return [
                'code'=>200,
                'msg'=>'ok'
            ];
        }
    }
}