<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    
    // Get user's orders
    public function getAllOrder(Request $request)
    {
        $orders = Order::with('items.product')
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'orders' => $orders,
        ]);
    }

    
     // Get single order
     
    public function getSingleOrder(Request $request, $id)
    {
        $order = Order::with('items.product')
            ->where('user_id', $request->user()->id)
            ->where('id', $id)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    //Create order from cart
    
    public function createOrder(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|array',
            'payment_method' => 'required|string',
        ]);

        $cartItems = CartItem::with('product')
            ->where('user_id', $request->user()->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty',
            ], 400);
        }

        DB::beginTransaction();

        try {
            // Calculate total
            $total = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            // Generate unique order number
            $orderNumber = 'ORD-' . strtoupper(uniqid());

            // Create order
            $order = Order::create([
                'user_id' => $request->user()->id,
                'order_number' => $orderNumber,
                'total' => $total,
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'billing_address' => $request->billing_address ?? $request->shipping_address,
                'payment_method' => $request->payment_method,
                'payment_status' => 'paid', // Mark as paid immediately for now
                'notes' => $request->notes,
            ]);

            // Create order items and update stock
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                    'subtotal' => $cartItem->product->price * $cartItem->quantity,
                ]);

                // Update product stock
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            // Save payment method if not already saved
            $this->savePaymentMethod($request->user(), $request->payment_method);

            // Clear cart
            CartItem::where('user_id', $request->user()->id)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'data' => $order->load('items.product'),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create order',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    
     //Cancel order
     
    public function cancelOrder(Request $request, $id)
    {
        $order = Order::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }

        if ($order->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Only pending orders can be cancelled',
            ], 400);
        }

        DB::beginTransaction();

        try {
            // Restore stock
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            $order->update(['status' => 'cancelled']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully',
                'data' => $order,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel order',
            ], 500);
        }
    }

    /**
     * Save payment method to user's saved payment methods
     */
    private function savePaymentMethod($user, $paymentMethod)
    {
        // Check if this payment method type already exists for the user
        $existingMethod = $user->paymentMethods()
            ->where('type', $paymentMethod)
            ->first();

        if (!$existingMethod) {
            // Create a new payment method record
            $user->paymentMethods()->create([
                'type' => ucfirst($paymentMethod),
                'last4' => '****', // Placeholder since we don't have actual card details
                'expiry' => null,
                'is_default' => $user->paymentMethods()->count() === 0, // Set as default if first method
            ]);
        }
    }

    
    // Get all orders (Admin only)
    
    public function adminIndex(Request $request)
    {
        $orders = Order::with(['items.product', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

    // Update order status (Admin only)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }

        $order->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated',
            'data' => $order,
        ]);
    }
}
