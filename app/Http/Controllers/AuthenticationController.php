<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends ApiController
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = User::create(array_merge($validated, [
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
        ]));

        return $this->success('Account created successfully Log in to continue',
            ['user' => $user], 201);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ]);

        if (! Auth::attempt($validated)) {
            return $this->failed('Invalid log in credentials', 401);
        }

        $user = $request->user();
        $token = $user->createToken('auth', ['role' => $user->role], now()->addMinute(15))
            ->plainTextToken;

        return $this->success('Logged in successfully', [
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return $this->success('Logged out successfully');

    }
}
