<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(private UserRepository $userRepository)
    {}

    public function login(LoginRequest $request)
    {
        $user = $this->userRepository->findByEmail($request->email);
 
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
 
        $user->tokens()->delete();
        $token = $user->createToken($request->device_name)->plainTextToken;
        return response()->json(['token' => $token]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([], 204);
    }

    public function me()
    {
        $user = Auth::user();
        $user->load('permissions');
        
        return $user;
    }
}
