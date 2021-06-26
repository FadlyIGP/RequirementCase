<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User_token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    public function register(Request $request)
    {
        $data = new User($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
            'email' => 'required|email|unique:users'

            ]);
        if ($validator->fails()) {
                $out = [
                "message" => $validator->messages()->all(),
                ];
                return response()->json($out, 422);
        }
        
        $register = $data->save();

        if($register)
        {
            $response = [
                "status" => true,
                "message" => "Register successful..."
            ];
            return response()->json($response, 200);

        }else
        {
            $response = [
                "status" => false,
                "message" => "Register failed..."
            ];
            return response()->json($response, 401);

        }
        // return response($response);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
            ]);

        if ($validator->fails()) {
                $out = [
                "message" => $validator->messages()->all(),
                ];
                return response()->json($out, 422);
        }

        $password = $request->password;
        $cekUser = User::where('email', $request->email)->first();
            if(empty($cekUser)){
                $response = [
                    "status" => false,
                    "message" => "Login failed"
                ];
                return response()->json($response, 401);
            }else{
                
                $user_token = User_token::updateOrCreate(
                    ['user_id' =>  $cekUser->id],
                    ['token' => Str::random(60)]
                );

                if(!Hash::check($password,$cekUser->password)){
                    $response = [
                        "data_profile" => $cekUser,
                        "token" => $user_token->token,
                        "status" => true,
                        "message" => "Login Successful."
                    ];
                    return response()->json($response, 200);

                }else{
                    $response = [
                        "status" => false,
                        "message" => "Login Failed."
                    ];
                    return response()->json($response, 401);

                }
            }
       
    }

   
}
