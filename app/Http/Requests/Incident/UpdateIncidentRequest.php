<?php

namespace App\Http\Requests\Incident;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIncidentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'occurred_at' => 'sometimes|date',
            'location' => 'sometimes|string|max:255',
            'status' => 'sometimes',
            'type' => 'sometimes',
            'is_anonymous' => 'sometimes|boolean',
            'update_text' => 'nullable',
            'support_services' => 'sometimes|array',
            'support_services.*' => 'exists:support_services,id'
        ];
    }
}
