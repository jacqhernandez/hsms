@extends('layouts.app')
@section('content')

{!! Form::model($user, ['method' => 'POST', 'action' => ['UsersController@postUpdateAccount', $user->id], 'class' => 'form_horizontal register']) !!}
    <h2> Editing {{ $user->username }}'s Account </h2><hr>

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

    <table class = "register-table" id="form-blades" cellpadding="5px"> <tbody>
        <tr>
            <td>{!! Form::label('username', 'Username:', ['class' => 'required-field']) !!}</td>
            <td>{!! Form::text('username',old('username'), ['class' => 'form-control']) !!}</td>
        </tr>
        <tr>
            <td>{!! Form::label('old_password', 'Old Password:', ['class' => 'required-field']) !!}</td>
            <td>{!! Form::password('old_password', ['class' => 'form-control']) !!}</td>
        </tr>
        <tr>
            <td>{!! Form::label('password', 'New Password:', ['class' => 'required-field']) !!}</td>
            <td>{!! Form::password('password', ['class' => 'form-control']) !!}</td>
        </tr>
        <tr>
            <td>{!! Form::label('confirm_new_password', 'Confirm New Password:', ['class' => 'required-field']) !!}</td>
            <td>{!! Form::password('confirm_new_password', ['class' => 'form-control']) !!}</td>
        </tr>

        <tr>
            <td>{!! Form::label('role', 'Role:') !!}</td>
            <td><select class="form-control" name="role" value={{ old('role') }}>
                <option value= "General Manager" <?php if($user->role == 'General Manager') {echo("selected");} ?>> 
                    General Manager</option>
                <option value= "Sales" <?php if($user->role == 'Sales') {echo("selected");} ?>> 
                    Sales</option>
                <option value= "Accounting" <?php if($user->role == 'Accounting') {echo("selected");} ?>> 
                    Accounting</option>
            </select></td>
        </tr>
    </tbody></table> <br>

    <div class="register-button">
        <br>
        
            @include('includes.update_confirm')


        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Cancel</button>
        <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Cancel Edit User</h4>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to Cancel? This will discard all changes made.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            <a href="{{ url('/users') }}">
                                <button type="button" class="btn btn-danger">Yes</button>
                            </a>
                </div>
                
              </div>
            </div>
          </div>


    </div>
</form>

@stop