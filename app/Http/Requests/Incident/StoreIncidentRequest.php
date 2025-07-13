<?php

namespace App\Http\Requests\Incident;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncidentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'occurred_at' => 'required|date',
            'location' => 'required|string|max:255',
            'type' => 'required',
            'is_anonymous' => 'sometimes|boolean',
            'victims' => 'required|array|min:1',
            'victims.*.name' => 'required_if:is_anonymous,false|string|max:255',
            'victims.*.gender' => 'required',
            'victims.*.age' => 'nullable|integer|min:0',
            'victims.*.contact_number' => 'nullable|string|max:20',
            'victims.*.contact_email' => 'nullable|email',
            'victims.*.address' => 'nullable|string',
            'victims.*.vulnerability' => 'nullable',
            'perpetrators' => 'sometimes|array',
            'perpetrators.*.name' => 'nullable|string|max:255',
            'perpetrators.*.gender' => 'required',
            'perpetrators.*.age' => 'nullable|integer|min:0',
            'perpetrators.*.relationship_to_victim' => 'nullable|string|max:255',
            'perpetrators.*.description' => 'nullable|string',
            'evidence' => 'required|array',
            'evidence.*.file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'evidence.*.description' => 'nullable|string'
        ];
    }
    public function messages()
    {
        return [
            'victims.required' => 'At least one victim must be reported',
            'victims.*.name.required_if' => 'Victim name is required unless report is anonymous',
            'perpetrators.*.gender.required' => 'Perpetrator gender is required',
        ];
    }
}
