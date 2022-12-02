<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'Category' => $this->Category,
            'price' => $this->price,
            'InStock' => $this->UnitsInStock> 0 ? true:false,
            'UnitsInStock' => $this->UnitsInStock,
            'description' => $this->description,
            'image' => $this->image,

        ];
    }
}
