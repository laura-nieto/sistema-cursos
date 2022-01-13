<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Class_day;
use App\Models\Class_day_student;
use App\Models\Course;
use Illuminate\Http\Request;
use Belamov\PostgresRange\Ranges\TimestampRange;
use Carbon\Carbon;

date_default_timezone_set("America/Argentina/Buenos_Aires");

class ClassDayController extends Controller
{
    protected $hoursCounter = "00:00:00";
    protected $days = array();
    
    public function __construct(Class_day $class_day)
    {
        $this->middleware('auth');
    }
    public function setHoursCounter($hoursCounter)
    {
        $this->hoursCounter = $hoursCounter;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $course = Course::findOrfail($request->courseId);
        return view('classDay.create',compact("course"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        for ($i=1; $i <= intval($request->numberTheDays) ; $i++) {
            //name for request
            $day = $request["dia$i"];
            $nameInstructor = "nombreInstructor$i";
            $startTime = $request["hora$i".'Inicio'].":00";
            $endTime = $request["hora$i".'Fin'].":00";

            $newHourRange = new TimestampRange(Carbon::parse("$day $startTime"),Carbon::parse("$day $endTime"),'[',']');

            $validator = Validator::make($request->all() + ['hourRange' => $newHourRange], [
                $day => [
                    function ($attribute, $value, $fail) {
                        if ($value < date('Y-m-d')) {
                            $fail('La fecha mínima de planificación es hoy.');
                        }
                    },
                ],
                'hourRange' => [
                    function ($attribute, $value, $fail) {
                        if ((string) $value->from() > (string) $value->to() ) {
                            $fail('La hora de inicio de un día, debe ser antes de la hora final del mismo.');
                        }
                    },
                ],
            ]);
            $request->flash();
            if ($validator->fails()) {
                return back()
                    ->withErrors($validator);
            }
            foreach ($this->days as $loadedDays) {
                // validator intersecting days
                $validatorIntersectingDays = Validator::make(['newDayRange' => array($loadedDays['hour_range'],$newHourRange) ], [
                    'newDayRange' => [
                        function ($attribute, $value, $fail) {
                            if(((string)$value[0]->to() > (string)$value[1]->from() && (string)$value[0]->from() < (string)$value[1]->to()) || ((string)$value[1]->to() > (string)$value[0]->from() && (string)$value[1]->from() < (string)$value[0]->to()))
                            {
                                $fail(' Los días planificados no pueden superponerse.');
                            }
                        },
                    ],
                ]);
                if ($validatorIntersectingDays->fails()) {
                    return back()
                        ->withErrors($validatorIntersectingDays);
                }
            }
            // Class hour counter
            $classTime = date("H:i:s",strtotime($endTime)-strtotime($startTime));
            $hoursCounter = date("H:i:s",strtotime($classTime) + strtotime($this->hoursCounter));
            $this->setHoursCounter($hoursCounter);
            // Validations after loading every day
            if ($i === intval($request->numberTheDays)) {
                //validate $course->total_hours != hoursCounter
                $validatorHoursCounter = Validator::make(['courseId'=>$request->courseId], [
                    'courseId' => [
                        function ($attribute, $value, $fail) {
                            $course = Course::findOrFail($value);
                            if ($course->total_hours != $this->hoursCounter) {
                                $fail('Las horas horas totales del curso ID '.$course->id.', no coindicen con las horas planificadas.');
                            }
                            if ($course->classDays->isNotEmpty()) {
                                $fail('Este curso ya ha sido planificado.');
                            }
                        },
                    ],
                ]);
                if ($validatorHoursCounter->fails()) {
                    return back()
                        ->withErrors($validatorHoursCounter);
                }
            }
            // After the validations, I save each day in the property days (array)[array].
            $this->days[] = array(
                'course_id' => $request->courseId,
                'name_instructor' => $request->$nameInstructor,
                'hour_range' => $newHourRange,
            );
        };
        foreach ($this->days as $day) {
            Class_day::create($day);
        }
        return redirect("/cursos/$request->courseId")->with('status','El curso ha sido planificado con éxito.');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Class_day  $class_day
     * @return \Illuminate\Http\Response
     */
    public function show(Class_day $class_day)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Class_day  $class_day
     * @return \Illuminate\Http\Response
     */
    public function edit($courseId)
    {
        $course = Course::findOrFail($courseId);

        foreach ($course->classDays as $classDay) {
            $classDay->hour_range_string = (string) $classDay->hour_range;
        }

        return view('classDay.edit',compact("course"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Class_day  $class_day
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $course = Course::findOrFail($request->courseId);

        for ($i=1; $i <= intval($request->numberTheDays) ; $i++) {
            //name for request
            $nameInstructor = "nombreInstructor$i";
            $day = $request["dia$i"];
            $startTime = $request["hora$i".'Inicio'];
            $endTime = $request["hora$i".'Fin'];

            $newHourRange = new TimestampRange(Carbon::parse("$day $startTime"),Carbon::parse("$day $endTime"),'[',']');

            $validator = Validator::make($request->all() + ['hourRange' => $newHourRange], [
                $day => [
                    function ($attribute, $value, $fail) {
                        if ($value < date('Y-m-d')) {
                            $fail('La fecha mínima es hoy.');
                        }
                    },
                ],
                'hourRange' => [
                    function ($attribute, $value, $fail) {
                        if ((string) $value->from() > (string) $value->to() ) {
                            $fail('La hora de inicio de un día, debe ser antes de la hora final del mismo.');
                        }
                    },
                ],
            ]);
            $request->flash();
            if ($validator->fails()) {
                return back()
                    ->withErrors($validator);
            }
            foreach ($this->days as $loadedDays) {
                // validator intersecting days
                $validatorIntersectingDays = Validator::make(['newDayRange' => array($loadedDays['hour_range'],$newHourRange)], [
                    'newDayRange' => [
                        function ($attribute, $value, $fail) {
                            if(((string)$value[0]->to() > (string)$value[1]->from() && (string)$value[0]->from() < (string)$value[1]->to()) || ((string)$value[1]->to() > (string)$value[0]->from() && (string)$value[1]->from() < (string)$value[0]->to()))
                            {
                                $fail('Los días planificados no pueden superponerse.');
                            }
                        },
                    ],
                ]);
                if ($validatorIntersectingDays->fails()) {
                    return back()
                        ->withErrors($validatorIntersectingDays);
                }
            }
            // Class hour counter
            $classTime = date("H:i:s",strtotime($endTime)-strtotime($startTime));
            $hoursCounter = date("H:i:s",strtotime($classTime) + strtotime($this->hoursCounter));
            $this->setHoursCounter($hoursCounter);
            // Validations after loading every day
            if ($i === intval($request->numberTheDays)) {
                //validate $course->total_hours != hoursCounter
                $validatorHoursCounter = Validator::make(['courseId'=>$request->courseId], [
                    'courseId' => [
                        function ($attribute, $value, $fail) {
                            $course = Course::findOrFail($value);
                            if ($course->total_hours != $this->hoursCounter) {
                                $fail('Las horas horas totales del curso ID '.$course->id.', no coindicen con las horas planificadas.');
                            }
                        },
                    ],
                ]);
                if ($validatorHoursCounter->fails()) {
                    return back()
                        ->withErrors($validatorHoursCounter);
                }
            }
            // After the validations, I save each day in the property days (array)[array].
            $this->days[] = array(
                'course_id' => $request->courseId,
                'name_instructor' => $request->$nameInstructor,
                'hour_range' => $newHourRange,
            );
        };
        foreach ($course->classDays as $classDay) {
            $exist = false;
            foreach ($this->days as $day) {
                $changeFormat = '["'.(string)$day['hour_range']->from().'","'.(string)$day['hour_range']->to().'"]';
                if($changeFormat === (string)$classDay->hour_range)
                {
                    $exist = true;
                    break;
                };
            }
            if (!$exist) {
                $classDay->delete();
            }
        }
        foreach ($this->days as $day) {
            $changeFormat = '["'.(string)$day['hour_range']->from().'","'.(string)$day['hour_range']->to().'"]';
            // ejemplo dd($course->classDays->where((string)"hour_range",'["2021-08-24 10:00:00","2021-08-24 13:00:00"]'));
            $matchClassDay = $course->classDays->where((string)"hour_range",$changeFormat);

            if ($matchClassDay->isEmpty()) {
                Class_day::create($day);
            }

        }
        return redirect("/cursos/$request->courseId")->with('status','La planificación ha sido editada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Class_day  $class_day
     * @return \Illuminate\Http\Response
     */
    public function destroy(Class_day $class_day)
    {
        //
    }

    public function vistaPresentes($idDay)
    {
        $classDay = Class_day::findOrFail($idDay);
        $students = $classDay->course->students;
        return view('classDay.present', compact('classDay','students'));
    }
    public function guardarPresentes(Request $request, $idDay)
    {
        $classDay = Class_day::findOrFail($idDay);
        $presentes = $classDay->course->students->whereIn('id',$request->presentes);
        $ausentes = $classDay->course->students->except($request->presentes);
        foreach ($ausentes as $ausente) {
            $ausente->classDays()->attach($idDay,['attendance'=>false]);
        }
        foreach ($presentes as $presente) {
            $presente->classDays()->attach($idDay,['attendance'=>true]);
        }
        return redirect()->route('cursos.show',$classDay->course->id)->with('status','Presentes guardados');
    }
    public function verPresentes($idDay)
    {
        $classDay = Class_day::findOrFail($idDay);
        $students = $classDay->students;
        return view('classDay.showPresents',compact('classDay','students'));
    }
    public function editarPresentes(Class_day $classDay)
    {
        $students = $classDay->students;
        return view('classDay.editPresents',compact('classDay','students'));
    }
    public function updatePresentes(Request $request, Class_day $classDay)
    {
        $presentes = $classDay->course->students->whereIn('id',$request->presentes);
        $ausentes = $classDay->course->students->except($request->presentes);
        $classDay->students()->detach(); //BORRAR TODOS LOS REGISTROS
        foreach ($ausentes as $ausente) {
            $ausente->classDays()->attach($classDay->id,['attendance'=>false]);
        }
        foreach ($presentes as $presente) {
            $presente->classDays()->attach($classDay->id,['attendance'=>true]);
        }
        return redirect()->route('cursos.show',$classDay->course->id)->with('status','Presentes guardados');
    }
}
