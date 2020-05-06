<?php

namespace App\Http\Requests;

class ReplyRequest extends Request
{
    public function rules()
    {
        switch($this->method()) {
            case 'POST':
            case 'PUT':
                return [
                    'content' => 'required',
                ];
                break;
            default:
                return [];
        }
    }

    public function messages()
    {
        return [
            // Validation messages
        ];
    }
}
