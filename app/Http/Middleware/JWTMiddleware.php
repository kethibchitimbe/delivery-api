<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Http\Middleware\BaseMiddleware;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class JWTMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // First, let the parent middleware check for token existence
            $this->checkForToken($request);
            
            // Check if Authorization header starts with 'Bearer '
            $authHeader = $request->header('Authorization');
            if (!str_starts_with($authHeader, 'Bearer ')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid authorization format',
                    'code' => 'invalid_authorization_format',
                    'details' => 'Authorization header must start with "Bearer " followed by your JWT token'
                ], 401);
            }

            $user = $this->auth->parseToken()->authenticate();
        } catch (UnauthorizedHttpException $e) {
            // Handle "Token not provided" exception
            return response()->json([
                'status' => 'error',
                'message' => 'Authorization header is required',
                'code' => 'authorization_header_missing',
                'details' => 'Please provide a valid JWT token in the Authorization header as: Bearer <token>'
            ], 401);
        } catch (TokenExpiredException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'JWT token has expired',
                'code' => 'token_expired',
                'details' => 'Please refresh your token or login again to get a new token'
            ], 401);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'JWT token is invalid',
                'code' => 'token_invalid',
                'details' => 'Please provide a valid JWT token'
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'JWT token not found or malformed',
                'code' => 'token_not_found',
                'details' => 'Please provide a valid JWT token in the Authorization header'
            ], 401);
        }

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found for the provided token',
                'code' => 'user_not_found',
                'details' => 'The token is valid but the associated user no longer exists'
            ], 401);
        }

        return $next($request);
    }
} 