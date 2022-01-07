@extends('layouts.menu')

@section('content_view')
    <h2 class="text-center">
        Listado de cursos
    </h2>
    <div class="card">
        <div class="card-body">
                <form action="{{ route('cursos.index') }}" method="GET">
                    <div class="row">
                        @if($request->branchOfficeId)
                            <input 
                                type="text" 
                                name="branchOfficeId" 
                                value="{{ $request->branchOfficeId }}"
                                style="display: none"
                            />
                        @endif
                        <div class="col">
                            <input type="text"
                            name="nombreSucursalAsociada"
                            value="{{ $request->nombreSucursalAsociada?$request->nombreSucursalAsociada: null }}"
                            class="form-control"
                            placeholder="Sucursal asociada">
                        </div>
                        <div class="col">
                          <input
                            type="text"
                            name="nombreTipoDeCurso"
                            value="{{ $request->nombreTipoDeCurso?$request->nombreTipoDeCurso: null }}"
                            class="form-control"
                            placeholder="Tipo de curso">
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center col-3">
                            @if(auth()->user()->can('courses.edit'))
                                <input 
                                    name='disabled'
                                @if ($request->disabled)
                                    checked
                                @endif
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="active">
                                <label
                                    class="custom-control-label"
                                    for="active">
                                    Cursos inactivas
                                </label>
                            @endif
                          </div>
                        <div class="col-2">
                            <input type="submit"
                                class="form-control btn btn-primary"
                                value="Buscar">
                        </div>
                      </div>
                </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table id="branchOfficeTable" class="table">
                <thead>
                    <tr>
                        <th class="col-1">
                            ID
                        </th>
                        <th class="col-4">
                            Sucursal asociada
                        </th>
                        <th class="col-4">
                            Tipo de curso
                        </th>
                        <th class="col-1" colspan="3"> 
                            &nbsp
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr
                            @if (!$course->isActive)
                                class = 'disabled'
                            @endif
                        >
                            <td>{{ $course->id }}</td>
                            <td>{{ $course->branchOffice->branch_name }}</td>
                            <td>{{ $course->courseType->course_type_name }}</td>
                        @if(auth()->user()->can('courses.edit'))
                            <td>
                                <a href="{{ route('cursos.edit', $course) }}"
                                    class="btn btn-primary btn-sm">
                                    Editar
                                </a>
                            </td>
                        @else 
                            <td>
                                
                            </td>
                        @endif
                        @if(auth()->user()->can('courses.index'))    
                            <td>
                                <a  href="{{ route('cursos.show', $course ) }}"
                                    class="btn btn-info btn-sm">
                                    Detalles
                                </a>
                            </td>
                        @else 
                            <td>
                            </td>
                        @endif
                        @if(auth()->user()->can('courses.destroy') && $course->isActive)
                            <td>
                                <form action="{{ route('cursos.destroy', $course) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input 
                                        type="submit"
                                        value="Eliminar"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Para eliminar un curso, no pueden tener alumnos inscritos ¿Aún desea eliminar este curso?...')"/>
                                </form>
                            </td>
                        @else
                            <td>
                            </td>
                        @endif
                        </tr>    
                    @endforeach
                </tbody>
            </table>
            <div class="float-right">
                {{  $courses->links() }}
            </div>
        </div>
    </div>
@endsection