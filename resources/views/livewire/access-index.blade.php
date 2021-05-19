<div>
	@if(env('APP_DEBUG'))
		View: resources/views/livewire/access-index.blade.php
	@endif
@if( $status == 'index')
	<div class="container">
		<button class="btn-success btn-lg" wire:click="setStatus('create')">Agregar</button>
		<table class="table table-striped">
			<thead>
				<tr class="row">
			    	<th class="col-sm-1">Id</th>
			    	<th class="col-sm-4">Usuario</th>
			    	<th class="col-sm-2">Tipo</th>
			    	<th class="col-sm-2">Acciones</th>
				</tr>
			</thead>

			<tbody>
			    @foreach($index as $item)
			        <tr class="row">
			        	<td class="col-sm-1">{{ $item->id }}</td>
			        	<td class="col-sm-4">{{ $item->user->name }}</td>
			        	<td class="col-sm-2">{{ $item->type->name }}</td>
			        	<td class="col-sm-2">
			        		@if( \Auth::user()->is_master )
								<button class="btn-success btn-md" wire:click="setStatus('edit', {{ $item->id }})">Editar {{ $item->id }}</button>
							@endif
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
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon0">User</span>
				</div>
				<div class="col-md-8">
					@if( $status == 'create' )
						<select wire:model="user_id" class="form-control" aria-describedby="basic-addon0">
							<option value="" selected>Choose user</option>
							@foreach($users as $user)
							<option value="{{ $user->id }}">{{ $user->name }}</option>
							@endforeach
						</select>
					@endif
					@if( $status == 'edit' )
						<input disabled type="text" value="{{ $item_name }}">
					@endif
				</div>
			</div>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon0">Type</span>
				</div>
				<div class="col-md-8">
					<select wire:model="type_id" class="form-control" aria-describedby="basic-addon0">
						<option value="" selected>Choose type</option>
						@foreach($types as $type)
						<option value="{{ $type->id }}">{{ $type->name }}</option>
						@endforeach
					</select>
					@error('type_id') <span class="error">{{ $message }}</span> @enderror
				</div>
			</div>
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
			<div class="input-group mb-3">
				<div class="col-sm-12">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Usuario</span>
						<input readonly type="text" class="form-control" wire:model="item_name">
					</div>
				</div>
			</div>
			<div class="input-group mb-3">
				<div class="col-sm-12">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Tipo</span>
						<input readonly type="text" class="form-control" wire:model="item_type">
					</div>
				</div>
			</div>
		</div>
	</div>
@endif
</div>
