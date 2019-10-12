<?php
/**
 * Created by PhpStorm.
 * name: 导航栏控制器
 * User: xgguo1
 * Date: 2018/11/15
 * Time: 19:43
 */

namespace app\api\controller\v1;
use app\api\model\NavType as NavTypeModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\MissException;

class Nav
{
    public function getNav($id){
        $validate = new IDMustBePositiveInt();
        $validate->goCheck();
        $nav = NavTypeModel::getNavById($id);//两个模型，嵌套
        if (!$nav){
            throw new MissException([
                'msg'=>'请求nav不存在！',
                'errorCode'=>40000
            ]);
        }
        return $nav;
    }

}