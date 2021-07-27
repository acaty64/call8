@extends('layouts.app2')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8"><h1>{{ $office->name }}</h1></div>
        <div class="col-md-2" align="right"><a href="{{ URL::previous() }}" class="btn btn-warning">Regresar</a></div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div id="app">
                    {!! $chart->container() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8 mt-3">
            <div class="card">
                <div id="app">
                    {!! $chart1->container() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    {!! $chart->script() !!}
    {!! $chart1->script() !!}
@endsection

@section('view','statistics/chart.blade.php')