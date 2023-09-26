<?php
/*
 * @Author: yumiazusa yumiazusa@hotmail.com
 * @Date: 2023-02-28 13:32:20
 * @LastEditors: yumiazusa yumiazusa@hotmail.com
 * @LastEditTime: 2023-05-13 11:06:03
 * @FilePath: /www/miledo/server/Modules/Students/Routes/api.php
 * @Description: 这是默认设置,请设置`customMade`,打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(["prefix"=>"v1/students","middleware"=>"StudentsApiAuth"],function (){
      //学生管理
      Route::get('students/index','v1\StudentsController@index');
      //添加
      Route::post('students/store','v1\StudentsController@store');
      //编辑页面
      Route::get('students/edit','v1\StudentsController@edit');
      //编辑提交
      Route::put('students/update','v1\StudentsController@update');
      //调整状态
      Route::put('students/status','v1\StudentsController@status');
      //初始化密码
      Route::put('students/updatePwd','v1\StudentsController@updatePwd');
      //修改密码
      Route::put('students/changePwd','v1\StudentsController@changePwd');

    //学院年级班级管理
      //学院年级班级列表
      Route::get('college/index','v1\CollegeController@index');
      //班级回收站列表
      Route::get('college/deleteList','v1\CollegeController@deleteList');
      //添加学院年级系部层次
      Route::post('college/store','v1\CollegeController@store');
      //调取学院年级系部层次下拉列表
      Route::get('college/attr','v1\CollegeController@attr');
      //添加班级
      Route::post('college/classStore','v1\CollegeController@classStore');
      //提取编辑学院年级系部层次班级信息
      Route::get('college/edit','v1\CollegeController@edit');
      //更新学院年级系部层次信息
      Route::post('college/colleUpdate','v1\CollegeController@colleUpdate');
      //更新班级信息
      Route::post('college/classUpdate','v1\CollegeController@classUpdate');
      //更新班级状态
      Route::put('college/status','v1\CollegeController@status');
      //更新班级排序
      Route::put('college/collegeSorts','v1\CollegeController@collegeSorts');
      //更新班级固定面板显示
      Route::put('college/collegeAffix','v1\CollegeController@collegeAffix');
      //删除班级
      Route::delete('college/deleteClass','v1\CollegeController@deleteClass');
      //回收班级
      Route::delete('college/recycleClass','v1\CollegeController@recycleClass');
      //回收班级
      Route::delete('college/realDestroy','v1\CollegeController@realDestroy');
});
