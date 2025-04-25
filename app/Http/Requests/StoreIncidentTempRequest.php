<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncidentTempRequest extends FormRequest
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
            'incident' => 'required|min:5',
            'service_id' => 'required',
            'probability' => 'required',
            'risk_quadrant' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'incident.required' => 'A title is required',
            'service_id.required' => 'A description is required',
            'probability.required' => 'A probability is required',
            'risk_quadrant.required' => 'A risk quadrant is required',
        ];
    }
}
