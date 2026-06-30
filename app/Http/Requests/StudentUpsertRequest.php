<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentUpsertRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $student = $this->route('student');
        $studentId = $student?->id;
        $parentId = $student?->parent?->id;

        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($studentId),
            ],
            'has_parent' => [
                'nullable',
                'boolean',
            ],
        ];

        if ($this->boolean('has_parent')) {
            $rules['parent_name'] = [
                'required',
                'string',
                'max:255',
            ];
            $rules['parent_email'] = [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($parentId),
            ];
        }

        return $rules;
    }
}
