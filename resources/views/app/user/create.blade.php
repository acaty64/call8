@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-md-10">
              Create User
            </div>
            <div class="col-md-2">
                <a href="{{ route('home')  }}">Menu</a>
            </div>
          </div>
        </div>

        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif
          <form method="POST" action="{{ route('user.store') }}" accept-charset="UTF-8" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1" >Apellidos y Nombres:  </span>
                </div>
                <input name="name" type="text" class="form-control" placeholder="Ingrese los apellidos y nombres" aria-label="name" aria-describedby="basic-addon1">
              </div>

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1" >Código:  </span>
                </div>
                <input name="codigo" type="text" class="form-control" placeholder="Ingrese el código del usuario" aria-label="codigo" aria-describedby="basic-addon1">
              </div>

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1" >E-mail:  </span>
                </div>
                <input name="email" type="email" class="form-control" placeholder="codigo@ucss.pe" aria-label="Número" aria-describedby="basic-addon1" maxlength="120">
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

@section('view','app/user/create.blade.php')