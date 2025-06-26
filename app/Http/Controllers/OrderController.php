<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Models\Order;

/**
 * @OA\Tag(
 *     name="Orders",
 *     description="API Endpoints for Order management"
 * )
 */
class OrderController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/orders",
     *     summary="Get all orders",
     *     tags={"Orders"},
     *     @OA\Response(
     *         response=200,
     *         description="List of orders"
     *     )
     * )
     */
    public function index()
    {
        $orders = Order::with(['user', 'restaurant', 'orderItems', 'delivery', 'review'])->get();
        return response()->json($orders);
    }

    /**
     * @OA\Post(
     *     path="/api/orders",
     *     summary="Create a new order",
     *     tags={"Orders"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="restaurant_id", type="integer"),
     *             @OA\Property(property="total_price", type="number"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(property="payment_status", type="string"),
     *             @OA\Property(property="delivery_address", type="string"),
     *             @OA\Property(property="placed_at", type="string", format="date-time"),
     *             @OA\Property(property="completed_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Order created successfully"
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
            'restaurant_id' => 'required|exists:restaurants,id',
            'total_price' => 'required|numeric',
            'status' => 'required|string',
            'payment_status' => 'required|string',
            'delivery_address' => 'required|string',
            'placed_at' => 'required|date',
            'completed_at' => 'nullable|date',
        ]);
        $order = Order::create($validated);
        return response()->json($order, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/orders/{id}",
     *     summary="Get a specific order",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Order ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order details"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found"
     *     )
     * )
     */
    public function show($id)
    {
        $order = Order::with(['user', 'restaurant', 'orderItems', 'delivery', 'review'])->findOrFail($id);
        return response()->json($order);
    }

    /**
     * @OA\Put(
     *     path="/api/orders/{id}",
     *     summary="Update an order",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Order ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="restaurant_id", type="integer"),
     *             @OA\Property(property="total_price", type="number"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(property="payment_status", type="string"),
     *             @OA\Property(property="delivery_address", type="string"),
     *             @OA\Property(property="placed_at", type="string", format="date-time"),
     *             @OA\Property(property="completed_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'restaurant_id' => 'sometimes|exists:restaurants,id',
            'total_price' => 'sometimes|numeric',
            'status' => 'sometimes|string',
            'payment_status' => 'sometimes|string',
            'delivery_address' => 'sometimes|string',
            'placed_at' => 'sometimes|date',
            'completed_at' => 'nullable|date',
        ]);
        $order->update($validated);
        return response()->json($order);
    }

    /**
     * @OA\Delete(
     *     path="/api/orders/{id}",
     *     summary="Delete an order",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Order ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Order not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
