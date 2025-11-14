<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use App\Models\Exam;

class SessionController extends Controller
{
    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {

        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/')->withErrors([
            'email' => 'You have logged out from the system.',
        ])->onlyInput('email');

    } //End of function logout()

    /**
     * Process login request.
     */
    public function processLogin(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = false;

        if($request->input('remember-me') == 'on'){
            $remember = true;
        }

        if(Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
 
            return redirect()->intended('dashboard')->with('push-success','You have Logged In!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');

    } //End of function processLogin()

    public function serveDashboard()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        return view('dashboard.dashboard', [
            'currentExam' => $currentExam
        ]);
    }

} //End of Class 'SessionController'
