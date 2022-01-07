<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Requests\StudentRequest;

class StudentController extends Controller
{
    protected $student;
    public function __construct(Student $student)
    {
        $this->middleware('permission:students.index')->only('index','show');
        $this->middleware('permission:students.create')->only('create','store');
        $this->middleware('permission:students.edit')->only('edit','update');
        $this->middleware('permission:students.destroy')->only('destroy');
        $this->student = $student;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dni = $request->dniDelEstudiantes;
        $email = $request->emailDelEstudiante;
        $state = $request->disabled;

        $students = $this->student
            ->isDisabled($state)
            ->email($email)
            ->dni($dni)
            ->orderBy('id','desc')
            ->paginate(20)
            ->withQueryString();

        return view('student.index',compact('students','request'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {   
        $date = array(
            'name' => $request->nombreAlumno,
            'last_name' => $request->apellidoAlumno,
            'birth_date' => $request->fechaDeNacimiento,
            'phone' => $request->prefijo.$request->telefono,
        );
        $this->student::create($date + $request->all());

        return redirect('/estudiantes')->with('status','El alumno ha sido creado con éxito'); 
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show($studentId)
    {
        $student = $this->student::findOrFail($studentId);
        // dd($student);
        return view('student.show',compact('student'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit($studentId)
    {
        $student = $this->student::findOrFail($studentId);
        return view('student.edit',compact('student'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request,$studentId)
    {
        $data = array(
            'name' => $request->nombreAlumno,
            'last_name' => $request->apellidoAlumno,    
            'birth_date' => $request->fechaDeNacimiento,
            'phone' => $request->prefijo.$request->telefono,
        );
        $student = $this->student::findOrFail($studentId);
        $student->update( $data + $request->all() );

        return back()->with('status','El alumno ha sido editada con éxito.');

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
}
