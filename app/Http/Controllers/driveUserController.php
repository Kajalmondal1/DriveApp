<?php

namespace App\Http\Controllers;

use App\Models\driveUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
}
