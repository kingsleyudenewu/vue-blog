<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken("API TOKEN")->plainTextToken;

        return $this->createdResponse("User created successfully", $token);
    }

    public function login(LoginRequest $request)
    {
        if(!Auth::attempt($request->only(['email', 'password']))){
            return $this->badRequestAlert('Invalid login credentials');
        }

        $user = User::where('email', $request->email)->first();

        return $this->successResponse('User Logged In Successfully', $user->createToken("API TOKEN")->plainTextToken);
    }
}
