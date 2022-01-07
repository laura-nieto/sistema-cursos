<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use Illuminate\Http\Request;
use App\Http\Requests\AcademyRequest;
use App\Models\Course_type;
use App\Models\Academy_course_type;
use Illuminate\Support\Facades\Validator;

class AcademyController extends Controller
{
    protected $academy;
    public function __construct(Academy $academy)
    {
        $this->middleware('permission:academies.index')->only('index','show');
        $this->middleware('permission:academies.create')->only('create','store');
        $this->middleware('permission:academies.edit')->only('edit','update');
        $this->middleware('permission:academies.destroy')->only('destroy');
        $this->academy = $academy;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->nombreDeAcademia;
        $email = $request->email;
        $state = $request->disabled;

        $academies = $this->academy
            ->name($name)
            ->email($email)
            ->isDisabled($state)
            ->orderBy('id','desc')
            ->paginate(20)
            ->withQueryString();

        return view('academy.index',compact('academies','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('academy.create',[
            'courseTypes'=> Course_type::latest()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\AcademyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AcademyRequest $request)
    {
        $data = array(
            'name' => $request->nombreDeAcademia,
            'street' => $request->calle,
            'streetHeight' => $request->alturaDeLaCalle,
            'responsible' => $request->responsable,
            'phone' => $request->prefijo.$request->telefono,
        );
        $academy = $this->academy::create($data + $request->all());
        // 'isActive' true for default
        foreach ($request->tiposDeCurso as $courseType) {
            Academy_course_type::create([
                'academy_id'=> $academy->id,
                'course_type_id'=> $courseType,
            ]);
        }
        return redirect('/academias')->with('status','Academia creado con éxito'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Academy->id  $academy
     * @return \Illuminate\Http\Response
     */
    public function show($academyId)
    {
        $academy = $this->academy::findOrFail($academyId);
        return view('academy.show' , compact('academy'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Academy->id $academy
     * @return \Illuminate\Http\Response
     */
    public function edit($academyId)
    {
        $academy = $this->academy->findOrFail($academyId);
        return view('academy.edit', [
            'courseTypes' => Course_type::latest()->get(),
            'academy' => $academy,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\AcademyRequest  $request
     * @param  \App\Models\Academy->id  $academy
     * @return \Illuminate\Http\Response
     */
    public function update(AcademyRequest $request,$academyId)
    {
        $data = array(
            'name' => $request->nombreDeAcademia,
            'street' => $request->calle,
            'streetHeight' => $request->alturaDeLaCalle,
            'responsible' => $request->responsable,
            'phone' => $request->prefijo.$request->telefono,
        );

        $academy = $this->academy::findOrFail($academyId);
        $academy->update($data + $request->all());

        $academy->coursesType()->sync($request->tiposDeCurso);

        return back()->with('status','La academia ha sido editada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Academy->id  $academy
     * @return \Illuminate\Http\Response
     */
    public function destroy($academyId)
    {
        //Find an academy
        $academy = $this->academy->findOrFail($academyId);
        //Find associated branch office for this academys
        $validator = Validator::make(['academia'=>$academyId], [
            'academia' => [
                function ($attribute, $value, $fail) {
                    $academy = $this->academy->findOrFail($value);
                    if ($academy->branchOffices->where('isActive',true)->isNotEmpty()) {
                        $fail('Esta '.$attribute.' posee sucursales asociadas.');
                    }
                },
            ],
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator);
        }

        if ($academy->isActive) {
            $academy->update([
                'isActive' => false,
            ]);
            return back()->with('status','Academia eliminada con éxito');
        }else{
            $academy->update([
                'isActive' => true,
            ]);
            return back()->with('status','Academia restaurada con éxito');
        }

    }
}
