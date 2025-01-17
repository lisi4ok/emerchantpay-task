<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'role' => array_flip(RoleEnum::array())[Auth::user()->role],
        ]);
    }
}
