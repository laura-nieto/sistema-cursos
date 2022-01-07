<?php

namespace Database\Factories;

use App\Models\Academy;
use Illuminate\Database\Eloquent\Factories\Factory;

class AcademyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Academy::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->name(),
            'street'=>$this->faker->name(),
            'streetHeight'=>strval(rand(1,6000)),
            'responsible'=>$this->faker->name(),
            'phone'=>strval(mt_rand()),
            'email' => $this->faker->unique()->safeEmail(),
            // 'email_verified_at' => now(),
            'noc' => $this->faker->text(200),
            'isActive' => true,
        ];
    }
}