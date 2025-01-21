<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    public function updating(User $user)
    {
        if (Auth::user()) {
            $user->updated_by = Auth::user()->id;
        }
    }

    public function saving(User $user)
    {
        if (Auth::user()) {
            $user->created_by = Auth::user()->id;
        }
    }
}
