<?php

namespace App\Services;

use Cache;
use Illuminate\Support\Str;
use Gregwar\Captcha\CaptchaBuilder;

class CaptchaService
{

    protected $captcha;

    public function __construct(CaptchaBuilder $captchaBuilder)
    {
        $this->captcha = $captchaBuilder->build();
    }

    public function register()
    {
        $data = ['phone' => 1];
        $this->makeCaptcha(120, $data);
    }

    public function general()
    {
        $this->makeCaptcha();
    }

    protected function makeCaptcha($expireTime = 600, $data = array())
    {
        $key = 'captcha-' . Str::random(15);


        $data = array_merge(['code' => $this->captcha->getPhrase()], $data);
        $expiredAt = now()->unix() + $expireTime;

        Cache::put($key, $data, $expiredAt);

        header('Content-type: image/jpeg');
        $this->captcha->output();
    }
}
