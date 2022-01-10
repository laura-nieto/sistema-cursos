@extends('layouts.menu')

@section('content_view')
<div class="card mb-2">
    <div class="card-header text-center">
        <div class='row'>
            <div class="col-sm-9">
                <h2>
                    Datos del Usuario
                </h2>
            </div>
            @if((auth()->user()->can('users.edit') || auth()->user()->can('users.destroy')) && $user->active)
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
                        @if (auth()->user()->can('users.edit'))  
                            <a class="dropdown-item"
                                href="{{ route('usuarios.edit', $user) }}">
                                Editar Usuario
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
                       ID usuario:
                    </strong>
                </h6>
            </div>
            <div class="col-3">
                <span>{{ $user->id }}</span>
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
                <span>{{ $user->name }}</span>
             </div>
            <div class="col-3 ">
                <h6>
                    <strong>
                        Apellido:
                    </strong>
                </h6>
            </div>
            <div class="col-3">
                <span>{{ $user->last_name }}</span>
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
                <span>{{ $user->dni }}</span>
            </div>
            <div class="col-3 ">
                <h6>    
                    <strong>
                        Mail:
                    </strong>
                </h6>
            </div>
            <div class="col-3">
                <span>{{ $user->email }}</span>
            </div>
        </div>
        @if ($user->academy != null)
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
                    <span>{{ $user->academy->name }}</span>
                </div>
            </div> 
        @endif
    </div>
</div>
@endsection