<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\BaseApiRequest;


class LoginRequest extends BaseApiRequest {
    public function rules() {
        return [
            'email'       => 'required|email|exists:users,email|max:50',
            'password'    => 'required|min:6|max:100',
            'remember_me' => 'boolean'
        ];
    }
}


