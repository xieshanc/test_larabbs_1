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
        echo '<pre>';
        var_dump($request->phone);
        exit;
    }
}
