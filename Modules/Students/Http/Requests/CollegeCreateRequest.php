<?php
/*
 * @Author: yumiazusa yumiazusa@hotmail.com
 * @Date: 2023-03-08 18:06:59
 * @LastEditors: yumiazusa
 * @LastEditTime: 2023-04-29 11:27:13
 * @FilePath: /www/miledo/server/Modules/Students/Http/Requests/CollegeCreateRequest.php
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
            'title'=> 'required',
            'type' =>'required',
            'sort' => 'required|regex:/^[1-9]{1}[0-9]{0,10}$/',
        ];
    }
	public function messages(){
		return [
		    'title.required'=>'请输入名称！',
            'type.required'=>'请确认类型',
		    'sort.required' => '排序必须为整数！',
			'sort.regex' => '排序必须为整数！',
		];
	}
}









