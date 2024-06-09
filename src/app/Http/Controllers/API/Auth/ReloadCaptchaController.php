<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mews\Captcha\Facades\Captcha;

class ReloadCaptchaController extends Controller
{
    public function __invoke(Request $request)
    {
        cache()->has(\request()->ip())
            ?  cache()->increment(\request()->ip())
            :  cache()->put(\request()->ip(),0 , 3600);


        if (cache()->has(request()->ip()) and cache()->get(request()->ip()) >= 3)
        {
            $captcha= Captcha::create('flat', true);
            $response= ['is_fishy' => true ,  'image' => $captcha['img'], 'captcha_key' => $captcha['key'] ];
        }else
        {
            $response= ['is_fishy' => false,  'image' => false];
        }

        return response($response, Response::HTTP_OK);
    }
}
