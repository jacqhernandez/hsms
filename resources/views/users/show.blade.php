@extends('layouts.app')
@section('content')

Username: {{ Auth::user()['username'] }}
<br>
Role: {{ Auth::user()['role'] }}
<br>

@stop