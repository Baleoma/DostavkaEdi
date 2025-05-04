<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderitemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // quantity - количество блюд в заказе
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'order_id' => 'required|exists:orders,id',
            'dish_id' => 'required|exists:dishes,id',
        ];
    }
}
