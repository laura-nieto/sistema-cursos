@extends('layouts.menu')

@section('content_view')
    <div class="card">
        <div class="card-header text-center">
            <h3>
                Registrar tipo de Curso
            </h3>
        </div>
        <div class="card-body">
            <form
                action="{{ route('tipo_cursos.store') }}"
                method="POST">
                <div class="form-group mt-4">
                    <div class="row">
                        <div class="col col-8">
                            <label for="course_type_name">
                                Nombre: *
                            </label>
                            <input 
                                type="text"
                                name="course_type_name"
                                class="form-control"
                                value="{{old('course_type_name')}}"
                                required
                            >
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <label for="description">
                            Descripción *
                        </label>
                        <textarea 
                            name="description"
                            class="form-control"
                            rows="4"
                            cols="50"
                            required>{{old('description')}}</textarea>
                            <span class="comment float-right">
                                Máximo 255 caracteres.
                            </span>
                    </div>
                </div>
                <div class="row justify-content-center">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-primary mt-3 p-3">
                        Registrar Tipo
                    </button>
                </div>  
            </form>
        </div>
    </div>
@endsection