<?php
/*
 * @Author: yumiazusa
 * @Date: 2023-02-26 10:53:07
 * @LastEditTime: 2023-02-27 17:05:42
 * @LastEditors: yumiazusa
 * @Description: 学生模块控制器
 * @FilePath: /www/miledo/server/Modules/Students/Http/Controllers/v1/StudentsController.php
 * yumiazusa@hotmail.com
 */

namespace Modules\Students\Http\Controllers\v1;

use Modules\Students\Http\Requests\CommonPageRequest;
use Modules\Students\Services\students\StudentsService;

class StudentsController extends BaseApiController
{
     /**
     * @name 列表数据
     * @description
     * @author 西安咪乐多软件
     * @date 2021/6/14 8:33
     * @method  GET
     * @param  page Int 页码
     * @param  limit Int 每页条数
     * @param  nickname String 昵称
     * @param  status Int 状态:0=禁用,1=启用
     * @param  province_id Int 省ID
     * @param  city_id Int 市ID
     * @param  county_id Int 区县ID
     * @param  sex Int 性别:0=未知,1=男，2=女
     * @param  created_at String 创建时间
     * @param  updated_at String 更新时间
     * @return JSON
     **/
    public function index(CommonPageRequest $request)
    {
        return (new StudentsService())->index($request->only([
            'page',
            'limit',
            'nickname',
            'status',
            'created_at',
            'updated_at',
            'province_id',
            'city_id',
            'county_id',
            'sex'
        ]));
    }
       
}
