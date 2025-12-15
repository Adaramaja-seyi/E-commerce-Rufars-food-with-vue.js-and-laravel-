<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function getAllProducts($request)
    {
        $products = Product::query();

        return response()->json($products->paginate('20'));
    }
}
