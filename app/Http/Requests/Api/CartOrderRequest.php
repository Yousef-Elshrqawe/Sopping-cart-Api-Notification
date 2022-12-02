<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\BaseApiRequest;


class CartOrderRequest extends BaseApiRequest {
    public function rules() {
        return [
            'cartKey' => 'required',
            'name' => 'required',
            'adress' => 'required',
            'credit card number' => 'required',
            'expiration_year' => 'required',
            'expiration_month' => 'required',
            'cvc' => 'required',
        ];
    }
}

