<?php

namespace App\Http\Requests\Backend\Setting;
use Illuminate\Foundation\Http\FormRequest;

class CreateCpanelTokenRequest extends FormRequest
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
            'admin_id' => 'required|string',
            'old_name' => 'required',
            'new_name' => 'required',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'admin_id.required' => 'Unknown Admin, try to reload this page.',
            'old_name.required' => 'Please Fill Out Your Cpanel User.',
            'new_name.required' => 'Please Fill Out New Cpanel Username.',
        ];
    }
}
