<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User_token;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Facades\Validator;

class ProfilController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function Create(Request $request)
    {   
        $token = $request->header('X-CSRF-Token');
        $cektoken = User_token::where('token', $token)->first();

        if ($cektoken) {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'status' => 'required',
                'position' => 'required'
            ]);

            if ($validator->fails()) {
                $out = [
                    "message" => $validator->messages()->all(),
                ];
                return response()->json($out, 422);
            }
            $cekdata = Profil::where('user_id', $request->user_id)->first();
            if ($cekdata) {
                $response = [
                        "status" => false,
                        "message" => "Data has inserted..."
                    ];
                return response()->json($response, 200);
            }else{
                $data = new Profil($request->all());
                $insert = $data->save();
                if($insert)
                {
                    $response = [
                        "status" => true,
                        "message" => "Create data successful..."
                    ];
                    return response()->json($response, 200);
                }else{
                    $response = [
                        "status" => false,
                        "message" => "Create data failed..."
                    ];
                    return response()->json($response, 401);
                }
            }
        }else{
            $response = [
                "status" => false,
                "message" => "These credentials do not match our records."
            ];
            return response()->json($response, 401);
        }
    }

    public function ListProfil()
    {
        $data = Profil::select('*')->get();
        $response = [
            "data" => $data,
            "status" => true,
            "message" => "Data show..."
        ];
        return response()->json($response, 200);
    }

    public function Update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'position' => 'required'
        ]);

        if ($validator->fails()) {
            $out = [
                "message" => $validator->messages()->all(),
            ];
            return response()->json($out, 422);
        }
        $Profil = Profil::find($request->id);
        $Profil->status = $request->status;
        $Profil->position = $request->position;
        $Profil->save();
        if($Profil)
        {
            $response = [
                "data"=>$Profil,
                "status" => true,
                "message" => "Update data successful..."
            ];
            return response()->json($response, 200);
        }else{
            $response = [
                "status" => false,
                "message" => "Update data failed..."
            ];
            return response()->json($response, 401);
        }

    }

    public function Delete(Request $request)
    {

        $delete = Profil::find($request->id);
        $delete->delete();
        if($delete)
        {
            $response = [
                "data"=>$delete,
                "status" => true,
                "message" => "Delete data successful..."
            ];
            return response()->json($response, 200);
        }else{
            $response = [
                "status" => false,
                "message" => "Delete data failed..."
            ];
            return response()->json($response, 401);
        }
    }


}
