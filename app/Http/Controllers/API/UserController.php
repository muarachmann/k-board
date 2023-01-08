<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Get user's profile
     * @return Response|Application|ResponseFactory
     */
    public function profile(): Response|Application|ResponseFactory
    {
        $user = auth()->user();
        return response(['user' => $user], 200);
    }
}
