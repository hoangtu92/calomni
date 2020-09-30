<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FrontendController extends Controller
{
    //

    public function home(){
        $bodyClass = "home";
        return view("welcome")->with(compact("bodyClass"));
    }

    public function signUpHost(){
        $bodyClass = "sign-up-node-operator requirements";
        return view("auth.sign_up_host.step1")->with(compact("bodyClass"));
    }

    public function signUpHostVerification(Request $request){

        if($request->isMethod("post")){
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
                'license_agree' => ["required"]
            ]);

            $code = sha1($request->input("email").time());

            $user = new User([
                'uid' => Str::uuid(),
                "name" => $request->input("name"),
                "password" => Hash::make($request->input("password")),
                "email" => $request->input("email"),
                "code" => $code,
                "role" => User::SH
            ]);

            $user->save();
            Auth::login($user);

            $user->sendEmailVerificationNotification();
        }

        $bodyClass = "sign-up-node-operator complete";
        return view("auth.sign_up_host.step2")->with(compact("bodyClass"));
    }

    public function signUpVerification(){
        return view("auth.email_verification");
    }
    public function signUpComplete(){
        return view("auth.sign_up_complete");
    }
}
