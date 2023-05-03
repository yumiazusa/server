<?php

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
            'type' =>'required',
        ];
    }
	public function messages(){
		return [
			'id.required' 				=> '缺少参数(id)!',
			'id.is_positive_integer' 	=> '(id)参数错误!',
            'type.required'=>'请确认类型',
		];
	}
}









