<?php

namespace App\Http\Requests\User;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
             'email' => 'required|email|unique:users,email,',
            'password' => 'required|min:5|max:255',
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
        ];
    }
}
