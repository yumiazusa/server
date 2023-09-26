<?php
/*
 * @Author: yumiazusa yumiazusa@hotmail.com
 * @Date: 2023-04-17 18:29:08
 * @LastEditors: yumiazusa yumiazusa@hotmail.com
 * @LastEditTime: 2023-05-08 00:12:45
 * @FilePath: /datamaker/Users/ligen/Desktop/www/server/Modules/Students/Http/Requests/StudentsUpdateRequest.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */

namespace Modules\Students\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentsUpdateRequest extends FormRequest
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
            'phone'=>'required|regex:/^1[34578]{1}\d{9}$/',
            'email'=>'required|regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/|unique:students,email,'.$this->get('id'),
            'stdid'=>'required|regex:/^[0-9]{8,10}$/|unique:students,stdid,'.$this->get('id'),
            'class_id'=> 'required|is_positive_integer',
            'project_id'=> 'required|is_positive_integer',
            'birth'=> 'required'

        ];
    }
	public function messages(){
		return [
            'name.required'=>'请输入姓名！',
		    'phone.required'=>'请输入手机号！',
		    'phone.unique'=>'手机号已注册！',
		    'phone.regex'=>'请输入正确的手机号！',
            'email.required'=>'请输入邮箱！',
            'email.unique'=>'邮箱已注册！',
            'email.regex'=>'请输入正确的邮箱！',
            'stdid.unique'=>'学号已注册！',
            'stdid.regex' => '请输入8-10位的学号',
			'class_id.required' => '请选择班级！',
			'grade_id.required' => '请选择年级！',
			'project_id.required' => '请选择归属项目！',
            'class_id.is_positive_integer' => '请选择正确班级！',
            'grade_id.is_positive_integer' => '请选择正确年级！',
            'project_id.is_positive_integer' => '请选择正确项目！',
			'birth.required' => '请选择出生年月日！'
		];
	}
}









