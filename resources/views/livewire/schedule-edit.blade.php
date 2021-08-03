<div>
	<div class="container card mb-3">
		<div class="card-body">
			<div class="row">
			    <div class="col-md-6">
					<h3>SCHEDULE EDIT</h3>
					<h4>Id: {{ $schedule_id }}</h4>
			    </div>
			    <div class="col-md-2">
			        <button wire:click="$emit('setStatus', 'index')" class="btn-warning mb-3 btn-lg">Regresar</button>
			    </div>
			</div>
		</div>
	</div>
	<div class="container">
	    <div>
	        @if (session()->has('message'))
	            <div class="alert alert-success">
	                {{ session('message') }}
	            </div>
	        @endif
	    </div>
		<div class="form-group row">
			<div class="col-sm-12">
				<div class="input-group mb">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon0">Host</span>
					</div>
					<div class="col-md-8 pl-0">
						<input readonly wire:model="host_name" class="form-control">
					</div>
				</div>
			</div>
		</div>
		@error('selectedHost') <span class="error">{{ $message }}</span> @enderror
		<div class="form-group row">
			<div class="col-sm-12">
				<div class="input-group mb">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon0">Office</span>
					</div>
					<div class="col-md-8 pl-0">
						<select wire:model="selectedOffice" class="form-control">
							<option value="" selected>Choose office</option>
							@foreach($offices as $office)
								<option value="{{ $office->id }}">{{ $office->name }}</option>
							@endforeach
						</select>
					</div>
					 @error('selectedOffice') <span class="error">{{ $message }}</span> @enderror
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-4">
				<div class="input-group mb">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon0">Day</span>
					</div>
					<div class="col-md-8 pl-0">
						<select wire:model="selectedDay" class="form-control">
							<option value="" selected>Choose day</option>
							@foreach($days as $key => $day)
								<option value="{{ $key }}">{{ $day }}</option>
							@endforeach
						</select>
					</div>
					@error('selectedDay') <span class="error">{{ $message }}</span> @enderror
				</div>
			</div>
			<div class="col-sm-4">
				<div class="input-group mb">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon0">Hora Inicio</span>
					</div>
					<div class="col-md-8 pl-0">
						<select wire:model="hour_start" class="form-control">
							<option value="" selected>Choose hour start</option>
							@foreach($hours_start as $kh => $hour)
								<option value="{{ $hour }}">{{ $hour }}</option>
							@endforeach
						</select>
					</div>
					@error('hour_start') <span class="error">{{ $message }}</span> @enderror
				</div>
			</div>
			<div class="col-sm-4">
				<div class="input-group mb">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon0">Hora de Fin</span>
					</div>
					<div class="col-md-8 pl-0">
						<select wire:model="hour_end" class="form-control">
							<option value="" selected>Choose hour end</option>
							@foreach($hours_end as $kh2 => $hour2)
								<option value="{{ $hour2 }}">{{ $hour2 }}</option>
							@endforeach
						</select>
					</div>
					@error('hour_end') <span class="error">{{ $message }}</span> @enderror
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-6">
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Fecha de inicio</span>
					</div>
					<input type="date" class="form-control"
						value="{{ $date_start }}"
						wire:model="date_start"
						min={{ $min_date_start }}
						aria-label="fecha_ini" aria-describedby="basic-addon1">
				</div>
				@error('date_start') <span class="error">{{ $message }}</span> @enderror
			</div>
			<div class="col-sm-6">
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Fecha de fin</span>
					</div>
					<input type="date" class="form-control"
						value="{{ $date_end }}"
						wire:model="date_end"
						min={{ $min_date_end }}
						aria-label="date_end" aria-describedby="basic-addon1">
				</div>
				@error('hour_end') <span class="error">{{ $message }}</span> @enderror
			</div>
		</div>
		@if($errores)
			<div class="container">
				<div class="card-header">
					Horarios cruzados
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-sm"><b>Id</b></div>
						<div class="col-sm"><b>Dia</b></div>
						<div class="col-sm"><b>Hora inicio</b></div>
						<div class="col-sm"><b>Hora fin</b></div>
						<div class="col-sm"><b>Fecha inicio</b></div>
						<div class="col-sm"><b>Fecha fin</b></div>
					</div>
					@foreach($errores as $error)
						<div class="row">
							<div class="col-sm">{{ $error->id }}</div>
							<div class="col-sm">{{ $error->day }}</div>
							<div class="col-sm">{{ $error->hour_start }}</div>
							<div class="col-sm">{{ $error->hour_end }}</div>
							<div class="col-sm">{{ $error->date_start }}</div>
							<div class="col-sm">{{ $error->date_end }}</div>
						</div>
					@endforeach
				</div>
			</div>
		@endif
		<div class="form-group row">
			<div class="col-sm-6">
				<button wire:click="save" class="btn-success btn-lg">Grabar</button>
			</div>
		</div>
	</div>
</div>
