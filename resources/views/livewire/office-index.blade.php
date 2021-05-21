<div>
	@if(env('APP_DEBUG'))
		View: resources/views/livewire/office-index.blade.php
	@endif
@if( $status == 'index')
	<div class="container">
		<button class="btn-success btn-lg" wire:click="setStatus('create')">Agregar</button>
		<table class="table table-striped">
			<thead>
				<tr class="row">
			    	<th class="col-sm-1">Id</th>
			    	<th class="col-sm-2">Siglas</th>
			    	<th class="col-sm-4">Nombre</th>
			    	<th class="col-sm-4">Acciones</th>
				</tr>
			</thead>
			<tbody>
			    @foreach($index as $item)
			        <tr class="row">
			        	<td class="col-sm-1">{{ $item->id }}</td>
			        	<td class="col-sm-2">{{ $item->code }}</td>
			        	<td class="col-sm-4">{{ $item->name }}</td>
			        	<td class="col-sm-4">
							<button class="btn-success btn-md" wire:click="setStatus('edit', {{ $item->id }})">Editar</button>
							<button class="btn-danger btn-md" wire:click="setStatus('destroy', {{ $item->id }})">Eliminar</button>
			        	</td>
			        </tr>
			    @endforeach
			</tbody>
		</table>
	</div>
	{{ $index->links() }}
@endif
@if( $status == 'create' || $status == 'edit')
	<div class="container">
		<div class="card-header">
			@if( $status == 'edit' )
				<div>
					<h1>Edición de Oficina Id: {{ $office_id }}</h1>
				</div>
			@endif
			@if( $status == 'create' )
				<h1>Nueva Oficina</h1>
			@endif
			<div class="row">
				<div class="col-sm-3">
					<button class="btn-warning btn-lg" wire:click="setStatus('index')">Regresar</button>
				</div>
				<div class="col-sm-3">
					<button class="btn-danger btn-lg" wire:click="save">Grabar</button>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="input-group mb-3">
				<div class="col-sm-12">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Siglas</span>
						<input type="text" class="form-control" wire:model="code">
						@error('code') <span class="error">{{ $message }}</span> @enderror
					</div>
				</div>
			</div>
			<div class="input-group mb-3">
				<div class="col-sm-12">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Nombre de oficina</span>
						<input type="text" class="form-control" wire:model="name">
						@error('name') <span class="error">{{ $message }}</span> @enderror
					</div>
				</div>
			</div>
		</div>
	</div>
@endif
@if( $status == 'destroy' )
	<div class="container">
		<div class="card-header">
			<h1>Oficina a Eliminar</h1>
			<div>Id: {{ $office_id }}</div>
			<button class="btn-warning btn-lg" wire:click="setStatus('index')">Regresar</button>
			<button class="btn-danger btn-lg" wire:click="save">Eliminar</button>
		</div>
		<div class="card-body">
			<div class="input-group mb-3">
				<div class="col-sm-12">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Siglas</span>
						<input readonly type="text" class="form-control" wire:model="code">
					</div>
				</div>
			</div>
			<div class="input-group mb-3">
				<div class="col-sm-12">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Oficina</span>
						<input readonly type="text" class="form-control" wire:model="name">
					</div>
				</div>
			</div>
		</div>
	</div>
@endif
</div>
