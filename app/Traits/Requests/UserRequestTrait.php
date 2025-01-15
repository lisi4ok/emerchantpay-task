<?php

declare(strict_types=1);

namespace App\Traits\Requests;

use App\Enums\UserStatusEnum;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator;

trait UserRequestTrait
{
    /**
     * Configure the validator instance.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if (! ($amount = $validator->getValue('amount'))) {
                $validator->setValue('amount', (double) $amount);
            }
            if (! $validator->getValue('status')) {
                $validator->setValue('status', UserStatusEnum::ACTIVE->value);
            }
            if (! $validator->getValue('email_verified_at')) {
                $validator->setValue('email_verified_at', now());
            }
        });
    }

    protected function prepareForValidation(): void {}

    protected function passedValidation(): void
    {
        if (! $this->validated('slug') && ! $this->input('slug')) {
            $this->replace(['slug' => Str::slug($this->validated(['name']), '-', app()->getLocale())]);
        }
    }
}
