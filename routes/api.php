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
    ->name('api.v1.')->group(function () {


    Route::middleware('throttle:' . config('api.rate_limits.sign'))->group(function () {
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
        // 登录
        Route::post('authorizations', 'AuthorizationsController@store')->name('api.authorizations.store');
        // 刷新 token
        Route::put('authorizations/current', 'AuthorizationsController@update')->name('authorizations.update');
        // 删除 token
        Route::delete('authorizations/current', 'AuthorizationsController@destroy')->name('authorizations.destroy');
    });

    Route::middleware('throttle:' . config('api.rate_limits.access'))->group(function () {
        // 游客可以访问的接口
        // 某个用户的详情
        Route::get('users/{user}', 'UsersController@show')->name('users.show');
        // 分类列表
        Route::get('categories', 'CategoriesController@index')->name('categories.index');
        // 话题列表、详情
        Route::resource('topics', 'TopicsController')->only([
            'index', 'show'
        ]);
        // 某个用户发布的帖子列表
        Route::get('users/{user}/topics', 'TopicsController@userIndex')->name('users.topics.index');

        // 要求登录
        Route::middleware('auth:api')->group(function () {
            // 当前登录用户
            Route::get('user', 'UsersController@me')->name('user.show');
            // 用户列表
            Route::get('users', 'UsersController@index')->name('users.index');
            // 编辑登录用户信息
            Route::patch('user', 'UsersController@update')->name('user.update');
            // 上传图片
            Route::post('images', 'ImagesController@store')->name('images.store');
            // 发布、修改、删除话题
            Route::resource('topics', 'TopicsController')->only([
                'store', 'update', 'destroy'
            ]);
        });
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
