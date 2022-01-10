@extends('layouts.menu')

@section('content_view')
    <h2 class="text-center">
        Listado de Tipo de Cursos
    </h2>

    <div class="card">
        <div class="card-body">
                <form action="{{ route('tipo_cursos.index') }}" method="GET">
                    <div class="row">
                        <div class="col">
                          <input
                            type="text"
                            name="name"
                            value="{{ $request->name?$request->name: null }}"
                            class="form-control"
                            placeholder="Por nombre">
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
                            Nombre
                        </th>
                        <th class="col-3" colspan="3"> 
                            &nbsp
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($typesCourse as $type)
                        <tr>
                            <td>{{ $type->id }}</td>
                            <td>{{ $type->course_type_name }}</td>
                        @if(auth()->user()->can('course_types.edit'))
                            <td>
                                <a href="{{ route('tipo_cursos.edit', $type) }}"
                                    class="btn btn-primary btn-sm">
                                    Editar
                                </a>
                            </td>
                        @else 
                            <td>
                                
                            </td>
                        @endif
                        @if(auth()->user()->can('course_types.index'))    
                            <td>
                                <a  href="{{ route('tipo_cursos.show', $type ) }}"
                                    class="btn btn-info btn-sm">
                                    Detalles
                                </a>
                            </td>
                        @else 
                            <td>
                            </td>
                        @endif
                        @if(auth()->user()->can('course_types.destroy'))
                            <td>
                                <form action="{{ route('tipo_cursos.destroy', $type) }}" method="POST">
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
                {{  $typesCourse->links() }}
            </div>
        </div>
    </div>
@endsection