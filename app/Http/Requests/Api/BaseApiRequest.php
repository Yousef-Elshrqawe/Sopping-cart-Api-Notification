<?php

namespace App\Http\Requests\Api;
use App\Traits\GeneralTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseApiRequest extends FormRequest {
    use GeneralTrait;
    public function authorize() {
        return true;
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException($this->returnValidationError('E001', $validator));
    }
}
