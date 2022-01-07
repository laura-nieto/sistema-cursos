@extends('layouts.menu')

@section('content_view')
    <div class="card">
        <div class="card-header text-center">
            <h3>
                Registrar rol
            </h3>
        </div>
        <div class="card-body">
            <form
                action="{{ route('roles.store') }}"
                method="POST">
                <div class="form-group mt-4">
                    <div class="row">
                        <div class="col">
                            <label for="name">
                                Nombre: *
                            </label>
                            <input 
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{old('name')}}"
                                required
                            >
                        </div>
                    </div>
                </div>
                <div class="form-group mt-4">
                    <div class="row">
                        <div class="col">
                            <label for="name">
                                Permisos: *
                            </label>
                            <div class="row row-cols-5">
                                @foreach ($permisos as $permiso)
                                    <div class="col mx-3 my-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{$permiso->id}}" name="permisos[]" id="{{$permiso->id}}">
                                            <label class="form-check-label" for="{{$permiso->id}}">
                                                {{$permiso->name}}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
                    <div class="row justify-content-center">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary mt-3 p-3">
                            Registrar rol
                        </button>
                    </div>  
            </form>
        </div>
    </div>
@endsection