<?php

namespace App\Http\Requests;

use App\Enums\MoneyTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'type' => ['nullable', Rule::enum(MoneyTypeEnum::class)],
            'user_id' => ['required', 'exists:users,id'],
            'amount' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
        ];
    }
}
