<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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
            'image' => 'nullable|string',
            'name' => 'required|string|min:3|max:255',
            'mother_name' => 'required|string|min:3|max:255',
            'birth_date' => 'required|date_format:d/m/Y',
            'cpf' => 'required|string|min:11|max:11',
            'cns' => 'required|string|min:15|max:15',
            'cep' => 'required|string|min:8|max:8',
            'street' => 'required|string|min:3|max:255',
            'number' => 'nullable|string',
            'complement' => 'nullable|string',
            'district' => 'required|string|min:3|max:255',
            'city' => 'required|string|min:3|max:255',
            'state' => 'required|string|min:2|max:2',
        ];
    }
}
