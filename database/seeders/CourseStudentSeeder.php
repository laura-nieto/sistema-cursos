<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Course_student;

class CourseStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course_student::Create([
            'student_id'=>1,
            'course_id'=>1,
            // 'attendance'=> false,
        ]);
        Course_student::Create([
            'student_id'=> 1,
            'course_id'=> 2,
            // 'attendance'=> false,
        ]);
        Course_student::Create([
            'student_id'=> 2,
            'course_id'=> 2,
            // 'attendance'=> false,
        ]);
        Course_student::Create([
            'student_id'=> 3,
            'course_id'=> 3,
            // 'attendance'=> true,
        ]);
        Course_student::Create([
            'student_id'=> 4,
            'course_id'=> 1,
            // 'attendance'=> true,
        ]);
    }
}
