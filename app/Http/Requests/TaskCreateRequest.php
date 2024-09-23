<?php

namespace App\Http\Requests;

use App\Enums\TaskDuration;
use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskCreateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
			'description' => ['required', 'string'],
			'start' => ['required', 'date_format:Y-m-d\\TH:i', 'string'],
			'duration' => ['required', Rule::enum(TaskDuration::class)],
			'status' => ['required', Rule::enum(TaskStatus::class)],
			'category_id' => ['nullable', 'exists:categories,id'],
        ];
    }
}
