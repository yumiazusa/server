<?php
/*
 * @Author: yumiazusa
 * @Date: 2023-02-27 17:08:57
 * @LastEditTime: 2023-02-27 17:28:39
 * @LastEditors: yumiazusa
 * @Description: 学生权限验证中间件
 * @FilePath: /www/miledo/server/Modules/Students/Http/Middleware/StudentsApiAuth.php
 * yumiazusa@hotmail.com
 */

namespace Modules\Students\Http\Middleware;

use Closure;
use Modules\Students\Services\log\OperationLogService;
use Modules\Common\Exceptions\ApiException;
use Modules\Common\Exceptions\MessageData;
use Modules\Common\Exceptions\StatusData;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use JWTAuth;

class StudentsApiAuth
{

    public function handle($request, Closure $next)
    {
        \Config::set('auth.defaults.guard', 'auth_admin');
        \Config::set('jwt.ttl', 60);
        $route_data = $request->route();
        $url = str_replace($route_data->getAction()['prefix'] . '/',"",$route_data->uri);
        $url_arr = ['login/login','index/getMain','index/refreshToken'];
        $api_key = $request->header('apikey');
        if($api_key != config('admin.api_key')){
            throw new ApiException(['status'=>StatusData::TOKEN_ERROR_KEY,'message'=>MessageData::TOKEN_ERROR_KEY]);
            return $next();
        }
        if(in_array($url,$url_arr)){
            return $next($request);
        }
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {  //获取到用户数据，并赋值给$user   'msg' => '用户不存在'
                throw new ApiException(['status'=>StatusData::TOKEN_ERROR_SET,'message'=>MessageData::TOKEN_ERROR_SET]);
                return $next();
            }

        }catch (TokenBlacklistedException $e) {
            // 这个时候是老的token被拉到黑名单了
            throw new ApiException(['status'=>StatusData::TOKEN_ERROR_BLACK,'message'=>MessageData::TOKEN_ERROR_BLACK]);
            return $next();
        } catch (TokenExpiredException $e) {
            //token已过期
            throw new ApiException(['status'=>StatusData::TOKEN_ERROR_EXPIRED,'message'=>MessageData::TOKEN_ERROR_EXPIRED]);
            return $next();
        } catch (TokenInvalidException $e) {
            //token无效

            throw new ApiException(['status'=>StatusData::TOKEN_ERROR_JWT,'message'=>MessageData::TOKEN_ERROR_JWT]);

            return $next();
        } catch (JWTException $e) {
            //'缺少token'
            throw new ApiException(['status'=>StatusData::TOKEN_ERROR_JTB,'message'=>MessageData::TOKEN_ERROR_JTB]);
            return $next();
        }
        // 写入日志
        (new OperationLogService())->store($user['id']);
//        if(!in_array($url,['auth/index/refresh','auth/index/logout'])){
//            if($user['id'] != 1 && $id = AuthRuleModel::where(['href'=>$url])->value('id')){
//                $rules = AuthGroupModel::where(['id'=>$user['group_id']])->value('rules');
//                if(!in_array($id,explode('|',$rules))){
//                    throw new ApiException(['code'=>6781,'msg'=>'您没有权限！']);
//                }
//            }
//        }
        return $next($request);
    }
}
