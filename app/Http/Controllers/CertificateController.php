<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Class_day_student;
use App\Models\Course;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    protected $certificate;
    public function __construct(Certificate $certificate)
    {
        $this->middleware('permission:certificates.index')->only('index','show');
        $this->middleware('permission:certificates.create')->only('create','store');
        $this->middleware('permission:certificates.edit')->only('edit','update');
        $this->middleware('permission:certificates.destroy')->only('destroy');
        $this->middleware('jwt.auth')->only('studentCertificate');
        $this->certificate = $certificate;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lastname = $request->apellidoEstudiante;
        $dni = $request->dniDelEstudiante;

        $certificates = $this->certificate
            ->lastname($lastname)
            ->dni($dni)
            ->orderBy('id','desc')
            ->paginate(20)
            ->withQueryString();

        return view('certificate.index',compact('certificates','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function show(Certificate $certificado)
    {
        $alumno = $certificado->student;
        $curso = $certificado->course;
        $dias = $certificado->course->classDays;
        return view('certificate.show',compact('certificado','alumno','curso','dias'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function edit(Certificate $certificate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Certificate $certificate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Certificate $certificate)
    {
        //
    }

    public function certificar(Course $course)
    {
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
        return redirect()->route('cursos.show',$course->id)->with('status','Se realizó la certificación del curso');
    }

    public function studentCertificate()
    {
        $dni = request(['dni']);
        $alumno = Student::where('dni',$dni)->first();
        
        if ($alumno === null) { //NO EXISTE
            return response()->json(['error' => 'No existe el alumno.'],404);
        }

        if (!count($alumno->certificates)) { // NO CERTIFICADO
            return response()->json(['certificado' => false]);
        }

        $certificado = $alumno->certificates->last(); // ULTIMA CERTIFICACION
        $json = [
            'certificado' => true,
            'tipo_certificado' => $certificado->course->courseType->course_type_name,
            'fecha_certificacion' => Carbon::parse($certificado->created_at)->format('d-m-Y h:m'),
            'fecha_vencimiento' => Carbon::parse($certificado->created_at)->addYear()->format('d-m-Y')
        ];
        return response()->json($json);
    }

    public function generatePDF(Certificate $certificate)
    {
        $today = Carbon::today()->locale('es_ES');
        $hoy = $today->translatedFormat('l, d ') . ' de ' . $today->translatedFormat('F ') . ' del ' . $today->format('Y') ;
        $alumno = $certificate->student;
        $curso = $certificate->course;
        $dias = $certificate->course->classDays->sortBy('id');
        $sucursal = $certificate->course->branchOffice;
        $vencimiento = Carbon::parse($certificate->created_at)->addYear()->format('d-m-Y');
        $operador = Auth::user();
        $path_to_image = "/images/ba_bak.svg";
        $logo = "data:image/svg+xml;base64,". base64_encode(file_get_contents(public_path($path_to_image)));
        $data = [
            'certificado' => $certificate,
            'alumno' => $alumno,
            'curso' => $curso,
            'dias' => $dias,
            'sucursal' => $sucursal,
            'vencimiento' => $vencimiento,
            'hoy' => $hoy,
            'operador' => $operador,
            'logo' => $logo,
        ];
        $pdf = PDF::loadView('pdf.certificate', $data);
        return $pdf->stream('certificate.pdf');
    }
}
