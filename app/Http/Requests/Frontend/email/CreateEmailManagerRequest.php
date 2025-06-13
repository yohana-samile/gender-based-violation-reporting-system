<?php

namespace App\Http\Requests\Frontend\email;
use Illuminate\Foundation\Http\FormRequest;

class CreateEmailManagerRequest extends FormRequest
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
            'password' => 'required|string|confirmed|min:8',
            'domain' => 'required|string|regex:/^[a-zA-Z0-9.-]+$/',
            'txtdiskquota' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if ($value !== 'unlimited' && (!ctype_digit((string) $value) || $value < 0)) {
                        $fail("The {$attribute} must be a positive integer or 'unlimited'.");
                    }
                },
            ],
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
            'txtdiskquota' => 'Quota',
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
            'password.confirmed' => 'The password confirmation does not match.',
            'domain.required' => 'Please enter a valid domain.',
            'domain.string' => 'The domain must be a valid string.',
            'domain.regex' => 'The domain must be a valid domain format.',
            'quota.min' => 'The quota cannot be less than 0.',
            'send_welcome_email.in' => 'The send_welcome_email must be either 0 or 1.',
            'skip_update_db.in' => 'The skip_update_db must be either 0 or 1.',
        ];
    }
}
