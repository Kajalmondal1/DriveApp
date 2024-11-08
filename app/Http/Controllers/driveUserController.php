<?php

namespace App\Http\Controllers;

use App\Models\driveUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class driveUserController extends Controller
{
    public function signUp(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
        if ($validated->fails()) {
            return response()->json([$validated->errors()], 400);
        }
        else{
            try {
                DB::beginTransaction();
                $user = driveUser::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);
                DB::commit();
                if($user){
                    return response()->json(["message"=>"User Signed Up Successfully","status"=>true], 201);
                }
                else{
                    return response()->json(["message"=>"Failed to Signed up"], 500);
                }
            } catch (\Exception $exception) {
                DB::rollBack();
                return response()->json(["message"=>"Internal Server Error. ".$exception->getMessage()], 500);
            }
        }
    }
    public function login(Request $request){
        $validated = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
        if ($validated->fails()) {
            return response()->json([$validated->errors()], 400);
        }
        else{
            $credentials = ['email'=>$request->email,'password'=>$request->password];
            $token = auth('drive')->attempt($credentials);
            if($token){
                return response()->json(['status'=>true,'message'=>"Logged In Successfylly",'token'=>$token], 200);
            }
            else{
                return response()->json(['status'=>false,'message'=>"Invalid Credentials"], 400);
            }
        }
    }

    public function me(){
        return response()->json(["status"=>true,"info"=>Auth::guard('drive')->user()],200);
    }
    
    public function logout(){
        Auth::guard('drive')->logout();
          // Optionally, invalidate the token if you’re using JWT
          if (Auth::guard('drive')->user()) {
            JWTAuth::invalidate(JWTAuth::getToken());
        }

        return response()->json(["status"=>true,"message"=>"Logged out successfully"],200);
    }
}
