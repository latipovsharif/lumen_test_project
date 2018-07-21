<?php

namespace App\Http\Controllers;

use App\User;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function create(Request $request) {
        $validatedData = $this->validate($request, [
            'full_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);

        if ($validatedData && $validatedData->errors()){
            return response()->json(['status'=>'error', 'message'=>$validatedData], 200);
        }

        $user = User::create($request);
        return response()->json(['status'=>'OK', 'message'=>$user], 200);
    }

    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($this->validate() && $this->validate()->errors()){
            return response()->json($validatedData, 200);
        }
    
        $user = User::where('email', $request->input('email'))->first();

        if (isset($user)) {
            if(Hash::check($request->input('password'), $user->password))
            {
                $apiKey = base64_encode(str_random(40));

                User::where('email', $request->input('email'))->update(['api_token' => "$apiKey"]);;

                return response()->json(['status' => 'success','api_token' => $apiKey]);
            } else {
                return response()->json(['status' => 'fail'],401);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'invalid login or password'], 401);
        }
    }
}