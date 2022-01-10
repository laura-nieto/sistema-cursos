@extends('layouts.menu')

@section('content_view')
<div class="card mb-2">
    <div class="card-header text-center">
        <div class='row'>
            <div class="col-sm-10">
                <h2>
                    Sucursal {{$branchOffice->branch_name}}
                </h2>
            </div>
            @if((auth()->user()->can('branch_offices.edit') || auth()->user()->can('branch_offices.destroy')) && $branchOffice->isActive)
            <div class="col-sm-2">
                <div class="btn-group">
                    <button
                        type="button"
                        class="btn btn-info dropdown-toggle"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">
                        Opciones
                    </button>
                    <div class="dropdown-menu border">

                        @if (auth()->user()->can('branch_offices.edit'))  
                            <a class="dropdown-item"
                                href="{{ route('sucursales.edit', $branchOffice) }}">
                                Editar sucursal
                            </a>
                        @endif
                    @if (auth()->user()->can('branch_offices.destroy'))
                        <form action="{{ route('sucursales.destroy', $branchOffice) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input 
                            type="submit"
                            value="Eliminar sucursal"
                            class="dropdown-item"
                            onclick="return confirm('Para eliminar una sucursar, no pueden haber cursos abiertos ¿Aún desea eliminar esta sucursal?...')"/>
                        </form>
                    @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-4">
               <h6>
                   <strong>
                       ID:
                    </strong>
                </h6>
            </div>
            <div class="col-8">
                <span>{{ $branchOffice->id }}</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">
               <h6>
                   <strong>
                       Nombre de la sucursal:
                    </strong>
                </h6>
            </div>
            <div class="col-8">
                <span>{{ $branchOffice->branch_name }}</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4 d-flex align-items-center">
               <h6>
                   <strong>
                       Dirección de la sucursal
                    </strong>
                </h6>
            </div>
            <div class="col-8">
                <span>{{ $branchOffice->street." ".$branchOffice->streetHeight }}</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4 d-flex align-items-center">
               <h6>
                   <strong>
                       NOC:
                    </strong>
                </h6>
            </div>
            <div class="col-8">
                <span>{{ $branchOffice->noc }}</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4 d-flex align-items-center">
                <h6>
                    <strong>
                        Nombre de la academia:
                     </strong>
                 </h6>
             </div>
             <div class="col-4">
                <span>{{ $branchOffice->academy->name }}</span>
             </div>
             <div class="col-4">
                @if (auth()->user()->can('academies.index'))  
                    <a class="btn btn-info float-left"
                        href="{{ route('academias.show', $branchOffice->academy) }}">
                        Ver academia
                    </a>
                @endif
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4 d-flex align-items-center">
                <h6>
                   <strong>
                       Estado:
                    </strong>
                </h6>
            </div>
            @if ($branchOffice->isActive)
            <div class="col-8">
                <span class="bg-success pr-3 pl-3 rounded d-inline-block">
                    activa
                </span>
            </div>
            @else
            <div class="col-4">
                <span class="bg-danger pr-3 pl-3 rounded d-inline-block">
                    Desactiva
                </span>
            </div>
            <div class="col-4">
                <form action="{{ route('sucursales.destroy', $branchOffice) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input 
                    type="submit"
                    value="Reactivar sucursal"
                    class="btn btn-warning"
                    onclick="return confirm('¿Desea reactivar esta sucursal?...')"/>
                </form>
            </div>
                @endif
        </div>
        <div class="row mb-5">
            <div class="col-4">
                <h6>
                   <strong>
                    Tipos de cursos habilitados:
                    </strong>
                </h6>
            </div>
            <div class="col-8">
                <div class="row">
                    @foreach ($branchOffice->academy->coursesType as $courseType)
                    <div class="col-4 mb-1">
                        <span>
                            {{$courseType->course_type_name}}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row mb-3">
            {{-- @if (auth()->user()->can('branch_offices.index')) --}}
                <div class="col">
                    <a href="{{url('/cursos/create?academy_id='.$branchOffice->academy_id)}}"
                        class="btn btn-primary float-right">
                        Crear curso en esta sucursal
                    </a>
                </div>
            {{-- @endif --}}
            {{-- @if (auth()->user()->can('branch_offices.create')) --}}
                <div class="col">
                    <a href="{{url('cursos?nombreSucursalAsociada=' . $branchOffice->branch_name . '&nombreTipoDeCurso=')}}"
                        class="btn btn-primary float-left">
                        Mostrar cursos planificados
                    </a>
                </div>
            {{-- @endif --}}
        </div>
    </div>
</div>
@endsection