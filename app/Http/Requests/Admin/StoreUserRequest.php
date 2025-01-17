<?php

namespace App\Http\Requests\Admin;

use App\Enums\UserStatusEnum;
use App\Traits\Requests\UserRequestTrait;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    use UserRequestTrait;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->letters()->symbols(),
            ],
            'slug' => [
                'nullable',
                'string',
                'max:1000',
                Rule::unique('users')->where(function (Builder $query) {
                    return $query
                        ->whereSlug($this->input('slug'))
                        ->when(($this->id !== null), function (Builder $query) {
                            $query->where('id', '!=', $this->id);
                        });
                }),
            ],
            'status' => ['nullable', Rule::enum(UserStatusEnum::class)],
            'amount' => ['nullable', 'numeric'],
            'description' => ['nullable', 'string'],
            'role' => ['required', 'numeric'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['required_with:roles', 'integer'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp,ico', 'max:2048'],
        ];
    }
}
