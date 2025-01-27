<?php
/*
 * @Author: yumiazusa
 * @Date: 2023-02-26 10:53:07
 * @LastEditTime: 2025-01-27 18:55:53
 * @LastEditors: yumiazusa yumiazusa@hotmail.com
 * @Description: 学院年级班级模块控制器
 * @FilePath: /www/miledo/server/Modules/Students/Http/Controllers/v1/CollegeController.php
 * yumiazusa@hotmail.com
 */

namespace Modules\Students\Http\Controllers\v1;

use Modules\Admin\Http\Requests\CommonSortRequest;
use Modules\Students\Entities\Colle;
use Modules\Students\Http\Requests\ClassCreateRequest;
use Modules\Students\Http\Requests\ClassUpdateRequest;
use Modules\Students\Http\Requests\CollegeCreateRequest;
use Modules\Students\Http\Requests\CollegeUpdateRequest;
use Modules\Students\Http\Requests\CommonAffixRequest;
use Modules\Students\Http\Requests\CommonIdRequest;
use Modules\Students\Http\Requests\CommonIdTypeRequest;
use Modules\Students\Http\Requests\CommonStatusRequest;
use Modules\Students\Services\College\CollegeService;

class CollegeController extends BaseApiController
{
    /**
     * @name 列表数据
     * @description
     * @method  GET
     * @param  page Int 页码
     * @param  limit Int 每页条数
     * @param  status Int 状态:0=禁用,1=启用
     * @param  stdid Int 学号
     * @param  class_id Int 班级ID
     * @param  grade_id Int 年级ID
     * @param  project_id Int 项目ID
     * @param  sex Int 性别:0=未知,1=男，2=女
     * @param  created_at String 创建时间
     * @param  updated_at String 更新时间
     * @return JSON
     **/
    public function index()
    {
        return (new CollegeService())->index();
    }

    public function deleteList()
    {
        $delete = 1;
        return (new CollegeService())->index($delete);
    }

    /**
     * @name 添加
     * @description
     * @method  POST
     * @param  name String 姓名
     * @param  phone String 手机号
     * @param  password String 密码
     * @param  password_confirmation String 确认密码
     * @param  stdid Int 学号
     * @param  email String 邮箱
     * @param  class_id Int 班级ID
     * @param  grade_id Int 年级ID
     * @param  group_id Int 权限组
     * @param  project_id Int 项目ID
     * @param  status Int 状态:0=禁用,1=启用
     * @param  sex Int 性别:0=未知,1=男，2=女
     * @param  birth String 出生年月日
     * @return JSON
     **/
    public function store(CollegeCreateRequest $request)
    {
        return (new CollegeService())->store($request->only([
            'type',
            'title',
            'sort'
        ]));
    }

    public function classStore(ClassCreateRequest $request)
    {
        return (new CollegeService())->classStore($request->only([
            'name',
            'college_id',
            'department_id',
            'grade_id',
            'level_id',
            'sort'
        ]));
    }

    /**
     * @name 编辑页面
     * @description
     * @method  GET
     * @param  id Int 会员id
     * @return JSON
     **/
    public function edit(CommonIdTypeRequest $request)
    {
        return (new CollegeService())->edit($request->only(['id', 'type']));
    }


    /**
    *@name 编辑学院信息
    *@description 
    *@method POST
    *@param CollegeUpdateRequest $request 请求参数
    *@return JSON 
    **/ 
    public function colleUpdate(CollegeUpdateRequest $request)
    {
        return (new CollegeService())->update($request->get('type'), $request->only([
            'title',
            'id',
            'sort'
        ]));
    }

    /**
    * 更新班级记录到数据库中。
    * @param ClassUpdateRequest $request
    * 包含班级更新的输入数据的请求对象。
    * @return mixed
    * 班级更新操作的结果，由 CollegeService 类返回。
     */
    public function classUpdate(ClassUpdateRequest $request)
    {
        return (new CollegeService())->classUpdate($request->get('type'), $request->only([
            'name',
            'id',
            'college_id',
            'grade_id',
            'department_id',
            'level_id',
            'sort'
        ]));
    }

    /**
     * @name 调整状态
     * @description
     * @method  PUT
     * @param  id Int 会员id
     * @param  status Int 状态（0或1）
     * @return JSON
     **/
    public function status(CommonStatusRequest $request)
    {
        return (new CollegeService())->status($request->get('id'), $request->only(['status']));
    }

     /**
     * @name 调整排序
     * @description
     * @method  PUT
     * @param  id Int 会员id
     * @param  sort Int 排序
     * @return JSON
     **/
    public function collegeSorts(CommonSortRequest $request)
    {
        return (new CollegeService())->sorts($request->get('id'), $request->only(['sort','type']));
    }

     /**
     * @name 调整状态
     * @description
     * @method  PUT
     * @param  id Int 会员id
     * @param  status Int 状态（0或1）
     * @return JSON
     **/
    public function attr()
    {
        return (new CollegeService())->attr();
    }

    public function collegeAffix(CommonAffixRequest $request)
    {
        return (new CollegeService())->affix($request->get('id'), $request->only(['affix']));
    }

    public function deleteClass(CommonIdRequest $request){
        return (new CollegeService())->delete($request->get('id'),$request->only(['id']));
    }

    public function recycleClass(CommonIdRequest $request)
    {
        return (new CollegeService())->recycle($request->get('id'),$request->only(['id']));
    }

    public function realDestroy(CommonIdRequest $request)
    {
        return (new CollegeService())->realDestroy($request->get('id'),$request->only(['id']));
    }
}

