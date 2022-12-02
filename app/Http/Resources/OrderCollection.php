<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{

    public $collects = 'App\Http\Resources\OrderResource';

    public function toArray($request)
    {
        return [
            'Orders' => $this->collection,
            'orders_count' => $this->collection->count()
        ];
    }
}
