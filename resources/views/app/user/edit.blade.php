@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-md-10">
              Edit User
            </div>
            <div class="col-md-2">
                <a href="{{ url()->previous()  }}">Regresar</a>
            </div>
          </div>
        </div>

        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif
          <form method="POST" action="{{ route('user.update') }}" accept-charset="UTF-8" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">

              <input type="hidden" name="id" value={{ $item['id'] }}>

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1" >Apellidos y Nombres:  </span>
                </div>
                <input value="{{ old($item['name']) }}" name="name" type="text" class="form-control" placeholder={{ $item['name'] }} aria-label="name" aria-describedby="basic-addon1">
              </div>

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1" >Código:  </span>
                </div>
                <input value="{{ old($item['code']) }}" name="code" type="text" class="form-control" placeholder={{ $item['code'] }} aria-label="code" aria-describedby="basic-addon1">
              </div>

              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1" >E-mail:  </span>
                </div>
                <input value="{{ old($item['email']) }}" name="email" type="email" class="form-control" placeholder={{ $item['email'] }} aria-label="Número" aria-describedby="basic-addon1" maxlength="120">
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

@section('view','app/user/edit.blade.php')