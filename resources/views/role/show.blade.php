@extends('layouts.menu')

@section('content_view')
<div class="card mb-2">
    <div class="card-header text-center">
        <div class='row'>
            <div class="col-sm-9">
                <h2>
                    Rol
                </h2>
            </div>
            @if((auth()->user()->can('roles.edit') || auth()->user()->can('roles.destroy')))
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
                        @if (auth()->user()->can('roles.edit'))  
                            <a class="dropdown-item"
                                href="{{ route('roles.edit', $role) }}">
                                Editar
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
                       ID del Rol:
                    </strong>
                </h6>
            </div>
            <div class="col-3">
                <span>{{ $role->id }}</span>
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
                <span>{{ $role->name }}</span>
            </div>
        </div>
        <div class="row mb-3 d-flex align-items-center">
            <div class="col-3">
                <h6>
                    <strong>
                        Permisos:
                    </strong>
                </h6>
            </div>
            <div class="col-9 row">
                @foreach ($role->permissions as $permission)
                    <span class="col-4 mb-1">{{$permission->name}}</span>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection