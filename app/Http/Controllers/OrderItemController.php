<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;

/**
 * @OA\Tag(
 *     name="Order Items",
 *     description="API Endpoints for Order Item management"
 * )
 */
class OrderItemController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/order-items",
     *     summary="Get all order items",
     *     tags={"Order Items"},
     *     @OA\Response(
     *         response=200,
     *         description="List of order items"
     *     )
     * )
     */
    public function index()
    {
        $orderItems = OrderItem::with(['order', 'menu'])->get();
        return response()->json($orderItems);
    }

    /**
     * @OA\Post(
     *     path="/api/order-items",
     *     summary="Create a new order item",
     *     tags={"Order Items"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="order_id", type="integer"),
     *             @OA\Property(property="menu_id", type="integer"),
     *             @OA\Property(property="quantity", type="integer"),
     *             @OA\Property(property="price", type="number")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Order item created successfully"
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
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);
        $orderItem = OrderItem::create($validated);
        return response()->json($orderItem, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/order-items/{id}",
     *     summary="Get a specific order item",
     *     tags={"Order Items"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Order Item ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order item details"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order item not found"
     *     )
     * )
     */
    public function show($id)
    {
        $orderItem = OrderItem::with(['order', 'menu'])->findOrFail($id);
        return response()->json($orderItem);
    }

    /**
     * @OA\Put(
     *     path="/api/order-items/{id}",
     *     summary="Update an order item",
     *     tags={"Order Items"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Order Item ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="order_id", type="integer"),
     *             @OA\Property(property="menu_id", type="integer"),
     *             @OA\Property(property="quantity", type="integer"),
     *             @OA\Property(property="price", type="number")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order item updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order item not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $validated = $request->validate([
            'order_id' => 'sometimes|exists:orders,id',
            'menu_id' => 'sometimes|exists:menus,id',
            'quantity' => 'sometimes|integer',
            'price' => 'sometimes|numeric',
        ]);
        $orderItem->update($validated);
        return response()->json($orderItem);
    }

    /**
     * @OA\Delete(
     *     path="/api/order-items/{id}",
     *     summary="Delete an order item",
     *     tags={"Order Items"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Order Item ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order item deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order item not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
