<?php

namespace App\Http\Requests;


use Illuminate\Support\Facades\Auth;

class ClothesRequest extends ApiFormRequest
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
            'img' => 'image|mimes:jpeg,jpg,png,gif',
        ];
    }
}
