@extends('layouts.menu')

@section('content_view')
    <div class="card">
        <div class="card-header text-center">
            <h3>
                Crear academia
            </h3>
        </div>
        <div class="card-body">
            <form
                action="{{ route('academias.store') }}"
                method="POST">
                <div class="form-group">
                    <label for="nombreDeAcademia">
                        Nombre de la Academia: *
                    </label>
                    <input
                        type="text"
                        name="nombreDeAcademia"
                        class="form-control"
                        value="{{old('nombreDeAcademia')}}"
                        required>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="calle">
                            Calle: *
                        </label>
                        <input
                        type="text"
                        name="calle"
                        class="form-control"
                        value="{{old('calle')}}" 
                        required>
                    </div>
                    <div class="col">
                        <label for="alturaDeLaCalle">
                            Altura de la calle: 
                        </label>
                        <input
                            type="number"
                            min="0"
                            name="alturaDeLaCalle"
                            class="form-control"
                            value="{{old('alturaDeLaCalle')}}"
                            required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="responsable">
                        Responsable *
                    </label>
                    <input 
                        type="text"
                        name="responsable"
                        class="form-control" 
                        value="{{old('responsable')}}" 
                        required>
                </div>
                <div class="form-group">
                    <label for="telefono">
                        Teléfono *
                    </label>
                    <div class="row">
                        <div class="col-md-4">
                            <input
                                type="tel"
                                name="prefijo"
                                id="prefijo"
                                class="form-control"
                                pattern="[0-9]{2}"
                                placeholder="11"
                                value="{{old('prefijo')}}">
                                <span class="comment ml-1">Prefijo.</span>
                        </div>
                        <div class="col-md-8">
                            <input type="number"
                                name="telefono"
                                id="telefono"
                                class="form-control"
                                placeholder="12345678"
                                value="{{old('telefono')}}"
                                required>
                                <span class="comment ml-1">Son necesario 8 digitos.</span>
                        </div>

                    </div>
                </div>
                <div class="form-group">
                    <label for="email">
                        Correo Electrónico: *
                    </label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{old('email')}}"
                        required>
                </div>
                <div class="form-group">
                    <label for="noc">
                        NOC *
                    </label>
                    <textarea 
                        name="noc"
                        class="form-control"
                        rows="4"
                        cols="50"
                        required>{{old('noc')}}</textarea>
                        <span class="comment float-right">
                            Máximo 255 caracteres.
                        </span>
                    </div>
                <div class="form-group mt-4">
                    <label for="courseType">
                        Tipos de cursos para los que está habilitada *
                    </label>
                    <div  class="row ml-1 mt-2">                        
                        @foreach ($courseTypes as $courseType)
                        <div class="form-check form-check-inline">
                            <input 
                                class="form-check-input"
                                type="checkbox"
                                name="tiposDeCurso[]"
                                value="{{ $courseType->id }}"
                                @if ( old('tiposDeCurso') !== null )
                                    @if (in_array( $courseType->id,old('tiposDeCurso') ))
                                        checked
                                    @endif
                                @endif
                                >
                            <label
                                class="form-check-label"
                                for="courseType{{$courseType->id}}">
                                {{ $courseType->course_type_name }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                    <div class="row justify-content-center">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary mt-3 p-3">
                            Crear academia
                        </button>
                    </div>  
            </form>
        </div>
    </div>
    {{-- Limit characters for inputs --}}
    <script src="/js/utilities.js"></script>
@endsection