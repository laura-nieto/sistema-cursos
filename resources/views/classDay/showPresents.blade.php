@extends('layouts.menu')

@section('content_view')
<div class="card mb-2">
    <div class="card-header text-center">
        <div class='row'>
            <div class="col-sm-10">
                <h2>
                    {{$classDay->get_date}} {{$classDay->get_start_date}} - {{$classDay->get_end_date}}
                </h2>
            </div>
            @can('presentes.edit')
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
                            <a class="dropdown-item"
                                href="{{ url('dia/'.$classDay->id.'/edit') }}">
                                Modificar Presentes
                            </a>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="col-3">
                        Apellido
                    </th>
                    <th class="col-3">
                        Nombre
                    </th>
                    <th class="col-3" colspan="3"> 
                        Presente
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{$student->last_name}}</td>
                        <td>{{$student->name}}</td>
                        <td>{{$student->pivot->attendance === true ? 'Presente' : 'Ausente'  }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection