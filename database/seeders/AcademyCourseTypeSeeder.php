<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Academy_course_type;

class AcademyCourseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Academy_course_type::create([
            'academy_id'=>1,
            'course_type_id'=>1,
        ]);
        Academy_course_type::create([
            'academy_id'=>1,
            'course_type_id'=>2,
        ]);
        Academy_course_type::create([
            'academy_id'=>2,
            'course_type_id'=>2,
        ]);
        Academy_course_type::create([
            'academy_id'=>2,
            'course_type_id'=>3,
        ]);
        Academy_course_type::create([
            'academy_id'=>3,
            'course_type_id'=>3,
        ]);
        Academy_course_type::create([
            'academy_id'=>4,
            'course_type_id'=>3,
        ]);
        Academy_course_type::create([
            'academy_id'=>4,
            'course_type_id'=>4,
        ]);
        Academy_course_type::create([
            'academy_id'=>5,
            'course_type_id'=>1,
        ]);
        Academy_course_type::create([
            'academy_id'=>5,
            'course_type_id'=>2,
        ]);
        Academy_course_type::create([
            'academy_id'=>5,
            'course_type_id'=>3,
        ]);
        Academy_course_type::create([
            'academy_id'=>6,
            'course_type_id'=>1,
        ]);
        Academy_course_type::create([
            'academy_id'=>6,
            'course_type_id'=>2,
        ]);
        Academy_course_type::create([
            'academy_id'=>6,
            'course_type_id'=>3,
        ]);
        Academy_course_type::create([
            'academy_id'=>6,
            'course_type_id'=>4,
        ]);
    }
}
