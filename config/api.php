<?php

return [
    'rate_limits' => [
        // 访问频率限制
        'access' => env('RATE_LIMITS', '60,1'),
        // 登录频率限制
        'sign' => env('SIGN_RATE_LIMITS', '10,1'),
    ],
];
