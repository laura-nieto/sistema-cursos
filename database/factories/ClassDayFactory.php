<?php

namespace Database\Factories;

use App\Models\Class_day;
use Illuminate\Database\Eloquent\Factories\Factory;
use Belamov\PostgresRange\Ranges\TimestampRange;

class ClassDayFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Class_day::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'course_id' => rand(1,6),
            'hour_range' => new TimestampRange('2021-07-06 13:00:00', '2010-01-02 16:00:00', '[', ')'),
            'NameIntructor' => $this->faker->name(),
        ];
    }
}
