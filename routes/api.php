<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::prefix('v1')->name('api.v1.')->group(function () {
//     Route::post('verificationCodes', 'VerificationCodesController@store')->name('verificationCodes.store');
// });

Route::prefix('v1')
    ->namespace('Api')
    ->name('api.v1.')
    ->group(function () {

        Route::middleware('throttle:' . config('api.rate_limits.sign'))
            ->group(function () {
                // 生成图片验证码
                Route::post('captchas', 'CaptchasController@store')->name('captchas.store');
                // 显示图片验证码
                Route::get('captchas', 'CaptchasController@show')->name('captchas.show');
                // 发送短信
                Route::post('verificationCodes', 'VerificationCodesController@store')->name('verificationCodes.store');
                // 用户注册
                Route::post('users', 'UsersController@store')->name('users.store');
                // 第三方登录
                Route::post('socials/{social_type}/authorizations', 'AuthorizationsController@socialStore')->where('social_type', 'weixin')->name('socials.authorizations.store');
            });

        Route::middleware('throttle:' . config('api.rate_limits.access'))
            ->group(function () {

        });

});


Route::prefix('v2')->name('api.v2.')->group(function () {
    Route::get('version', function () {
        abort(403, '你🐴没了');
        return 'this is version v2';
    })->name('version');
});

Route::prefix('v1')->name('api.v1.')->group(function () {
    // Route::get('version', function () {
    //     return 'this is version v1';
    // })->name('version');
});

// Route::prefix('v2')->name('api.v2.')->group(function () {
//     Route::get('version', function () {
//         return 'this is version v2';
//     })->name('version');
// });
