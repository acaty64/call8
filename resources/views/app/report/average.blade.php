@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8"><h1>{{ $title }}</h1></div>
                        <div class="col-md-2" align="right"><a href="{{ URL::previous() }}" class="btn btn-warning">Regresar</a></div>
                    </div>
                </div>
                <div class="card">

                    <div class="container">
                        <table class="table table-striped">
                            <thead>
                                <tr class="row">
                                    <th class="col-sm-4">Oficina</th>
                                    <th class="col-sm-3">Fecha</th>
                                    <th class="col-sm-3">Promedio en minutos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                    <tr class="row">
                                        <td class="col-sm-4">{{ $item['office_id'] }}</td>
                                        <td class="col-sm-3">{{ $item['date'] }}</td>
                                        <td class="col-sm-3">{{ $item['average']/60 }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('view','app/report/average.blade.php')