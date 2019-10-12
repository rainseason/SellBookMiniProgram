<?php
/**
 * Created by PhpStorm.
 * name: 处理用户登录mysise业务类
 * User: xgguo1
 * Date: 2018/11/17
 * Time: 14:30
 */

namespace app\api\service;


use app\api\model\UserInfo;
use app\lib\exception\MySiseException;

class UserInfoDeal extends Token
{
    protected $stuid;
    protected $stupwd;
    protected $uid;
    protected $loginUrl;

    public function __construct($stuid,$stupwd,$uid)
    {
        $this->stuid = $stuid;
        $this->stupwd = $stupwd;
        $this->uid = $uid;
        $this->loginUrl=sprintf(config('sise.login_url'),$this->stuid,$this->stupwd);
    }

    /**
     * 处理登录业务逻辑
     */
    public function get(){
        $user = UserInfo::getUserByStuId($this->stuid,$this->stupwd);//根据学号密码从数据库中查找
        if ($user){//有记录
//            var_dump($user->user_id);
            return true;
        }else{//无记录
            $result = curl_get($this->loginUrl);//模拟登录mysise系统
            $result_json = json_decode($result,true);
            if ($result_json){
                $new_arr = $this->prettyArray($result_json);
//                $user = UserInfo::create($new_arr);//向用户表插入数据
                $user = UserInfo::where('user_id','=',$this->uid)->update($new_arr);
                return $user;
            }else{
                throw new MySiseException([
                    'msg'=>'调用mysise接口失败！',
                    'errorCode'=>403
                ]);
            }
        }
    }

    /**
     * 拼凑用户信息成数组
     * @param $key_arr
     * @param $value_arr
     * @return array
     */
    public function prettyArray($value_arr){
        $key_arr = ['stu_major','true_name','stu_id','stu_grade','head_teacher','e_mail','stu_class','cart_id','stu_instructor'];
        $new_value = [];
        foreach ($value_arr as $value){
            array_push($new_value,$value);
        }
        $new_arr = array_combine($key_arr,$value_arr);
        $new_arr['stu_pwd']=$this->stupwd;
        return $new_arr;
    }

}