<?php
/*
 * @Author: yumiazusa yumiazusa@hotmail.com
 * @Date: 2023-02-13 15:49:16
 * @LastEditors: yumiazusa
 * @LastEditTime: 2023-02-20 22:40:05
 * @FilePath: /www/miledo/server/Modules/BlogApi/Http/Controllers/v1/IndexController.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
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

namespace Modules\BlogApi\Http\Controllers\v1;


use Illuminate\Http\Request;
use Modules\BlogApi\Http\Requests\CommonPageRequest;
use Modules\BlogApi\Services\article\ArticleService;
use Modules\BlogApi\Services\articleType\ArticleTypeService;
use Modules\BlogApi\Services\pic\PicService;

class IndexController extends BaseApiController
{
    /**
     * @name
     * @description
     * @author 西安咪乐多软件
     * @date 2021/7/16 14:45
     * @method  GET
     * @param
     * @return JSON
     **/
    public function typeList(){
        return (new ArticleTypeService())->typeList();
    }
    /**
     * @name 图片列表
     * @description
     * @author 西安咪乐多软件
     * @date 2021/7/21 3:59
     * @method  GET
     * @param  type  Int  类型:0=首页轮播图
     * @return JSON
     **/
    public function bannerList(Request $request){
        return (new PicService)->bannerList($request->get('type'));
    }

    /**
     * @name 文章列表
     * @description
     * @author 西安咪乐多软件
     * @date 2021/7/21 4:17
     * @method  GET
     * @param  id  Int 文章分类  一级id
     * @param  type_id INt  文章分类二级id
     * @param  title  String   文章标题模糊查询
     * @param  page Int 页码
     * @param  limit Int 每页条数
     * @return JSON
     **/
    public function articleList(CommonPageRequest $request){
        return (new ArticleService())->articleList($request->only([
            'id',
            'type_id',
            'title',
            'page',
            'limit',
            'open'
        ]));
    }

    /**
     * @name 推荐文章列表
     * @description
     * @author 西安咪乐多软件
     * @date 2021/7/21 4:59
     * @method  GET
     * @return JSON
     **/
    public function openArticleList(){
        return (new ArticleService())->openArticleList();
    }
}
