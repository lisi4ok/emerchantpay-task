<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class TransactionsController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard');
    }
}
