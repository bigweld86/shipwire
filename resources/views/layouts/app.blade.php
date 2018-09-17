@include('layouts.header')

<div class="container" id="app-container">
	@include('layouts.errors')
	@include('layouts.session_alerts')
	
	@yield('content')
</div>

@include('layouts.footer')
