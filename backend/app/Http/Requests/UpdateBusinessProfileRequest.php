<?php

namespace App\Http\Requests;

class UpdateBusinessProfileRequest extends StoreBusinessProfileRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        foreach ($rules as $key => $rule) $rules[$key] = array_merge(['sometimes'], $rule);
        return $rules;
    }
}
