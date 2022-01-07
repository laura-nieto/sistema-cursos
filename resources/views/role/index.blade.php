@extends('layouts.menu')

@section('content_view')
    <h2 class="text-center">
        Listado de Roles
    </h2>

    <div class="card">
        <div class="card-body">
                <form action="{{ route('roles.index') }}" method="GET">
                    <div class="row">
                        {{-- @if($request->branchOfficeId)
                            <input 
                                type="text" 
                                name="branchOfficeId" 
                                value="{{ $request->branchOfficeId }}"
                                style="display: none"
                            />
                        @endif --}}
                        <div class="col">
                          <input
                            type="text"
                            name="name"
                            value="{{ $request->name?$request->name: null }}"
                            class="form-control"
                            placeholder="Por nombre">
                        </div>
                        <div class="col-2">
                            <input type="submit"
                                class="form-control btn btn-primary"
                                value="Buscar">
                        </div>
                      </div>
                </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="studentsTable" class="table">
                <thead>
                    <tr>
                        <th class="col-3">
                            ID
                        </th>
                        <th class="col-3">
                            Nombre
                        </th>
                        <th class="col-3" colspan="3"> 
                            &nbsp
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $rol)
                        <tr>
                            <td>{{ $rol->id }}</td>
                            <td>{{ $rol->name }}</td>
                        @if(auth()->user()->can('roles.edit'))
                            <td>
                                <a href="{{ route('roles.edit', $rol) }}"
                                    class="btn btn-primary btn-sm">
                                    Editar
                                </a>
                            </td>
                        @else 
                            <td>
                                
                            </td>
                        @endif
                        @if(auth()->user()->can('roles.index'))    
                            <td>
                                <a  href="{{ route('roles.show', $rol ) }}"
                                    class="btn btn-info btn-sm">
                                    Detalles
                                </a>
                            </td>
                        @else 
                            <td>
                            </td>
                        @endif
                        @if(auth()->user()->can('roles.destroy'))
                            <td>
                                <form action="{{ route('roles.destroy', $rol) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input 
                                        type="submit"
                                        value="Eliminar"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Para eliminar un alumno, no puede estar inscrito a ningún curso ni tener certificados vigentes.')"/>
                                </form>
                            </td>
                        @else
                            <td>
                            </td>
                        @endif
                        </tr>    
                    @endforeach
                </tbody>
            </table>
            <div class="float-right">
                {{  $roles->links() }}
            </div>
        </div>
    </div>
@endsection