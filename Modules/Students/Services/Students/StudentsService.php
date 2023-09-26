<?php
/*
 * @Author: yumiazusa
 * @Date: 2023-02-27 16:32:04
 * @LastEditTime: 2023-05-13 09:47:18
 * @LastEditors: yumiazusa yumiazusa@hotmail.com
 * @Description: Students的服务类
 * @FilePath: /www/miledo/server/Modules/Students/Services/Students/StudentsService.php
 * yumiazusa@hotmail.com
 */

namespace Modules\Students\Services\Students;


use Modules\Students\Entities\Students;
use Modules\Students\Services\BaseApiService;
use Modules\Students\Entities\Colle;
use Modules\Students\Entities\College;
use Modules\Students\Entities\Department;
use Modules\Students\Entities\Grade;
use Modules\Students\Entities\Level;

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
        if (!empty($data['created_at'])){
            $model = $model->whereBetween('created_at',$data['created_at']);
        }
        if (!empty($data['updated_at'])){
            $model = $model->whereBetween('updated_at',$data['updated_at']);
        }
        if (!empty($data['name'])){
            $model = $model->where('students.name','like','%' . $data['name'] . '%');
        }
        if (!empty($data['stdid'])){
            $model = $model->where('students.stdid','like','%' . $data['stdid'] . '%');
        }
        if (isset($params['status']) && $params['status'] != ''){
            $model = $model->where('status',$params['status']);
        }
        if (isset($data['sex']) && $data['sex'] != ''){
            $model = $model->where('students.sex',$data['sex']);
        }
        if (isset($data['status']) && $data['status'] != ''){
            $model = $model->where(['students.status' => $data['status'],'cla.status'=> 1 ]);
        }
        if (isset($data['college']) && $data['college'] != ''){
            $model = $model->where(['college.id' => $data['college']]);
        }
        if (isset($data['grade']) && $data['grade'] != ''){
            $model = $model->where(['grade.id' => $data['grade']]);
        }
        if (isset($data['department']) && $data['department'] != ''){
            $model = $model->where(['department.id' => $data['department']]);
        }
        if (isset($data['level']) && $data['level'] != ''){
            $model = $model->where(['level.id' => $data['level']]);
        }
        if (isset($data['class']) && $data['class'] != ''){
            $model = $model->where(['cla.id' => $data['class']]);
        }
        $list = $model->join('class as cla', 'cla.id', '=', 'class_id')
        ->join('class_attribution as attr', 'attr.class_id', '=', 'cla.id')
        ->join('college', 'college.id', '=', 'attr.college_id')
        ->join('grade', 'grade.id', '=', 'attr.grade_id')
        ->join('department', 'department.id', '=', 'attr.department_id')
        ->join('level', 'level.id', '=', 'attr.level_id')
        ->where(['cla.is_delete'=> 0])
        ->select('students.*','cla.name as class_name','college.college','college.id as college_id', 'department.department', 'department.id as dep_id','grade.grade','grade.id as grade_id', 'level.level', 'level.id as level_id')
        ->orderBy('id','desc')
        ->paginate($data['limit'])
        ->toArray();

        $college = Colle::get()->toArray();
        $grade = Grade::get()->toArray();
        $department = Department::get()->toArray();
        $level = Level::get()->toArray();
        $class = College::where(['is_delete'=> 0])->get()->toArray();

        return $this->apiSuccess('',[
            'list'=>$list['data'],
            'total'=>$list['total'],
            'college'=>$college, 
            'grade'=>$grade, 
            'department'=>$department, 
            'level'=>$level,
            'class'=>$class
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
