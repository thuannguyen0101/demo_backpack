<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditServiceProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:5|max:255',
            'priority' => 'required',
            'ios_cost' => 'required|numeric|min:0',
            'android_cost' => 'required|numeric|min:0',
            'web_cost' => 'required|numeric|min:0',
        ];
    }
}
