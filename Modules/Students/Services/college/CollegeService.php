<?php
/*
 * @Author: yumiazusa yumiazusa@hotmail.com
 * @Date: 2023-03-21 13:30:59
 * @LastEditors: yumiazusa yumiazusa@hotmail.com
 * @LastEditTime: 2023-05-13 11:26:57
 * @FilePath: /www/miledo/server/Modules/Students/Services/college/CollegeService.php
 * @Description: 学院年级班级管理服务
 */


namespace Modules\Students\Services\College;

use Modules\Common\Exceptions\MessageData;
use Modules\Students\Entities\ClassAttribution;
use Modules\Students\Entities\College;
use Modules\Students\Entities\Colle;
use Modules\Students\Entities\Department;
use Modules\Students\Entities\Grade;
use Modules\Students\Entities\Level;
use Modules\Students\Services\BaseApiService;

class CollegeService extends BaseApiService
{

    /**
     * @name 列表数据
     * @description
     * @return JSON
     **/
    public function index(int $delete = 0)
    {
        if($delete){
            // $list = College::join('class_attribution as attr', 'attr.class_id', '=', 'class.id')
            // ->join('college', 'college.id', '=', 'attr.college_id')
            // ->join('grade', 'grade.id', '=', 'attr.grade_id')
            // ->join('department', 'department.id', '=', 'attr.department_id')
            // ->join('level', 'level.id', '=', 'attr.level_id')
            // ->where(['is_delete'=>1])
            // ->select('class.id as class_id', 'class.name as class', 'class.status', 'class.sort', 'class.affix', 'college.college', 'college.sort as college_sort','college.id as college_id', 'department.department', 'department.sort as dep_sort', 'department.id as dep_id','grade.grade', 'grade.sort as grade_sort','grade.id as grade_id', 'level.level', 'level.sort as level_sort','level.id as level_id')
            // ->orderBy('college.sort', 'asc')
            // ->orderBy('grade.sort', 'asc')
            // ->orderBy('department.sort', 'asc')
            // ->orderBy('level.sort', 'asc')
            // ->orderBy('class.sort', 'asc')
            // ->get()->toArray();
            $list = College::where(['is_delete'=>1])
            ->orderBy('class.sort', 'asc')
            ->get()->toArray();
            $treeList = $list;
        }else{
            $list = College::join('class_attribution as attr', 'attr.class_id', '=', 'class.id')
            ->join('college', 'college.id', '=', 'attr.college_id')
            ->join('grade', 'grade.id', '=', 'attr.grade_id')
            ->join('department', 'department.id', '=', 'attr.department_id')
            ->join('level', 'level.id', '=', 'attr.level_id')
            ->where(['is_delete'=>0])
            ->select('class.id as class_id', 'class.name as class', 'class.status', 'class.sort', 'class.affix', 'college.college', 'college.sort as college_sort','college.id as college_id', 'department.department', 'department.sort as dep_sort', 'department.id as dep_id','grade.grade', 'grade.sort as grade_sort','grade.id as grade_id', 'level.level', 'level.sort as level_sort','level.id as level_id')
            ->orderBy('college.sort', 'asc')
            ->orderBy('grade.sort', 'asc')
            ->orderBy('department.sort', 'asc')
            ->orderBy('level.sort', 'asc')
            ->orderBy('class.sort', 'asc')
            ->get()->toArray();
            $treeList = $this->dealList($list);
        }
        $college = Colle::get()->toArray();
        $grade = Grade::get()->toArray();
        $department = Department::get()->toArray();
        $level = Level::get()->toArray();
        return $this->apiSuccess('', [$college, $grade, $department, $level, $treeList]);
    }

