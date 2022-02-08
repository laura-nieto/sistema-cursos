@extends('layouts.menu')

@section('content_view')
<div class="card mb-2">
    <div class="card-header text-center">
        <div class='row'>
            <div class="col">
                <h2>
                    Alumno
                </h2>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{-- row --}}
        <div class="row mb-3 d-flex align-items-center">
            <div class="col-3">
                <h6>
                    <strong>
                        Nombre:
                    </strong>
                 </h6>
             </div>
             <div class="col-3">
                <span>{{ $alumno->name }}</span>
             </div>
            <div class="col-3 ">
                <h6>
                    <strong>
                        Apellido:
                    </strong>
                </h6>
            </div>
            <div class="col-3">
                <span>{{ $alumno->last_name }}</span>
            </div>
        </div>
        {{-- row --}}
        <div class="row mb-3 d-flex align-items-center">
            <div class="col-3 ">
                <h6>
                    <strong>
                        DNI:
                     </strong>
                 </h6>
             </div>
             <div class="col-3">
                <span>{{ $alumno->dni }}</span>
             </div>
            <div class="col-3 ">
                <h6>
                    <strong>
                        Fecha de Nacimiento:
                    </strong>
                </h6>
            </div>
            <div class="col-3">
                <span>{{ $alumno->get_iSO_format_birthDate }}</span>
            </div>
        </div>
        {{-- row --}}
        <div class="row mb-3 d-flex align-items-center">
            <div class="col-3 ">
                <h6>
                    <strong>
                        Teléfono:
                     </strong>
                 </h6>
             </div>
             <div class="col-3">
                <span>{{ $alumno->phone }}</span>
             </div>
            <div class="col-3 ">
                <h6>    
                    <strong>
                        Mail:
                    </strong>
                </h6>
            </div>
            <div class="col-3">
                <span>{{ $alumno->email }}</span>
            </div>
        </div>
    </div>
</div>
<div class="card mb-2">
    <div class="card-header text-center">
        <div class='row'>
            <div class="col">
                <h2>
                    Curso
                </h2>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{-- row --}}
        <div class="row mb-3 d-flex align-items-center">
            <div class="col-3 ">
                <h6>
                    <strong>
                        Academia:
                    </strong>
                </h6>
            </div>
            <div class="col-3">
                <span>{{ $curso->branchOffice->academy->name }}</span>
            </div>
            <div class="col-3 ">
                <h6>
                    <strong>
                        Sucursal:
                    </strong>
                 </h6>
            </div>
            <div class="col-3">
                <span>{{ $curso->branchOffice->branch_name }}</span>
            </div>
        </div>
        {{-- row --}}
        <div class="row mb-3 d-flex align-items-center">
            <div class="col-3 ">
                <h6>
                    <strong>
                        Teléfono:
                     </strong>
                 </h6>
            </div>
            <div class="col-3">
                <span>{{ $curso->branchOffice->academy->phone }}</span>
            </div>
            <div class="col-3 ">
                <h6>
                    <strong>
                        Domicilio:
                    </strong>
                </h6>
            </div>
            <div class="col-3">
                <span>{{ $curso->branchOffice->academy->street . ' ' . $curso->branchOffice->academy->streetHeight}}</span>
            </div>
        </div>
        {{-- row --}}
        <div class="row mb-3 d-flex align-items-center">
            <div class="col-3">
                <h6>
                    <strong>
                        Tipo:
                    </strong>
                 </h6>
            </div>
            <div class="col-3">
                <span>{{ $curso->courseType->course_type_name }}</span>
            </div>
            <div class="col-3">
                <h6>
                    <strong>
                        Horas:
                    </strong>
                 </h6>
            </div>
            <div class="col-3">
                <span>{{ $curso->getSimpleHours()}} / {{ $curso->getSimpleHours() }}</span>
            </div>
        </div>
        <div class="row mb-3 d-flex align-items-center">
            <div class="col-3">
                <h6>
                    <strong>
                        Modalidad:
                    </strong>
                </h6>
            </div>
            <div class="col-3">
                <span>{{ $curso->modality }}</span>
            </div>
            <div class="col-2">
                <h6>
                    <strong>
                        Días:
                    </strong>
                </h6>
            </div>
            <div class="col-4">
                @foreach ($dias as $dia)
                    <span>{{$dia->get_date}} {{$dia->get_start_date}} - {{$dia->get_end_date}}</span><br>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="row mt-3 d-flex align-items-center justify-content-center">
    <a href="{{route('exportCertificate',$certificado)}}" class="btn btn-primary">
        PDF
    </a>
</div>

@endsection