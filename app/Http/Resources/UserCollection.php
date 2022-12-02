<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    protected $foo;

    public function foo($value){
        $this->foo = $value;
        return $this;
    }
    public function toArray($request){
        return $this->collection->map(function(UserResource $resource) use($request){
            return $resource->foo($this->foo)->toArray($request);
    })->all();


  }
}