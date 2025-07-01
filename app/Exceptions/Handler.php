<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use UnexpectedValueException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Handle authentication exceptions
        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Authentication required',
                    'code' => 'authentication_required',
                    'details' => 'Please provide valid authentication credentials'
                ], 401);
            }
        });

        // Handle authorization exceptions
        $this->renderable(function (AuthorizationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Access denied',
                    'code' => 'access_denied',
                    'details' => 'You do not have permission to perform this action'
                ], 403);
            }
        });

        // Handle model not found exceptions
        $this->renderable(function (ModelNotFoundException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Resource not found',
                    'code' => 'resource_not_found',
                    'details' => 'The requested resource could not be found'
                ], 404);
            }
        });

        // Handle route not found exceptions
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Endpoint not found',
                    'code' => 'endpoint_not_found',
                    'details' => 'The requested API endpoint does not exist'
                ], 404);
            }
        });

        // Handle method not allowed exceptions
        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Method not allowed',
                    'code' => 'method_not_allowed',
                    'details' => 'The HTTP method is not supported for this endpoint'
                ], 405);
            }
        });

        // Handle throttle exceptions
        $this->renderable(function (ThrottleRequestsException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Too many requests',
                    'code' => 'too_many_requests',
                    'details' => 'Please wait before making another request'
                ], 429);
            }
        });

        // Handle JWT Unauthorized exceptions
        $this->renderable(function (UnauthorizedHttpException $e, $request) {
            if ($request->expectsJson()) {
                $msg = $e->getMessage();
//                if (str_contains($msg, 'Token not provided')) {
//                    return response()->json([
//                        'status' => 'error',
//                        'message' => 'Authorization header is required',
//                        'code' => 'authorization_header_missing',
//                        'details' => 'Please provide a valid JWT token in the Authorization header as: Bearer <token>'
//                    ], 401);
//                }
//                if (str_contains($msg, 'Could not decode token')) {
//                    return response()->json([
//                        'status' => 'error',
//                        'message' => 'JWT token not found or malformed',
//                        'code' => 'token_not_found',
//                        'details' => 'Please provide a valid JWT token in the Authorization header'
//                    ], 401);
//                }
                // fallback
                return response()->json([
                    'status' => 'error',
                    'message' => $msg ?: 'Unauthorized',
                    'code' => 'unauthorized'
                ], 401);
            }
        });

        // Optionally, handle malformed tokens
        $this->renderable(function (UnexpectedValueException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'JWT token not found or malformed',
                    'code' => 'token_not_found',
                    'details' => 'Please provide a valid JWT token in the Authorization header'
                ], 401);
            }
        });
    }
}
