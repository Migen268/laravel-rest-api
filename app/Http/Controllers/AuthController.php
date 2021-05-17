<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{   
    /**
     * Register a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request){

        $fields=$request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user=User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);
        
            // i can use this token to access portected routes
           $token=$user->createToken('migen_rest_api')->plainTextToken; 

           $response=[
            'user' => $user,
            'token' => $token
           ];
            
           return response($response,201); 

    }
   
     /**
     * Log in with a barear token
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request){
        // return "jemi ketu";
        $fields=$request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        
        //check email
       // $email=DB::select("Select  * from user where email ='".$fields['email'."'";])
        $user=User::where('email',$fields['email'])->first();

        //check password
        if(!$user || !Hash::check($fields['password'],$user->password)){

            return response([
                'msg'=>'Bad credentials'
            ],401);
        }
        
        // i can use this token to access portected routes
           $token=$user->createToken('migen_rest_api')->plainTextToken; 

           $response=[
            'user' => $user,
            'token' => $token
           ];
            
           return response($response,201); 

    }

     /**
     * Log out and destroy token
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request){

        auth()->user()->tokens()->delete();

        $response =[
            'msg' =>'Logged Out ',
            'extra' => 'Token destroyed'
        ];

        return response($response,201);

    }

}
