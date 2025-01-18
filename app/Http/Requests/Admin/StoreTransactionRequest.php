<?php

namespace App\Http\Requests\Admin;

use App\Enums\TransactionTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTransactionRequest extends FormRequest
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
            'type' => ['required', Rule::enum(TransactionTypeEnum::class)],
            'user_id' => ['required', 'exists:users,id'],
            'amount' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
        ];
    }
}
