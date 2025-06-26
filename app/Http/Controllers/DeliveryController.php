<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;

/**
 * @OA\Tag(
 *     name="Deliveries",
 *     description="API Endpoints for Delivery management"
 * )
 */
class DeliveryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/deliveries",
     *     summary="Get all deliveries",
     *     tags={"Deliveries"},
     *     @OA\Response(
     *         response=200,
     *         description="List of deliveries"
     *     )
     * )
     */
    public function index()
    {
        $deliveries = Delivery::with(['order', 'deliveryPartner'])->get();
        return response()->json($deliveries);
    }

    /**
     * @OA\Post(
     *     path="/api/deliveries",
     *     summary="Create a new delivery",
     *     tags={"Deliveries"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="order_id", type="integer"),
     *             @OA\Property(property="delivery_partner_id", type="integer"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(property="delivered_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Delivery created successfully"
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
            'delivery_partner_id' => 'required|exists:users,id',
            'status' => 'required|string',
            'delivered_at' => 'nullable|date',
        ]);
        $delivery = Delivery::create($validated);
        return response()->json($delivery, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/deliveries/{id}",
     *     summary="Get a specific delivery",
     *     tags={"Deliveries"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Delivery ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Delivery details"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Delivery not found"
     *     )
     * )
     */
    public function show($id)
    {
        $delivery = Delivery::with(['order', 'deliveryPartner'])->findOrFail($id);
        return response()->json($delivery);
    }

    /**
     * @OA\Put(
     *     path="/api/deliveries/{id}",
     *     summary="Update a delivery",
     *     tags={"Deliveries"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Delivery ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="order_id", type="integer"),
     *             @OA\Property(property="delivery_partner_id", type="integer"),
     *             @OA\Property(property="status", type="string"),
     *             @OA\Property(property="delivered_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Delivery updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Delivery not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $delivery = Delivery::findOrFail($id);
        $validated = $request->validate([
            'order_id' => 'sometimes|exists:orders,id',
            'delivery_partner_id' => 'sometimes|exists:users,id',
            'status' => 'sometimes|string',
            'delivered_at' => 'nullable|date',
        ]);
        $delivery->update($validated);
        return response()->json($delivery);
    }

    /**
     * @OA\Delete(
     *     path="/api/deliveries/{id}",
     *     summary="Delete a delivery",
     *     tags={"Deliveries"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Delivery ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Delivery deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Delivery not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $delivery = Delivery::findOrFail($id);
        $delivery->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