    /**
     * @name 转换班级数组方法
     * @param  $data Array 班级一维数组
     * @return Array
     **/
    public function dealList($arr)
    {
        $result = array();
        foreach ($arr as $item) {
            $collegeTitle = $item["college"];
            $collegeSrot = $item["college_sort"];
            $collegeId = $item["college_id"];
            $gradeTitle = $item["grade"];
            $gradeSort = $item["grade_sort"];
            $gradeId = $item["grade_id"];
            $departmentTitle = $item["department"];
            $departmentSort = $item["dep_sort"];
            $departmentId = $item["dep_id"];
            $levelTitle = $item["level"];
            $levelSort = $item["level_sort"];
            $levelId = $item["level_id"];
            $classTitle = $item["class"];
            $classId = $item["class_id"];
            $status = $item["status"];
            $sort = $item["sort"];
            $affix = $item["affix"];
            // find college in result array
            $collegeIndex = array_search($collegeTitle, array_column($result, 'title'));
            if ($collegeIndex === false) {
                $college = array(
                    "type" => "college",
                    "title" => $collegeTitle,
                    "sort" => $collegeSrot,
                    "type_id" => $collegeId,
                    "children" => array()
                );
                $result[] = $college;
                $collegeIndex = count($result) - 1;
            }
            // find grade in college
            $gradeIndex = array_search($gradeTitle, array_column($result[$collegeIndex]['children'], 'title'));
            if ($gradeIndex === false) {
                $grade = array(
                    "type" => "grade",
                    "title" => $gradeTitle,
                    "sort" => $gradeSort,
                    "type_id" => $gradeId,
                    "children" => array()
                );
                $result[$collegeIndex]['children'][] = $grade;
                $gradeIndex = count($result[$collegeIndex]['children']) - 1;
            }
            // find department in grade
            $departmentIndex = array_search($departmentTitle, array_column($result[$collegeIndex]['children'][$gradeIndex]['children'], 'title'));
            if ($departmentIndex === false) {
                $department = array(
                    "type" => "department",
                    "title" => $departmentTitle,
                    "sort" =>  $departmentSort,
                    "type_id" =>  $departmentId,
                    "children" => array()
                );
                $result[$collegeIndex]['children'][$gradeIndex]['children'][] = $department;
                $departmentIndex = count($result[$collegeIndex]['children'][$gradeIndex]['children']) - 1;
            }
            // find level in department
            $levelIndex = array_search($levelTitle, array_column($result[$collegeIndex]['children'][$gradeIndex]['children'][$departmentIndex]['children'], 'title'));
            if ($levelIndex === false) {
                $level = array(
                    "type" => "level",
                    "title" => $levelTitle,
                    "sort" => $levelSort,
                    "type_id" => $levelId,
                    "children" => array()
                );
                $result[$collegeIndex]['children'][$gradeIndex]['children'][$departmentIndex]['children'][] = $level;
                $levelIndex = count($result[$collegeIndex]['children'][$gradeIndex]['children'][$departmentIndex]['children']) - 1;
            }
            // add class to level
            $class = array(
                "type" => "class",
                "class_id" => $classId,
                "title" => $classTitle,
                "sort" => $sort,
                "status" => $status,
                "affix" => $affix
            );
            $result[$collegeIndex]['children'][$gradeIndex]['children'][$departmentIndex]['children'][$levelIndex]['children'][] = $class;
        }
        $treeList = $this->dealListId($result);
        return $treeList;
    }

    /**
     *将传入的数组每个元素上添加了一个唯一的 id 属性。
     *@param array $array 包含学院、年级、专业和班级信息的多维数组。
     *@return array 包含了原数组的所有元素，并在每个元素上添加了一个唯一的 id 属性的新数组。
     */
    public function dealListId($array)
    {
        $newArray = [];
        $id = 1;
        foreach ($array as $college) {
            $collegeArr = [
                "id" => $id++,
                "type" => $college["type"],
                "title" => $college["title"],
                "sort" => $college['sort'],
                "type_id" => $college['type_id'],
                "children" => []
            ];
            foreach ($college["children"] as $grade) {
                $gradeArr = [
                    "id" => $id++,
                    "type" => $grade["type"],
                    "title" => $grade["title"],
                    "sort" => $grade['sort'],
                    "type_id" => $grade['type_id'],
                    "children" => []
                ];
                foreach ($grade["children"] as $department) {
                    $departmentArr = [
                        "id" => $id++,
                        "type" => $department["type"],
                        "title" => $department["title"],
                        "sort" => $department['sort'],
                        "type_id" => $department['type_id'],
                        "children" => []
                    ];
                    foreach ($department["children"] as $level) {
                        $levelArr = [
                            "id" => $id++,
                            "type" => $level["type"],
                            "title" => $level["title"],
                            "sort" => $level['sort'],
                            "type_id" => $level['type_id'],
                            "children" => []
                        ];
                        foreach ($level["children"] as $class) {
                            $classArr = [
                                "id" => $id++,
                                "class_id" => $class["class_id"],
                                "type" => $class["type"],
                                "title" => $class["title"],
                                "sort" => $class["sort"],
                                "status" => $class["status"],
                                "affix" => $class["affix"]
                            ];
                            $levelArr["children"][] = $classArr;
                        }
                        $departmentArr["children"][] = $levelArr;
                    }
                    $gradeArr["children"][] = $departmentArr;
                }
                $collegeArr["children"][] = $gradeArr;
            }
            $newArray[] = $collegeArr;
        }
        return $newArray;
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
        $store[$data['type']] = $data['title'];
        $store['sort'] = $data['sort'];
        switch ($data['type']) {
            case "college":
                return $this->collegeCreate(Colle::query(), $store);
                break;
            case "grade":
                return $this->collegeCreate(Grade::query(), $store);
                break;
            case "department":
                return $this->collegeCreate(Department::query(), $store);
                break;
            case "level":
                return $this->collegeCreate(Level::query(), $store);
                break;
            default:
        }
    }

