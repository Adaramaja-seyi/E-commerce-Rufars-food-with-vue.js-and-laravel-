<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index(Request $request)
    {
        $paymentMethods = $request->user()->paymentMethods()->orderBy('is_default', 'desc')->get();

        return response()->json([
            'success' => true,
            'payment_methods' => $paymentMethods,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'last4' => 'required|string|size:4',
            'expiry' => 'nullable|string|max:5',
            'is_default' => 'boolean',
        ]);

        $paymentMethod = $request->user()->paymentMethods()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Payment method created successfully',
            'payment_method' => $paymentMethod,
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $paymentMethod = PaymentMethod::where('user_id', $request->user()->id)->where('id', $id)->first();
        
        if (!$paymentMethod) {
            return response()->json([
                'success' => false,
                'message' => 'Payment method not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'payment_method' => $paymentMethod,
        ]);
    }

    public function update(Request $request, $id)
    {
        $paymentMethod = PaymentMethod::where('user_id', $request->user()->id)->where('id', $id)->first();
        
        if (!$paymentMethod) {
            return response()->json([
                'success' => false,
                'message' => 'Payment method not found',
            ], 404);
        }

        $validated = $request->validate([
            'type' => 'sometimes|required|string|max:255',
            'last4' => 'sometimes|required|string|size:4',
            'expiry' => 'nullable|string|max:5',
            'is_default' => 'boolean',
        ]);

        $paymentMethod->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Payment method updated successfully',
            'payment_method' => $paymentMethod->fresh(),
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $paymentMethod = PaymentMethod::where('user_id', $request->user()->id)->where('id', $id)->first();
        
        if (!$paymentMethod) {
            return response()->json([
                'success' => false,
                'message' => 'Payment method not found',
            ], 404);
        }

        $paymentMethod->delete();

        return response()->json([
            'success' => true,
            'message' => 'Payment method deleted successfully',
        ]);
    }

    public function setDefault(Request $request, $id)
    {
        $paymentMethod = PaymentMethod::where('user_id', $request->user()->id)->where('id', $id)->first();
        
        if (!$paymentMethod) {
            return response()->json([
                'success' => false,
                'message' => 'Payment method not found',
            ], 404);
        }

        $paymentMethod->update(['is_default' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Default payment method updated',
            'payment_method' => $paymentMethod->fresh(),
        ]);
    }
}
