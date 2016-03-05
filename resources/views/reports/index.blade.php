@extends('layouts.app')
@section('content')
<br>
<h2>Reports</h2>
<hr>

{!! Form::open(['route' => ['reports.generate'], 'method' => 'post' ]) !!}
<table>
	<tbody>
		<tr>
			<td>{!! Form::label('report_type', 'Report Type: ') !!}</td>
			<!-- <td><select name ="report_type" id = "report_type">
				<option value="sales">Sales</option>
				<option value="collection">Collection</option>
				<option value="item">Item</option>
				<option value="client">Client</option>
				</select></td> -->
				<td>{!! Form::select('report_type', $reportOptions, null, ['id' => 'report_type', 'class' => 'form-control']) !!}</td>
		</tr>

		<tr id="item">
			<td>{!! Form::label('item', 'Item: ') !!}</td>
			<td>{!! Form::select('item', $items, null, ['id' => 'item_select', 'class' => 'form-control']) !!}</td>
		</tr>
		
		<tr id="month">
			<td>{!! Form::label('month', 'Month: ') !!}</td>
			<td>{!! Form::selectMonth('select_monthFrom', null, ['class' => 'form-control']) !!}</td>
			<td>{!! Form::label('monthTo', ' To ') !!}</td>
			<td>{!! Form::selectMonth('select_monthTo', null, ['class' => 'form-control']) !!}</td>
		</tr>

		<tr id="year">
			<td>{!! Form::label('month', 'Year: ') !!}</td>
			<td>{!! Form::select('year', $years, null, ['id' => 'year_select', 'class' => 'form-control']) !!}</td>
		</tr>

		<tr id="client">
			<td>{!! Form::label('client', 'Client: ') !!}</td>
			<td>{!! Form::select('client', $clients, null, ['id' => 'client_select', 'class' => 'form-control']) !!}</td>
		</tr>
	</tbody>
</table>

<br>
	<div class = "submit">
		{!! Form::submit('Generate', ['class' => 'btn btn-primary', 'id' => 'mySubmit']) !!}
		<!-- <a href="{{ action ('ReportsController@generate') }}"><button type="button" class="btn btn-info">Generate</button></a> -->
	</div>
{!! Form::close() !!}








<script type="text/javascript">
$('#item').hide();
$('#client').hide();

if (!$('#year_select').val())
{
	$('#mySubmit').attr('disabled', 'disabled');
}


$('#report_type').change(function() {
    $('#month').show();
    $('#item').show();
    $('#client').show();
    $('#year').show();
	$('#mySubmit').removeAttr('disabled', 'disabled');



    if($(this).val() == 'client') {
        $('#month').hide();
        $('#item').hide();
        $('#year').hide();

        if (!$('#client_select').val())
    	{
    		//$('#mySubmit').removeAttr('disabled');
    		$('#mySubmit').attr('disabled', 'disabled');
    	}
    }

    if ($(this).val() == 'item') {
    	$('#client').hide();

    	if (!$('#item_select').val() || !$('#year_select').val())
    	{
    		//$('#mySubmit').removeAttr('disabled');
    		$('#mySubmit').attr('disabled', 'disabled');
    	}

    }

    if ($(this).val() == 'sales'){
    	$('#item').hide();
    	$('#client').hide();

    	if (!$('#year_select').val())
    	{
    		//$('#mySubmit').removeAttr('disabled');
    		$('#mySubmit').attr('disabled', 'disabled');
    	}
    }

    if ($(this).val() == 'collection'){
    	$('#item').hide();
    	$('#client').hide();

    	if (!$('#year_select').val())
    	{
    		//$('#mySubmit').removeAttr('disabled');
    		$('#mySubmit').attr('disabled', 'disabled');
    	}
    }
});


</script>
@stop

