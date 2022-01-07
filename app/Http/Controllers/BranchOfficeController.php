<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use App\Models\Branch_office;
use Illuminate\Http\Request;
use App\Http\Requests\BranchofficeRequest;
use Illuminate\Support\Facades\Validator;

class BranchOfficeController extends Controller
{
    protected $branchOffice;
    public function __construct(Branch_office $branchOffice)
    {
        $this->middleware('permission:users.index')->only('index','show');
        $this->middleware('permission:users.create')->only('create','store');
        $this->middleware('permission:users.edit')->only('edit','update');
        $this->middleware('permission:users.destroy')->only('destroy');
        $this->branchOffice = $branchOffice;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $state = $request->disabled;
        $name = $request->nombreDeSucursal;
        $nameAcademy = $request->nombreAcademiaAsociada;
        $academyId = $request->academyId;

        // dd($request->all());
        
        $branchOffices = $this->branchOffice
            ->forAcademyId($academyId)
            ->isDisabled($state)
            ->NameBranchOffice($name)
            ->nameAcademy($nameAcademy)
            ->orderBy('id','desc')
            ->paginate(20)
            ->withQueryString();
    
        return view('branchOffice.index',compact('branchOffices','request'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->academyId){
            $preSelectedAcademy = Academy::findOrFail($request->academyId);
        }else{
            $preSelectedAcademy = null;
        };
        $academies = Academy::where('isActive',true)->get();
        return view('branchOffice.create',[
            'academies'=>$academies,
            'preSelectedAcademy'=>$preSelectedAcademy,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchofficeRequest $request)
    {
        $date = array(
            'academy_id' => $request->academiaAsociada,            
            'branch_name' => $request->nombreDeSucursal,            
            'street' => $request->calle,
            'streetHeight' => $request->alturaDeLaCalle,
            'noc' => $request->noc,
        );
        
        $this->branchOffice::create($date);

        return redirect('/sucursales')->with('status','Sucursal creada con éxito'); 
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Branch_office  $branchOffice
     * @return \Illuminate\Http\Response
     */
    public function show($branchOfficeId)
    {
        $branchOffice = $this->branchOffice::findOrFail($branchOfficeId);
        return view('branchOffice.show', compact('branchOffice'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Branch_office  $branchOffice
     * @return \Illuminate\Http\Response
     */
    public function edit($branchOfficeId)
    {
        $branchOffice = $this->branchOffice::findOrFail($branchOfficeId);
        return view('branchOffice.edit', [
            'branchOffice' => $branchOffice,
        ]);
    }
    /**
     * Update the specified resource in sstorage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch_office  $branchOffice
     * @return \Illuminate\Http\Response
     */
    public function update(BranchofficeRequest $request, $id)
    {
        $branchOffice = $this->branchOffice::findOrFail($id);
    
        $date = array(
            'branch_name' => $request->nombreDeSucursal,            
            'street' => $request->calle,
            'streetHeight' => $request->alturaDeLaCalle,
            'noc' => $request->noc,
        );

        $branchOffice->update($date);

        return back()->with('status','La sucursal  ha sido editada con éxito.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Branch_office  $branchOffice
     * @return \Illuminate\Http\Response
     */
    public function destroy($branchOfficeId)
    {
        //Find an academy
        $branchOffice = $this->branchOffice->findOrFail($branchOfficeId);
        //Find associated courses for this branchOffice
        $validator = Validator::make(['sucursal'=>$branchOfficeId], [
            'sucursal' => [
                function ($attribute, $value, $fail) {
                    $branchOffice = $this->branchOffice->findOrFail($value);
                    if ($branchOffice->courses->where('isActive',true)->isNotEmpty()) {
                        $fail('Esta '.$attribute.' posee cursos asociados planificados.');
                    }
                },
            ],
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator);
        }
        if ($branchOffice->isActive) {
            $branchOffice->update([
                'isActive' => false,
            ]);
            return back()->with('status','sucursal eliminada con éxito');
        }else{
            $branchOffice->update([
                'isActive' => true,
            ]);
            return back()->with('status','Sucursal restaurada con éxito');
        }
    }
}
