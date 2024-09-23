<?php

namespace App\Http\Requests;

use App\Enums\GoalDuration;
use App\Enums\GoalStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GoalUpdateRequest extends FormRequest
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
			'title' => ['string'],
			'description' => ['string'],
			'start' => ['date_format:Y-m-d\\TH:i', 'string'],
			'duration' => [Rule::enum(GoalDuration::class)],
			'status' => [Rule::enum(GoalStatus::class)],
			'category_id' => ['nullable', 'exists:categories,id'],
		];
	}
}
