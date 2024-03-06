<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:100',
            'images' => 'array|min:1',
            'images.*' => 'image|mimes:jpg,jpeg,png',
            'image_names' => 'array|min:1',
            'image_names.*' => 'string',
            'captions' => 'array',
            'captions.*' => 'string|max:100|nullable',
            'positions' => 'array|min:1',
            'positions.*' => 'integer|min:1'
        ];
    }
}
