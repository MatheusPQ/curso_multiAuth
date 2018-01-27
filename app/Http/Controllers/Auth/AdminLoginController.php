<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminLoginController extends Controller
{
    public function __contruct(){
        $this->middleware('guest');
        //guest:admin permite logar como user e admin ao mesmo tempo
        //se fosse só 'guest', não seria possível
    }

    public function showLoginForm() {
        return view('auth.admin-login');
    }
    
    public function login(Request $request){
        //Validate the form data
        $this->validate($request, [
            'email'     => 'required|email',
            'password'  => 'required|min:6'
        ]);

        // Attempt to log the user in
        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) { //True, if successful
            // Redirect to their intended location
            return redirect()->intended(route('admin.dashboard')); //Redirect to the intended page the user wanted to go
        }
        
        // Redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email', 'remember')); //Page the user was before (the login page) with the input data (except the password)
        


    }
}
