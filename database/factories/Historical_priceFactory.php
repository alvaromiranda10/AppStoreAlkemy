<?php

namespace Database\Factories;

use App\Models\Historical_price;
use Illuminate\Database\Eloquent\Factories\Factory;

class Historical_priceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Historical_price::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'price' => $this->faker->randomFloat(2, 1, 9999 )
        ];
    }
}
