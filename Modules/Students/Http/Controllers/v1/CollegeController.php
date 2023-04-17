<?php
/*
 * @Author: yumiazusa
 * @Date: 2023-02-26 10:53:07
 * @LastEditTime: 2023-04-07 12:16:31
 * @LastEditors: yumiazusa yumiazusa@hotmail.com
 * @Description: 学院年级班级模块控制器
 * @FilePath: /www/miledo/server/Modules/Students/Http/Controllers/v1/StudentsController.php
 * yumiazusa@hotmail.com
 */

namespace Modules\Students\Http\Controllers\v1;

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

    //  /**
    //  * @name 添加
    //  * @description
    //  * @method  POST
    //  * @param  name String 姓名
    //  * @param  phone String 手机号
    //  * @param  password String 密码
    //  * @param  password_confirmation String 确认密码
    //  * @param  stdid Int 学号
    //  * @param  email String 邮箱
    //  * @param  class_id Int 班级ID
    //  * @param  grade_id Int 年级ID
    //  * @param  group_id Int 权限组
    //  * @param  project_id Int 项目ID
    //  * @param  status Int 状态:0=禁用,1=启用
    //  * @param  sex Int 性别:0=未知,1=男，2=女
    //  * @param  birth String 出生年月日
    //  * @return JSON
    //  **/
    // public function store(StudentsCreateRequest $request)
    // {
    //     return (new StudentsService())->store($request->only([
    //         'name',
    //         'phone',
    //         'email',
    //         'password',
    //         'stdid',
    //         'class_id',
    //         'grade_id',
    //         'project_id',
    //         'status',
    //         'sex',
    //         'birth',
    //     ]));
    // }

    //  /**
    //  * @name 编辑页面
    //  * @description
    //  * @method  GET
    //  * @param  id Int 会员id
    //  * @return JSON
    //  **/
    // public function edit(CommonIdRequest $request)
    // {
    //     return (new StudentsService())->edit($request->get('id'));
    // }
    // /**
    //  * @name 编辑提交
    //  * @description
    //  * @author 西安咪乐多软件
    //  * @date 2021/6/14 9:01
    //  * @method  PUT
    //  * @param  id Int 会员id
    //  * @param  name String 姓名
    //  * @param  phone String 手机号
    //  * @param  password String 密码
    //  * @param  password_confirmation String 确认密码
    //  * @param  stdid Int 学号
    //  * @param  email String 邮箱
    //  * @param  class_id Int 班级ID
    //  * @param  grade_id Int 年级ID
    //  * @param  group_id Int 权限组
    //  * @param  project_id Int 项目ID
    //  * @param  status Int 状态:0=禁用,1=启用
    //  * @param  sex Int 性别:0=未知,1=男，2=女
    //  * @param  birth String 出生年月日
    //  * @return JSON
    //  **/
    // public function update(StudentsUpdateRequest $request)
    // {
    //     return (new StudentsService())->update($request->get('id'),$request->only([
    //         'name',
    //         'phone',
    //         'email',
    //         'stdid',
    //         'class_id',
    //         'grade_id',
    //         'project_id',
    //         'status',
    //         'sex',
    //         'birth',
    //     ]));
    // }

    //  /**
    //  * @name 调整状态
    //  * @description
    //  * @method  PUT
    //  * @param  id Int 会员id
    //  * @param  status Int 状态（0或1）
    //  * @return JSON
    //  **/
    // public function status(CommonStatusRequest $request)
    // {
    //     return (new StudentsService())->status($request->get('id'),$request->only(['status']));
    // }

    // /**
    //  * @name 修改会员密码
    //  * @description
    //  * @method  PUT
    //  * @param  y_password String 原密码
    //  * @param  password String 密码
    //  * @param  password_confirmation String 确认密码
    //  * @return JSON
    //  **/
    // public function changePwd(PwdRequest $request)
    // {
    //     return (new UpdatePasswordService())->upadtePwd($request->only(['id','y_password','password']));
    // }

    //  /**
    //  * @name 初始化密码
    //  * @description
    //  * @method  PUT
    //  * @param  id Int 会员id
    //  * @return JSON
    //  **/
    // public function updatePwd(CommonIdRequest $request)
    // {
    //     return (new StudentsService())->updatePwd($request->get('id'));
    // }
       
}
