@extends('layouts.menu')

@section('content_view')
    <h2 class="text-center">
        Listado de Alumnos
    </h2>

    <div class="card">
        <div class="card-body">
                <form action="{{ route('estudiantes.index') }}" method="GET">
                    <div class="row">
                        {{-- @if($request->branchOfficeId)
                            <input 
                                type="text" 
                                name="branchOfficeId" 
                                value="{{ $request->branchOfficeId }}"
                                style="display: none"
                            />
                        @endif --}}
                        <div class="col">
                            <input type="number"
                            name="dniDelEstudiantes"
                            value="{{ $request->dniDelEstudiantes?$request->dniDelEstudiantes: null }}"
                            class="form-control"
                            placeholder=" Por D.N.I">
                        </div>
                        <div class="col">
                          <input
                            type="text"
                            name="emailDelEstudiante"
                            value="{{ $request->emailDelEstudiante?$request->emailDelEstudiante: null }}"
                            class="form-control"
                            placeholder="Por Mail">
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center col-3">
                            @if(auth()->user()->can('student.edit'))
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
                                    estudiantes inactivos
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
            <table id="studentsTable" class="table">
                <thead>
                    <tr>
                        <th class="col-3">
                            ID
                        </th>
                        <th class="col-3">
                            DNI
                        </th>
                        <th class="col-3">
                            Mail
                        </th>
                        <th class="col-3" colspan="3"> 
                            &nbsp
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr
                            @if (!$student->isActive)
                                class ='disabled'
                            @endif
                        >
                            <td>{{ $student->id }}</td>
                            <td>{{ $student->dni }}</td>
                            <td>{{ $student->email }}</td>
                        @if(auth()->user()->can('students.edit'))
                            <td>
                                <a href="{{ route('estudiantes.edit', $student) }}"
                                    class="btn btn-primary btn-sm">
                                    Editar
                                </a>
                            </td>
                        @else 
                            <td>
                                
                            </td>
                        @endif
                        @if(auth()->user()->can('students.index'))    
                            <td>
                                <a  href="{{ route('estudiantes.show', $student ) }}"
                                    class="btn btn-info btn-sm">
                                    Detalles
                                </a>
                            </td>
                        @else 
                            <td>
                            </td>
                        @endif
                        @if(auth()->user()->can('students.destroy') && $student->isActive)
                            <td>
                                <form action="{{ route('estudiantes.destroy', $student) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input 
                                        type="submit"
                                        value="Eliminar"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Para eliminar un alumno, no puede estar inscrito a ningún curso ni tener certificados vigentes.')"/>
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
                {{  $students->links() }}
            </div>
        </div>
    </div>
@endsection