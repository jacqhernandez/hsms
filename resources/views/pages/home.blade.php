<script src="{{ URL::asset('/bower_components/jquery/dist/jquery.min.js')}}"></script>
 <!-- Morris Charts JavaScript -->
 <script src="{{ URL::asset('/bower_components/raphael/raphael-min.js')}}"></script>
 <script src="{{ URL::asset('/bower_components/morrisjs/morris.min.js')}}"></script>


<!-- THESE ARE ALREADY DECLARED ON APP.BLADE.PHP BUT IT DOESNT WORK SO I DECLARED IT AGAIN HERE-->
<!-- we might want to move the scripts at the beginning of the page..although it might load a little slower-->

@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Dashboard</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="row">

	<div class="col-lg-3 col-md-6">
	    <div class="panel panel-green">
	        <div class="panel-heading">
	            <div class="row">
	                <div class="col-xs-3">
	                    <i class="fa fa-tasks fa-5x"></i>
	                </div>
	                <div class="col-xs-9 text-right">
	                    <div class="huge">{{ '₱' . $currentAmount }}</div>
	                    <div>{{ $currentCount }} Sale Invoice(s) Collected This Week</div>
	                </div>
	            </div>
	        </div>
	        <a href="{{ action ('SalesInvoicesController@viewCollected')}}">
	            <div class="panel-footer">
	                <span class="pull-left">View Details</span>
	                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
	                <div class="clearfix"></div>
	            </div>
	        </a>
	    </div>
	</div>



    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-bank fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ '₱' . $currentCollectibleAmount }}</div>
                        <div>{{ $currentCollectibleCount }} Sale Invoice(s) Due This Week</div>
                    </div>
                </div>
            </div>
            <a href="{{ action ('SalesInvoicesController@viewCollectibles')}}">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

	<div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-shopping-cart fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ '₱' . $upcomingCollectibleAmount }}</div>
                        <div>{{ $upcomingCollectibleCount }} Sale Invoice(s) Due Next Week</div>
                    </div>
                </div>
            </div>
            <a href="{{ action ('SalesInvoicesController@viewUpcoming')}}">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-support fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ '₱' . $overdueCollectibleAmount }}</div>
                        <div>{{ $overdueCollectibleCount }} Sale Invoice(s) Overdue</div>
                    </div>
                </div>
            </div>
            <a href="{{ action ('SalesInvoicesController@viewOverdue')}}">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
<!--row-->

@if (Auth::user()->role == 'Accounting')
    <div id="dailySales" style="height: 250px; display:none;"></div>
@else
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">Daily Sales Performance</h3>
        <div id="dailySales" style="height: 250px;"</div>
    </div>
</div>
@endif



<br>
<br>
<br>

<div class="row">
    <div class="col-lg-6">
    	<div class="panel panel-default">
    			<div class="panel-heading">
        			Collection Overview for <?php echo date('F Y'); ?>
        		</div>
        		<div class="panel-body">
                    <div id="collectionDonut" style="height: 350px;"></div>
        		</div>
    	</div>
   	</div>
    <!-- /.col-lg-6 -->

    <div class="col-lg-6">
    	<div class="panel panel-default">

            @if (Auth::user()->role == 'General Manager')
    		<div class="panel-heading">Activity Log</div>
            <div class="panel-body">
                <table class="table table-hover sortable"> 
                    <thead>
                        <tr>
                        <th>Action</th>
                        <th>User</th>
                        <th>Date and Time</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($activities as $activity)
                        <tr>
                        <td>{{ $activity->text }}</td>
                        @if (isset($activity->user))
                            <td>{{ $activity->user->username }}</td>
                        @else
                            <td>User Deleted</td>
                        @endif
                        <td>{{ $activity->created_at->format('F j, Y h:i:s A') }}</td>
                        </tr>
                        @endforeach
                    </tbody> 
                </table>
    		</div>

            @elseif (Auth::user()->role == 'Accounting')
            <div class="panel-heading">To-do List</div>
            <div class="panel-body">
                <table class="table table-hover sortable"> 
                    <thead>
                        <tr>
                        <th>Client</th>
                        <th>Follow Up Date</th>
                        <th>Note</th>
                    </thead>

                    <tbody>
                        
                    </tbody> 
                </table>
            </div>
            @endif
    	</div>
    </div>
</div>




<script>
new Morris.Line({
  // ID of the element in which to draw the chart.
  element: 'dailySales',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
    	@foreach ($dailySales as $sale)
    	{ date: '{{$sale->date}}', value: {{$sale->total}} },
    	@endforeach
  ],
  // The name of the data record attribute that contains x-values.
  xkey: 'date',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['value'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Amount'],
  xLabelAngle: 60,
  parseTime: false

});

// new Morris.Line({
//   // ID of the element in which to draw the chart.
//   element: 'myfirstchart',
//   // Chart data records -- each entry in this array corresponds to a point on
//   // the chart.
//   data: [
//     { year: '2008', value: 20 },
//     { year: '2009', value: 10 },
//     { year: '2010', value: 5 },
//     { year: '2011', value: 5 },
//     { year: '2012', value: 20 }
//   ],
//   // The name of the data record attribute that contains x-values.
//   xkey: 'year',
//   // A list of names of data record attributes that contain y-values.
//   ykeys: ['value'],
//   // Labels for the ykeys -- will be displayed when you hover over the
//   // chart.
//   labels: ['Value']
// });

new Morris.Donut({
  // ID of the element in which to draw the chart.
  element: 'collectionDonut',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
        {label: 'Collected This Month', value: {{$currentAmountMonth}} },
        {label: 'Not Yet Collected This Month', value: {{$currentCollectibleAmountMonth }} },
        {label: 'Overdue This Month', value: {{$overdueCollectibleAmountMonth}} }
  ],

 colors: [
    '#004d00',
    '#0066ff',
    '#ff0000'
  ]
});

// Morris.Donut({
//   element: 'donut-example',
//   data: [
//     {label: "Download Sales", value: 12},
//     {label: "In-Store Sales", value: 30},
//     {label: "Mail-Order Sales", value: 20}
//   ]
  
  
// });


</script>
@stop