<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class EmailManagerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
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
            'email' => 'required|string|email|unique:email_managers',
            'password' => 'required|string|min:8',
            'domain' => 'required|string|regex:/^[a-zA-Z0-9.-]+$/',
            'quota' => 'nullable',
            'send_welcome_email' => 'nullable',
            'skip_update_db' => 'nullable',
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
            'email' => 'Email address',
            'password' => 'Password',
            'domain' => 'Domain',
            'quota' => 'Quota',
            'send_welcome_email' => 'Send welcome email',
            'skip_update_db' => 'Skip database update',
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
            'email.required' => 'Please enter a valid email address.',
            'email.email' => 'The email must be a valid email address.',
            //'email.regex' => 'The email account cannot be "cpanel" as the username.',
            'password.required' => 'Please enter a password.',
            'password.min' => 'The password must be at least 8 characters.',
            'domain.required' => 'Please enter a valid domain.',
            'domain.string' => 'The domain must be a valid string.',
            'domain.regex' => 'The domain must be a valid domain format.',
            'quota.min' => 'The quota cannot be less than 0.',
            'send_welcome_email.in' => 'The send_welcome_email must be either 0 or 1.',
            'skip_update_db.in' => 'The skip_update_db must be either 0 or 1.',
        ];
    }
}
