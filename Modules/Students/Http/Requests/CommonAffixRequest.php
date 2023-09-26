<?php
/*
 * @Author: yumiazusa yumiazusa@hotmail.com
 * @Date: 2023-03-07 14:50:40
 * @LastEditors: yumiazusa yumiazusa@hotmail.com
 * @LastEditTime: 2023-05-06 15:43:10
 * @FilePath: /www/miledo/server/Modules/Students/Http/Requests/CommonStatusRequest.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */

namespace Modules\Students\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommonAffixRequest extends FormRequest
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
			'affix' 	=> 'required|is_status_integer',

        ];
    }
	public function messages(){
		return [
			'id.required' 					=> '缺少参数(id)!',
			'id.is_positive_integer' 		=> '(id)参数错误!',
			'affix.required' 				=> '缺少参数(affix)!',
			'affix.is_status_integer' 		=> '(affix)参数错误！',
		];
	}
}









