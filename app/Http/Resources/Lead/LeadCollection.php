<?php

namespace App\Http\Resources\Lead;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LeadCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return parent::toArray($this->collects);
    }
}
