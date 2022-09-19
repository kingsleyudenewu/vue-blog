<?php

namespace App\Http\Controllers;

use App\Actions\GenerateTokenAction;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register a user into the blog system
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => User::USER
        ]);

        $payload = (new GenerateTokenAction())->generatePayload($user);

        return $this->createdResponse("User created successfully", $payload);
    }

    /**
     * Login a user into the blog system
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        if(!Auth::attempt($request->only(['email', 'password']))){
            return $this->badRequestAlert('Invalid login credentials');
        }

        $user = User::where('email', $request->email)->first();

        $payload = (new GenerateTokenAction())->generatePayload($user);

        return $this->successResponse('User Logged In Successfully', $payload);
    }

    /**
     * Log user out and destroy token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->successResponse('User successfully logout');
    }
}
