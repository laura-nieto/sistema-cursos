<?php

namespace App\Console\Commands;

use App\Models\Certificate;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class Certificar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'certificar:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Certificar cursos que ya finalizaron en el día';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today('America/Argentina/Buenos_Aires');
        //$today = Carbon::parse('2022-03-16');
        $to = $today->endOfDay()->toDateTimeString();

        $cursos = Course::where('certificated',false)->whereHas('classDays',function(Builder $query)use($to)
        {
            $query->whereRaw("( SELECT max(upper(hour_range)) FROM class_days WHERE courses.id = class_days.course_id ) <= ?",$to);
        })
        ->get();

        foreach ($cursos as $course) {
            $presentes = $course->students->keyBy->id;
            //REMOVER AUSENTES
            foreach ($course->classDays as $classDay) {
                foreach ($classDay->students as $student) {
                    if ($student->pivot->attendance === false) {
                        $presentes->forget($student->id);
                    }
                }
            }
            //CERTIFICADOS
            $presentes->each(function($presente,$item) use($course){
                $certificado = new Certificate;
                $certificado->student_id = $presente->id;
                $certificado->course_id = $course->id;
                $certificado->save();
            });
            $course->certificated = true;
            $course->save();
        }
        $this->info('Certificados del día emitidos.');
    }
}
