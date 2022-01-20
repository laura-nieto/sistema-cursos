@extends('layouts.menu')

@section('content_view')
    <div class="card mb-2">
        <div class="card-header text-center">
            <h3 class="text-center">
                {{$student->last_name . ' ' . $student->name}}
            </h3>
        </div>
        <div class="card-body">
            <form
                action="{{route('cursos.elegir',$student->id)}}"
                method="POST">
                <div class="form-group mt-4">
                    <div class="row">
                        <div class="col-6">
                            <label for="tipoCurso">Tipo de Curso</label>
                            <select name="type_course_id" id="tipoCurso" class="form-control" value="{{old('type_course_id')}}" required>
                                <option value=""></option>
                                @foreach ($tiposCursos as $tipo)
                                    <option value="{{ $tipo->id }}" {{old('type_course_id' == $tipo->id ? 'selected':'')}}>
                                        {{$tipo->course_type_name}}
                                    </option> 
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="academies">Academia</label>
                            <select name="academies" id="academies" class="form-control" value="{{old('academies')}}" required></select>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-6">
                            <label for="sucursales">Sucursal</label>
                            <select name="branch_office_id" id="sucursales" class="form-control" value="{{old('branch_office_id')}}" required></select>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary mt-3 p-3">
                            Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        let select_tipoCursos = document.getElementById('tipoCurso'),
            select_academias = document.getElementById('academies'),
            select_sucursales = document.getElementById('sucursales');
        //OBTENER ACADEMIAS
        select_tipoCursos.addEventListener('change',()=>{
            let url =  `{{url('/tipo_curso/${select_tipoCursos.value}')}}`
            select_academias.innerHTML = "";
            select_sucursales.innerHTML = "";
            axios.post(url)
            .then(response =>{
                if (!Array.isArray(response.data)) {
                    for(let i in response.data){
                        // var opciones ="<option value=''>Elegir</option>";
                        var opciones = '<option value="'+response.data[i].id+'">'+response.data[i].name+'</option>';
                        select_academias.innerHTML = opciones;
                        select_academias.dispatchEvent(new Event('change'));
                    }
                }else{
                    var opciones ="<option value=''>Elegir</option>";
                    response.data.forEach(academia => {
                        opciones += '<option value="'+academia.id+'">'+academia.name+'</option>';
                    })
                    select_academias.innerHTML = opciones;
                }
            })
            .catch(error => {
                console.log(error)
            })
        })
        //OBTENER SUCURSALES
        select_academias.addEventListener('change',()=>{
            let url =  `{{url('/tipo_curso/${select_tipoCursos.value}/academia/${select_academias.value}')}}`
            select_sucursales.innerHTML = "";
            axios.post(url)
            .then(response =>{
                let opciones ="<option value=''>Elegir</option>";
                response.data.forEach(sucursal => {
                    opciones+= '<option value="'+sucursal.id+'">'+sucursal.branch_name+'</option>';
                })
                select_sucursales.innerHTML = opciones;
            })
            .catch(error => {
                console.log(error)
            })
        })
    </script>
@endsection