<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    private $token;

    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @param  string  $token
     * @return void
     */
    public function __construct($resource, $token)
    {
        parent::__construct($resource);
        $this->token = $token;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'user' => $this->resource,
            'token' => $this->token,
        ];
    }
}
