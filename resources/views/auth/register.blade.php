@extends('layouts.app')
@section('content')

<form class="form-horizontal register" role="form" method="POST" action="{{ url('/auth/register') }}">
    @if (count($errors) > 0)
        <div class="alert alert-danger register-danger">
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
            <td align="right" class="required-field"> Username: </td>
            <td><input type="text" class="form-control" name="username" value="{{ old('username') }}"></td>
        </tr>
        <tr>
            <td align="right" class="required-field"> Password: </td>
            <td><input type="password" class="form-control" name="password"></td>
        </tr>
        <tr>
            <td align="right" class="required-field"> Confirm Password: </td>
            <td><input type="password" class="form-control" name="password_confirmation"></td>
        </tr>
        <tr>
            <td align="right"> Role: </td>
            <td><select class="form-control" name="role" value="{{ old('role') }}">
                <option value="General Manager">General Manager</option>
                <option value="Sales">Sales</option>
                <option value="Accounting">Accounting</option>
            </select></td>
        </tr>
    </tbody></table> <br>

    <div>
        <br>
        <button type="submit" class="btn btn-warning" align="center">
            Register
        </button>
        <a href="{{ action('UsersController@index') }}" class="btn btn-default" color="gray">
            Back
        </a>
    </div>
    </form>

@stop