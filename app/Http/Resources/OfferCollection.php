<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OfferCollection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\OfferResource';

    public function toArray($request)
    {
        return [
            'disconnect' => $this->collection,
        ];
    }
}
