<?php
/*
 * @Author: yumiazusa yumiazusa@hotmail.com
 * @Date: 2023-03-21 13:30:59
 * @LastEditors: yumiazusa yumiazusa@hotmail.com
 * @LastEditTime: 2023-04-23 14:31:13
 * @FilePath: /www/miledo/server/Modules/Students/Services/College/CollegeService.php
 * @Description: 学院年级班级管理服务
 */


namespace Modules\Students\Services\College;



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
    public function index()
    {
        $list = College::join('class_attribution as attr', 'attr.class_id', '=', 'class.id')
            ->join('college', 'college.id', '=', 'attr.college_id')
            ->join('grade', 'grade.id', '=', 'attr.grade_id')
            ->join('department', 'department.id', '=', 'attr.department_id')
            ->join('level', 'level.id', '=', 'attr.level_id')
            ->select('class.id as class_id', 'class.name as class', 'class.status', 'class.sort','class.affix','college.college', 'college.sort as college_sort', 'department.department', 'department.sort as dep_sort','grade.grade','grade.sort as grade_sort', 'level.level', 'level.sort as level_sort')
            ->orderBy('college.sort', 'asc')
            ->orderBy('grade.sort', 'desc')
            ->orderBy('department.sort', 'asc')
            ->orderBy('level.sort', 'asc')
            ->get()->toArray();
        $treeList = $this->dealList($list);
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
            $gradeTitle = $item["grade"];
            $gradeSort = $item["grade_sort"];
            $departmentTitle = $item["department"];
            $departmentSort = $item["dep_sort"];
            $levelTitle = $item["level"];
            $levelSort = $item["level_sort"];
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
    public function dealListId($array){
        $newArray = [];
        $id = 1;
        foreach($array as $college) {
          $collegeArr = [
            "id" => $id++,
            "type" => $college["type"],
            "title" => $college["title"],
            "sort" => $college['sort'],
            "children" => []
          ];
          foreach($college["children"] as $grade) {
            $gradeArr = [
              "id" => $id++,
              "type" => $grade["type"],
              "title" => $grade["title"],
              "sort" => $grade['sort'],
              "children" => []
            ];
            foreach($grade["children"] as $department) {
              $departmentArr = [
                "id" => $id++,
                "type" => $department["type"],
                "title" => $department["title"],
                "sort" => $department['sort'],
                "children" => []
              ];
              foreach($department["children"] as $level) {
                $levelArr = [
                  "id" => $id++,
                  "type" => $level["type"],
                  "title" => $level["title"],
                  "sort" => $level['sort'],
                  "children" => []
                ];
                foreach($level["children"] as $class) {
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
        return $this->commonCreate(College::query(),$data);
    }


    /**
     * @name 添加子级返回父级id
     * @description
     * @param  pid Int 父级id
     * @return JSON
     **/
    public function pidArr(int $pid)
    {
        $value = [];
        if ($pid != 0) {
            $value = $this->superiorArrId($pid);
        }
        return $this->apiSuccess('', $value);
    }
    /**
     * @name 获取菜单id
     * @description
     * @author 西安咪乐多软件
     * @date 2021/6/14 10:14
     * @param pid Int 父级id
     * @return Array
     **/
    private function superiorArrId(int $pid): array
    {
        $list = College::select('id', 'pid')->orderBy('id', 'asc')->get()->toArray();
        return array_reverse($this->superiorArrIdSort($list, $pid));
    }
    /**
     * @name 递归遍历数据
     * @description
     * @author 西安咪乐多软件
     * @date 2021/6/14 10:13
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
    // /**
    //  * @name 修改提交
    //  * @description
    //  * @author 西安咪乐多软件
    //  * @date 2021/6/12 4:03
    //  * @param  data Array 修改数据
    //  * @param id Int 权限id
    //  * @param  data.pid Int 父级ID
    //  * @param  data.path String 标识
    //  * @param  data.url String 路由文件
    //  * @param  data.redirect String 重定向路径
    //  * @param  data.name String 权限名称
    //  * @param  data.type Int 菜单类型:1=模块,2=目录,3=菜单
    //  * @param  data.status Int 侧边栏显示状态:0=隐藏,1=显示
    //  * @param  data.auth_open Int 是否验证权限:0=否,1=是
    //  * @param  data.level Int 级别
    //  * @param  data.affix Int 是否固定面板:0=否,1=是
    //  * @param  data.icon String 图标名称
    //  * @param  data.sort Int 排序
    //  * @return JSON
    //  **/
    // public function update(int $id,array $data){
    //     return $this->commonUpdate(AuthRule::query(),$id,$data);
    // }
    // /**
    //  * @name 调整状态
    //  * @description
    //  * @author 西安咪乐多软件
    //  * @date 2021/6/12 4:06
    //  * @param  data Array 调整数据
    //  * @param  id Int 菜单id
    //  * @param  data.status Int 状态（0或1）
    //  * @return JSON
    //  **/
    // public function status(int $id,array $data){
    //     return $this->commonStatusUpdate(AuthRule::query(),$id,$data);
    // }
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
        return $this->commonSortsUpdate(College::query(), $id, $data);
    }
    // /**
    //  * @name 是否验证权限
    //  * @description
    //  * @author 西安咪乐多软件
    //  * @date 2021/6/12 4:06
    //  * @param  data Array 调整数据
    //  * @param  id Int 菜单id
    //  * @param  data.auth_open Int 状态（0或1）
    //  * @return JSON
    //  **/
    // public function open(int $id,array $data){
    //     return $this->commonStatusUpdate(AuthRule::query(),$id,$data);
    // }
    // /**
    //  * @name 固定面板
    //  * @description
    //  * @author 西安咪乐多软件
    //  * @date 2021/6/12 4:06
    //  * @param  data Array 调整数据
    //  * @param  id Int 菜单id
    //  * @param  data.affix Int 是否固定面板:0=否,1=是
    //  * @return JSON
    //  **/
    // public function affix(int $id,array $data){
    //     return $this->commonStatusUpdate(AuthRule::query(),$id,$data);
    // }
    // /**
    //  * @name 删除
    //  * @description
    //  * @author 西安咪乐多软件
    //  * @date 2021/6/14 10:16
    //  * @param id Int 菜单id
    //  * @return JSON
    //  **/
    // public function cDestroy(int $id){
    //     $idArr = $this->ids($id);
    //     return $this->commonDestroy(AuthRule::query(),$idArr);
    // }
    /**
     * @name 获取菜单id
     * @description
     * @author 西安咪乐多软件
     * @date 2021/6/14 10:14
     * @param id Int 当前删除数据id
     * @return Array
     **/
    private function ids(int $id): array
    {
        $College = College::select('id', 'pid')->get()->toArray();
        $arr = $this->delSort($College, $id);
        $arr[] = $id;
        return $arr;
    }

    /**
     * @name 递归遍历数据
     * @description
     * @author 西安咪乐多软件
     * @date 2021/6/14 10:13
     * @param id Int 当前删除数据id
     * @param College Array 学院年级班级信息
     * @return Array 返回获取当前的删除id的其他子id
     **/
    public function delSort(array $College, int $id): array
    {
        //创建新数组
        static $arr = array();
        foreach ($College as $k => $v) {
            if ($v['pid'] == $id) {
                $arr[] = $v['id'];
                unset($College[$k]);
                $this->delSort($College, $v['id']);
            }
        }
        return $arr;
    }
}
