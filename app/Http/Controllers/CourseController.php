<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Academy;
use Illuminate\Http\Request;
use App\Http\Requests\CourseRequest;
use App\Models\Academy_course_type;
use App\Models\Course_type;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    protected $course;
    public function __construct(Course $course)
    {
        $this->middleware('auth');
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
        $today = Carbon::today()->format('d-m-Y');
        foreach ($course->classDays as $class) {
            if ($class->students->isEmpty()) {
               $certificate = false;
               break;
            }else{
                $certificate = true;
            }
        }
        return view('course.show',compact('course','certificate','today'));
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
        $student = Student::findOrFail($prueba->id);
        if (auth()->user()->academy_id === null) {
            $tiposCursos = Course_type::orderBy('course_type_name')->get();
        }else{
            $tiposCursos = Academy::findOrFail(auth()->user()->academy_id)->coursesType;
        }
        return view('inscription.inscription',compact('student','tiposCursos'));
    }
    public function elegirCurso(Request $request,$idAlumno)
    {
        $cursos_disponibles = Course::where('isActive',true)
            ->where('branch_office_id',$request->branch_office_id)
            ->where('type_course_id',$request->type_course_id)
            ->orderBy('id','desc')
            ->get();
        $student = Student::findOrFail($idAlumno);
        return view('inscription.indexCourses',compact('cursos_disponibles','student'));
    }
    public function inscribir($idAlumno,$idCurso)
    {
        $course = Course::findOrFail($idCurso);

        /* En caso de que se ocupe el últipo cupo */
        $validator = Validator::make(['curso' => $idCurso], [
            'curso' => [
                function ($attribute, $value, $fail) {
                    $course = $this->course->findOrFail($value);
                    if ($course->students->count() >= $course->student_capacity) {
                        $fail('Parece que ocurrió un error');
                    }
                },
            ],
        ]);
        if ($validator->fails()) {
            return redirect()->route('cursos.elegir')
                ->withErrors($validator);
        }

        $course->students()->attach($idAlumno);
        return redirect()->route('home')->with('status','Alumno inscripto con éxito');
    }
    public function bajaAlumno($idCurso,$idAlumno)
    {
        $course = Course::findOrFail($idCurso);
        $course->students()->detach($idAlumno);
        return back()->with('status','El alumno fue dado de baja');
    }
    public function inscripcionAlumnos(Request $request,$idCurso)
    {
        $dni = $request->dniDelEstudiantes;
        $email = $request->emailDelEstudiante;
        $students = Student::where('isActive',true)
            ->email($email)
            ->dni($dni)
            ->orderBy('id','desc')
            ->paginate(20)
            ->withQueryString();
        return view('inscription.indexStudents',compact('students','request','idCurso'));
    }
}
