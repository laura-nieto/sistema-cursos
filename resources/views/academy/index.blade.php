@extends('layouts.menu')

@section('content_view')
    <h2 class="text-center">
        listado de academias
    </h2>
    <div class="card">
        <div class="card-body">
                <form action="{{ route('academias.index') }}" method="GET">
                    <div class="row">
                        <div class="col">
                            <input type="text"
                            name="nombreDeAcademia"
                            value="{{ $request->nombreDeAcademia?$request->nombreDeAcademia: null }}"
                            class="form-control"
                            placeholder="Nombre de la academia">
                        </div>
                        <div class="col">
                          <input
                            type="text"
                            name="email"
                            value="{{ $request->email?$request->email: null }}"
                            class="form-control"
                            placeholder="Correo electronico">
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center col-3">
                            @if(auth()->user()->can('academies.edit'))
                                <input 
                                    name='disabled'
                                @if ($request->disabled)
                                    checked
                                @endif
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="active">
                                <label class="custom-control-label"for="active">
                                    Academias inactivas
                                </label>
                            @endif
                          </div>
                        <div class="col-2">
                            <input type="submit" class="form-control btn btn-primary" value="Buscar">
                        </div>
                      </div>
                </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table id="academiesTable" class="table">
                <thead>
                    <tr>
                        <th class="col-1">ID</th>
                        <th class="col-3">Nombre</th>
                        <th class="col-4">Dirección</th>
                        <th class="col-4" colspan="3"> &nbsp </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($academies as $academy)
                        <tr
                            @if (!$academy->isActive)
                                class = 'disabled'
                            @endif
                        >
                            <td>{{ $academy->id }}</td>
                            <td>{{ $academy->name }}</td>
                            <td>{{ $academy->street." ".$academy->streetHeight }}</td>
                        @if(auth()->user()->can('academies.edit')&& $academy->isActive)
                            <td>
                                <a href="{{ route('academias.edit', $academy) }}" class="btn btn-primary btn-sm">
                                    Editar
                                </a>
                            </td>
                        @else 
                            <td>
                                    
                            </td>
                        @endif
                        @if(auth()->user()->can('academies.index'))
                            <td>
                                <a href="{{ route('academias.show', $academy ) }}" class="btn btn-info btn-sm">
                                    Detalles
                                </a>
                            </td>
                        @else
                            <td>
                                    
                            </td>
                        @endif
                        @if(auth()->user()->can('academies.destroy') && $academy->isActive)
                            <td>
                                <form action="{{ route('academias.destroy', $academy) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input 
                                        type="submit"
                                        value="Eliminar"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Para eliminar una academia, no pueden tener sucursales asociadas ¿Aún desea eliminar esta academia?...')"/>
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
                {{ $academies->links() }}
            </div>
        </div>
    </div>
@endsection