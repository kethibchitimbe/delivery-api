<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

/**
 * @OA\Tag(
 *     name="Menus",
 *     description="API Endpoints for Menu management"
 * )
 */
class MenuController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/menus",
     *     summary="Get all menu items",
     *     tags={"Menus"},
     *     @OA\Response(
     *         response=200,
     *         description="List of menu items"
     *     )
     * )
     */
    public function index()
    {
        $menus = Menu::with(['restaurant', 'orderItems'])->get();
        return response()->json($menus);
    }

    /**
     * @OA\Post(
     *     path="/api/menus",
     *     summary="Create a new menu item",
     *     tags={"Menus"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="restaurant_id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="price", type="number"),
     *             @OA\Property(property="image_url", type="string"),
     *             @OA\Property(property="is_available", type="boolean")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Menu item created successfully"
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
            'restaurant_id' => 'required|exists:restaurants,id',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image_url' => 'nullable|string',
            'is_available' => 'boolean',
        ]);
        $menu = Menu::create($validated);
        return response()->json($menu, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/menus/{id}",
     *     summary="Get a specific menu item",
     *     tags={"Menus"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Menu ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Menu item details"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Menu item not found"
     *     )
     * )
     */
    public function show($id)
    {
        $menu = Menu::with(['restaurant', 'orderItems'])->findOrFail($id);
        return response()->json($menu);
    }

    /**
     * @OA\Put(
     *     path="/api/menus/{id}",
     *     summary="Update a menu item",
     *     tags={"Menus"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Menu ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="restaurant_id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="price", type="number"),
     *             @OA\Property(property="image_url", type="string"),
     *             @OA\Property(property="is_available", type="boolean")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Menu item updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Menu item not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $validated = $request->validate([
            'restaurant_id' => 'sometimes|exists:restaurants,id',
            'name' => 'sometimes|string',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric',
            'image_url' => 'nullable|string',
            'is_available' => 'boolean',
        ]);
        $menu->update($validated);
        return response()->json($menu);
    }

    /**
     * @OA\Delete(
     *     path="/api/menus/{id}",
     *     summary="Delete a menu item",
     *     tags={"Menus"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Menu ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Menu item deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Menu item not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
