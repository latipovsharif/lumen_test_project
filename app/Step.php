<?php
    namespace App;

    use App\Image;
    use Illuminate\Database\Eloquent\Model;

    class Step extends Model {
        protected $fillable = ['title', 'description', 'image_id'];
        protected $hidden = array('recipe_id');

        public function recipe() {
            return $this->belongsTo('App\Recipe');
        }
    }
?>