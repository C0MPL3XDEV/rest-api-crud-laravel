<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        $products = Product::get();

        if (count($products) > 0) {
            return ProductResource::collection($products);
        } else {
            return response()->json(['message'=> 'No Products Available'], 200);
        }
    }
}
