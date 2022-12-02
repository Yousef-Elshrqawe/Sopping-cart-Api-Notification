<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\BaseApiRequest;


class SendMailRequest extends BaseApiRequest {
    public function rules() {
        return [
            'greating' => 'required',
            'body' => 'required',
            'actiontext' => 'required',
            'actionurl' => 'required',
            'endtext' => 'required',
        ];
    }
}

