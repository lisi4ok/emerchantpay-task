<?php

namespace App\Http\Resources;

use App\Enums\TransactionTypeEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            "user" => $this->user,
            "type" => array_flip(TransactionTypeEnum::array())[$this->type],
            "amount" => (new \NumberFormatter(config('app.locale'), \NumberFormatter::CURRENCY))
                ->formatCurrency($this->amount, config('app.currency')),
            "description" => $this->description,
            "created_by" => $this->createdBy,
            "created_at" => (new Carbon($this->created_at))->format('Y-m-d H:i:s'),
            "updated_at" => (new Carbon($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}
