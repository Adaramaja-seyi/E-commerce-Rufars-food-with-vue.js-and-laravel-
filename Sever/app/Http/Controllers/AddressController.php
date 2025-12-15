<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        $addresses = $request->user()->addresses()->orderBy('is_default', 'desc')->get();

        return response()->json([
            'success' => true,
            'addresses' => $addresses,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'nullable|string|max:255',
            'street' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:20',
            'country' => 'nullable|string|max:255',
            'is_default' => 'boolean',
        ]);

        $address = $request->user()->addresses()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Address created successfully',
            'address' => $address,
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $address = Address::where('user_id', $request->user()->id)->where('id', $id)->first();
        
        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'address' => $address,
        ]);
    }

    public function update(Request $request, $id)
    {
        $address = Address::where('user_id', $request->user()->id)->where('id', $id)->first();
        
        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found',
            ], 404);
        }

        $validated = $request->validate([
            'label' => 'nullable|string|max:255',
            'street' => 'sometimes|required|string',
            'city' => 'sometimes|required|string|max:255',
            'state' => 'sometimes|required|string|max:255',
            'zip' => 'sometimes|required|string|max:20',
            'country' => 'nullable|string|max:255',
            'is_default' => 'boolean',
        ]);

        $address->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Address updated successfully',
            'address' => $address->fresh(),
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $address = Address::where('user_id', $request->user()->id)->where('id', $id)->first();
        
        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found',
            ], 404);
        }

        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Address deleted successfully',
        ]);
    }

    public function setDefault(Request $request, $id)
    {
        $address = Address::where('user_id', $request->user()->id)->where('id', $id)->first();
        
        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found',
            ], 404);
        }

        $address->update(['is_default' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Default address updated',
            'address' => $address->fresh(),
        ]);
    }
}
