@extends('layouts.menu')

@section('content_view')
    <div class="card">
        <div class="card-header text-center">
            <h3>
                Crear curso
            </h3>
        </div>
        <div class="card-body">
            <form
                action="{{ route('cursos.create') }}"
                method="GET">

                <div class="form-group mt-4">
                    <label for="academy_id">
                        Seleccione la academia donde desee crear el curso *
                    </label>
                    <div  class="row ml-1 mt-2">                        
                        <select
                        class="form-control"
                        name="academy_id"
                        required>
                            <option value="">
                                
                            </option>
                        @foreach ($academies as $academy)
                            <option value="{{$academy->id}}">
                                {{$academy->name}}
                            </option>   
                        @endforeach
                    </select>
                    </div>
                </div>
                    <div class="row justify-content-center">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary mt-3 p-3">
                            Seleccionar academia
                        </button>
                    </div>  
            </form>
        </div>
    </div>
@endsection