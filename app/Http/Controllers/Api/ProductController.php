<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // Method to get the list of all records in the DB
    public function index() {

        $products = Product::get();

        if (count($products) > 0) {
            return ProductResource::collection($products);
        } else {
            return response()->json(['message'=> 'No Products Available'], 200);
        }
    }

    // Method to create a new record in the DB
    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required | string | max:255',
            'description' => 'required | string | max:255',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => "All fields are mandatory",
                'errors' => $validator->errors()
            ], 422);
        }

        // Execute the query to create the new record

        $product = Product::create([
           'name' => $request->name,
           'description' => $request->description,
           'price' => $request->price,
        ]);

        return response()->json([
            'message' => "New Product Added Successfully",
            'data' => new ProductResource($product)
        ], 200);

    }

    // Method to show the data of one Product specified with ID
    public function show(Product $product) {
        return response()->json([
            'message' => "Product Found",
            'data' => new ProductResource($product)
        ]);
    }

    public function update(Request $request, Product $product) {

        $validator = Validator::make($request->all(), [
            'name' => 'required | string | max:255',
            'description' => 'required | string | max:255',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => "All fields are mandatory",
                'errors' => $validator->errors()
            ], 422);
        }

        $product->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,
        ]);

        return response()->json([
            'message' => "Product Updated Successfully",
            'data' => new ProductResource($product)
        ]);
    }

    public function destroy(Product $product) {
        $product->delete();
        return response()->json([
            'message' => "Product Deleted Successfully",
        ]);
    }
}
