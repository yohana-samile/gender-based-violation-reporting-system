<?php

namespace App\Http\Requests\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'nullable|string|min:6|confirmed',
            'roles' => 'nullable|array',
            'permissions' => 'nullable|array',
            'is_active' => 'sometimes|boolean',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'full name',
            'email' => 'email address',
            'role_id' => 'role',
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
        ];
    }
}
