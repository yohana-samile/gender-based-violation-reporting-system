<?php

namespace App\Http\Requests\Frontend\email;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmailManagerRequest extends FormRequest
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
            'password' => 'nullable|string|min:8|confirmed|required_without:quota',
            'quota' => [
                'nullable',
                'required_without:password',
                function ($attribute, $value, $fail) {
                    if ($value !== 'unlimited' && (!ctype_digit((string) $value) || $value < 0)) {
                        $fail("The {$attribute} must be a positive integer or 'unlimited'.");
                    }
                },
            ],
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
            'password' => 'Password',
            'quota' => 'Quota',
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
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.required_without' => 'The password is required when quota is not provided.',
            'quota.required_without' => 'The quota is required when password is not provided.',
        ];
    }
}
