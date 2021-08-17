<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class SubFunctionRequest extends FormRequest
{

    public function authorize()
    {
        return backpack_auth()->check();
    }

    public function rules()
    {
        return [
            'name' => 'required|min:5|max:255',
            'requirement_id' => 'required',
            'priority' => 'required',
            'ios_cost' => 'required|numeric|min:0',
            'android_cost' => 'required|numeric|min:0',
            'web_cost' => 'required|numeric|min:0',
        ];
    }

}
