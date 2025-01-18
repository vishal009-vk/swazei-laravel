<?php

namespace App\Http\Controllers\API;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Login API
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if ($validator->fails()) {

                $error = $validator->errors()->first();

                $response = [
                    'message' => $error,
                    'status' => false,
                    'code' => 200,
                    'data' => []
                ];

                return response()->json($response, $response['code']);
            }

            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $response = [
                    'message' => 'Invalid Credentials',
                    'status' => false,
                    'code' => 200,
                    'data' => []
                ];

                return response()->json($response, $response['code']);
            }

            $user = User::find(Auth::user()->id);

            $tokenResult = $user->createToken('Photobook');
            $token = $tokenResult->plainTextToken;
            
            $response = [
                'message' => 'User Login Successfully',
                'status' => true,
                'code' => 200,
                'data' => [
                    'user' => $user,
                    'access_token' => $token,
                ]
            ];

            return response()->json($response, $response['code']);
        } catch (Throwable $e) {
            return $e;
        }
    }
}
