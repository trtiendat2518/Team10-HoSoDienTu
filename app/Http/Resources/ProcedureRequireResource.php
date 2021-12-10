<?php

namespace App\Http\Resources;

use App\Models\ProcedureRequire;
use Illuminate\Http\Resources\Json\JsonResource;

class ProcedureRequireResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
