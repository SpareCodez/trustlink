<?php

namespace App\Http\Controllers;

use App\Models\User;

class MerchantController extends Controller
{
    public function show(User $user)
    {
        return view('merchant.show', compact('user'));
    }
}
