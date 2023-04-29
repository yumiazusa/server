<?php
/*
 * @Author: yumiazusa
 * @Date: 2023-02-27 16:32:04
 * @LastEditTime: 2023-04-18 14:09:47
 * @LastEditors: yumiazusa yumiazusa@hotmail.com
 * @Description: Students的服务类
 * @FilePath: /www/miledo/server/Modules/Students/Services/Students/StudentsService.php
 * yumiazusa@hotmail.com
 */

namespace Modules\Students\Services\Students;


use Modules\Students\Entities\Students;
use Modules\Students\Services\BaseApiService;

class StudentsService extends BaseApiService
{
    /**
     * @name 列表
     * @description
     * @param  data Array 查询相关参数
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
    public function index(array $data)
    {
        $model = Students::query();
        $model = $this->queryCondition($model,$data,'nickname');
        if (isset($data['sex']) && $data['sex'] != ''){
            $model = $model->where('sex',$data['sex']);
        }
        $list = $model->orderBy('id','desc')
            ->paginate($data['limit'])
            ->toArray();
        return $this->apiSuccess('',[
            'list'=>$list['data'],
            'total'=>$list['total']
        ]);
    }

    /**
     * @name 添加
     * @description
     * @method  POST
     * @param  data Array 添加数据
     * @param  name String 姓名
     * @param  phone String 手机号
     * @param  password String 密码
     * @param  password_confirmation String 确认密码
     * @param  stdid Int 学号
     * @param  class_id Int 班级ID
     * @param  grade_id Int 年级ID
     * @param  group_id Int 权限组
     * @param  project_id Int 项目ID
     * @param  status Int 状态:0=禁用,1=启用
     * @param  sex Int 性别:0=未知,1=男，2=女
     * @param  birth String 出生年月日
     * @return JSON
     **/
    public function store(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        return $this->commonCreate(Students::query(),$data);
    }

    /**
     * @name 修改页面
     * @param  id Int 管理员id
     * @return JSON
     **/
    public function edit(int $id){
        return $this->apiSuccess('',Students::find($id)->toArray());
    }
    /**
     * @name 修改提交
     * @description
     * @param  data Array 修改数据
     * @param  daya.id Int 会员id
     * @param  name String 姓名
     * @param  phone String 手机号
     * @param  password String 密码
     * @param  password_confirmation String 确认密码
     * @param  stdid Int 学号
     * @param  class_id Int 班级ID
     * @param  grade_id Int 年级ID
     * @param  group_id Int 权限组
     * @param  project_id Int 项目ID
     * @param  status Int 状态:0=禁用,1=启用
     * @param  sex Int 性别:0=未知,1=男，2=女
     * @param  birth String 出生年月日
     * @return JSON
     **/
    public function update(int $id,array $data){
        return $this->commonUpdate(Students::query(),$id,$data);
    }
    /**
     * @name 调整状态
     * @description
     * @param  data Array 调整数据
     * @param  id Int 会员id
     * @return JSON
     * @param  data.status Int 状态（0或1）
     **/
    public function status(int $id,array $data){
        return $this->commonStatusUpdate(Students::query(),$id,$data);
    }
    /**
     * @name 初始化密码
     * @description
     * @param  id Int 会员id
     * @return JSON
     **/
    public function updatePwd(int $id){
        return $this->commonStatusUpdate(Students::query(),$id,['password'=>bcrypt(config('students.update_pwd'))],'密码初始化成功！','密码初始化失败，请重试！');
    }
}
