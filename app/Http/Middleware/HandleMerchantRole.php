<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HandleMerchantRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guest() || Auth::user()->role != RoleEnum::USER->value || Auth::user()->role != RoleEnum::MERCHANT->value) {
            abort(403);
        }

        return $next($request);
    }
}
