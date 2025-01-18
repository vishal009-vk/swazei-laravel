<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search ?? null;

        $products = Product::when(($search && $search != ''), function ($search_query) use ($search) {
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

        if ($request->ajax()) {
            $data['products'] = $products;
            $html =  view('product.products', $data)->render();
            
            return response()->json(['html' => $html], 200);
        }

        return view('product.index');
    }
}
