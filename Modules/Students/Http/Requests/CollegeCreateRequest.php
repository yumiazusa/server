<?php
/*
 * @Author: yumiazusa yumiazusa@hotmail.com
 * @Date: 2023-03-08 18:06:59
 * @LastEditors: yumiazusa yumiazusa@hotmail.com
 * @LastEditTime: 2023-04-23 14:35:34
 * @FilePath: /www/miledo/server/Modules/Students/Http/Requests/StudentsCreateRequest.php
 * @Description: College request类
 */

namespace Modules\Students\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CollegeCreateRequest extends FormRequest
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
            'college'=> 'required',
        ];
    }
	public function messages(){
		return [
		    'college.required'=>'请输入学院名！',
		];
	}
}









