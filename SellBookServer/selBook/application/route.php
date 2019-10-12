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

//http://www.lzx.cn/api/v1/user?id=1
Route::get('api/v1/user','api/v1.User/getUser');

Route::get('api/v1/nav','api/v1.Nav/getNav');

Route::get('api/v1/type','api/v1.Goods/getGoods');

Route::post('api/v1/caddress','api/v1.Address/createOrUpdateAddress');

Route::post('api/v1/saddress','api/v1.Address/showAllAddressByUid');

Route::post('api/v1/daddress','api/v1.Address/delAddressByAddrId');

Route::get('api/v1/goods','api/v1.Goods/getAllGoods');

//http://www.lzx.cn/api/v1/token/user
Route::post('api/v1/token/user','api/v1.Token/getToken');


