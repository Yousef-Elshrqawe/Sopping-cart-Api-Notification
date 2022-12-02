<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{

    public $collects = 'App\Http\Resources\ProductResource';


    public function toArray($request)
    {
        return [
            'Products' => $this->collection,
        ];
    }
}
