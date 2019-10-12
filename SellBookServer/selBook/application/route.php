<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


use think\Route;

//定义测试路由
Route::rule('rtest','index/test/mytest');
//根据id返回商品，和全部商品
Route::get('api/v1/classify/goods','api/v1.Goods/getGoods');
//查询商品类型列表
Route::get('api/v1/classify/type','api/v1.Goods/getGoodsType');
//获取热门商品
Route::get('api/v1/classify/hots','api/v1.Goods/getHotsGoods');
//根据id返回商品详细信息
Route::get('api/v1/classify/details','api/v1.Goods/getGoodsDetails');
//上传商品图片
Route::Post('api/v1/upload/wxUpload','api/v1.Upload/wxUpload');
//发布商品
Route::post('api/v1/publish/goods','api/v1.Publish/publishGoods');

//http://www.lzx.cn/api/v1/token/user
Route::post('api/v1/token/user','api/v1.Token/getToken');

Route::post('api/v1/token/validate','api/v1.Token/isValidate');

Route::post('api/v1/userinfo/login','api/v1.UserInfo/getUserByStuId');


//return [
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
//
//];
