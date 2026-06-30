<?php

namespace App\Http\Requests;

use App\Enums\AnnouncementType;
use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnnouncementUpsertRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $rules = [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'required',
                'string',
            ],
        ];

        if ($this->user()?->hasRole(Role::TEACHER->value)) {
            $rules['targets'] = [
                'required',
                'array',
                'min:1',
            ];
            $rules['targets.*'] = [
                'required',
                'string',
                Rule::in([
                    AnnouncementType::STUDENT->value,
                    AnnouncementType::PARENTS->value,
                ]),
            ];
        }

        return $rules;
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'targets.required' => 'At least one target audience (Students or Parents) must be selected.',
        ];
    }
}
