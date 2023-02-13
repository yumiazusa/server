<?php
// +----------------------------------------------------------------------
// | Name: 咪乐多管理系统 [ 为了快速搭建软件应用而生的，希望能够帮助到大家提高开发效率。 ]
// +----------------------------------------------------------------------
// | Copyright: (c) 2020~2021 https://www.lvacms.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed: 这是一个自由软件，允许对程序代码进行修改，但希望您留下原有的注释。
// +----------------------------------------------------------------------
// | Author: 西安咪乐多软件 <997786358@qq.com>
// +----------------------------------------------------------------------
// | Version: V1
// +----------------------------------------------------------------------

/**
 * @Name 博客首页相关接口
 * @Description
 * @Auther 西安咪乐多软件
 * @Date 2021/7/16 14:30
 */

namespace Modules\Test\Http\Controllers;



use Illuminate\Http\Request;
use Modules\Test\Http\Controllers\BaseApiController;
use Modules\Test\Services\articleType\ArticleTypeService;

class IndexController extends BaseApiController
{
   public function typeList(){
        return  (new ArticleTypeService())->typeList();
   }
}
