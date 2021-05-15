<div>
	@if(env('APP_DEBUG'))
		View: resources/views/livewire/access-index.blade.php
	@endif
@if( $status == 'index')
	<div class="container">
		<h1>Indice de Accesos</h1>
		<button class="btn-success btn-lg" wire:click="setStatus('create')">Agregar</button>
		<table class="table table-striped">
			<thead>
				<tr class="row">
			    	<th class="col-sm-1">Id</th>
			    	<th class="col-sm-1">Usuario</th>
			    	<th class="col-sm-2">Tipo</th>
			    	<th class="col-sm-3">Oficina</th>
				</tr>
			</thead>
			<tbody>
			    @foreach($index as $item)
			        <tr class="row">
			        	<td class="col-sm-1">{{ $item->id }}</td>
			        	<td class="col-sm-1">{{ $item->user->name }}</td>
			        	<td class="col-sm-2">{{ $item->type->acronym }}</td>
			        	<td class="col-sm-3">{{ $item->office->code }}</td>
			        	<td class="col-sm-2">
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
					<h1>Edición de Acceso Id: {{ $access_id }}</h1>
				</div>
			@endif
			@if( $status == 'create' )
				<h1>Nuevo Acceso</h1>
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


{{-- 			<div class="input-group mb-3">
				<div class="col-sm-12">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Enlace</span>
						<input type="text" class="form-control" wire:model="access">
						@error('access') <span class="error">{{ $message }}</span> @enderror
					</div>
				</div>
			</div> --}}
		</div>
	</div>
@endif
@if( $status == 'destroy' )
	<div class="container">
		<div class="card-header">
			<h1>Acceso a Eliminar</h1>
			<div>Id: {{ $access_id }}</div>
			<button class="btn-warning btn-lg" wire:click="setStatus('index')">Regresar</button>
			<button class="btn-danger btn-lg" wire:click="save">Eliminar</button>
		</div>
		<div class="card-body">
{{-- 			<div class="input-group mb-3">
				<div class="col-sm-12">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Enlace</span>
						<input readonly type="text" class="form-control" wire:model="access">
					</div>
				</div>
			</div> --}}
		</div>
	</div>
@endif
</div>
