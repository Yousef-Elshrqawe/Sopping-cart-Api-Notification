<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CartItemCollection extends ResourceCollection
{

    public $collects = 'App\Http\Resources\CartItemResource';


    public function toArray($request)
    {
        return $this->collection;
    }
}
