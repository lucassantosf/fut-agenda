<?php 

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Player;

class PlayerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Player::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [ 
            'user_id'=>1,
            'name'=>$this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'level'=>$this->faker->numberBetween(1,5),
            'goalkeeper'=>$this->faker->numberBetween(0,1)
        ];
    }
}