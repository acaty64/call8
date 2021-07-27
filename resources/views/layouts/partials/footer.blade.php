<div class="container">
	<div class="row">
		<br>
		<span  class="nav navbar-nav list-group-item list-inline" style="color:blue; font-size:75%">
			<div>Universidad Católica Sedes Sapientiae</div>
		</span>
		@if(env('APP_DEBUG'))	
			<span  class="nav navbar-nav list-group-item list-inline" style="color:blue; font-size:75%">
				<div>Laravel v8.12</div>
				<div>VueJs ^2.5.17</div>
				<div>Node v12.14</div>
				<div>Npm v6.13.4</div>
			</span>	
			<span  class="nav navbar-nav list-group-item list-inline" style="color:blue; font-size:75%">
				<div>App: {{ env('APP_NAME') }}</div>
				<div>Bootstrap v4.4.1</div>
				<div>Livewire v2.4</div>
				{{-- <div>family=Nunito</div> --}}
			</span>
			@auth
				<span  class="nav navbar-nav list-group-item list-inline" style="color:blue; font-size:75%">
					<div>User Id: "{{ \Auth::user()->id }}"</div>
					<div>is_master: "{{ \Auth::user()->is_master }}"</div>
					<div>is_admin: "{{ \Auth::user()->is_admin }}"</div>
					<div>is_hostr: "{{ \Auth::user()->is_host }}"</div>
				</span>	
			@endif
			<div class="row">
				<div class="nav navbar-nav list-group-item list-inline" id="userType" style="color:red; font-size:75%">
					Vista: @yield('view')
				</div>
			</div>
		@endif	
	</div>
</div>