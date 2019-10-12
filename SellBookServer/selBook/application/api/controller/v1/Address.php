<?php
/**
 * Created by PhpStorm.
 * User: xgguo1
 * Date: 2018/11/20
 * Time: 14:34
 */

namespace app\api\controller\v1;

use app\api\model\UserInfo as UserInfoModel;
use app\api\service\Token as TokenService;
use app\api\validate\AddressDel;
use app\api\validate\AddressNew;
use app\lib\exception\ParameterException;
use app\lib\exception\SuccessMssage;
use app\lib\exception\UserException;
use think\Exception;

class Address
{

    /**
     * 根据token查询用户id
     * 根据用户id查询地址表所有信息并返回
     * @return false|\PDOStatement|string|\think\Collection
     * @throws UserException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function showAllAddressByUid(){
        $uid = TokenService::getCurrentUid();
        $user = UserInfoModel::get($uid);
        if (!$user){
            throw new UserException();
        }
        $res = $user->address()->where('address_id','>',0)->where('user_id','=',$uid)->select();
        return $res;
    }

    /**
     * 根据token查询用户id
     * 根据用户id和address_id删除地址表记录
     * @return SuccessMssage
     * @throws Exception
     * @throws ParameterException
     * @throws UserException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function delAddressByAddrId(){
        $validate = new AddressDel();
        $validate->goCheck();
        $uid = TokenService::getCurrentUid();
        $user = UserInfoModel::get($uid);
        $addressId = $validate->getDataByRule(input('post.'));
        if (!$user){
            throw new UserException();
        }
        $res = $user->address()->where('address_id','=',$addressId['address_id'])->where('user_id','=',$uid)->delete();
        if ($res==0){
            throw new Exception("address_id不存在,没有要删除的记录！");
        }
        return new SuccessMssage();
    }

    /**
     * 根据token令牌拿到uid
     * 根据uid查询用户是否存在
     * 执行更新或插入操作
     * @return SuccessMssage
     * @throws Exception
     * @throws ParameterException
     * @throws UserException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function createOrUpdateAddress(){
        $validate = new AddressNew();
        $validate->goCheck();
        $uid = TokenService::getCurrentUid();
        $user = UserInfoModel::get($uid);

        if (!$user){
            throw new UserException();
        }
        //获取传递过来的地址信息(数组)
        $dataArray = $validate->getDataByRule(input('post.'));
        $userAddress = $user->address;
        $addressId = $dataArray['address_id'];
        unset($dataArray['address_id']);
        if ($addressId==0){//新增记录
            $user->address()->save($dataArray);
        }else{
            $res = $user->address()->where('address_id','=',$addressId)->where('user_id','=',$uid)->update($dataArray);//根据用户id和address_id更新地址
            if ($res==0){
                throw new ParameterException([
                    'msg'=>'address_id参数有误！'
                ]);
            }
        }
        return new SuccessMssage();
    }
}