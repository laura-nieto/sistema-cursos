@extends('layouts.menu')

@section('content_view')
<div class="card mb-2">
    <div class="card-header text-center">
        <div class='row'>
            <div class="col-sm-9">
                <h2>
                    Tipo de curso
                </h2>
            </div>
            @if((auth()->user()->can('course_types.edit') || auth()->user()->can('course_types.destroy')))
            <div class="col-sm-3">
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
                        @if (auth()->user()->can('course_types.edit'))  
                            <a class="dropdown-item"
                                href="{{ route('tipo_cursos.edit', $course_type) }}">
                                Editar Tipo
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="card-body">
        {{-- row --}}
        <div class="row mb-3">
            <div class="col-3">
               <h6>
                   <strong>
                       ID Tipo de Curso:
                    </strong>
                </h6>
            </div>
            <div class="col-3">
                <span>{{ $course_type->id }}</span>
            </div>
        </div>
        {{-- row --}}
        <div class="row mb-3 d-flex align-items-center">
            <div class="col-3 ">
                <h6>
                    <strong>
                        Nombre:
                     </strong>
                 </h6>
            </div>
            <div class="col-3">
                <span>{{ $course_type->course_type_name }}</span>
            </div>
        </div>
        <div class="row mb-3 d-flex align-items-center">
            <div class="col-3">
                <h6>
                    <strong>
                        Descripción:
                    </strong>
                </h6>
            </div>
            <div class="col-9">
                <span>{{ $course_type->description }}</span>
            </div>
        </div>
    </div>
</div>
@endsection