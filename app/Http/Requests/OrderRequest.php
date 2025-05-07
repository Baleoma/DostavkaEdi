<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
        'total_price' => 'required|numeric|min:0',
        'discount' => 'nullable|numeric|min:0',
        'final_price' => 'required|numeric|min:0',
        'address' => 'required|string|max:500',
        'comment' => 'nullable|string|max:1000',
        'status_id' => 'required|exists:statuses,id',
        'user_id' => 'required|exists:users,id',
    ];
    }
}
