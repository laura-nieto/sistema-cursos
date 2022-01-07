@extends('layouts.menu')

@section('content_view')
    <div class="card">
        <div class="card-header text-center">
            <div class="row">
                <div class="col-sm-10">
                    <h3>
                        Editar curso
                    </h3>
                </div>
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
                            <a class="dropdown-item" href="{{ route('cursos.show', $course) }}">
                                Detalles
                            </a>
                            <form action="{{ route('cursos.destroy', $course) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input 
                                    type="submit"
                                    value="Eliminar curso"
                                    class="dropdown-item"
                                    onclick="return confirm('Para eliminar un curso, no puede tener alumnos inscritos ¿Aún desea eliminar este curso?...')"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($course->students->isNotempty())
        <span class="bg-warning text-center p-3">
            Este curso, tiene estudiantes inscritos.
        </span>
        @endif
        <div class="card-body">
            <form
                action="{{ route('cursos.update',$course) }}"
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
                                    @foreach ($course->branchOffice->academy->branchOffices as $branchOffice)
                                    <option
                                        value="{{$branchOffice->id}}"
                                        @if (null === old("sucursalAsociada") && $course->branchOffice->id === $branchOffice->id )
                                            selected
                                        @elseif (intval(old("sucursalAsociada")) === $branchOffice->id)
                                            selected
                                        @endif 
                                        >
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
                                    @foreach ($course->branchOffice->academy->coursesType as $courseType)
                                    <option value="{{$courseType->id}}"
                                        @if (null === old('tipoCurso') && $course->courseType->id === $courseType->id)
                                            selected
                                        @elseif (intval(old('tipoCurso')) === $courseType->id)
                                            selected
                                        @endif
                                        >
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
                            <div class="row d-flex justify-content-center align-items-center">
                                <div class="col-3">
                                    <input
                                        type="number"
                                        name="horasTotales"
                                        id="horasTotalesCrear"
                                        class="form-control"
                                        placeholder="HH"
                                        min="5"
                                        max="23"
                                        value="{{old('horasTotales',explode(":",$course->total_hours)[0])}}"
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
                                        min="0"
                                        max="59"
                                        step="15"
                                        value="{{old('minutosTotales',explode(":",$course->total_hours)[1])}}"
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
                                value="{{old('capacidadDeEstudiantes',$course->student_capacity)}}"
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
                                <option value="{{old('modalidadCurso',$course->modality)}}">
                                    {{old('modalidadCurso',$course->modality)}}
                                </option>
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
                                value="{{old('vencimientoCurso',$course->expiration)}}"
                                required
                            />
                        </div>
                    </div>
                </div>
                    <div class="row justify-content-center">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-primary mt-3 p-3">
                            Editar curso
                        </button>
                    </div>  
            </form>
        </div>
    </div>
@endsection