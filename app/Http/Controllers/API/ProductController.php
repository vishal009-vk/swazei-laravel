<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Throwable;

class ProductController extends Controller
{
    // Product listing
    public function index(Request $request)
    {
        try {
            $search = $request->search ?? null;
            
            $products = Product::when(($search && $search != ''), function($search_query) use($search){
                return $search_query->where('name', 'LIKE', "%{$search}%");
            })
            ->select([
                'unique_id as product_id',
                'image',
                'name',
                'slug',
                'description',
                'price',
                'rating',
            ])
            ->get();

            $response = [
                'message' => 'Product successfully retrived',
                'status' => true,
                'code' => 200,
                'data' => [
                    'products' => $products,
                ]
            ];

            return response()->json($response, $response['code']);
        } catch (Throwable $e) {
            return $e;
        }
    }
    
    // Product delete
    public function delete($product)
    {
        try {
            $product = Product::whereUniqueId($product)->first();

            if(!$product) {
                $response = [
                    'message' => 'Product not found.',
                    'status' => false,
                    'code' => 200,
                    'data' => []
                ];

                return response()->json($response, $response['code']);
            }

            $product->delete();

            $response = [
                'message' => 'Product successfully deleted.',
                'status' => true,
                'code' => 200,
                'data' => []
            ];

            return response()->json($response, $response['code']);
        } catch (Throwable $e) {
            return $e;
        }
    }
}
