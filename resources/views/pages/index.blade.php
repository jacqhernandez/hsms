@if (Auth::guest())
	<a href="{{ url('/auth/login') }}">Login</a>
@else
	Username: {{ Auth::user()['username'] }}
	<br>
	<a href="{{ url('/auth/logout') }}">Logout</a>
@endif