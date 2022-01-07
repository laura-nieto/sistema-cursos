@extends('layouts.menu')

@section('content_view')
    <div class="card">
        <div class="card-header text-center">
            <h3>
                Crear Sucursal
            </h3>
        </div>
        <div class="card-body">
            <form
                action="{{ route('sucursales.store') }}"
                method="POST">
                <div class="form-group">
                    <label for="academiaAsociada">
                        Nombre de la academia a la que pertenece: *
                    </label>
                    <select
                        class="form-control"
                        name="academiaAsociada"
                        required>
                        @if($preSelectedAcademy !== null)
                            <option value="{{$preSelectedAcademy->id}}">
                                {{$preSelectedAcademy->name}}
                            </option>
                        @else
                            <option value="">
                            </option>
                        @endif
                        @foreach ($academies as $academy)
                            <option value="{{$academy->id}}">
                                {{$academy->name}}
                            </option>   
                        @endforeach
                    </select>
                    <span class="comment">Escribe el nombre de la academia.</span>
                </div>
                <div class="form-group">
                    <label for="nombreDeSucursal">
                        Nombre de la sucursal: *
                    </label>
                    <input
                        type="text"
                        name="nombreDeSucursal"
                        class="form-control"
                        value="{{old('nombreDeAcademia')}}"
                        required>
                </div>
                <div class="row mb-4">
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
                            Altura de la calle: *
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
                <div class="row justify-content-center">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-primary mt-3 p-3">
                        Crear sucursal
                    </button>
                </div>  
            </form>
        </div>
    </div>
@endsection