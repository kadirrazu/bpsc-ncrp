<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

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
        return view('dashboard.user.add');
    }

    public function addNewUserCommit(Request $request)
    {
        $validated = $request->validate([
            'profile_image' => [
                'nullable',
                File::image()
                    ->min('1kb')
                    ->max('200kb')
                    ->dimensions(Rule::dimensions()->maxWidth(300)->maxHeight(300)),
            ],
            'name' => ['required','string'],
            'designation' => ['required'],
            'email' => ['required','email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $profileImagePath = null;

        if( $request->hasFile('profile_image') ){
         
            $profileImagePath = $request->file('profile_image')->store('profile_photos','public');

        }

        $user = new User();

        $user->name = $validated['name'];
        $user->designation = $validated['designation'];
        $user->email = $validated['email'];
        $user->password = Hash::make( $validated['password'] );
        $user->profile_image = $profileImagePath;

        $user->save();

        return redirect('/list-user')->with('success', 'User was added successfully.');

    }

    public function viewUser(Request $request){

        $user = User::findOrFail($request->id);

        return view('dashboard.user.show', ['user' => $user]);

    }

    public function editUser(Request $request){

        $user = User::findOrFail($request->id);

        return view('dashboard.user.edit', ['user' => $user]);

    }

    public function editUserCommit(Request $request){

        $validator = Validator::make($request->all(), [
            'profile_image' => [
                'nullable',
                File::image()
                    ->min('1kb')
                    ->max('200kb')
                    ->dimensions(Rule::dimensions()->maxWidth(300)->maxHeight(300)),
            ],
            'name' => ['required','string'],
            'designation' => ['required'],
            'email' => ['required','email'],
            'password' => ['nullable','min:8','confirmed'],
            'user_id' => ['required', 'numeric']
        ]);

        $validated = $validator->validated();

        $user = User::findOrFail( $validated['user_id'] );

        $user->name = $validated['name'];
        $user->designation = $validated['designation'];
        $user->email = $validated['email'];
        

        if( $request->hasFile('profile_image') ){
         
            $profileImagePath = $request->file('profile_image')->store('profile_photos','public');
            $user->profile_image = $profileImagePath;

        }

        if( $request->has('password') &&  $request->password != '' ){
         
            $user->password = Hash::make( $validated['password'] );

        }

        $user->save();

        return redirect('/list-user')->with('success', 'User was updated successfully.');

    }

    public function deleteUserCommit(Request $request){

        $user = User::find( $request->id );
 
        $user->delete();

        return redirect('/list-user')->with('error', 'User was deleted successfully.');
    }

}
