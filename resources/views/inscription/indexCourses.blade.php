@extends('layouts.menu')

@section('content_view')
<div class="card">
    <div class="card-header text-center">
        <h3>
            {{$student->last_name . ' ' . $student->name}}
        </h3>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th class="col-3 text-center">
                        ID curso
                    </th>
                    <th class="col-3 text-center">
                        Modalidad
                    </th>
                    <th class="col-3 text-center">
                        Días
                    </th>
                    <th class="col-3" colspan="3"> 
                        &nbsp
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cursos_disponibles as $course)
                <tr>
                    <td class="text-center">
                        {{$course->id}}
                    </td>
                    <td class="text-center">
                        {{$course->modality}}
                    </td>
                    <td class="text-center">
                        @if ($course->classDays->isEmpty())
                            Sin Planificar
                        @else
                            <div>
                                @foreach ($course->classDays as $class)
                                    <h6>
                                        {{$class->get_date}}   
                                        {{ \Carbon\Carbon::parse($class->get_start_date)->format('H:i')}} - 
                                        {{ \Carbon\Carbon::parse($class->get_end_date)->format('H:i')}}
                                    </h6>
                                @endforeach
                            </div>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($course->classDays->isNotEmpty() && $course->students->count() < $course->student_capacity && !$course->students->contains($student->id))
                            <form action="{{route('cursos.inscribir',[$student->id,$course->id])}}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-info">
                                    Inscribir
                                </button>
                            </form>
                        @elseif($course->students->contains($student->id))
                            El alumno está inscripto en este curso
                        @else
                            No disponible
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection