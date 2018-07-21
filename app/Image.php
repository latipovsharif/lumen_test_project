<?php
    namespace App;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Http\Request;

    class Image extends Model {
        protected $fillable = ['image_path'];
        public $timestamps = false;

        public static function create(Request $request) {
            $input = $request->all();
            $image = base64_decode($input['image']);
            // Should be unique string (UUID)
            $image_filename = base_path() . '/public/images/' . 'asdf.jpg';
            file_put_contents($image_filename, $image);
            $i = new Image();
            $i->image_path = $image_filename;
            $i->save();
            return $i;
        }
    }
?>