<?php

namespace Database\Factories;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentsFactory extends Factory
{
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content' => $this->faker->text(),
            'created_at' => $this->faker->dateTimeBetween('-3 months')
        ];
    }

    public static function boot(){
        parent::boot();

        static::addGlobalScope(new LatestScope);
    }
    
}
