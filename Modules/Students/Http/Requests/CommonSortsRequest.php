<?php
/*
 * @Author: yumiazusa yumiazusa@hotmail.com
 * @Date: 2023-03-07 14:50:40
 * @LastEditors: yumiazusa yumiazusa@hotmail.com
 * @LastEditTime: 2023-05-06 11:54:45
 * @FilePath: /www/miledo/server/Modules/Students/Http/Requests/CommonStatusRequest.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */

namespace Modules\Students\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommonSortsRequest extends FormRequest
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
			'id' 		=> 'required|is_positive_integer',
            'type'      => 'required',
            'sort' => 'required|regex:/^[1-9]{1}[0-9]{0,10}$/'
        ];
    }
	public function messages(){
		return [
			'id.required' 					=> '缺少参数(id)!',
			'id.is_positive_integer' 		=> '(id)参数错误!',
            'type.required'                 => '缺少类型信息！',
			'sort.required' => '排序必须为整数！',
			'sort.regex' => '排序必须为整数！'
		];
	}
}









