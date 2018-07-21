<?php
    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class Ingredient extends Model {
        protected $fillable = ['title', 'amount', 'unit'];

        protected $hidden = array('recipe_id');

        public function recipe() {
            return $this->belongsTo('App\Recipe');
        }
    }
?>