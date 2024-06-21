<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'main_fabric' => ['required', 'string', 'max:255'],
            'pattern' => ['required', 'string', 'max:255'],
            'fit' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'compare_price' => ['nullable', 'numeric', 'min:0'],
            'thickness' => ['required', 'string', 'max:255'],
            'sleeve_length' => ['required', 'string', 'max:255'],
            'occasion' => ['required', 'string', 'max:255'],
            'material' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'size' =>['required','string','max:255']
        ];
    }
}
