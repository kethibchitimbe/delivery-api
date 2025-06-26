<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;

/**
 * @OA\Tag(
 *     name="Restaurants",
 *     description="API Endpoints for Restaurant management"
 * )
 */
class RestaurantController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/restaurants",
     *     summary="Get all restaurants",
     *     tags={"Restaurants"},
     *     @OA\Response(
     *         response=200,
     *         description="List of restaurants"
     *     )
     * )
     */
    public function index()
    {
        $restaurants = Restaurant::with(['user', 'menus', 'orders', 'reviews'])->get();
        return response()->json($restaurants);
    }

    /**
     * @OA\Post(
     *     path="/api/restaurants",
     *     summary="Create a new restaurant",
     *     tags={"Restaurants"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="phone", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="logo_url", type="string"),
     *             @OA\Property(property="is_active", type="boolean")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Restaurant created successfully"
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
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'description' => 'nullable|string',
            'logo_url' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        $restaurant = Restaurant::create($validated);
        return response()->json($restaurant, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/restaurants/{id}",
     *     summary="Get a specific restaurant",
     *     tags={"Restaurants"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Restaurant ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Restaurant details"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Restaurant not found"
     *     )
     * )
     */
    public function show($id)
    {
        $restaurant = Restaurant::with(['user', 'menus', 'orders', 'reviews'])->findOrFail($id);
        return response()->json($restaurant);
    }

    /**
     * @OA\Put(
     *     path="/api/restaurants/{id}",
     *     summary="Update a restaurant",
     *     tags={"Restaurants"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Restaurant ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="address", type="string"),
     *             @OA\Property(property="phone", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="logo_url", type="string"),
     *             @OA\Property(property="is_active", type="boolean")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Restaurant updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Restaurant not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'name' => 'sometimes|string',
            'address' => 'sometimes|string',
            'phone' => 'sometimes|string',
            'description' => 'nullable|string',
            'logo_url' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        $restaurant->update($validated);
        return response()->json($restaurant);
    }

    /**
     * @OA\Delete(
     *     path="/api/restaurants/{id}",
     *     summary="Delete a restaurant",
     *     tags={"Restaurants"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Restaurant ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Restaurant deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Restaurant not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
