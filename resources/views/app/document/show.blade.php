@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-md-10">
              Show Document
            </div>
            <div class="col-md-2">
                <a href="{{ route('documents.index')  }}">Indice</a>
            </div>
          </div>
        </div>
        <div class="card-header">

          <p>{{$item['filename']}}</p>

        </div>
        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif
            <iframe src="{{$item['src']}}" type="application/pdf" style="width: 100%; height:50vw; position: relative; allowfullscreen;display:block; width:100%; border:none; "></iframe>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


@section('view','app/document/edit.blade.php')

