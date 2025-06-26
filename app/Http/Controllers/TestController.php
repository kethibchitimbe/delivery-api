<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Food Delivery API",
 *     description="API for Food Delivery Application",
 *     @OA\Contact(
 *         email="admin@example.com"
 *     )
 * )
 */
class TestController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/test",
     *     summary="Test endpoint",
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     )
     * )
     */
    public function test()
    {
        return response()->json(['message' => 'Test successful']);
    }
} 