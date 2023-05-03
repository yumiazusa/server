<?php
/*
 * @Author: yumiazusa yumiazusa@hotmail.com
 * @Date: 2023-03-08 18:06:59
 * @LastEditors: yumiazusa
 * @LastEditTime: 2023-04-29 22:10:51
 * @FilePath: /www/miledo/server/Modules/Students/Http/Requests/ClassCreateRequest.php
 * @Description: College request类
 */

namespace Modules\Students\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassCreateRequest extends FormRequest
{
    /**
     * php artisan module:make-request AdminRequest Admin
     */

    public function authorize()
    {
        return true;
    }
	public function rules()
    {
        return [
            'name'=> 'required',
            'college_id' =>'required',
            'grade_id' =>'required',
            'department_id' =>'required',
            'level_id' =>'required',
            'sort' => 'required|regex:/^[1-9]{1}[0-9]{0,10}$/',
        ];
    }
	public function messages(){
		return [
		    'name.required'=>'请输入班级名称！',
            'college_id.required'=>'请选择所属学院',
            'grade_id.required'=>'请选择所属年级',
            'department_id.required'=>'请选择所属系部',
            'level_id.required'=>'请选择所属层次',
		    'sort.required' => '排序必须为整数！',
			'sort.regex' => '排序必须为整数！',
		];
	}
}









