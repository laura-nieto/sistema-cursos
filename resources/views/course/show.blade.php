@extends('layouts.menu')

@section('content_view')
<div class="card mb-2">
    <div class="card-header text-center">
        <div class='row'>
            <div class="col-sm-10">
                <h2>
                    Curso
                </h2>
            </div>
            @if((auth()->user()->can('courses.edit') || auth()->user()->can('courses.destroy'))&& $course->isActive)
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
                        @if (auth()->user()->can('courses.edit'))  
                            <a class="dropdown-item"
                                href="{{ route('cursos.edit', $course) }}">
                                Editar curso
                            </a>
                        @endif
                    @if (auth()->user()->can('courses.destroy'))
                        <form action="{{ route('cursos.destroy', $course) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input 
                            type="submit"
                            value="Eliminar curso"
                            class="dropdown-item"
                            onclick="return confirm('Para eliminar un curso, no puede tener alumnos inscritos ¿Aún desea eliminar este curso?...')"/>
                        </form>
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
                       ID curso:
                    </strong>
                </h6>
            </div>
            <div class="col-3">
                <span>{{ $course->id }}</span>
            </div>
            <div class="col-3 ">
                <h6>
                    <strong>
                        Nombre Sucursal:
                     </strong>
                 </h6>
             </div>
             <div class="col-3">
                 <span>{{ $course->branchOffice->branch_name }}</span>
             </div>
        </div>
        {{-- row --}}
        <div class="row mb-3 d-flex align-items-center">
            <div class="col-3">
               <h6>
                   <strong>
                       Tipo de curso:
                    </strong>
                </h6>
            </div>
            <div class="col-3">
                <span>{{ $course->courseType->course_type_name }}</span>
            </div>
            <div class="col-3">
                <h6>
                    <strong>
                        Capacidad de alumnos:
                     </strong>
                 </h6>
             </div>
             <div class="col-3">
                 <span>{{ $course->student_capacity }}</span>
             </div>
        </div>
        {{-- row --}}
        <div class="row mb-3">
            <div class="col-3">
               <h6>
                   <strong>
                       Modalidad:
                    </strong>
                </h6>
            </div>
            <div class="col-3">
                <span>{{ $course->modality }}</span>
            </div>
            <div class="col-3">
                <h6>
                    <strong>
                        Horas totales:
                     </strong>
                 </h6>
             </div>
             <div class="col-3">
                 <span>{{ $course->total_hours }}</span>
             </div>
        </div>
        {{-- row --}}
        <div class="row mb-3 d-flex align-items-center">
            <div class="col-4">
               <h6>
                   <strong>
                       Fecha de expiración:
                    </strong>
                </h6>
            </div>
            <div class="col-8">
                <span>{{ $course->expiration }}</span>
            </div>
        </div>
        {{-- row --}}
        <div class="row mb-3 d-flex align-items-center">
            <div class="col-3">
               <h6>
                   <strong>
                        Fecha de creación:
                    </strong>
                </h6>
            </div>
            <div class="col-9">
                <span>{{ $course->created_at }}</span>
            </div>
        </div>
        {{-- row --}}
        <div class="row mb-3 d-flex align-items-center">
            <div class="col-3">
                <h6>
                    <strong>
                        Última actualización:
                     </strong>
                 </h6>
             </div>
             <div class="col-9">
                 <span>{{ $course->updated_at }}</span>
             </div>
        </div>
        {{-- row --}}
        <div class="row mb-3 d-flex align-items-center">
            <div class="col-3">
                <h6>
                    <strong>
                        Estado:
                     </strong>
                 </h6>
             </div>
            @if ($course->isActive)
                <div class="col-9">
                    <span class="bg-success pr-3 pl-3 rounded d-inline-block">
                        Activo
                    </span>    
                </div>
                @else
                <div class="col-3">
                    <span class="bg-danger pr-3 pl-3 rounded d-inline-block">
                        Desactivado
                    </span>
                </div>
                <div class="col-6">
                    <form action="{{ route('cursos.destroy', $course) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input 
                        type="submit"
                        value="Reactivar"
                        class="btn btn-warning"
                        onclick="return confirm('¿Desea Reactivar este curso?...')"/>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
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
                    <th>
                        &nbsp
                    </th>
                </tr>
            </thead>
            <tbody>
            @foreach ($course->classDays as $classDay)
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
                    <td class="text-center">
                        @if($classDay->students->isEmpty())
                            @if($classDay->get_date === $today)
                                <a href="{{ url('dia/'.$classDay->id) }}" class="btn btn-sm btn-info p-2">Presentes</a>
                            @endif
                        @else
                            <div class="d-flex">
                                <a href="{{ url('presentes/dia/'.$classDay->id)}}" class="btn btn-sm btn-info px-3 mr-2">Ver</a>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center mb-3">
            @if($certificate && $course->certificated === false)
                <form action="{{ route('certificar',$course) }}" method="post">
                    @csrf
                    <button class="btn btn-primary">
                        Certificar
                    </button>
                </form>
            @elseif(!$certificate)
                <a class="btn btn-primary" href="{{ route('horarios.edit',$course) }}">
                    Editar planificación
                </a>
            @endif
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
            <a class="btn btn-sm btn-primary p-2" href="{{route('alumnos.inscripcion',$course->id)}}">
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
            {{$course->students->count()}}/{{$course->student_capacity}}
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
                        <form action="{{route('cursos.bajaAlumno',[$course->id,$student->id])}}"
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
</div>
@endsection