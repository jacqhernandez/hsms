@if ($errors->any())
	<ul class="alert alert-danger" style="padding-left: 30px; margin-left: 0px">
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
@endif