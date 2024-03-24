<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'image_files' => 'sometimes|array|min:1',
            'image_files.*' => 'image|mimes:jpg,jpeg,png',
            'images' => 'required|array|min:1',
            'images.*.id' => 'sometimes|required|integer',
            'images.*.file_index' => 'sometimes|required|integer',
            'images.*.caption' => 'nullable|string|max:100',
            'images.*.position' => 'required|integer|min:1',
            'deleted_images' => 'sometimes|array',
            'deleted_images.*' => 'integer'
        ];
    }

    public function messages(): array
    {
        return [
            'images.required' => 'Your post must include at least one image'
        ];
    }
}
