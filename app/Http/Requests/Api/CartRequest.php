<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\BaseApiRequest;

class CartRequest extends BaseApiRequest {
    public function rules() {
        return [
            'cartKey' => 'required',
            'productID' => 'required',
            'quantity' => 'required|numeric|min:1|max:10',
        ];
    }
}

