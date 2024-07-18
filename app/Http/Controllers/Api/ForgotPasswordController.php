<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    
    public function sendResetLinkEmail(Request $request){
          $request->validate(['email'=>'required|email']);
          $status = Password::sendResetLink($request->only('email'));

          return $status === Password::RESET_LINK_SENT ? response()->json(['success'=>true, 'message'=>__($status)],200) : response()->json(['success'=>false, 'message'=> __($status)], 400);
    }

    public function reset(Request $request ){
           
        $request->validate([
            'token'=>['required'],
            'email'=> ['email','required'],
            'password'=> ['required','string','confirmed','min:6'],
        ]);
       
        $status = Password::reset(
            $request->only('email','password','password_confirmation', 'token'),
            function(User $user, string $password){
                $user->forceFill([
                    'password' => bcrypt($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );
    
        return $status === Password::RESET_LINK_SENT ? response()->json(['success'=>true, 'message'=>__($status)],200) : response()->json(['success'=>false, 'message'=> __($status)], 400);

    }
}
