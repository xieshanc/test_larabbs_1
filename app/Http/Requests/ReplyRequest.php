<?php

namespace App\Http\Requests;

class ReplyRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            // CREATE
            case 'POST':
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'content' => 'required',
                ];
            }
            default:
            {
                return [];
            }
        }
    }

    public function messages()
    {
        return [
            // Validation messages
        ];
    }
}