     /**
     * @name 修改页面
     * @param  id Int 班级id
     * @return JSON
     **/
    public function edit(array $data){
        if($data['type'] == 'class' ){
            $list= College::join('class_attribution as attr', 'attr.class_id', '=', 'class.id')
            ->join('college', 'college.id', '=', 'attr.college_id')
            ->join('grade', 'grade.id', '=', 'attr.grade_id')
            ->join('department', 'department.id', '=', 'attr.department_id')
            ->join('level', 'level.id', '=', 'attr.level_id')
            ->select('class.id', 'class.name','class.sort', 'college.college','college.id as college_id', 'department.department', 'department.id as department_id','grade.grade', 'grade.id as grade_id', 'level.level','level.id as level_id')
            ->where(['class.id'=>$data['id'],'is_delete'=> 0])
            ->get()
            ->toArray();
        }else{
            switch ($data['type']) {
                case "college":
                    $list = Colle::where('id','=',$data['id'])->select('college.id','college.college as title','college.sort')->get()->toArray();
                    break;
                case "grade":
                    $list = Grade::where('id','=',$data['id'])->select('grade.id','grade.grade as title','grade.sort')->get()->toArray();
                    break;
                case "department":
                    $list = Department::where('id','=',$data['id'])->select('department.id','department.department as title','department.sort')->get()->toArray();
                    break;
                case "level":
                    $list = Level::where('id','=',$data['id'])->select('level.id','level as title','level.sort')->get()->toArray();
                    break;
                default:
            }
        }
        if($list){
            $list[0]['type'] = $data['type'];
            return $this->apiSuccess('',$list);
        }else{
            return $this->apiError(MessageData::NO_DATA_EXISTS);
        }
        
    }


