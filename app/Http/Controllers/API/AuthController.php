<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login user
     * @param Request $request
     * @return Response|Application|ResponseFactory
     */
    public function login(Request $request): Response|Application|ResponseFactory
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check( $data['password'], $user->password)) {
            return response(['message' => 'Invalid Credentials provided!'], 404);
        }

        $token = $user->createToken('kanban-token')->plainTextToken;

        return response(['user' => $user, 'access_token' => $token], 201);
    }

    /**
     * Logout user
     * @return Response|Application|ResponseFactory
     */
    public function logout(): Response|Application|ResponseFactory
    {
        auth()->user()->tokens()->delete();
        return response([ 'message' => 'User logged out!'], 201);
    }
}
