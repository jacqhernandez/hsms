@extends('layouts.app')
@section('content')

<form class="form-horizontal register" role="form" method="POST" action="{{ url('/auth/login') }}">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <br> <br>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <table cellpadding="5px"> <tbody>
        <tr>
            <td align="right"> Username: </td>
            <td><input type="text" class="form-control" name="username" value="{{ old('username') }}"></td>
        </tr>
        <tr>
            <td align="right"> Password: </td>
            <td><input type="password" class="form-control" name="password"></td>
        </tr>
    </tbody></table> <br>

    <div>
        <br>
        <button type="submit" class="btn btn-warning" align="center">
            Login
        </button>
        <a href="../" class="btn btn-default" color="gray">
            Back
        </a>
    </div>
    </form>

@stop