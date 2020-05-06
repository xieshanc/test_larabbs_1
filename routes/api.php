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

Route::prefix('v1')->name('api.v1.')->namespace('Api')->group(function () {
    Route::post('verificationCodes', 'VerificationCodesController@store')->name('verificationCodes.store');
});


Route::prefix('v2')->name('api.v2.')->group(function () {
    Route::get('version', function () {
        abort(403, '你🐴没了');
        return 'this is version v2';
    })->name('version');
});
