<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Academy;
use Illuminate\Http\Request;
use App\Http\Requests\CourseRequest;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    protected $course;
    public function __construct(Course $course)
    {
        $this->middleware('permission:courses.index')->only('index','show');
        $this->middleware('permission:courses.create')->only('create','store');
        $this->middleware('permission:courses.edit')->only('edit','update');
        $this->middleware('permission:courses.destroy')->only('destroy');
        $this->middleware('auth.academyId')->only('edit','show','destroy');
        $this->course = $course;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $branchName = $request->nombreSucursalAsociada;
        $CourseTypeName = $request->nombreTipoDeCurso;
        $state = $request->disabled;
        $userAuth = auth()->user();
        
        $courses = $this->course
            ->coursesForUser($userAuth)
            ->nameAssociatedBranchOffice($branchName)
            ->nameAssociatedCourseType($CourseTypeName)
            ->isDisabled($state)
            ->orderBy('id','desc')
            ->paginate(20)
            ->withQueryString();

        return view("course.index",compact('courses','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $userAuth = auth()->user();
        //search academy for userAuth
        if (!$userAuth->academy_id && !$request->academy_id) {
            $academies = Academy::all();
            return view('course.selectAcademy',compact('academies'));
        }
        if ($userAuth->academy_id) {
        // academy for user auth/user academy
            $academyId = $userAuth->academy_id;
        }
        if ($request->academy_id) {
        // academy selected for the user/admins
            $academyId = $request->academy_id;
        }
        $academy = Academy::findOrFail($academyId);

        return  view('course.create',compact('academy'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        $date = array(
            'branch_office_id' => $request->sucursalAsociada,
            'type_course_id' => $request->tipoCurso,
            'total_hours' => date("H:i:s",mktime($request->horasTotales,$request->minutosTotales,0,0,0,0)),
            'student_capacity' => $request->capacidadDeEstudiantes,
            'modality' => $request->modalidadCurso,
            'expiration' => $request->vencimientoCurso,
        );
        $course = $this->course::create($date);

        return redirect()->route('horarios.create',['courseId'=>$course->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show($courseId)
    {
        $course = $this->course::findOrfail($courseId);

        return view('course.show',compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit($courseId)
    {
        $course = $this->course::findOrFail($courseId);
        return view("course.edit", compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(CourseRequest $request,$courseId)
    {
        $date = array(
            'branch_office_id' => $request->sucursalAsociada,
            'type_course_id' => $request->tipoCurso,
            'total_hours' => date("H:i:s",mktime($request->horasTotales,$request->minutosTotales,0,0,0,0)),
            'student_capacity' => $request->capacidadDeEstudiantes,
            'modality' => $request->modalidadCurso,
            'expiration' => $request->vencimientoCurso,
        );
        $course = $this->course::findOrFail($courseId);
        $course->update($date);

        return back()->with('status','El curso ha sido editado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy($courseId)
    {
        $course = $this->course::findOrFail($courseId);

        $validator = Validator::make(['curso' => $courseId], [
            'curso' => [
                function ($attribute, $value, $fail) {
                    $course = $this->course->findOrFail($value);
                    if ($course->students->isNotEmpty()) {
                        $fail('Este '.$attribute.' tiene estudiantes inscritos, deben darlos de baja para este curso para eliminarlo.');
                    }
                },
            ],
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator);
        }
        if ($course->isActive) {
            $course->update([
                'isActive' => false,
            ]);
            return back()->with('status','Curso eliminado con éxito');
        }else{
            $course->update([
                'isActive' => true,
            ]);
            return back()->with('status','Curso restaurada con éxito');
        }

    }
    public function inscripcion(Request $prueba)
    {
        
        dd($prueba->id);
        return 'Aca se abrira la planilla de inscripcion, esto es prueba: '.$prueba;
    }
}
