<?php

namespace Modules\Admin\Http\Controllers\v1;


use Modules\Admin\Http\Requests\LoginRequest;
use Modules\Admin\Services\auth\LoginService;
class LoginController extends BaseApiController
{
    /**
     * @name 用户登录
     * @date 2021/6/11 15:14
     * @method  POST
     * @param username String 账号
     * @param password String 密码
     * @return JSON
     **/
    public function login(LoginRequest $request)
    {
        return (new LoginService())->login($request->only(['username','password']));
    }
}
