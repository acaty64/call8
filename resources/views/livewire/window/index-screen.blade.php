<div>
	<div class="container">
		<h1>Windows Index</h1>
		<table class="table table-striped">
			<thead>
				<tr class="row">
			    	<th class="col-sm-1">Id</th>
			    	<th class="col-sm-1">Modulo</th>
			    	<th class="col-sm-3">Operador</th>
			    	<th class="col-sm-3">Usuario</th>
			    	<th class="col-sm-2">Estado</th>
			    	<th class="col-sm-1">Oficina</th>
				</tr>
			</thead>
			<tbody>
			    @foreach($windows as $item)
			        <tr class="row">
			        	<td class="col-sm-1">{{ $item->id }}</td>
			        	<td class="col-sm-1">{{ $item->window }}</td>
			        	<td class="col-sm-3">{{ $item->host['name'] }}</td>
			        	<td class="col-sm-3">{{ is_null($item->client) ?  '' : $item->client['name']  }}</td>
			        	<td class="col-sm-2">{{ $item->status['status'] }}</td>
			        	<td class="col-sm-1">{{ $item->office['code'] }}</td>
			        </tr>
			    @endforeach
			</tbody>
		</table>
	</div>
	{{ $windows->links() }}
</div>
