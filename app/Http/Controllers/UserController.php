<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    public function login(Request $request){
        $validator = Validator::make($request->all(),[
             'email'=>'required|string|email',
             'password'=>'required|string|min:8'
        ]);

        if($validator->fails()){
            return response()->json(['success'=>false, 'message'=>$validator->errors()], 401);
        }
       
        $data = $validator->validated();

          $user = User::where('email', $request->email)->first();
          if(!$user || !Hash::check($data['password'], $user->password)){
             return response()->json(['success'=>false, 'message'=>'Invalid Credentials'],401);
          }
        //   $cookie = cookie('token', $token, 60, '/', '.yourdomain.com', true, true, false, 'none');
       
          $token = $user->createToken($data['email'])->plainTextToken;
          $cookie = cookie('token', $token, 7 * 24 * 60, '/',null, true, true, false, 'none');
         // $cookie = cookie('token', $token, 60, '/', null, true, true, false, 'none');

          return response()->json(['success'=>true, 'message'=>'login successfull', 'user'=>$user], 200)->withCookie($cookie);

    }



    public function register(Request $request){
         $validator = Validator::make($request->all(),[
             'full_name'=>'required|string|max:255',
             'email'=>'required|email|string|max:255|unique:users',
             'mobile_number'=>'required|string|max:15|unique:users',
             'password'=>'required|string|min:8|confirmed',
         ]);

         
         if($validator->fails()){
            return response()->json(['success'=>false, 'message'=>$validator->errors()], 401);
         }

         
         $user = User::create($request->all());
  
         return response()->json(['success'=>true, 'message'=>'User Registered Successfully', 'user'=>$user], 201);


    }

   





}
