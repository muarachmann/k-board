<?php

namespace App\Http\Middleware;

use App\Models\BasicAccessToken;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AccessToken
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse)  $next
     * @return JsonResponse|Response
     */
    public function handle(Request $request, Closure $next): Response|JsonResponse
    {
        if (!$request->has('access_token')) {
            return response()->json([
                'message' => 'Not a valid API requests.',
            ], 404);
        }
        // check if the api key is valid
        if (!BasicAccessToken::where('token', $request->access_token)
            ->where('expires_at', '>', Carbon::now())->exists()) {
            return response()->json([
                'message' => 'Not a valid API request.',
            ], 404);
        }
        return $next($request);
    }
}
