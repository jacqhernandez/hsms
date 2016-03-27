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
    <h2>Create User</h2><hr>
    <table cellpadding="5px" id="form-blades"> <tbody>
        <tr>

            <td><label class="required-field">Username:</label></td>
            <td><input type="text" class="form-control" name="username" value="{{ old('username') }}"></td>
        </tr>
        <tr>
            <td><label class="required-field">Password:</label></td>
            <td><input type="password" class="form-control" name="password"></td>
        </tr>
        <tr>
            <td><label class="required-field">Confirm Password:</label></td>
            <td><input type="password" class="form-control" name="password_confirmation"></td>
        </tr>
        <tr>
            <td><label class="required-field">Role:</label></td>
            <td><select class="form-control" name="role" value="{{ old('role') }}">
                <option value="General Manager">General Manager</option>
                <option value="Sales">Sales</option>
                <option value="Accounting">Accounting</option>
            </select></td>
        </tr>
    </tbody></table> <br>

    <div>
        <br>
        <button type="submit" class="btn btn-success" align="center">
            Register
        </button>
        <a href="{{ action('UsersController@index') }}" class="btn btn-info" color="gray">
            Back
        </a>
    </div>
    </form>

@stop