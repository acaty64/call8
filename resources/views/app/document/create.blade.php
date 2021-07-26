@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-md-10">
              Create Document
            </div>
            <div class="col-md-2">
                <a href="{{ route('documents.index')  }}">Indice</a>
            </div>
          </div>
        </div>

        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif
          <form method="POST" action="{{ route('document.store') }}" accept-charset="UTF-8" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1" >Descripción:  </span>
                </div>
                <input name="name" type="text" class="form-control" placeholder="Ingrese la descripción" aria-label="name" aria-describedby="basic-addon1">
                @error('name') <span class="error">{{ $message }}</span> @enderror
              </div>

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1" >Archivo:  </span>
                </div>
                <input name="file" type="file" class="form-control" placeholder="Seleccione el archivo" aria-describedby="basic-addon1">
                @error('file') <span class="error">{{ $message }}</span> @enderror
              </div>

              <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Orden</span>
                    <input type="number" name="order" min="1" class="form-control" >
                    @error('order') <span class="error">{{ $message }}</span> @enderror
                  </div>
              </div>


              <div class="input-group mb-3">
                  <div class="input-group-prepend form-check">
                    {{-- <div class="input-group-text"> --}}
                    <span class="input-group-text" id="basic-addon1">Activo ?</span>
                    <input type="checkbox" name="active" id="active" class="form-check-input" >
                    {{-- </div> --}}
                  </div>

              </div>
              <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                  <button type="submit" class="btn btn-primary">Grabar</button>
                </div>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('view','app/document/create.blade.php')

