<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LeadResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'nif' => $this->nif,
            'details' => $this->details,
            'phone' => $this->phone,
            'mobile_phone' => $this->mobile_phone,
            'company_id' => $this->company_id,
        ];
    }
}
