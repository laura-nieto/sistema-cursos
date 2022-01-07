@extends('layouts.menu')

@section('content_view')
    <div class="card">
        <div class="card-header text-center">
            <h3>
                Crear curso
            </h3>
        </div>
        <div class="card-body">
            <form
                action="{{ route('cursos.store') }}"
                method="POST">
                <div class="form-group mt-4">
                    <div class="row">
                        <div class="col">
                            <label for="sucursalAsociadaCursoCrear">
                                Sucursal asociada: *
                            </label>
                                <select
                                    class="form-control"
                                    name="sucursalAsociada"
                                    id="sucursalAsociadaCursoCrear"
                                    required>
                                    @foreach ($academy->branchOffices as $branchOffice)
                                    <option value="{{ $branchOffice->id }}"
                                        @if (intval(old("sucursalAsociada")) === $branchOffice->id)
                                            selected
                                        @endif>
                                        {{$branchOffice->branch_name}}
                                    </option>   
                                    @endforeach
                                </select>
                        </div>
                        <div class="col">
                            <label for="tipoCursoCrear">
                                Tipo de cursos: *
                            </label>
                                <select
                                    class="form-control"
                                    name="tipoCurso"
                                    id="tipoCursoCrear"
                                    required>
                                    @foreach ($academy->coursesType as $courseType)
                                    <option value="{{ $courseType->id }}" 
                                        @if (intval(old("tipoCurso")) === $courseType->id)
                                            selected
                                        @endif>
                                        {{$courseType->course_type_name}}
                                    </option>   
                                    @endforeach
                                </select>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-4">
                    <div class="row">
                        <div class="col">
                            <label for="horasTotalesCrear">
                                Horas totales del curso: *
                            </label>
                            <div
                                class="row d-flex justify-content-center align-items-center">
                                <div class="col-3">
                                    <input
                                        type="number"
                                        name="horasTotales"
                                        id="horasTotalesCrear"
                                        class="form-control"
                                        placeholder="HH"
                                        value="{{ old('horasTotales') }}"
                                        min="5"
                                        max="23"
                                        required
                                    />
                                </div>
                                <span>:</span>
                                <div class="col-3">
                                    <input
                                        type="number"
                                        name="minutosTotales"
                                        id="minutosTotalesCrear"
                                        class="form-control"
                                        placeholder="MM"
                                        value="{{ old('minutosTotales') }}"
                                        min="0"
                                        max="59"
                                        step="15"
                                        required
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <label for="capacidadEstudiantesCurso">
                                Capacidad de estudiantes: *
                            </label>
                            <input
                                type="number"
                                name="capacidadDeEstudiantes"
                                id="capacidadEstudiantesCurso"
                                class="form-control"
                                min="1"
                                step="1"
                                value="{{old('capacidadDeEstudiantes')}}"
                                required
                            />
                        </div>
                    </div>
                </div>
                <div class="form-group mt-4">
                    <div class="row">
                        <div class="col">
                            <label for="modalidadCursoCrear">
                                Modalidad: *
                            </label>
                            <select
                                name="modalidadCurso"
                                id="modalidadCursoCrear"
                                class="form-control"
                                required
                            >
                            @if (old('modalidadCurso'))
                                <option value="{{ old('modalidadCurso') }}">
                                    {{old('modalidadCurso')}}
                                </option>
                            @else
                                <option value="">
                                </option>
                            @endif
                                <option value="Virtual">
                                    Virtual
                                </option>
                                <option value="Presencial">
                                    Presencial
                                </option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="vencimientoCursoCrear">
                                Vencimiento: *
                            </label>
                            <input
                                type="date"
                                name="vencimientoCurso"
                                id="vencimientoCursoCrear"
                                class="form-control"
                                min="{{date('Y-m-d')}}"
                                value="{{ old('vencimientoCurso') }}"
                                required
                            />
                        </div>
                    </div>
                </div>
                    <div class="row justify-content-center">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary mt-3 p-3">
                            Planificar curso
                        </button>
                    </div>  
            </form>
        </div>
    </div>
@endsection