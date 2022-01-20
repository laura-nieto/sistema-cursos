@extends('layouts.menu')

@section('content_view')
<div class="card mb-2">
    <div class="card-header text-center">
        <div class='row'>
            <div class="col-sm-9">
                <h2>
                    Datos del alumno
                </h2>
            </div>
            @if((auth()->user()->can('students.edit') || auth()->user()->can('students.destroy')) && $student->isActive)
            <div class="col-sm-3">
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
                        @if (auth()->user()->can('students.edit'))  
                            <a class="dropdown-item"
                                href="{{ route('estudiantes.edit', $student) }}">
                                Editar alumno
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="card-body">
        {{-- row --}}
        <div class="row mb-3">
            <div class="col-3">
               <h6>
                   <strong>
                       ID alumno:
                    </strong>
                </h6>
            </div>
            <div class="col-3">
                <span>{{ $student->id }}</span>
            </div>
        </div>
        {{-- row --}}
        <div class="row mb-3 d-flex align-items-center">
            <div class="col-3 ">
                <h6>
                    <strong>
                        Nombre:
                     </strong>
                 </h6>
             </div>
             <div class="col-3">
                <span>{{ $student->name }}</span>
             </div>
            <div class="col-3 ">
                <h6>
                    <strong>
                        Apellido:
                    </strong>
                </h6>
            </div>
            <div class="col-3">
                <span>{{ $student->last_name }}</span>
            </div>
        </div>
        {{-- row --}}
        <div class="row mb-3 d-flex align-items-center">
            <div class="col-3 ">
                <h6>
                    <strong>
                        DNI:
                     </strong>
                 </h6>
             </div>
             <div class="col-3">
                <span>{{ $student->dni }}</span>
             </div>
            <div class="col-3 ">
                <h6>
                    <strong>
                        Fecha de Nacimiento:
                    </strong>
                </h6>
            </div>
            <div class="col-3">
                <span>{{ $student->get_iSO_format_birthDate }}</span>
            </div>
        </div>
        {{-- row --}}
        <div class="row mb-3 d-flex align-items-center">
            <div class="col-3 ">
                <h6>
                    <strong>
                        Teléfono:
                     </strong>
                 </h6>
             </div>
             <div class="col-3">
                <span>{{ $student->phone }}</span>
             </div>
            <div class="col-3 ">
                <h6>    
                    <strong>
                        Mail:
                    </strong>
                </h6>
            </div>
            <div class="col-3">
                <span>{{ $student->email }}</span>
            </div>
        </div>
    </div>
</div>
<div class="card mb-2">
    <div class="card-header text-center">
        <div class="row">
            <div class="col-sm-9">
                <h2>
                    Cursos asociados
                </h2>
            </div>
            <div class="col-sm-3">
                <a class="btn btn-primary"
                href="{{ route('cursos.inscripcion',['id'=>$student]) }}">
                Inscribir a un curso
            </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th class="col-3 text-center">
                        ID curso
                    </th>
                    <th class="col-3 text-center">
                        Tipo de curso
                    </th>
                    <th class="col-3 text-center">
                        Expiración
                    </th>
                    <th class="col-3" colspan="3"> 
                        &nbsp
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($student->courses->sortDesc() as $course)
                    <tr>
                        <td class="text-center">
                            {{$course->id}}
                        </td>
                        <td>
                            {{$course->courseType->course_type_name}}
                        </td>
                        <td>
                            {{$course->expiration}}
                        </td>
                        <td>
                            @if ($course->certificates()->where('student_id',$student->id)->exists())
                                <a href="{{route('certificados.show',$course->certificates()->where('student_id',$student->id)->first()->id)}}" class="btn btn-sm btn-info px-3 mr-2">Ver</a>
                            @else
                                No certificado
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
        {{-- row --}}
{{--
<div class="card mb-2">
    <div class="card-header text-center">
        <h2>
            Planificación
        </h2>
    </div>
    <div class="card-body">
        @if ($course->classDays->isEmpty() && $course->isActive)
        <div class="row d-flex justify-content-center">
            <a class="btn btn-sm btn-primary p-2" href="{{ route('horarios.create',['courseId'=>$course->id])}}">
                Planificar Curso
            </a>
        </div>
        @elseif(!$course->isActive)
        <div class="row d-flex justify-content-center">
            <h6>
                Este curso ha sido desactivado
            </h6>
        </div>
        @else
        <table class="table">
            <thead>
                <tr>
                    <th class="col-4 text-center">
                        Dia
                    </th>
                    <th class="col-4 text-center">
                        Desde
                    </th>
                    <th class="col-4 text-center">
                        Hasta
                    </th>
                </tr>
            </thead>
            <tbody>
            @foreach ($course->classDays as $keys => $classDay)
                <tr>
                    <td class="text-center">
                        {{$classDay->get_date}}
                    </td>
                    <td class="text-center">
                        {{ $classDay->get_start_date }}
                    </td>
                    <td class="text-center">
                        {{ $classDay->get_end_date }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center mb-3">
            <a class="btn btn-primary" href="{{ route('horarios.edit',$course) }}">
                Editar planificación
            </a>
        </div>
        @endif
    </div>
</div>
<div class="card mb-2">
    <div class="card-header text-center">
        <h2>
            Estudiantes inscritos
        </h2>
    </div>
    <div class="card-body">
    @if ($course->students->isEmpty() && $course->classDays->isEmpty() && $course->isActive)
        <div class="row d-flex justify-content-center">
            <a class="btn btn-sm btn-primary p-2 disabled" href="">
                Inscribir alumnos
            </a>
        </div>
        <div class="text-center">
            <span class="comment">
                Es necesario hacer una planificación para inscribir alumnos.
            </span>
        </div>
        @elseif($course->students->isEmpty() && $course->isActive)
    <div class="row d-flex justify-content-center">
        <a class="btn btn-sm btn-primary p-2" href="">
            Inscribir alumnos
        </a>
    </div>
    @elseif(!$course->isActive)
        <div class="row d-flex justify-content-center">
            <h6>
                Este curso ha sido desactivado
            </h6>
        </div>
        @else
        <h6 class="text-center">
            {{$course->student_capacity}}/{{$course->students->count()}}
        </h6>
        <table class="table">
            <thead>
                <tr>
                    <th class="col-3 text-center">
                        DNI
                    </th>
                    <th class="col-3 text-center">
                        Nombre
                    </th>
                    <th class="col-3 text-center">
                        Apellido
                    </th>
                    <th class="col-3" colspan="2">
                        &nbsp
                    </th>
                </tr>
            </thead>
            <tbody>
            @foreach ($course->students as $student)
                <tr>
                    <td class="text-center">
                        {{$student->dni}}
                    </td>
                    <td class="text-center">
                        {{$student->name}}
                    </td>
                    <td class="text-center">
                        {{$student->last_name}}
                    </td>
                    @if (auth()->user()->can('students.index'))
                    <td class="d-flex justify-content-center">
                        <a class="btn btn-info btn-sm" href="">
                            Detalle
                        </a>
                    </td>
                    <td>
                        <form action=""
                            method="POST"
                            class="d-flex justify-content-center"
                            >
                            @csrf
                            @method('DELETE')
                            <input 
                                type="submit"
                                value="Dar  baja"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Esta seguro que desea dar de baja a este estudiante?')"/>
                        </form>
                    </td>
                    @else
                        <td>
                        </td>
                        <td>
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div> --}}
@endsection