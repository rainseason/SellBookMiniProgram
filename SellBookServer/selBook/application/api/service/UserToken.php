<?php
/**
 * Created by PhpStorm.
 * name: 处理复杂的业务逻辑类
 * UserInfo: xgguo1
 * Date: 2018/11/8
 * Time: 1:11
 */

namespace app\api\service;


use app\api\model\UserInfo as UserInfoModel;
use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use think\Exception;
use think\Request;

class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSceret;
    protected $wxLoginUrl;

    /**
     * UserToken constructor.
     * @param $code
     */
    public function __construct($code)
    {
        $this->code = $code;
        $this->wxAppID = config('wx.app_id');//从配置文件中读取
        $this->wxAppSceret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'),$this->wxAppID,$this->wxAppSceret,$this->code);//sprintf()拼接字符串，填入占位符%s
    }

    /**
     * @param $code
     * @throws Exception
     */
    public function get(){
        $result = curl_get($this->wxLoginUrl);//请求微信服务器，openid,session_key返回字符串
        $wxResult = json_decode($result,true);//转换成数组对象

        if (empty($wxResult)){//请求异常 返回空
            throw new Exception('获取session_key和openID时异常，微信内部错误！');
        }else{
            //array_key_exists判断数组是否含有errcode
            $loginFail = array_key_exists('errcode',$wxResult);
            if ($loginFail){//请求失败 返回错误信息
                $this->processLoginError($wxResult);
            }else{//成功拿到openID
                $token = $this->grantToken($wxResult);
                return $token;
            }

        }
    }

    /**
     * 拿到openID 查询数据库是否已存在
     * 存在，不处理，不存在，插入一条记录
     * 生成令牌，准备缓存数据，写入缓存
     * 把令牌返回给小程序客户端
     * 写入缓存数据：
     * key:令牌
     * value:wxResult,uid,scope用户权限
     * @param $wxResult
     */
    public function grantToken($wxResult){
        $openid = $wxResult['openid'];
        $user = UserInfoModel::getUserByOpenID($openid);//根据openid数据库查询用户

        if ($user){//用户存在
            $uid = $user->user_id;//取出数据表中id
        }else{//插入用户
            $uid = $this->newUser($openid);//返回数据表id
        }
        //写入缓存 $cachedValue数组类型
        $cachedValue = $this->prepareCachedValue($wxResult,$uid);
        $token = $this->saveToCache($cachedValue);
        return $token;//返回令牌给客户端
    }

    /**
     * 请求失败，异常返回
     * @param $wxResult
     * @throws WeChatException
     */
    public function processLoginError($wxResult){
        throw new WeChatException([
            'msg' => $wxResult['errmsg'],
            'errorCode' => $wxResult['errcode'],
        ]);
    }

    /**
     * 从数据库中插入用户信息
     * @param $openid
     * @return mixed
     */
    private function newUser($openid){
        $request = Request::instance();
        $info_arr = json_decode($request->param()['rawData'],true);
        $nickName = $info_arr['nickName'];
        $avatarUrl = $info_arr['avatarUrl'];

        $user = UserInfoModel::create([//插入数据库函数
            'open_id'=>$openid,
            'user_name'=>$nickName,
            'avatar_url'=>$avatarUrl
        ]);
        return $user->user_id;
    }

    /**
     * 缓存前数据准备操作
     * @param $wxResult
     * @param $uid
     * @return mixed array
     */
    private function prepareCachedValue($wxResult,$uid){
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = 16;
        return $cachedValue;
    }

    /**
     * 存入缓存 返回令牌
     * @param $cachedValue
     * @return string
     * @throws TokenException
     */
    private function saveToCache($cachedValue){
        $key = self::generateToken();//生成令牌(在service中得token)
        $value = json_encode($cachedValue);//把数组转化成字符串，便于缓存
        $token_expire_in = config('setting.token_expire_in');//从配置文件中读取缓存过期时间

        $request = cache($key,$value,$token_expire_in);//键值过期时间 cache()存入缓存函数
        if (!$request){
            throw new TokenException([
                'msg'=>'服务器缓存异常',
                'errorCode'=>10005
            ]);
        }
        return $key;
    }
}