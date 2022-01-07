@extends('layouts.menu')

@section('content_view')
    <h2 class="text-center">
        Listado de Usuarios
    </h2>

    <div class="card">
        <div class="card-body">
                <form action="{{ route('usuarios.index') }}" method="GET">
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
                            <input type="number"
                            name="dniDelUsuario"
                            value="{{ $request->dniDelUsuario?$request->dniDelUsuario: null }}"
                            class="form-control"
                            placeholder=" Por D.N.I">
                        </div>
                        <div class="col">
                          <input
                            type="text"
                            name="emailDelUsuario"
                            value="{{ $request->emailDelUsuario?$request->emailDelUsuario: null }}"
                            class="form-control"
                            placeholder="Por Mail">
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center col-3">
                            @if(auth()->user()->can('users.edit'))
                                <input 
                                    name='disabled'
                                @if ($request->disabled)
                                    checked
                                @endif
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="active">
                                <label
                                    class="custom-control-label"
                                    for="active">
                                    usuarios inactivos
                                </label>
                            @endif
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
                            DNI
                        </th>
                        <th class="col-3">
                            Mail
                        </th>
                        <th class="col-3" colspan="3"> 
                            &nbsp
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr
                            @if (!$user->active)
                                class ='disabled'
                            @endif
                        >
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->dni }}</td>
                            <td>{{ $user->email }}</td>
                        @if(auth()->user()->can('users.edit'))
                            <td>
                                <a href="{{ route('usuarios.edit', $user) }}"
                                    class="btn btn-primary btn-sm">
                                    Editar
                                </a>
                            </td>
                        @else 
                            <td>
                                
                            </td>
                        @endif
                        @if(auth()->user()->can('users.index'))    
                            <td>
                                <a  href="{{ route('usuarios.show', $user ) }}"
                                    class="btn btn-info btn-sm">
                                    Detalles
                                </a>
                            </td>
                        @else 
                            <td>
                            </td>
                        @endif
                        @if(auth()->user()->can('users.destroy') && $user->active)
                            <td>
                                <form action="{{ route('usuarios.destroy', $user) }}" method="POST">
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
                {{  $users->links() }}
            </div>
        </div>
    </div>
@endsection