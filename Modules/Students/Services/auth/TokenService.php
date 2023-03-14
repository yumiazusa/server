<?php
/*
 * @Author: yumiazusa
 * @Date: 2023-03-14 23:33:28
 * @LastEditTime: 2023-03-14 23:37:00
 * @LastEditors: yumiazusa
 * @Description: 管理员信息服务
 * @FilePath: /www/miledo/server/Modules/Students/Services/auth/TokenService.php
 * yumiazusa@hotmail.com
 */


namespace Modules\Students\Services\auth;
use Modules\Students\Services\BaseApiService;
use Modules\Common\Exceptions\ApiException;
use Modules\Common\Exceptions\MessageData;
use Modules\Common\Exceptions\StatusData;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Facades\JWTAuth;

class TokenService extends BaseApiService
{
    /**
     * @name 设置token 生成机制
     * @description
     * @return JSON
     **/
    public function __construct()
    {
        \Config::set('auth.defaults.guard', 'auth_admin');
        \Config::set('jwt.ttl', 60);
    }
    /**
     * @name 设置token
     * @description
     * @param data  Array 用户信息
     * @param data.username String 账号
     * @param data.password String 密码$
     * @return JSON | Array
     **/
    public function setToken($data){
        if (! $token = JWTAuth::attempt($data)){
            $this->apiError('token生成失败');
        }
        return $this->respondWithToken($token);
    }
    /**
     * @name 刷新token
     * @description
     * @return JSON
     **/
    public function refreshToken()
    {
        try {
            $oldToken = JWTAuth::getToken();
            $token = JWTAuth::refresh($oldToken);
        }catch (TokenBlacklistedException $e) {
            // 这个时候是老的token被拉到黑名单了
            throw new ApiException(['status'=>StatusData::TOKEN_ERROR_BLACK,'message'=>MessageData::TOKEN_ERROR_BLACK]);
        }
        return $this->apiSuccess('', $this->respondWithToken($token));
    }
    /**
     * @name 管理员信息
     * @description
     * @return Array
     **/
    public function my():Object
    {
        return JWTAuth::parseToken()->touser();
    }
    /**
     * @name
     * @description
     * @method  GET
     * @param
     * @return JSON
     **/
    public function info()
    {
        $data = $this->my();
        return $this->apiSuccess('',['username'=>$data['username']]);
    }


    /**
     * @name 组合token数据
     * @description
     * @author 西安咪乐多软件
     * @date 2021/6/11 17:47
     * @return Array
     **/
    protected function respondWithToken($token):Array
    {
        return [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ];
    }


}
