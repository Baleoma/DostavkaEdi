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
    public function toArray($request)
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
            'items' => $this->whenLoaded('items', function () {
                return $this->items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'quantity' => $item->quantity,
                        'dish' => new DishResource($item->dish), // Существующая связь `dish`
                    ];
                });
            }),
        ];
    }
}
