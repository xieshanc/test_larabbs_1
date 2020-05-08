<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Api\VerificationCodeRequest;

class PagesController extends Controller
{
    public function root()
    {
        return view('pages.root');
    }

    public function permissionDenied()
    {
        if (config('administrator.permission')()) {
            return redirect(url(config('administrator.uri')), 302);
        }

        return view('pages.permission_denied');
    }

    public function test()
    {
        $code = '011EGleg1gmiTt0YVPdg1vWFeg1EGle6';
        $driver = Socialite::driver('weixin');
        $response = $driver->getAccessTokenResponse($code);
        $driver->setOpenId($response['openid']);
        $oauthUser = $driver->userFromToken($response['access_token']);

        // 第三步：通过 access_token 和 openid 取用户信息
        $accessToken = '33_toTr2MGjkO0Skcw7gWYCwhXqRR_rFxhMpUD4-7QD627svgyR9hty202l2OTcCg14WbDeRwMBfgG9jcnDKx3AfA';
        $openID = 'okUYy0YCAFAcyc9UbMvCMD8ZpdvM';
        $driver = Socialite::driver('weixin');
        $driver->setOpenId($openID);
        $oauthUser = $driver->userFromToken($accessToken);
    }
}
