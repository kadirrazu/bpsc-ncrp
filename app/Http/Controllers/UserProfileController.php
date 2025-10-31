<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Models\User;

class UserProfileController extends Controller
{
    public function viewUserProfile(Request $request)
    {
        $user = Auth::user();

        return view('dashboard.user.profile', ['user' => $user]);
    }

    public function passwordChangeWindow()
    {
        $user = Auth::user();

        return view('dashboard.user.change-password', ['user' => $user]);
    }

    public function passwordChangeCommit(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The provided current password does not match your actual password.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

    public function getUserList()
    {
        $users = User::all();

        return view('dashboard.user.list', [ 'users' => $users ]);
    }

    public function addNewUser()
    {
        return view('dashboard.user.add-new');
    }
}
