@extends('layouts.menu')

@section('content_view')
    <div class="card">
        <div class="card-header text-center">
            <h3>
                Modificar usuario
            </h3>
        </div>
        <div class="card-body">
            <form
                action="{{ route('usuarios.update',$user) }}"
                method="POST">
                <div class="form-group mt-4">
                    <div class="row">
                        <div class="col">
                            <label for="name">
                                Nombre: *
                            </label>
                            <input 
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{$user->name}}"
                                
                            >
                        </div>
                        <div class="col">
                            <label for="last_name">
                                Apellido: *
                            </label>
                            <input
                                type="text"
                                name="last_name"
                                class="form-control"
                                value="{{$user->last_name}}"
                                
                            >
                        </div>
                    </div>
                </div>
                <div class="form-group mt-4">
                    <div class="row">
                        <div class="col">
                            <label for="dni">
                                DNI: *
                            </label>
                            <input
                                type="number"
                                name="dni"
                                id="dni"
                                class="form-control"
                                value="{{$user->dni}}"
                                min="1"
                                
                            />
                        </div>
                        <div class="col">
                            <label for="gender">Género:</label>
                            <select
                                name="gender"
                                id="gender"
                                class="form-control"
                                
                            >
                                <option value="female" {{$user->gender == 'female' ? 'selected' : ''}}>
                                    Femenino
                                </option>
                                <option value="male" {{$user->gender == 'male' ? 'selected' : ''}}>
                                    Masculino
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-4">
                    <div class="row">
                        <div class="col">
                            <label for="mailAlumnoCrear">
                                Mail: 
                            </label>
                            <input
                                type="email"
                                name="email"
                                id="mailAlumnoCrear"
                                class="form-control"
                                value="{{ $user->email }}"
                            />
                        </div>
                        <div class="col">
                            <label for="password">
                                Contraseña: 
                            </label>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control"
                                value="{{ $user->password }}"
                            />
                        </div>
                 
                    </div>
                </div>
                <div class="form-group mt-4">
                    <div class="row">
                        <div class="col col-6">
                            <label for="role">Rol:</label>
                            <select
                                name="role"
                                id="role"
                                class="form-control"
                                
                            >
                            <option value="{{$user->roles->first()->id}}">
                                {{$user->getRoleNames()->first() }}
                            </option>
                            @foreach ($roles as $rol)
                                <option value="{{$rol->id}}">
                                    {{$rol->name}}
                                </option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col col-6 {{$user->academy_id == null ? 'd-none' : ''}}" id="academies">
                            <label for="academy">Academia:</label>
                            <select
                                name="academy_id"
                                id="academy"
                                class="form-control"
                            >
                            @if ($user->academy_id != null)   
                                <option value="{{$user->academy_id}}">
                                    {{$user->academy->name}}
                                </option>
                            @endif
                            @foreach ($academias as $academia)
                                <option value="{{$academia->id}}">
                                    {{$academia->name}}
                                </option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                    <div class="row justify-content-center">
                        @csrf
                        @method('PUT')
                        <input type="number" name="id" value = {{$user->id}} style="display: none">
                        <button type="submit" class="btn btn-sm btn-primary mt-3 p-3">
                            Modificar usuario
                        </button>
                    </div>  
            </form>
        </div>
    </div>
    {{-- Mostrar Academias si el rol es mayor a 2 --}}
    <script src="{{asset('/js/showAcademias.js')}}"></script>
@endsection