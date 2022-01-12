@extends('layouts.menu')

@section('content_view')
    <h2 class="text-center">
        Listado de Alumnos
    </h2>

    <div class="card">
        <div class="card-body">
                <form action="{{ route('alumnos.inscripcion',$idCurso) }}" method="GET">
                    <div class="row">
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
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td>{{ $student->dni }}</td>
                            <td>{{ $student->email }}</td>
                        @if(auth()->user()->can('students.index'))    
                            <td>
                                <form action="{{route('cursos.inscribir', [$student->id,$idCurso])}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-info btn-sm">Inscribir</button>
                                </form>
                            </td>
                        @else 
                            <td>
                            </td>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div class="float-right">
                {{  $students->links() }}
            </div>
        </div>
    </div>
@endsection