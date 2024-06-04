<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\API\BaseController;

class UserController extends BaseController
{

      /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
             'full_name'=>'required|string|max:255',
             'email'=>'required|email|string|max:255|unique:users',
             'mobile_number'=>'required|string|max:15|unique:users',
             'password'=>'required|string|min:8|confirmed',
             'password_confirmation'=>'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        //$success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['full_name'] =  $user->full_name;
   
        return $this->sendResponse($success, 'User register successfully.');
    }
   

     /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'=>'required|email|string|max:255',
            'password'=>'required|string|min:8',
       ]);
  
       if($validator->fails()){
           return $this->sendError('Validation Error.', $validator->errors());       
       }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken($user->full_name)->plainTextToken; 
            $success['full_name'] =  $user->full_name;
   
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    

   
}
