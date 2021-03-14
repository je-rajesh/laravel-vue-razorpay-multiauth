<?php

namespace Database\Factories;

use App\Models\Inspire;
use Illuminate\Database\Eloquent\Factories\Factory;

class InspireFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Inspire::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
        ];
    }
}
