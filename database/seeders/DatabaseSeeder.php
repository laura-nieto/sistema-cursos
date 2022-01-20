<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Academy;
use \App\Models\Branch_office;
use \App\Models\Course;
use \App\Models\Student;
use \App\Models\Certificate;
use \App\Models\Schedule;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //RoleSeeder create 4(four) user with roles
        Academy::factory(6)->create();
        
        // Academy::create([
        //     'name'=>'Academia 1',
        //     'street'=>'Av J.B alberdo',
        //     'streetHeight'=>strval(rand(1,6000)),
        //     'responsible'=>'Jose',
        //     'phone'=>strval(mt_rand()),
        //     'email' => 'admin@admin.com',
        //     // 'email_verified_at' => now(),
        //     'noc' => 'asd',
        //     'isActive' => true,
        // ]);
        $this->call(RoleSeeder::class);
        $this->call(CourseTypeSeeder::class);
        
        //Need create Academy before implement AcademyCourseTypeSeer,for Academy_id
        //$this->call(AcademyCourseTypeSeeder::class);
        
        //Branch_office::factory(40)->create();
        
        //Course::factory(100)->create();
        //Student::factory(4)->create();
        // Certificate::factory(6)->create();
        //$this->call(CourseStudentSeeder::class);
    }
}