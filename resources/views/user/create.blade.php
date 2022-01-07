@extends('layouts.menu')

@section('content_view')
    <div class="card">
        <div class="card-header text-center">
            <h3>
                Registrar usuarios
            </h3>
        </div>
        <div class="card-body">
            <form
                action="{{ route('usuarios.store') }}"
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
                                value="{{old('name')}}"
                                required
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
                                value="{{old('last_name')}}"
                                required
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
                                value="{{old('dni')}}"
                                min="1"
                                required
                            />
                        </div>
                        <div class="col">
                            <label for="gender">Género:</label>
                            <select
                                name="gender"
                                id="gender"
                                class="form-control"
                                required
                            >
                                <option value="{{old('gender')}}">
                                    {{old('gender')}}
                                </option>
                                <option value="female">
                                    Femenino
                                </option>
                                <option value="male">
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
                                value="{{ old('email') }}"
                            />
                        </div>
                        <div class="col">
                            <label for="role">Rol:</label>
                            <select
                                name="role"
                                id="role"
                                class="form-control"
                                required
                            >
                            <option value="{{old('role')}}">
                                {{old('role')}}
                            </option>
                            @foreach ($roles as $rol)
                                <option value="{{$rol->id}}">
                                    {{$rol->name}}
                                </option>
                            @endforeach
                            </select>
                        </div>
                        {{-- SI ROL != 1 || ROL != 2  DEBE HABILITARSE ACADEMIAS --}}
                    </div>
                </div>
                    <div class="row justify-content-center">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary mt-3 p-3">
                            Registrar usuario
                        </button>
                    </div>  
            </form>
        </div>
    </div>
    {{-- Limit characters for inputs --}}
@endsection