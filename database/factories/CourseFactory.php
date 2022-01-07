<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;
    protected $modalidad = array('Virtual','Presencial');

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'branch_office_id'=>rand(1,40),
            'type_course_id'=>rand(1,4),
            'total_hours'=>date("H:i:s", mktime(6,0,0,0,0,0)),
            'student_capacity'=>rand(20,25),
            'modality'=>$this->modalidad[array_rand($this->modalidad)],
            'expiration'=>date("Y-m-d", mktime(0,0,0,6,20,2030))
        ];
    }
}
