@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8"><h1>INDICE DE DOCUMENTOS</h1></div>
                        <div class="col-md-2" align="right"><a href="{{route('document.create')}}" class="btn btn-success">Nuevo</a></div>
                        <div class="col-md-2" align="right"><a href="{{ (\Auth::user()->is_master) ? route('master.menu') : route('admin.menu') }}" class="btn btn-warning">Regresar</a></div>
                    </div>
                </div>
                <div class="card">

                    <div class="container">
                        <table class="table table-striped">
                            <thead>
                                <tr class="row">
                                    <th class="col-sm-1">Id</th>
                                    <th class="col-sm-1">Orden</th>
                                    <th class="col-sm-1">Activo</th>
                                    <th class="col-sm-2">Descripción</th>
                                    <th class="col-sm-2">Documento</th>
                                    <th class="col-sm-2">Enlace</th>
                                    <th class="col-sm-3">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($index as $item)
                                    <tr class="row">
                                        <td class="col-sm-1">{{ $item->id }}</td>
                                        <td class="col-sm-1">{{ $item->order }}</td>
                                        <td class="col-sm-1">{{ $item->active }}</td>
                                        <td class="col-sm-2">{{ $item->name }}</td>
                                        <td class="col-sm-2">{{ $item->filename }}</td>
                                        <td class="col-sm-2">{{ $item->link }}</td>
                                        <td class="col-sm-3">
                                            <a class="btn-success btn-lg" href="{{ route('document.edit', $item->id) }}">Editar</a>
                                            <a class="btn-primary btn-lg" href="{{ route('document.show', $item->id) }}">Ver</a>
                                            <a class="btn-warning btn-lg" href="{{ route('document.destroy', $item->id) }}">Eliminar</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $index->links() }}


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('view','app/document/index.blade.php')