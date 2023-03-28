<?php
/*
 * @Author: yumiazusa yumiazusa@hotmail.com
 * @Date: 2023-03-21 13:30:59
 * @LastEditors: yumiazusa
 * @LastEditTime: 2023-03-28 23:38:25
 * @FilePath: /www/miledo/server/Modules/Students/Services/college/CollegeService.php
 * @Description: 学院年级班级管理服务
 */


namespace Modules\Students\Services\college;


// use Modules\Admin\Models\AuthGroup;
// use Modules\Admin\Models\AuthRule;

use Modules\Students\Entities\College;
use Modules\Students\Services\BaseApiService;

class CollegeService extends BaseApiService
{

    /**
     * @name 列表数据
     * @description
     * @return JSON
     **/
    public function index(){
        $model = College::join('class_attribution as attr','attr.class_id','=','class.id')
                ->join('college','college.id','=','attr.college_id')
                ->join('grade','grade.id','=','attr.grade_id')
                ->join('department','department.id','=','attr.department_id')
                ->join('level','level.id','=','attr.level_id')
                ->select('class.*','college.college','grade.grade','department.department','level.level')
                ->orderBy('college.sort','asc')
                ->orderBy('grade.sort','desc')
                ->orderBy('department.sort','asc')
                ->orderBy('level.sort','asc')
                ->get()->toArray();
                // http://www.qb5200.com/article/268948.html
                // https://www.douban.com/note/588332910/?_i=001491807qWaSM
        dd($model);
    }








    // /**
    //  * @name 添加
    //  * @description
    //  * @author 西安咪乐多软件
    //  * @date 2021/6/12 3:29
    //  * @method  POST
    //  * @param  data Array 添加数据
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
    // public function store(array $data)
    // {
    //     return $this->commonCreate(AuthRule::query(),$data);
    // }
    // /**
    //  * @name 修改页面
    //  * @description
    //  * @author 西安咪乐多软件
    //  * @date 2021/6/14 9:51
    //  * @param  id Int 菜单id
    //  * @return JSON
    //  **/
    // public function edit(int $id){
    //     $data = AuthRule::find($id)->toArray();
    //     if($data['pid'] != 0){
    //         $data['value'] = $this->superiorArrId($data['pid']);
    //     }else{
    //         $data['value'] = [];
    //     }
    //     return $this->apiSuccess('',$data);
    // }
    /**
     * @name 添加子级返回父级id
     * @description
     * @param  pid Int 父级id
     * @return JSON
     **/
    public function pidArr(int $pid){
        $value = [];
        if($pid != 0){
            $value = $this->superiorArrId($pid);
        }
        return $this->apiSuccess('',$value);
    }
    /**
     * @name 获取菜单id
     * @description
     * @author 西安咪乐多软件
     * @date 2021/6/14 10:14
     * @param pid Int 父级id
     * @return Array
     **/
    private function superiorArrId(int $pid):Array
    {
        $list = College::select('id','pid')->orderBy('id','asc')->get()->toArray();
        return array_reverse($this->superiorArrIdSort($list,$pid));
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
    private function superiorArrIdSort(array $list,int $pid):Array
    {
        //创建新数组
        static $arr=array();
        foreach($list as $k=>$v){
            if($v['id'] == $pid){
                $arr[] = $v['id'];
                unset($list[$k]);
                $this->superiorArrIdSort($list,$v['pid']);
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
    public function sorts(int $id,array $data){
        return $this->commonSortsUpdate(College::query(),$id,$data);
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
    private function ids(int $id):Array
    {
        $college = College::select('id','pid')->get()->toArray();
        $arr = $this->delSort($college,$id);
        $arr[] = $id;
        return $arr;
    }
    
    /**
     * @name 递归遍历数据
     * @description
     * @author 西安咪乐多软件
     * @date 2021/6/14 10:13
     * @param id Int 当前删除数据id
     * @param college Array 学院年级班级信息
     * @return Array 返回获取当前的删除id的其他子id
     **/
    public function delSort(array $college,int $id):Array
    {
        //创建新数组
        static $arr=array();
        foreach($college as $k=>$v){
            if($v['pid'] == $id){
                $arr[] = $v['id'];
                unset($college[$k]);
                $this->delSort($college,$v['id']);
            }
        }
        return $arr;
    }
}
