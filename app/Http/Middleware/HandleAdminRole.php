<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HandleAdminRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->role == RoleEnum::ADMINISTRATOR->value) {
            return $next($request);
        }

        abort(403);
    }
}
