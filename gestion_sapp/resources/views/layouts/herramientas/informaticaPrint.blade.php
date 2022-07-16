@extends('layouts.app', ['class' => 'bg-default'])

@section('content')

  <div class="header bg-gradient-default pb-8 pt-5 pt-md-8">
    @include('layouts.admin.message')
    @include('layouts.admin.errors')
    <div class="row" style="padding: 10px">
      <div class="col-lg-6 col-md-8">
          <h1 style="color:aqua">Imprimir Solicitudes</h1>
      </div>
    </div>

    <form action="{{ url('informatica/imprimir') }}" method="get">
      @csrf
      <div class="row" style="padding: 10px">
        <div class="col-lg-4 col-md-8">
          <div class="form-group">
            <label style="color: aqua" for="filtro">Filtro</label>
            <select id="filtro" class="form-control input-sm" name="filtro">
              <option selected>Todo</option>
              <option value="Pendiente">Pendiente</option>
              <option value="Terminado">Terminado</option>
            </select>
          </div>
        </div>
      </div>
      <div class="row" style="padding: 10px">
        <div class="col-lg-4 col-md-8">
          <div class="form-group">
            <label style="color:aqua" for="fecha_ini">Fecha inicial</label>
            <input type="date" class="form-control" id="fecha_ini" name="fecha_ini">
          </div>
        </div>
        <div class="col-lg-4 col-md-8">
          <div class="form-group">
            <label for="fecha_fin" style="color:aqua">Fecha final</label>
            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
          </div>
        </div>
      </div>
      <div class="row" style="padding-left: 10px">
        <div class="col-lg-8 col-md-8">
          <button class="btn bg-gradient-primary" type="submit">Generar</button>
          <button class="btn btn-icon btn-3 btn bg-gradient-primary" type="reset">
            <span class="btn-inner--icon"><i class="ni ni-fat-remove"></i></span>
            <span class="btn-inner--text">Cancelar</span>
          </button>
        </div>
      </div>
    </form>
    @if ($informaticas !=null)
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
                        <th>Estado</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($informaticas as $informatica)
                        <tr>
                            <td>{{ $informatica->id }}</td>
                            <td>{{ $informatica->fecha }}</td>                          
                            <td>{{ $informatica->grupoinf->descripcion }}</td>
                            <td>{{ $informatica->user->name }}</td>
                            <td>{{ $informatica->base }}</td>
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
    @endif
  </div>
@endsection
