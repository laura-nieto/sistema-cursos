<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Course_type;


class CourseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course_type::Create([
            'course_type_name' => 'Auto A',
            'description' => 'En este curso se dictaran las normas de transito para motos y carro',
        ]);
        Course_type::Create([
            'course_type_name' => 'Camion chico B',
            'description' => 'En este curso se dictaran las normas de transito para camion chico B',
        ]);
        Course_type::Create([
            'course_type_name' => 'Camion grande C',
            'description' => 'En este curso se dictaran las normas de transito para camion grande C',
        ]);
        Course_type::Create([
            'course_type_name' => 'Tractor',
            'description' => 'En este curso se dictaran las normas de transito para tractores',
        ]);
    }
}
