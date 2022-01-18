@extends('layouts.menu')

@section('content_view')
    <h2 class="text-center">
        Certificados
    </h2>
    <div class="card">
        <div class="card-body">
                <form action="{{ route('certificados.index') }}" method="GET">
                    <div class="row">
                        <div class="col">
                            <input type="number"
                            name="dniDelEstudiante"
                            value="{{ $request->dniDelEstudiante?$request->dniDelEstudiante: null }}"
                            class="form-control"
                            placeholder="D.N.I del estudiante">
                        </div>
                        <div class="col">
                            <input type="text"
                            name="apellidoEstudiante"
                            value="{{ $request->apellidoEstudiante?$request->apellidoEstudiante: null }}"
                            class="form-control"
                            placeholder="Apellido del Estudiantes">
                        </div>
                        <div class="col-2">
                            <input type="submit" class="form-control btn btn-primary" value="Buscar">
                        </div>
                      </div>
                </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table id="certificatesTable" class="table">
                <thead>
                    <tr>
                        <th class="col-1">ID</th>
                        <th class="col-3">DNI</th>
                        <th class="col-3">Apellido</th>
                        <th class="col-3">Nombre</th>
                        <th class="col-2">Día</th>
                        <th class="col-2" colspan="2"> &nbsp </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($certificates as $certificate)
                        <tr>
                            <td>{{ $certificate->id }}</td>
                            <td>{{ $certificate->student->dni }}</td>
                            <td>{{ $certificate->student->last_name }}</td>
                            <td>{{ $certificate->student->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($certificate->created_at)->format('d-m-Y') }}</td>
                            <td>
                                @can('certificates.index')
                                    <a href="{{ route('certificados.show', $certificate ) }}" class="btn btn-info btn-sm">
                                        Ver
                                    </a>
                                @endcan
                            </td>
                        
                        </tr>    
                    @endforeach
                </tbody>
            </table>            
            <div class="float-right">
                {{ $certificates->links() }}
            </div>
        </div>
    </div>
@endsection