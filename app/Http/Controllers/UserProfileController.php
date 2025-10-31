<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\User;

class UserProfileController extends Controller
{
    public function viewUserProfile(Request $request)
    {
        $user = Auth::user();

        return view('dashboard.user.profile', ['user' => $user]);
    }
}
