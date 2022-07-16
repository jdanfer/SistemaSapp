<div class="header bg-gradient-default pb-8 pt-5 pt-md-8">
    @include('layouts.admin.message')
    @include('layouts.admin.errors')
    <div class="row" style="padding: 20px">
      <div class="col-lg-6 col-md-8">
         <h1 style="color:aqua">Editar Solicitud</h1>
      </div>
    </div>
    <form action="{{ url('/admin/evaluadores/' . $jefatura->id . '/editar') }}" method="post">

        @csrf

        <div class="form-group">
            <label for="descrip">Nombre de Evaluador</label>
            <input type="text" class="form-control" id="descrip" name="descrip" placeholder="Ingresar nombre de evaluador..." value="{{ old('descrip', $jefatura->descrip) }}">
        </div>

        <button type="submit" class="btn btn-primary">Modificar</button>

    </form>
</div><!-- /.container -->
