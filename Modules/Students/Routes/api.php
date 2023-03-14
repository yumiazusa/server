<?php
/*
 * @Author: yumiazusa yumiazusa@hotmail.com
 * @Date: 2023-02-28 13:32:20
 * @LastEditors: yumiazusa
 * @LastEditTime: 2023-03-14 23:40:51
 * @FilePath: /www/miledo/server/Modules/Students/Routes/api.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
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
    // 会员列表
    Route::get('students/index', 'v1\StudentsController@index');
      //添加
      Route::post('students/store', 'v1\StudentsController@store');
      //编辑页面
      Route::get('students/edit', 'v1\StudentsController@edit');
      //编辑提交
      Route::put('students/update', 'v1\StudentsController@update');
      //调整状态
      Route::put('students/status', 'v1\StudentsController@status');
      //初始化密码
      Route::put('students/updatePwd', 'v1\StudentsController@updatePwd');
      //修改密码
      Route::put('students/changePwd', 'v1\StudentsController@changePwd');
});