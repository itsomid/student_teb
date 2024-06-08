<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRegistrationCompletion
{
    public function handle(Request $request, Closure $next): Response
    {

        if (auth('student')->check() && empty(auth('student')->user()->name))
            return redirect()->route('student.auth.otp.register');

//        if (auth('student')->check() && !auth('student')->user()->verified)
//            return redirect()->route('student.auth.otp.term-condition');

        return $next($request);
    }
}
