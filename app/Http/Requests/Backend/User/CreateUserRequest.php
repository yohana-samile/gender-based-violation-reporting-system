<?php

namespace App\Http\Requests\Backend\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name' => 'required|min:4|max:255',
            'cpanel_token_name' => [
                'nullable',
                'string',
                'max:50',
                'regex:/^[a-zA-Z0-9_-]+$/'
            ],
            'cpanel_user' => 'nullable',
            'cpanel_password' => 'nullable',
            'is_addon_domain' => 'nullable',
            'email' => 'required|email',
            'password' => 'required|string|confirmed|min:8',
            'domain_id' => 'nullable|exists:domains,id,deleted_at,NULL',
            'on_login_change_password' => 'nullable',
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
            'name.required' => 'Please Fill Out Your Name.',
            'name.min' => 'You came up short. Try more than 4 characters.',
            'name.max' => 'You came up short. Try few characters less that 255.',
            'email.required' => 'Please Enter Valid Email Address.',
            'password.required' => 'Please Enter Your Password.',
            'password.min' => 'You came up short. Try more than 5 password characters.',
            'domain.exists' => 'The selected domain does not exist in the database.',
        ];
    }
}
