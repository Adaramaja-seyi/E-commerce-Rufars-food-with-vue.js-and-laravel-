<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    //    Get user's cart
     
    public function getAllCart(Request $request)
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', $request->user()->id)
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return response()->json([
            'success' => true,
            'cart' => [
                'items' => $cartItems,
                'total' => $total,
                'count' => $cartItems->sum('quantity'),
            ],
        ]);
    }

    // Add item to cart
    
    public function addItemCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($request->product_id);

        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock',
            ], 400);
        }

        // Check if item already exists in cart
        $cartItem = CartItem::where('user_id', $request->user()->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            // Update existing cart item - add to quantity
            $newQuantity = $cartItem->quantity + $request->quantity;
            
            if ($product->stock < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock',
                ], 400);
            }
            
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            $cartItem = CartItem::create([
                'user_id' => $request->user()->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Item added to cart',
            'data' => $cartItem->load('product'),
        ]);
    }

    //Update cart item quantity
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found',
            ], 404);
        }

        if ($cartItem->product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock',
            ], 400);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated',
            'data' => $cartItem->load('product'),
        ]);
    }

    
     //Remove item from cart
    
    public function remove(Request $request, $id)
    {
        $cartItem = CartItem::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found',
            ], 404);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
        ]);
    }

    // Clear cart
     
    public function clear(Request $request)
    {
        CartItem::where('user_id', $request->user()->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared',
        ]);
    }
}
