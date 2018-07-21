<?php
    namespace App;

    use DB;
    use Log;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Http\Request;

    use App\Image;
    use App\User;
    use App\Step;
    use App\Ingredient;

    class Recipe extends Model {
        protected $fillable = ['duration_in_minutes', 'image_id', 'about'];
        

        public function ingredients() {
            return $this->hasMany('App\Ingredient');
        }
        
        public function getImageIdAttribute($value) {
            return Image::find($value)->image_path;
        }
        
        public function steps() {
            return $this->hasMany('App\Step');
        }

        public static function create(Request $request, User $user) {
                $input = $request->all();
                $recipe = new Recipe();
                $recipe->duration_in_minutes = $input['duration_in_minutes'];
                $recipe->image_id = $input['image_id'];
                $recipe->user_id = $user->id;

                DB::beginTransaction();

                $recipe->save();

                $ingredients = $request['ingredients'];

                // Append recipe id to array
                for($i = 0; $i < count($ingredients); $i++) {
                    $ingredients[$i]['recipe_id']=$recipe->id;
                }

                // Bulk insert
                Ingredient::insert($ingredients);

                $steps = $request['steps'];
                for($i = 0; $i < count($steps); $i++) {
                    $steps[$i]['recipe_id']=$recipe->id;
                }

                Step::insert($steps);
                DB::commit();

                return $recipe;
        }
    }
?>