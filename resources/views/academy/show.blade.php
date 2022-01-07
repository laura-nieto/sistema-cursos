@extends('layouts.menu')

@section('content_view')
<div class="card mb-2">
    <div class="card-header text-center">
        <div class='row'>
            <div class="col-sm-10">
                <h2>
                    Academia {{$academy->name}}
                </h2>
            </div>
            @if((auth()->user()->can('academies.edit') || auth()->user()->can('academies.destroy'))&& $academy->isActive)
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
                        @if (auth()->user()->can('academies.edit'))  
                            <a class="dropdown-item"
                                href="{{ route('academias.edit', $academy) }}">
                                Editar academia
                            </a>
                        @endif
                    @if (auth()->user()->can('academies.destroy'))
                        <form action="{{ route('academias.destroy', $academy) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input 
                            type="submit"
                            value="Eliminar academia"
                            class="dropdown-item"
                            onclick="return confirm('Para eliminar una academia, no pueden tener sucursales asociadas ¿Aún desea eliminar esta academia?...')"/>
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
                <span>{{ $academy->id }}</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">
               <h6>
                   <strong>
                       Nombre de la academia:
                    </strong>
                </h6>
            </div>
            <div class="col-8">
                <span>{{ $academy->name }}</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">
               <h6>
                   <strong>
                       Dirección de la academia:
                    </strong>
                </h6>
            </div>
            <div class="col-8">
                <span>{{ $academy->street." ".$academy->streetHeight }}</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">
               <h6>
                   <strong>
                       Responsable:
                    </strong>
                </h6>
            </div>
            <div class="col-8">
                <span>{{ $academy->responsible }}</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">
               <h6>
                   <strong>
                       Teléfono:
                    </strong>
                </h6>
            </div>
            <div class="col-8">
                <span>{{ $academy->phone }}</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">
               <h6>
                   <strong>
                       Mail:
                    </strong>
                </h6>
            </div>
            <div class="col-8">
                <span>{{ $academy->email }}</span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">
               <h6>
                   <strong>
                       NOC:
                    </strong>
                </h6>
            </div>
            <div class="col-8">
                <span>{{ $academy->noc }}</span>
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
            @if ($academy->isActive)
            <div class="col-8">
                <span class="bg-success pr-3 pl-3  rounded d-inline-block">
                    activa
                </span>
            </div>
            @else
            <div class="col-4">
                <span class="bg-danger pr-3 pl-3  rounded d-inline-block">
                    Desactiva
                </span>
            </div>
            <div class="col-4">
                <form action="{{ route('academias.destroy', $academy) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input 
                    type="submit"
                    value="Reactivar academia"
                    class="btn btn-warning"
                    onclick="return confirm('¿Desea Reactivar esta academia?...')"/>
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
                    @foreach ($academy->coursesType as $courseType)
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
            @if (auth()->user()->can('branch_offices.index'))
                <div class="col">
                    <a href="{{ route('sucursales.index',['academyId'=>$academy]) }}"
                        class="btn btn-primary float-right">
                        Mostrar Sucursales activas
                    </a>
                </div>
            @endif
            @if (auth()->user()->can('branch_offices.create'))
                <div class="col">
                    <a href="{{ route('sucursales.create',['academyId'=>$academy]) }}"
                        class="btn btn-primary float-left">
                        Crear sucursal asociada
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection