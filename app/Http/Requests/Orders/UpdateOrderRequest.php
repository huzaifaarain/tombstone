<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'tombstone' => 'required|exists:tombstones,id',
            'name' => 'required|string',
            'font' => 'required|exists:fonts,id',
            'textColor' => 'required|exists:text_colors,id',
            'dateOfBirth' => 'required|date|date_format:Y-m-d',
            'deathDate' => 'required|date|date_format:Y-m-d',
            'icon' => 'required|exists:icons,id',
            'price' => 'required|numeric|gte:0',
        ];
    }
}
