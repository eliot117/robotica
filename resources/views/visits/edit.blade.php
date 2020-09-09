@extends('layouts.app')

@section('content')
<div class="card card-info">
    <div class="card-header">
      <h3 class="card-title">Editar registro</h3>
    </div>
    <form class="form-horizontal" method="POST" action="{{ route('visits.update', $visits->id)}}">
    @csrf
    @method('PUT')
    <input hidden name="user_id" value="{{auth()->user()->id}}">

      <div class="card-body">
        <div class="form-group row">
            <label for="fecha" class="col-sm-2 col-form-label">Fecha:</label>
            <div class="col-sm-10">
              <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ $visits->date }}">
            </div>
            @error('date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group row">
            <label for="assessor" class="col-sm-2 col-form-label">Asesor:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control @error('assessor') is-invalid @enderror" id="assessor" name="assessor" placeholder="Ingrese nombre completo del asesor" value="{{ $visits->assessor }}">
            </div>
            @error('assessor')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        <button type="submit" class="btn btn-success">Guardar</button>
        <a class="btn btn-warning" href="{{ route('visits.index') }}">Cancelar</a>
      </div>
      <!-- /.card-footer -->
    </form>
</div>
@endsection