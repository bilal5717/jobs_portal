<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Company;
use Illuminate\Support\Str;
class AuthController extends Controller
{
    //

    public function register(){
        return view('auth.register');
    }
    public function login(){
        return view('auth.login');
    }
    
    public function verify(){
        return view('auth.verify');
    }
    
    public function forgot(){
        return view('auth.forgot');
    }

    public function resetForm(Request $request, $token = null)
    {
        return view('auth.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function createAccount(Request $request){
       $validator =  $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

            // dd($validator);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        toastr()->success('User registered successfully.');

        return redirect('/login');
    }
}
