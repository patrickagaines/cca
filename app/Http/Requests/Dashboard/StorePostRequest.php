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
            'image_files' => 'required|array|min:1',
            'image_files.*' => 'image|mimes:jpg,jpeg,png',
            'images' => 'required|array|min:1',
            'images.*.file_index' => 'required|integer',
            'images.*.caption' => 'string|max:100|nullable',
            'images.*.position' => 'required|integer|min:1'
        ];
    }

    public function messages()
    {
        return [
            'images.required' => 'Your post must include at least one image'
        ];
    }
}
