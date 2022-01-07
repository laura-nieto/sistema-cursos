@extends('layouts.menu')

@section('content_view')
    <div class="card">
        <div class="card-header text-center">
            <h3>
                Planificar curso
            </h3>
        </div>
        <div class="card-body">
            <form
                action="{{ route('horarios.store') }}"
                method="POST">
                    <div class="form-row d-flex align-items-center justify-content-center mb-3">
                        <label for="courseId" class="m-0 float-right">
                            ID del curso:
                        </label>
                        <h6 class="m-0">
                            {{$course->id}}
                        </h6>
                    </div>
                    {{-- courseId for --}}
                    <input
                    name="courseId" 
                    id="courseIdHorario" 
                    value="{{$course->id}}" 
                    class="d-none"/>
                    {{-- Add or Remove days --}}
                    <div class="form-row d-flex align-items-center mb-3">
                        <div class="form-group col-5 "1>
                            <button class="btn btn-success btn-days float-right" type="button" onclick="removeDays()">
                                -
                            </button>
                        </div>
                        <div class="form-group col-2">
                            <h6 class="m-0 text-center">
                                Días cursada
                            </h6>
                        </div>
                        <div class="form-group col-5 ">
                            <button class="btn btn-success btn-days float-left" type="button" onclick="addDays()">
                                +
                            </button>
                        </div>
                    </div>
                    <div class="form-row  mb-1">
                        <div class="col-3"></div>
                        <div class="col-3">
                            <h6>
                                fecha
                            </h6>
                        </div>
                        <div class="col-3">
                            <h6>
                                Hora inicio
                            </h6>
                        </div>
                        <div class="col-3">
                            <h6>
                                Hora fin
                            </h6>
                        </div>
                    </div>
                    <div class="form-row mb-1" id="CourseDaysDiv">
                        {{-- <div class="col-3 p-0 d-flex align-items-center justify-content-center">
                            <label for="dia1" class="m-0">
                                Dia 1
                            </label>
                        </div>
                        <div class="col-3">
                            <input
                                type="date" 
                                name="dia1"
                                id="dia1CrearDia" 
                                class="w-100 form-control"
                                min="{{date('Y-m-d')}}"
                                value="{{old('dia1')}}"
                                required>
                        </div>
                        <div class="col-3">
                            <input 
                                type="time" 
                                name="hora1Inicio" 
                                id="hora1InicioCrearDia" 
                                class="w-100 form-control"
                                step="900"
                                value="{{old('hora1Inicio')}}"
                                required>
                        </div>
                        <div class="col-3">
                            <input 
                                type="time" 
                                name="hora1Fin" 
                                id="hora1FinCrearDia" 
                                class="w-100 form-control"
                                step="900"
                                value="{{old('hora1Fin')}}"
                                required>
                        </div>
                        <div class="col-3 p-0 mt-2 d-flex align-items-center justify-content-center">
                            <label for="nombreInstructor1" class="m-0">
                                Nombre del Instructor:
                            </label>
                        </div>
                        <div class="col-9 mt-2">
                            <input
                                type="text"
                                name="nombreInstructor1"
                                id="nombreInstructor1CrearDia"
                                class="form-control"
                                value="{{old('nombreInstructor1')}}"
                                required>
                        </div> --}}
                    </div>
                    <input
                        style="display:none"
                        id="numberTheDays"
                        name="numberTheDays"
                        type="text"
                        value="1">
                    {{-- value for numberTheDays change with script src /js/classDay.js --}}
                    <div class="row justify-content-center mt-3">
                        <h6>
                            Duración del curso: {{$course->total_hours}}
                        </h6>
                    </div>
                    <div class="row justify-content-center mt-3">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary p-2">
                            Enviar
                        </button>
                    </div>  
            </form>
        </div>
    </div>
        @php
         $oldData = json_encode(old());
        @endphp
        <script>
            let oldData = <?= $oldData; ?>;
        </script>
        {{-- Add and remove days --}}
        <script src="/js/classDay.js"></script>
@endsection