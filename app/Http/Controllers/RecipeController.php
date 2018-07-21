<?php

namespace App\Http\Controllers;

use App\Recipe;

use Auth;
use Illuminate\Http\Request;

class RecipeController extends Controller
{

    public function showAll()
    {
        $recipes = Recipe::with('ingredients', 'steps')->paginate(10);

        return response()->json($recipes);
    }

    public function show($id)
    {
        $recipe = Recipe::with('ingredients', 'steps')->find($id);
        return response()->json($recipe);
    }

    public function create(Request $request)
    {
        $user = Auth::user();

        if (!isset($user)) {
            return response()->json(['status'=>'error', 'message'=>'Unauthorized'], 401);
        }
        
        $rules = [
            'duration_in_minutes' => 'required|numeric',
            'image_id' => 'required|numeric',

            'ingredients' => 'required|array',
            'ingredients.*.title' => 'required',
            'ingredients.*.unit' => 'required',
            'ingredients.*.amount' => 'required|numeric',

            'steps' => 'required|array',
            'steps.*.title' => 'required',
            'steps.*.description' => 'required',
            'steps.*.image_id' => 'required|numeric',
        ];

        $validatedData = $this->validate($request, $rules);
        if ($validatedData && $validatedData->errors()){
            return response()->json($validatedData, 200);
        }

        $recipe = Recipe::create($request, $user);
        return response()->json(['status'=>'OK', 'message'=>$recipe], 201);
    }

    public function update($id, Request $request)
    {
        $user = Auth::user();

        if (!isset($user)) {
            return response()->json(['status'=>'error', 'message'=>'Unauthorized'], 401);
        }

        $recipe = Recipe::findOrFail($id);
        if ($recipe->user_id != $user->id) {
            return response()->json(['status'=>'error', 'message'=>'Forbidden'], 403);
        }

        $recipe->update($request->all());

        return response()->json($recipe, 200);
    }

    public function delete($id)
    {
        $recipe = Recipe::findOrFail($id);

        if ($recipe->user_id != $user->id) {
            return response()->json(['status'=>'error', 'message'=>'Forbidden'], 403);
        }

        $recipe->delete();
        return response()->json(['status'=>'OK', 'message'=>'Deleted Successfully'], 200);
    }
}