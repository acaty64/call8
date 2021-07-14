@extends('layouts.app2')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8"><h1>ESTADISTICAS (pdte por Office_id)</h1></div>
        <div class="col-md-2" align="right"><a href="{{ URL::previous() }}" class="btn btn-warning">Regresar</a></div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                {{-- <div class="card-header">Chart with VueJS - in layout.app2</div> --}}

                <div id="app">
                    {!! $chart->container() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8 mt-3">
            <div class="card">
                {{-- <div class="card-header">Chart with VueJS - in layout.app2</div> --}}

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

@section('view','statistics/dashboard.blade.php')