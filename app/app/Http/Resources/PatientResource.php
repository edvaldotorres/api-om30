<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'image' => $this->image,
            'name' => $this->name,
            'mother_name' => $this->mother_name,
            'birth_date' => $this->birth_date,
            'cpf' => $this->cpf,
            'cns' => $this->cns,
            'cep' => $this->address->cep,
            'street' => $this->address->street,
            'number' => $this->address->number,
            'complement' => $this->address->complement,
            'district' => $this->address->district,
            'city' => $this->address->city,
            'state' => $this->address->state,
        ];
    }
}
