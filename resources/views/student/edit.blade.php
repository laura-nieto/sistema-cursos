@extends('layouts.menu')

@section('content_view')
    <div class="card">
        <div class="card-header text-center">
            <h3>
                Editar alumno
            </h3>
        </div>
        <div class="card-body">
            <form
                action="{{ route('estudiantes.update',$student) }}"
                method="POST">
                <div class="form-group mt-4">
                    <div class="row">
                        <div class="col">
                            <label for="nombreAlumno">
                                Nombre: *
                            </label>
                            <input 
                                type="text"
                                name="nombreAlumno"
                                class="form-control"
                                value="{{old('nombreAlumno',$student->name)}}"
                                required
                            >
                        </div>
                        <div class="col">
                            <label for="apellidoAlumno">
                                Apellido: *
                            </label>
                            <input
                                type="text"
                                name="apellidoAlumno"
                                class="form-control"
                                value="{{old('apellidoAlumno',$student->last_name)}}"
                                required
                            >
                        </div>
                    </div>
                </div>
                <div class="form-group mt-4">
                    <div class="row">
                        <div class="col">
                            <label for="dniAlumnoCrear">
                                DNI: *
                            </label>
                            <input
                                type="number"
                                name="dni"
                                id="dniAlumnoCrear"
                                class="form-control"
                                value="{{old('dni',$student->dni)}}"
                                min="1"
                                required
                            />
                        </div>
                        <div class="col">
                            <label for="fechaDeNacimiento">
                                Fecha Nacimiento: *
                            </label>
                            <input
                                type="date"
                                class="form-control"
                                name="fechaDeNacimiento"
                                id="fechaDeNacimientoCrear"
                                max="{{date('Y-m-d')}}"
                                value="{{old('fechaDeNacimiento',$student->birth_date)}}"
                                required
                                >
                        </div>
                    </div>
                </div>
                <div class="form-group mt-4">
                    <div class="row">
                        <div class="col">
                            <label for="telefono">
                                Telefono:
                            </label>
                            <div class="row">
                                <div class="col-md-4">
                                    <input
                                        type="tel"
                                        name="prefijo"
                                        id="prefijo"
                                        class="form-control"
                                        pattern="[0-9]{2}"
                                        placeholder="11"
                                        value="{{ old('prefijo',$student->get_prefijo) }}"
                                        >
                                        <span class="comment ml-1">Prefijo.</span>
                                </div>
                                <div class="col-md-8">
                                    <input type="number"
                                        name="telefono"
                                        id="telefono"
                                        class="form-control"
                                        placeholder="12345678"
                                        value="{{ old('telefono',$student->get_phone) }}"
                                    >
                                        <span class="comment ml-1">Son necesario 8 digitos.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <label for="mailAlumnoCrear">
                                Mail:
                            </label>
                            <input
                                type="email"
                                name="email"
                                id="mailAlumnoCrear"
                                class="form-control"
                                value="{{ old('email',$student->email) }}"
                            />
                        </div>
                    </div>
                </div>
                    <input type="number" name="id" value = {{$student->id}} style="display: none">
                    <div class="row justify-content-center">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-primary mt-3 p-3">
                            Editar alumno
                        </button>
                    </div>  
            </form>
        </div>
    </div>
    {{-- Limit characters for inputs --}}
    <script src="/js/utilities.js"></script>
@endsection