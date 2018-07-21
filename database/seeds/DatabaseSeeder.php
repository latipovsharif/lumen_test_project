<?php

use App\Image;
use App\User;
use App\Recipe;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // В реальном проекте лучше для каждой модели создать свой файл для seed - a

        $faker = Faker\Factory::create();

        DB::table('users')->insert([
            'full_name' => $faker->name,
            'email' => $faker->email,
            'password' => app('hash')->make('yourpassword'),

        ]);

        for ($i = 0; $i < 10; $i++) {
            DB::table('images')->insert([
                'image_path' => $faker->imageUrl($width=640, $height=480),
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            $image = Image::skip($i)->take(1)->get();
            DB::table('recipes')->insert([
                'duration_in_minutes' => $faker->randomDigit,
                'image_id' => $image[0]->id,
                'user_id' => User::first()->id,
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            $image = Image::skip($i)->take(1)->get();
            $recipe = Recipe::skip($i)->take(1)->get();
            DB::table('steps')->insert([
                'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'description' => $faker->text($maxNbChars = 200),
                'image_id' => $image[0]->id,
                'recipe_id' => $recipe[0]->id,
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            $recipe = Recipe::skip($i)->take(1)->get();
            DB::table('ingredients')->insert([
                'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'unit' => $faker->randomElement($array = array('лт', 'шт', 'гр')),
                'amount' => $faker->numberBetween($min = 100, $max = 1000),
                'recipe_id' => $recipe[0]->id,
            ]);
        }
    }
}