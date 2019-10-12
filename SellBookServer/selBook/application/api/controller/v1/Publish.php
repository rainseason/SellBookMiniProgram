<?php
/**
 * Created by PhpStorm.
 * User: xgguo1
 * Date: 2018/11/27
 * Time: 15:51
 */

namespace app\api\controller\v1;
use app\api\model\GoodsImage;
use app\api\model\GoodsItems;
use app\api\service\Token as TokenService;
use app\api\model\UserInfo as UserInfoModel;
use app\api\validate\PublishGoods;
use app\lib\exception\UserException;
use think\Exception;
use think\Request;

class Publish
{
    public function publishGoods(){
        (new PublishGoods())->goCheck();
        $uid = TokenService::getUidByToken();
        $user = UserInfoModel::get($uid);
//        用户不存在
        if (!$user){
            throw new UserException();
        }

        $request = Request::instance();
        $data = $request->param();
        $imageUrls = json_decode($data['images'],true);
        unset($data['images']);
        $data['seller_id']=$uid;
        try{
            $items = $user->items()->save($data);
            foreach ($imageUrls as $key => $value){
                $imageUrls[$key]['goods_id'] = $items['goods_id'];
            }
            $image = new GoodsImage();
            $res = $image->saveAll($imageUrls);
        }catch (Exception $e){
            return json($e->getMessage());
        }

        return [
            'code'=>200,
            'msg'=>'发布成功！'
        ];
    }

}