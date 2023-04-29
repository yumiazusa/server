<?php
/*
 * @Author: yumiazusa yumiazusa@hotmail.com
 * @Date: 2023-04-26 22:27:28
 * @LastEditors: yumiazusa yumiazusa@hotmail.com
 * @LastEditTime: 2023-04-28 14:44:42
 * @FilePath: /datamaker/Users/ligen/Desktop/www/server/Modules/Students/Http/Requests/CollegeUpdateRequest.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */

namespace Modules\Students\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CollegeUpdateRequest extends FormRequest
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









