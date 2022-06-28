<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    function index(Request $request)
    {
        $user= User::where('email', $request->email)->first();
        // print_r($data);
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['These credentials do not match our records.']
                ], 404);
            }
        
             $token = $user->createToken('my-app-token')->plainTextToken;
        
            $response = [
                'user' => $user,
                'token' => $token
            ];
        
             return response($response, 201);
    }

    public function signup(Request $request)
    {
      //  return $request;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        $duplicate = User::where('email', '=', $request->email)->count();

        if ($duplicate === 1) {
          return response()->json(['message' => 'Bad Request Duplicate Email', 'email' => $request->email], 404);
        }
   
        if($validator->fails()){
            return $validator->errors();       
        }
   
        else
        {
            DB::table('users')->insert([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'api_token'=>Str::random(60)
            ]);

            return 'User created successfully.';
        }
   
        
    }
}
