
@extends('layouts.app', ['class' => 'bg-default'])

@section('content')

  <div class="header bg-gradient-default pb-8 pt-5 pt-md-8">
    @include('layouts.admin.message')
    @include('layouts.admin.mensajealerta')
    @include('layouts.admin.errors')
    <div class="row" style="padding: 20px">
      <div class="col-lg-6 col-md-8">
          <h1 style="color:aqua">Agregar permiso a un Usuario</h1>
      </div>
    </div>
    <div class="row" style="padding: 20px">
      <div class="col-lg-8 col-md-8">

        <form action="{{ url('permisos') }}" method="post">
          @csrf
          <div class="form-group">
            <label style="color: aqua" for="username">Nombre de usuario</label>
            <input class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="{{ __('Nombre de usuario') }}" type="text" name="username" value="{{ old('username') }}" style="width: 300px" required autofocus>
          </div>
          <div class="form-group">
            <label style="color: aqua" for="opcion">Opción del sistema</label>
            <input class="form-control{{ $errors->has('opcion') ? ' is-invalid' : '' }}" placeholder="{{ __('Opción del sistema') }}" type="text" name="opcion" value="{{ old('opcion') }}" required autofocus>
          </div>

          <div class="row">
            <div class="col-lg-8 col-md-8">
              <button class="btn bg-gradient-primary" type="submit">Grabar</button>

              <button class="btn btn-icon btn-3 btn bg-gradient-primary" type="reset">
                <span class="btn-inner--icon"><i class="ni ni-fat-remove"></i></span>
                <span class="btn-inner--text">Cancelar</span>
              </button>
            </div>
          </div>      

        </form>
      </div>

    </div>
  </div>
@endsection
