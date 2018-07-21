<?php

namespace App\Http\Controllers;

use App\Image;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class ImageController extends Controller
{
    public function upload(Request $request) {
        $validatedData = $this->validate($request, [
            'image' => 'required',
        ]);

        if ($validatedData && $validatedData->errors()){
            return response()->json(['status'=>'error', 'message'=>$validatedData], 200);
        }

        $user = Image::create($request);
        return response()->json(['status'=>'OK', 'message'=>$user], 200);
    }
}