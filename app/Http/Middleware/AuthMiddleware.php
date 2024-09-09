<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // $userInfo = Session::get('userConfirmOTP');
        // if (!$userInfo) {
        //     return redirect("/login")->with("message", "Vui long dang nhap");
        // } 
        // switch ($userInfo->role) {
        //     case 'admin':
        //         return $next($request);
        //     case 'user':
        //         return redirect('/home');
        //     default:
        //         return redirect('/login');
        // }
        return $next($request);
    }
}
