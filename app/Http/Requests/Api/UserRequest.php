<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|between:3,25|regex:/^\w+$/|unique:users,name',
                    'password'  => 'required|alpha_dash|min:6',
                    'verification_key' => 'required|string',
                    'verification_code' => 'required|string',
                ];
                break;
            case 'PATCH':
                // $userId = auth('api')->id();
                $userId = \Auth::id();
                return [
                    // 'name' => 'required|between:3,25|regex:/^\w+$/|unique:users,name,' . $userId,
                    'name' => [
                        'required', 'between:3,25', 'regex:/^\w+$/',
                        Rule::unique('users', 'name')->ignore($userId),
                    ],
                    // 'email' => 'email|unique:users,email,' . $userId,
                    'email' => [
                        'email',
                        Rule::unique('users', 'email')->ignore($userId),
                    ],
                    'introduction' => 'max:80',
                    // 简写
                    // 'avatar_image_id' => 'exists:images,id,type,avatar,user_id,' . $userId,
                    // 详细
                    'avatar_image_id' => [
                        Rule::exists('images', 'id')->where(function ($query) use ($userId) {
                            $query->where([
                                'type' => 'avatar',
                                'user_id' => $userId,
                            ]);
                        }),
                    ],
                    // 这么写不行
                    // 'avatar_image_id' => [
                    //     Rule::exists('images', 'id')->where([
                    //         'type' => 'avatar',
                    //         'user_id' => $userId,
                    //     ]),
                    // ],
                ];
                break;
        }


    }

    public function attributes()
    {
        return [
            'verification_key' => '短信验证码 key',
            'verification_code' => '短信验证码',
        ];
    }

    public function message()
    {
        return [

        ];
    }
}
