<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "amount" => (new \NumberFormatter(config('app.locale'), \NumberFormatter::CURRENCY))
                ->formatCurrency($this->amount, config('app.currency')),
            "status" => $this->status,
            "description" => $this->description,
            "created_by" => $this->createdBy,
            "updated_by" => $this->updatedBy,
            "created_at" => (new Carbon($this->created_at))->format('Y-m-d H:i:s'),
            "updated_at" => (new Carbon($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}
