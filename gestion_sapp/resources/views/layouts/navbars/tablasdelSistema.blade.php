@extends('layouts.app', ['class' => 'bg-default'])

@section('content')

  <div class="header bg-gradient-default pb-8 pt-5 pt-md-8">
    @include('layouts.admin.message')
    @include('layouts.admin.errors')
    <div class="row" style="padding: 20px">
      <div class="col-lg-6 col-md-8">
          <h1 style="color:aqua">Tablas del sistema</h1>
      </div>
    </div>

    <div class="row" style="padding: 20px">
      <div class="col-lg-12 col-md-8">
        <div class="card">
            <div class="table-responsive">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                      <th>Descripción</th>
                      <th>Ingresar</th>
                  </tr>
                </thead>
                <tbody>
                  @if(auth()->user()->administra===1)
                    <tr>
                        <td>Opciones del sistema</td>
                        <td style="width: 200px;">
                            <a href="#" class="btn btn-sm btn-primary">Ingresar</a>
                        </td>
                    </tr>
                  @endif
                    <tr>
                      <td>Permisos del sistema</td>
                      <td style="width: 200px;">
                          <a href="{{ url('permisos/crear') }}" class="btn btn-sm btn-primary">Ingresar</a>
                      </td>
                    </tr>
                </tbody>
              </table>
            </div>
          </div>
      </div>
    </div>
  </div>
@endsection
