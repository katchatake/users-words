<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PassportAuthController extends Controller
{
    /**
     * Registration Req
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password',
            'type' => 'required|min:1'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'id_role'=> intval($request->type)
        ]);
  
        $token = $user->createToken('MinatoNAmikase')->accessToken;
  
        return response()->json(['token' => $token,'status'=>true], 200);
    }
  
    /**
     * Login Req
     */
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
  
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('MinatoNAmikase')->accessToken;
            $dataResponse = User::with('roles')->where('email', $data['email'])->get();
            // $dataResponse = User::with('roles')->get();
            return response()->json(['token' => $token,'data'=>$dataResponse,'status'=>true], 200);
        } else {
            return response()->json(['data' => 'Unauthorised','status'=>false], 401);
        }
    }
 
    public function userInfo() 
    {
 
     $user = auth()->user();
      
     return response()->json(['user' => $user], 200);
 
    }
}