    /**
     *创建学院年级系部层次方法，并判断是否有重复数据
     *@param mixed $model 数据库模型
     *@param array $data 要插入的数据
     *@param string $successMessage 成功消息
     *@param string $errorMessage 唯一性字段错误消息
     *@return mixed
     *@throws \Throwable
     */
    public function collegeCreate($model, array $data = [], string $successMessage = MessageData::ADD_API_SUCCESS, string $errorMessage = MessageData::FIELD_UNIQUE)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        try {
            $model->insert($data);
        } catch (\PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                // 1062 是唯一性冲突的错误代码
                // 处理唯一性错误
                return $this->apiError($errorMessage);
            } else {
                return $this->apiError(MessageData::ADD_API_ERROR);
            }
        }
        return $this->apiSuccess($successMessage);
    }

    public function attr(){
        $collegelist = Colle::select('id as college_id','college','sort as college_sort')
        ->orderBy('college_sort', 'asc')
        ->get()->toArray();
        $gradelist = Grade::select('id as grade_id','grade','sort as grade_sort')
        ->orderBy('grade_sort', 'asc')
        ->get()->toArray();
        $departmentlist = Department::select('id as department_id','department','sort as department_sort')
        ->orderBy('department_sort', 'asc')
        ->get()->toArray();
        $levellist = Level::select('id as level_id','level','sort as level_sort')
        ->orderBy('level_sort', 'asc')
        ->get()->toArray();
        return $this->apiSuccess('', [$collegelist,$gradelist,$departmentlist,$levellist]);
    }

    public function classStore(array $data){
        $data['created_at'] = date('Y-m-d H:i:s');
        try {
            $class_id = College::insertGetId(['name'=>$data['name'],'sort'=>$data['sort'],'created_at'=>$data['created_at']]);
        } catch (\PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                // 1062 是唯一性冲突的错误代码
                // 处理唯一性错误
                return $this->apiError(MessageData::FIELD_UNIQUE);
            } else {
                return $this->apiError(MessageData::ADD_API_ERROR);
            }
        }
        if($class_id){
            return $this->commonCreate(ClassAttribution::query(),
            ['class_id'=>$class_id,
            'college_id'=>$data['college_id'],
            'grade_id'=>$data['grade_id'],
            'department_id'=>$data['department_id'],
            'level_id'=>$data['level_id'],
            ]);
        }
        $this->apiError(MessageData::ADD_API_ERROR);
    }

    /**
     * @name 递归遍历数据
     * @description
     * @param id Int 父级id
     * @param list Array 权限信息
     * @return Array 返回获取当前的删除id的其他子id
     **/
    private function superiorArrIdSort(array $list, int $pid): array
    {
        //创建新数组
        static $arr = array();
        foreach ($list as $k => $v) {
            if ($v['id'] == $pid) {
                $arr[] = $v['id'];
                unset($list[$k]);
                $this->superiorArrIdSort($list, $v['pid']);
            }
        }
        return $arr;
    }
    /**
     * @name 修改提交
     * @description
     * @param  data Array 修改数据
     * @param id Int 学院年级系部层次id
     * @param  type String 学院年级系部层次种类
     * @param  data.title String 学院年级系部层次名称
     * @param  data.sort Int 排序
     * @return JSON
     **/
    public function update(string $type,array $data){
        switch ($type) {
            case "college":
                $model = new Colle();
                break;
            case "grade":
                $model = new Grade();
                break;
            case "department":
                $model = new Department();
                break;
            case "level":
                $model = new Level();
                break;
            default:
        }
        $store[$type] = $data['title'];
        $store['sort'] = $data['sort'];
        try {
            $model->where('id',$data['id'])->update($store);
        } catch (\PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                // 1062 是唯一性冲突的错误代码
                // 处理唯一性错误
                return $this->apiError(MessageData::FIELD_UNIQUE);
            } else {
                return $this->apiError(MessageData::ADD_API_ERROR);
            }
        }
        return $this->apiSuccess(MessageData::UPDATE_API_SUCCESS);
    }

    public function classUpdate(string $type,array $data){
       if($type === 'class'){
        try {
            $class = College::findOrFail($data['id']);
            $class->name = $data['name'];
            $class->sort = $data['sort'];
            $class->save();
            $class->classAttr()->update([
                'college_id' => $data['college_id'],
                'department_id' =>  $data['department_id'],
                'grade_id' =>  $data['grade_id'],
                'level_id' =>  $data['level_id'],
            ]);
        } catch (\PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                // 1062 是唯一性冲突的错误代码
                // 处理唯一性错误
                return $this->apiError(MessageData::FIELD_UNIQUE);
            } else {
                return $this->apiError(MessageData::ADD_API_ERROR);
            }
        }
        return $this->apiSuccess(MessageData::UPDATE_API_SUCCESS);
       }
       return $this->apiError(MessageData::ADD_API_ERROR);
    }

    /**
     * @name 调整状态
     * @description
     * @param  data Array 调整数据
     * @param  id Int 菜单id
     * @param  data.status Int 状态（0或1）
     * @return JSON
     **/
    public function status(int $id,array $data){
        return $this->commonStatusUpdate(College::query(),$id,$data);
    }
    
    /**
     * @name 排序
     * @description
     * @author 西安咪乐多软件
     * @date 2021/6/12 4:06
     * @param  data Array 调整数据
     * @param  id Int 菜单id
     * @param  data.status Int 状态（0或1）
     * @return JSON
     **/
    public function sorts(int $id, array $data)
    {   
        // return $data;
        switch ($data['type']) {
            case "class":
                $model = new College();
                break;
            case "college":
                $model = new Colle();
                break;
            case "grade":
                $model = new Grade();
                break;
            case "department":
                $model = new Department();
                break;
            case "level":
                $model = new Level();
                break;
            default:
        }
        unset($data['type']);
        return $this->commonSortsUpdate($model::query(),$id,$data);
    }
  
    /**
     * @name 固定面板
     * @description
     * @param  data Array 调整数据
     * @param  id Int 菜单id
     * @param  data.affix Int 是否固定面板:0=否,1=是
     * @return JSON
     **/
    public function affix(int $id,array $data){
        return $this->commonStatusUpdate(College::query(),$id,$data);
    }
    /**
     * @name 删除
     * @description
     * @author 西安咪乐多软件
     * @date 2021/6/14 10:16
     * @param id Int 菜单id
     * @return JSON
     **/
    public function delete(int $id){
        return $this->commonIsDelete(College::query(),[$id]);
    }

    //回收
    public function recycle(int $id){
        return $this->commonRecycleIsDelete(College::query(),[$id]);
    }

    //真删除
    public function realDestroy(int $id){
        return $this->commonDestroy(College::query(),[$id]);
    }
}
