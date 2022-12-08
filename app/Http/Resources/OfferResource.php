<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{


    public function toArray($request)
    {
        return [
            'amount' => $this->amount . $this->type(),
        ];
    }
}
