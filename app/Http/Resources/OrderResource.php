<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'id' => $this->id,
            'total_price' => $this->total_price,
            'discount' => $this->discount,
            'final_price' => $this->final_price,
            'address' => $this->address,
            'comment' => $this->comment,
            'status_id' => $this->status_id,
            'user_id' => $this->user_id,
            'restaurant_id' => $this->restaurant_id,
        ];
    }
}
