<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Order list
     */
    public function index()
    {
        try {
            $orders = Order::whereUserId(Auth::id())->get(); 
            
            return view('order.index', compact('orders'));
        } catch (Throwable $e) {
            return $e;
        }
    }

    /**
     * Order product
     */
    public function orderProduct($product)
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

            $orderNo = 'ORD-' . strtoupper(Str::random(6)) . '-' . now()->format('YmdHis');

            $order = new Order();
            $order->unique_id = Str::uuid();
            $order->user_id = Auth::id();
            $order->product_id = $product->id;
            $order->order_no = $orderNo;
            $order->order_date = now();
            $order->save();

            $response = [
                'message' => 'Product successfully ordered.',
                'status' => true,
                'code' => 200,
                'data' => []
            ];

            return response()->json($response, $response['code']);
        } catch (Throwable $e) {
            return $e;
        }
    }
    
    /**
     * Cancel product
     */
    public function cancelOrder($order)
    {
        try {
            $order = Order::whereUniqueId($order)->first();

            if(!$order) {
                $response = [
                    'message' => 'Order not found.',
                    'status' => false,
                    'code' => 200,
                    'data' => []
                ];

                return response()->json($response, $response['code']);
            }

            $order->delete();

            $response = [
                'message' => 'Order successfully ordered.',
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
