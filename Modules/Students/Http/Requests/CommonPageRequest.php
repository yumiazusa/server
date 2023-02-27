<?php
/*
 * @Author: yumiazusa
 * @Date: 2023-02-27 17:03:30
 * @LastEditTime: 2023-02-27 17:05:06
 * @LastEditors: yumiazusa
 * @Description: yumiazusa的渣渣小作
 * @FilePath: /www/miledo/server/Modules/Students/Http/Requests/CommonPageRequest.php
 * yumiazusa@hotmail.com
 */


namespace Modules\Students\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class CommonPageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'page' => 'required|is_positive_integer',
            'limit' => 'required|is_positive_integer',
        ];
    }
    public function messages(){
        return [
            'page.required' 				=> '缺少参数(page)!',
            'page.is_positive_integer' 	=> '(page)参数错误！',
            'limit.required' 				=> '缺少参数(limit)!',
            'limit.is_positive_integer' 	=> '(limit)参数错误！',
        ];
    }
}
