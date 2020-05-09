<?php

namespace App\Http\Requests\Api;

class SocialAuthorizationRequest extends FormRequest
{
    public function rules()
    {
        $rules =  [
            // 当没有 access_token 时，code 为必须
            'code' => 'required_without:access_token|string',
            'access_token' => 'required_without:code|string',
        ];

        if ($this->social_type == 'weixin' && !$this->code) {
            $rules['openid'] = 'required|string';
        }

        return $rules;
    }
}
