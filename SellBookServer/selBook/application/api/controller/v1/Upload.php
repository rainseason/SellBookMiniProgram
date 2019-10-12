<?php
/**
 * Created by PhpStorm.
 * User: xgguo1
 * Date: 2018/11/27
 * Time: 13:36
 */

namespace app\api\controller\v1;
use app\api\service\Token as TokenService;


use think\Request;

class Upload
{
    public function wxUpload()
    {
        $file = request()->file('file');//接收上传图片
        if ($file) {
            $info = $file->move(ROOT_PATH.'public'.DS.'public/uploads/index/images');//保存图片
            if ($info) {
                $res = [
                    'code'=>200,
                    'msg'=>'上传成功!',
                    'url'=>$info->getSaveName()
                ];
                return $res;
            }else{
                return [
                    'msg'=>$file->getError(),
                    'code'=>400005
                ];
            }
        }
        return [
            'code'=>400004,
            'msg'=>'你没有上传图片！'
        ];
    }

}