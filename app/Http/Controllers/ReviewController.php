<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

/**
 * @OA\Tag(
 *     name="Reviews",
 *     description="API Endpoints for Review management"
 * )
 */
class ReviewController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/reviews",
     *     summary="Get all reviews",
     *     tags={"Reviews"},
     *     @OA\Response(
     *         response=200,
     *         description="List of reviews"
     *     )
     * )
     */
    public function index()
    {
        $reviews = Review::with(['order', 'user', 'restaurant'])->get();
        return response()->json($reviews);
    }

    /**
     * @OA\Post(
     *     path="/api/reviews",
     *     summary="Create a new review",
     *     tags={"Reviews"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="order_id", type="integer"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="restaurant_id", type="integer"),
     *             @OA\Property(property="rating", type="integer", minimum=1, maximum=5),
     *             @OA\Property(property="comment", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Review created successfully"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'user_id' => 'required|exists:users,id',
            'restaurant_id' => 'required|exists:restaurants,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);
        $review = Review::create($validated);
        return response()->json($review, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/reviews/{id}",
     *     summary="Get a specific review",
     *     tags={"Reviews"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Review ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Review details"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Review not found"
     *     )
     * )
     */
    public function show($id)
    {
        $review = Review::with(['order', 'user', 'restaurant'])->findOrFail($id);
        return response()->json($review);
    }

    /**
     * @OA\Put(
     *     path="/api/reviews/{id}",
     *     summary="Update a review",
     *     tags={"Reviews"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Review ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="order_id", type="integer"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="restaurant_id", type="integer"),
     *             @OA\Property(property="rating", type="integer", minimum=1, maximum=5),
     *             @OA\Property(property="comment", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Review updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Review not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $validated = $request->validate([
            'order_id' => 'sometimes|exists:orders,id',
            'user_id' => 'sometimes|exists:users,id',
            'restaurant_id' => 'sometimes|exists:restaurants,id',
            'rating' => 'sometimes|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);
        $review->update($validated);
        return response()->json($review);
    }

    /**
     * @OA\Delete(
     *     path="/api/reviews/{id}",
     *     summary="Delete a review",
     *     tags={"Reviews"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Review ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Review deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Review not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
