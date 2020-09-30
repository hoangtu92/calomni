<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    //
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken($request->email)->plainTextToken;
    }

    public function logout () {
        Auth::logout();
    }


    public function detail (Request $request) {
        return new \App\Http\Resources\User($request->user());
    }

    //Get all tasks of current user
    public function tasks(Request $request)
    {
        return DB::table("tasks")
            ->join("jobs", "jobs.id", "=", "tasks.job_id")
            ->join("users", "jobs.user_id", "=", "users.id")
            ->where("users.id", "=", $request->user()->id)
            ->select(DB::raw("tasks.*"))
            ->get()->toArray();
    }
}
