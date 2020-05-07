<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\CaptchaRequest;
use Illuminate\Support\Str;
use Gregwar\Captcha\CaptchaBuilder;
use App\Services\CaptchaService;

class CaptchasController extends Controller
{
    public function show(CaptchaService $captchaService)
    {
        echo '<pre>';
        var_dump('???');
        exit;
        // header('Content-type: image/jpeg');
        // $captchaService->register();
    }

    public function store(CaptchaRequest $request, CaptchaBuilder $captchaBuilder)
    {
        $key = 'captcha-' . Str::random(15);
        $phone = $request->phone;

        $captcha = $captchaBuilder->build();
        $expiredAt = now()->addMinutes(2);

        $data = ['phone' => $phone, 'code' => $captcha->getPhrase()];
        \Cache::put($key, $data, $expiredAt);

        $result = [
            'captcha_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
            'captcha'   => $captcha->getPhrase(),
            'captcha_image_content' => $captcha->inline(),
        ];

        return response()->json($result)->setStatusCode(201);
    }
}
