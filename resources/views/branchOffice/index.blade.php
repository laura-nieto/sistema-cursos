@extends('layouts.menu')

@section('content_view')
    <h2 class="text-center">
        Listado de sucursale
    </h2>
    <div class="card">
        <div class="card-body">
                <form action="{{ route('sucursales.index') }}" method="GET">
                    <div class="row">
                        <div class="col-2">
                            <input 
                                type="text" 
                                name="academyId"
                                value="{{ $request->academyId }}"
                                class="form-control"
                                placeholder="ID Academia" 
                            />
                        </div>
                        <div class="col-3">
                            <input
                              type="text"
                              name="nombreAcademiaAsociada"
                              value="{{ $request->nombreAcademiaAsociada?$request->nombreAcademiaAsociada: null }}"
                              class="form-control"
                              placeholder="Nombre de la academia asociada">
                          </div>    
                        <div class="col-3">
                            <input
                                type="text"
                                name="nombreDeSucursal"
                                value="{{ $request->nombreDeSucursal?$request->nombreDeSucursal: null }}"
                                class="form-control"
                                placeholder="Nombre de la sucursal">
                        </div>
                        <div class="col-2 custom-control custom-checkbox d-flex align-items-center">
                            @if(auth()->user()->can('branch_offices.edit'))
                                <input 
                                    name='disabled'
                                @if ($request->disabled)
                                    checked
                                @endif
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="active">
                                <label
                                    class="custom-control-label text-center"
                                    for="active">
                                    Sucursales inactivas
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
            <table id="branchOfficeTable" class="table">
                <thead>
                    <tr>
                        <th class="col-1">
                            ID
                        </th>
                        <th class="col-3">
                            Nombre de la sucursal
                        </th>
                        <th class="col-4">
                            Academia a la que pertenece
                        </th>
                        <th class="col-4" colspan="3"> 
                            &nbsp
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($branchOffices as $branchOffice)
                        <tr
                            @if (!$branchOffice->isActive)
                                class = 'disabled'
                            @endif
                        >
                            <td>{{ $branchOffice->id }}</td>
                            <td>{{ $branchOffice->branch_name }}</td>
                            <td>{{ $branchOffice->academy->name }}</td>
                        @if(auth()->user()->can('branch_offices.edit'))
                            <td>
                                <a href="{{ route('sucursales.edit', $branchOffice) }}"
                                    class="btn btn-primary btn-sm">
                                    Editar
                                </a>
                            </td>
                        @else 
                            <td>
                                
                            </td>
                        @endif
                        @if(auth()->user()->can('branch_offices.index'))    
                            <td>
                                <a href="{{ route('sucursales.show', $branchOffice ) }}"
                                    class="btn btn-info btn-sm">
                                    Detalles
                                </a>
                            </td>
                        @else 
                            <td>
                            </td>
                        @endif
                        @if(auth()->user()->can('branch_offices.destroy') && $branchOffice->isActive)
                            <td>
                                <form action="{{ route('sucursales.destroy', $branchOffice) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input 
                                        type="submit"
                                        value="Eliminar"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Para eliminar una sucursar, no pueden haber cursos abiertos ¿Aún desea eliminar esta sucursal?...')"/>
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
                {{  $branchOffices->links() }}
            </div>
        </div>
    </div>
@endsection