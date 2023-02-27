<?php
/*
 * @Author: yumiazusa
 * @Date: 2023-02-27 16:23:27
 * @LastEditTime: 2023-02-27 16:24:24
 * @LastEditors: yumiazusa
 * @Description: Students的控制器基类
 * @FilePath: /www/miledo/server/Modules/Students/Http/Controllers/v1/BaseApiController.php
 * yumiazusa@hotmail.com
 */

/**
 * @Name 当前模块控制器基类
 * @Description
 */

namespace Modules\Students\Http\Controllers\v1;


use Modules\Common\Controllers\BaseController;

class BaseApiController extends BaseController
{
    public function __construct(){
        parent::__construct();
    }
}
