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
        if (Auth::guest() || Auth::user()->role != RoleEnum::ADMINISTRATOR->value) {
            echo '<pre>';
            var_dump('sdd');
            exit;

            abort(403);
        }

        return $next($request);
    }
}
