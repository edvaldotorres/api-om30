<?php

namespace App\Http\Requests\v1;

class ImportCsvRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'file' => 'required|file|mimes:csv',
        ];
    }
}
