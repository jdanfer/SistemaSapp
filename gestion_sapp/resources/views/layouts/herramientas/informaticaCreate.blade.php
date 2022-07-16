
@extends('adminlte::page')

@section('content')

  <div class="header bg-gradient-default pb-8 pt-5 pt-md-8">
    @include('layouts.admin.message')
    @include('layouts.admin.errors')
    <div class="row" style="padding: 10px">
      <div class="col-lg-6 col-md-8">
          <h1 style="color:aqua">Crear nueva solicitud</h1>
      </div>
    </div>
    <div class="row" style="padding: 10px">
      <div class="col-lg-8 col-md-8">
        <form action="{{ url('informatica') }}" method="post">
          @csrf
          <div class="form-group">
            <label style="color: aqua" for="grupoinf_id">Grupo</label>
            <select id="grupoinf_id" class="form-control input-sm" name="grupoinf_id">
                <option selected>Seleccionar...</option>
                @foreach ($grupoinfs as $grupoinf)
                   @if (old('grupoinf_id') == $grupoinf->id)
                       <option value="{{ $grupoinf->id }}" selected>{{ $grupoinf->descripcion }}</option>
                   @else
                       <option value="{{ $grupoinf->id }}">{{ $grupoinf->descripcion }}</option>
                   @endif
                @endforeach
            </select>
          </div>
          <div class="form-group">
            <label style="color: aqua" for="exampleFormControlTextarea1">Ingrese detalle</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="5"></textarea>
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
