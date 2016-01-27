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
				<td>{!! Form::select('report_type', $reportOptions, null, ['id' => 'report_type']) !!}</td>
		</tr>

		<tr id="item">
			<td>{!! Form::label('item', 'Item: ') !!}</td>
			<td>{!! Form::select('item', $items) !!}</td>
		</tr>
		
		<tr id="month">
			<td>{!! Form::label('month', 'Month: ') !!}</td>
			<td>{!! Form::selectMonth('select_monthFrom') !!}</td>
			<td>{!! Form::label('monthTo', ' To ') !!}</td>
			<td>{!! Form::selectMonth('select_monthTo') !!}</td>
		</tr>

		<tr id="year">
			<td>{!! Form::label('month', 'Year: ') !!}</td>
			<td>{!! Form::select('year', $years, null) !!}</td>
		</tr>

		<tr id="client">
			<td>{!! Form::label('client', 'Client: ') !!}</td>
			<td>{!! Form::select('client', $clients) !!}</td>
		</tr>
	</tbody>
</table>

<br>
	<div class = "submit">
		{!! Form::submit('Generate', ['class' => 'btn btn-primary']) !!}
		<!-- <a href="{{ action ('ReportsController@generate') }}"><button type="button" class="btn btn-info">Generate</button></a> -->
	</div>
{!! Form::close() !!}








<script type="text/javascript">
$('#item').hide();
$('#client').hide();

$('#report_type').change(function() {
    $('#month').show();
    $('#item').show();
    $('#client').show();
    $('#year').show();
    if($(this).val() === 'client') {
        $('#month').hide();
        $('#item').hide();
        $('#year').hide();
    }

    if ($(this).val() == 'item') {
    	$('#client').hide();
    }

    if ($(this).val() == 'sales'){
    	$('#item').hide();
    	$('#client').hide();
    }

    if ($(this).val() == 'collection'){
    	$('#item').hide();
    	$('#client').hide();
    }
});
</script>
@stop

