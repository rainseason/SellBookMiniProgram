<?php
/**
 * Created by PhpStorm.
 * name: 获取令牌token控制器
 * UserInfo: xgguo1
 * Date: 2018/11/8
 * Time: 0:35
 */

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\validate\TokenGet;

class Token
{
    public function getToken($code=''){
        (new TokenGet())->goCheck();//匿名对象调用验证器验证
        $ut = new UserToken($code);//实例化
        $token = $ut->get();//调用get方法获取token令牌
        return [
            'token'=>$token
        ];
    }

    public function isValidate(){
        $res = \app\api\service\Token::validateToken();
        if ($res){
            return [
                'code'=>200,
                'msg'=>'ok'
            ];
        }
    }

}