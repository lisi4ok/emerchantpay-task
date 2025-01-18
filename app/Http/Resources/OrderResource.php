<?php

namespace App\Http\Resources;

use App\Enums\OrderStatusEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use NumberFormatter;

class OrderResource extends JsonResource
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
            "status" => array_flip(OrderStatusEnum::array())[$this->status],
            "amount" => (new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY))
                ->formatCurrency($this->amount, config('app.currency')),
            "title" => $this->title,
            "description" => $this->description,
            "created_at" => (new Carbon($this->created_at))->format('Y-m-d H:i:s'),
            "updated_at" => (new Carbon($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}
