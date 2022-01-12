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
                        &nbsp
                    </th>
                </tr>
            </thead>
            <tbody>
                <form action="" method="post">
                    @csrf
                    @foreach ($students as $student)
                        <tr>
                            <td>{{$student->last_name}}</td>
                            <td>{{$student->name}}</td>
                            <td><input type="checkbox" name="presentes[]" value="{{$student->id}}" id="{{$student->id}}" class="form-check-input"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row justify-content-center">
                <button type="submit" class="btn btn-sm btn-primary mt-3 p-3">Dar Presente</button>
            </div>
        </form>
    </div>
</div>
@endsection