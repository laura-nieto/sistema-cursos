@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="card">
                @if(auth()->user()->can('academies.index') || auth()->user()->can('academies.create'))
                  <div class="panel-group">
                    <div class="panel-heading">
                      <h3 class="panel-title">
                        <a class="btn btn-menu btn-block text-left p-2" data-toggle="collapse"
                        href="#menuAcademy">
                          Academias
                        </a>
                      </h3>
                    </div>
                    <div id="menuAcademy" class="panel-collapse collapse">
                    @if (auth()->user()->can('academies.index'))
                      <div class="panel-body">
                        <a class="btn btn-submenu btn-block text-left p-2 pl-5"
                        href="{{ route('academias.index') }}">
                          Mostrar academias
                        </a>
                      </div>
                    @endif
                    @if(auth()->user()->can('academies.create'))
                      <div class="panel-body">
                        <a class="btn btn-submenu btn-block text-left p-2 pl-5" 
                          href="{{ route('academias.create') }}">
                          Crear academias
                        </a>
                      </div>
                    @endif
                    </div>
                  </div>
                @endif
                
                @if(auth()->user()->can('students.index')||auth()->user()->can('students.create'))
                  <div class="panel-group">
                    <div class="panel-heading">
                      <h3 class="panel-title">
                        <a class="btn btn-menu btn-block text-left p-2" data-toggle="collapse" 
                          href="#menuAlumnos">
                          Alumnos
                        </a>
                      </h3>
                    </div>
                    <div id="menuAlumnos" class="panel-collapse collapse">
                    @if (auth()->user()->can('students.index'))                    
                      <div class="panel-body">
                        <a class="btn btn-submenu btn-block text-left p-2 pl-5"
                          href="{{ route('estudiantes.index') }}">
                          Mostrar alumnos
                        </a>
                      </div>
                    @endif
                    @if(auth()->user()->can('students.create'))
                      <div class="panel-body">
                        <a class="btn btn-submenu btn-block text-left p-2 pl-5"
                          href="{{ route('estudiantes.create') }}">
                          Crear alumnos
                        </a>
                      </div>
                    @endif
                    </div>
                </div>
              @endif

              @if(auth()->user()->can('certificates.index'))
                <div class="panel-group">
                  <div class="panel-heading">
                    <h3 class="panel-title">
                      <a class="btn btn-menu btn-block text-left p-2" data-toggle="collapse"
                      href="#menuCertificado">
                        Certificados
                      </a>
                    </h3>
                  </div>
                  <div id="menuCertificado" class="panel-collapse collapse">
                    <div class="panel-body">
                      <a class="btn btn-submenu btn-block text-left p-2 pl-5"
                        href="">
                        Mostrar certificados
                      </a>
                    </div>
                  </div>
                </div>
              @endif

              @if(auth()->user()->can('courses.index') || auth()->user()->can('courses.create'))
                <div class="panel-group">
                  <div class="panel-heading">
                    <h3 class="panel-title">
                      <a class="btn btn-menu btn-block text-left p-2" data-toggle="collapse"
                        href="#menuCurso">
                        Cursos
                      </a>
                    </h3>
                  </div>
                  <div id="menuCurso" class="panel-collapse collapse">
                  @if(auth()->user()->can('courses.index'))
                    <div class="panel-body">
                      <a class="btn btn-submenu btn-block text-left p-2 pl-5"
                        href="{{ route('cursos.index') }}">
                        Mostrar cursos
                      </a>
                    </div>
                  @endif
                  @if(auth()->user()->can('courses.create'))
                    <div class="panel-body">
                      <a class="btn btn-submenu btn-block text-left p-2 pl-5" 
                      href="{{ route('cursos.create') }}">
                        Crear curso
                      </a>
                    </div>
                  @endif
                  </div>
                </div>
              @endif

              @if(auth()->user()->can('roles.index') || auth()->user()->can('roles.create'))
                <div class="panel-group">
                  <div class="panel-heading">
                    <h3 class="panel-title">
                      <a class="btn btn-menu btn-block text-left p-2" data-toggle="collapse" 
                        href="#menuRoles">
                        Roles
                      </a>
                    </h3>
                  </div>
                  <div id="menuRoles" class="panel-collapse collapse">
                  @if(auth()->user()->can('roles.index'))
                    <div class="panel-body">
                      <a class="btn btn-submenu btn-block text-left p-2 pl-5"
                        href="{{route('roles.index')}}">
                        Mostrar roles
                      </a>
                    </div>
                  @endif
                  @if(auth()->user()->can('roles.create'))
                    <div class="panel-body">
                      <a class="btn btn-submenu btn-block text-left p-2 pl-5"
                        href="{{route('roles.create')}}">
                        Crear role
                      </a>
                    </div>
                  @endif
                  </div>
                </div>
              @endif

              @if(auth()->user()->can('branch_offices.index') || auth()->user()->can('branch_offices.create'))
                <div class="panel-group">
                    <div class="panel-heading">
                      <h3 class="panel-title">
                        <a
                          class="btn btn-menu btn-block text-left p-2"
                          data-toggle="collapse"
                          href="#menuSucursal">
                          Sucursales
                        </a>
                      </h3>
                    </div>
                  <div id="menuSucursal" class="panel-collapse collapse">
                    @if (auth()->user()->can('branch_offices.index'))
                      <div class="panel-body">
                        <a
                          class="btn btn-submenu btn-block text-left p-2 pl-5" 
                          href="{{ route('sucursales.index') }}">
                          Mostrar sucursales
                        </a>
                      </div>
                    @endif
                    @if(auth()->user()->can('branch_offices.create'))
                      <div class="panel-body">
                        <a
                          class="btn btn-submenu btn-block text-left p-2 pl-5"
                          href="{{ route('sucursales.create') }}">
                          Crear sucursal
                        </a>
                      </div>
                    @endif
                  </div>
                </div>
              @endif

              @if(auth()->user()->can('course_types.index')||auth()->user()->can('course_types.create'))
                <div class="panel-group">
                  <div class="panel-heading">
                    <h3 class="panel-title">
                      <a class="btn btn-menu btn-block text-left p-2" data-toggle="collapse"
                        href="#menuTipoCurso">
                        Tipos de cursos
                      </a>
                    </h3>
                  </div>
                  <div id="menuTipoCurso" class="panel-collapse collapse">
                  @if(auth()->user()->can('course_types.index'))
                    <div class="panel-body">
                      <a class="btn btn-submenu btn-block text-left p-2 pl-5"
                        href="">
                        Mostrar tipos de cursos
                      </a>
                    </div>
                  @endif
                  @if(auth()->user()->can('course_types.create'))
                    <div class="panel-body">
                      <a class="btn btn-submenu btn-block text-left p-2 pl-5"
                        href="">
                          Crear tipo de curso
                        </a>
                    </div>
                  @endif
                  </div>
                </div>
              @endif
              @if(auth()->user()->can('users.index') || auth()->user()->can('users.create'))
                <div class="panel-group">
                  <div class="panel-heading">
                    <h3 class="panel-title">
                      <a class="btn btn-menu btn-block text-left p-2" data-toggle="collapse"
                        href="#menuUsuario">
                        Usuarios
                      </a>
                    </h3>
                  </div>
                  <div id="menuUsuario" class="panel-collapse collapse">
                    @if(auth()->user()->can('users.index'))
                    <div class="panel-body">
                      <a class="btn btn-submenu btn-block text-left p-2 pl-5"
                        href="{{route('usuarios.index')}}">
                        Mostrar usuarios
                      </a>
                    </div>
                    @endif
                  @if(auth()->user()->can('users.create'))
                    <div class="panel-body">
                      <a class="btn btn-submenu btn-block text-left p-2 pl-5"
                        href="{{route('usuarios.create')}}">
                        Crear usuario
                      </a>
                    </div>
                  @endif
                  </div>
                </div>               
              @endif
                </div>
            </div>
            <div class="col-9">
              @if (session('status'))
                <div class="alert alert-success" role="alert">
                  {{ session('status') }}
                </div>
              @endif
              @if ($errors-> any())
              {{-- Variable global que almacena todos los errores --}}
                <div class="alert alert-danger">
                  {{-- De esta manera rescatas todos los errores, con all(), acá lo recorre e imprime --}}
                  @foreach ($errors->all() as $error)
                      -{{$error}} <br>
                  @endforeach
                </div>
              @endif  
            @yield('content_view')
            </div>
        </div>
    </div>
    @endsection