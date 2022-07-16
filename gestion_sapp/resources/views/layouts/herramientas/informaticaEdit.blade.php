@extends('layouts.app', ['class' => 'bg-default'])

@section('content')

  <div class="header bg-gradient-default pb-8 pt-5 pt-md-8">
    @include('layouts.admin.message')
    @include('layouts.admin.errors')
    <div class="row" style="padding-left: 10px">
      <div class="col-lg-6 col-md-8">
          <h1 style="color:aqua">Solicitudes a Informática</h1>
      </div>
    </div>
    <div class="row" style="padding-left: 10px">
      <div class="col-lg-3 col-md-8">
        <a href="{{ url('informatica/crear') }}" class="btn btn-icon btn-2 btn-success">
          <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
          Crear nueva solicitud</a>
      </div>
      <div class="col-lg-3 col-md-8">
      </div>

      <div class="col-lg-3 col-md-8">
          <br>
      </div>
      <div class="col-lg-3 col-md-8">
        @if (auth()->user()->administra ===1)
          <a href="{{ url('informatica/ver') }}" class="btn btn-icon btn-2 btn-success">
            <span class="btn-inner--icon"><i class="ni ni-bullet-list-67"></i></span>
            Imprimir Solicitudes</a>

        @else 
        @endif
      </div>
    </div>
    <div class="row" style="padding: 10px">
      <div class="col-lg-12 col-md-8">
        <div class="card">
            <div class="table-responsive">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                      <th>Id</th>
                      <th>Fecha</th>
                      <th>Título de solicitud</th>
                      <th>Usuario</th>
                      <th>Base</th>
                      <th>Modificar</th>
                      <th>Estado</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($informaticas as $informatica)
                      <tr>
                          <td>{{ $informatica->id }}</td>
                          <td>{{ date('d/m/Y', strtotime($informatica->fecha)) }}</td>                          
                          <td>{{ $informatica->grupoinf->descripcion }}</td>
                          <td>{{ $informatica->user->name }}</td>
                          <td>{{ $informatica->base }}</td>
                          <td style="width: 200px;">
                              <a href="{{ url('informatica/' . $informatica->id . '/editar') }}" class="btn btn-sm btn-primary">Editar</a>
                          </td>
                          <td>
                            @if (is_null($informatica->fecha_fin))
                              <span class="badge badge-dot me-4">
                                <i class="bg-danger"></i>
                                <span class="text-dark text-xs">Pendiente</span>
                              </span>
                            @else
                              <span class="badge badge-dot me-4">
                                <i class="bg-success"></i>
                                <span class="text-dark text-xs">Terminado</span>
                              </span>

                            @endif
                          </td>
                        </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
      </div>
    </div>
  </div>
@endsection
