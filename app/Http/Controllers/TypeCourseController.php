<?php

namespace App\Http\Controllers;

use App\Models\Course_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeCourseController extends Controller
{
    protected $type;
    public function __construct(Course_type $type)
    {
        $this->middleware('permission:course_types.index')->only('index','show');
        $this->middleware('permission:course_types.create')->only('create','store');
        $this->middleware('permission:course_types.edit')->only('edit','update');
        $this->middleware('permission:course_types.destroy')->only('destroy');
        $this->type = $type;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->name;

        $typesCourse = $this->type
            ->where('course_types.course_type_name','ILIKE', "$name%")
            ->orderBy('id','desc')
            ->paginate(20)
            ->withQueryString();
        return view('typeCourse.index',compact('typesCourse','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('typeCourse.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'course_type_name' => 'required|max:80|min:5',
            'description' => 'required|min:5|max:255'
        ];
        $message = [
            'required' => 'El campo :attribute es requerido',
            'min' => 'El campo :attribute requiere :min caracteres',
            'max' => 'El campo :attribute debe tener como máximo :max caracteres',
        ];
        $request->validate($rules,$message);
        $tipo_curso = $this->type->create($request->all());
        
        return redirect()->route('tipo_cursos.index')->with('status','El tipo de curso fue creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course_type  $courseType
     * @return \Illuminate\Http\Response
     */
    public function show($courseType_id)
    {
        $course_type = Course_type::findOrFail($courseType_id);
        return view('typeCourse.show',compact('course_type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course_type  $courseType
     * @return \Illuminate\Http\Response
     */
    public function edit($courseType_id)
    {
        $course_type = Course_type::findOrFail($courseType_id);
        return view('typeCourse.edit',compact('course_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course_type  $courseType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $courseType_id)
    {
        $rules = [
            'course_type_name' => 'required|max:80|min:5',
            'description' => 'required|min:5|max:255'
        ];
        $message = [
            'required' => 'El campo :attribute es requerido',
            'min' => 'El campo :attribute requiere :min caracteres',
            'max' => 'El campo :attribute debe tener como máximo :max caracteres',
        ];
        $request->validate($rules,$message);
        $tipo_curso = $this->type::findOrFail($courseType_id);
        $tipo_curso->update($request->all());
        
        return redirect()->route('tipo_cursos.index')->with('status','El tipo de curso fue modificado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course_type  $courseType
     * @return \Illuminate\Http\Response
     */
    public function destroy($courseType_id)
    {
        //Find a course type
        $course_type = $this->type->findOrFail($courseType_id);
        //Find associated courses for this branchOffice
        $validator = Validator::make(['tipo'=>$courseType_id], [
            'tipo' => [
                function ($attribute, $value, $fail) {
                    $course_type = $this->type->findOrFail($value);
                    if ($course_type->courses->where('isActive',true)->isNotEmpty()) {
                        $fail('Este '.$attribute.' posee cursos asociados planificados.');
                    }
                },
            ],
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator);
        }
        $course_type->delete();
        return back()->with('status','Tipo de curso eliminado con éxito');
    }
}
