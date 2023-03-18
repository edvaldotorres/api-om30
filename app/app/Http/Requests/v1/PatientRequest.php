<?php

namespace App\Http\Requests\v1;

use App\Rules\v1\CnsValidationRule;
use Illuminate\Validation\Rule;

class PatientRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|min:3|max:255',
            'mother_name' => 'nullable|string|min:3|max:255',
            'birth_date' => 'required|date_format:d/m/Y',
            'cpf' => [
                'required',
                'string',
                'min:11',
                'max:11',
                Rule::unique('patients')->ignore($this->patient),
            ],
            'cns' => [
                'nullable',
                Rule::unique('patients')->ignore($this->patient),
                new CnsValidationRule()
            ],
            'zip_code' => 'nullable|string|min:8|max:8',
            'street' => 'required|string|min:3|max:255',
            'number' => 'nullable|string',
            'complement' => 'nullable|string',
            'district' => 'required|string|min:3|max:255',
            'city' => 'required|string|min:3|max:255',
            'state' => 'required|string|min:2|max:2',
        ];
    }
}
