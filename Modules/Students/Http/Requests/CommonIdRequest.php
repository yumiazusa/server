<?php
/*
 * @Author: yumiazusa yumiazusa@hotmail.com
 * @Date: 2023-05-03 23:31:27
 * @LastEditors: yumiazusa yumiazusa@hotmail.com
 * @LastEditTime: 2023-05-06 16:22:30
 * @FilePath: /datamaker/Users/ligen/Desktop/www/server/Modules/Students/Http/Requests/CommonIdRequest.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */

namespace Modules\Students\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommonIdRequest extends FormRequest
{


    public function authorize()
    {
        return true;
    }
	public function rules()
    {
        return [
			'id' => 'required|is_positive_integer',
        ];
    }
	public function messages(){
		return [
			'id.required' 				=> '缺少参数(id)!',
			'id.is_positive_integer' 	=> '(id)参数错误!',
		];
	}
}









