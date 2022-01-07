@extends('layouts.menu')

@section('content_view')
    <div class="card">
        <div class="card-header text-center">
            <div class="row">
                <div class="col-sm-10">
                    <h3>
                        Editar sucursal
                    </h3>
                </div>
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
                            <a class="dropdown-item" href="{{ route('sucursales.show', $branchOffice) }}">
                                Detalles
                            </a>
                            <form action="{{ route('sucursales.destroy', $branchOffice) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input 
                                    type="submit"
                                    value="Eliminar sucursal"
                                    class="dropdown-item"
                                    onclick="return confirm('Para eliminar una sucursar, no pueden haber cursos abiertos ¿Aún desea eliminar esta sucursal?...')"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form
                action="{{ route('sucursales.update',$branchOffice) }}"
                method="POST">
                <div class="form-group">
                    <label for="academiaAsociada">
                        Nombre de la academia a la que pertenece: *
                    </label>
                    <select
                        class="form-control"
                        name="academiaAsociada"
                        required
                        >
                            <option value="{{$branchOffice->academy->id}}" selected>
                                {{$branchOffice->academy->name}}
                            </option>   
                    </select>
                </div>
                <div class="form-group">
                    <label for="nombreDeSucursal">
                        Nombre de la sucursal: *
                    </label>
                    <input
                        type="text"
                        name="nombreDeSucursal"
                        class="form-control"
                        value="{{old('nombreDeAcademia',$branchOffice->branch_name)}}"
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
                            value="{{old('calle',$branchOffice->street)}}"
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
                            value="{{old('alturaDeLaCalle',$branchOffice->streetHeight)}}"
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
                        required>{{old('noc',$branchOffice->noc)}}</textarea>
                    <span class="comment float-right">
                        Máximo 255 caracteres.
                    </span>
                    </div>
                <div class="row justify-content-center">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-sm btn-primary mt-3 p-3">
                        Editar sucursal
                    </button>
                </div>  
            </form>
        </div>
    </div>
@endsection