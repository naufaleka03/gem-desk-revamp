<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|min:5',
            'username' => 'required',
            'profile_picture' => 'mimes:pdf,jpg,jpeg,png,doc,docx|max:2500'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A name is required',
            'username.required' => 'A username is required',
        ];
    }
}
