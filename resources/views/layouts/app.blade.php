<!doctype html>
<html>
<head>
    @include('includes.head')
</head>
<body>
<div id="wrapper">

        @include('includes.header')

    <div id="main" class="row">
		 <div id="page-wrapper">
		 <br>
            @yield('content')
		</div>

    </div>
	
    <footer class="row">
        <!--@include('includes.footer')-->
    </footer>

</div>



    <!-- jQuery -->
    <script src="{{ URL::asset('/bower_components/jquery/dist/jquery.min.js')}}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ URL::asset('/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ URL::asset('/bower_components/metisMenu/dist/metisMenu.min.js')}}"></script>

    <!-- Morris Charts JavaScript -->
    <script src="{{ URL::asset('/bower_components/raphael/raphael-min.js')}}"></script>
    <script src="{{ URL::asset('/bower_components/morrisjs/morris.min.js')}}"></script>
    <!--<script src="../bower_components/startbootstrap-sb-admin-2/js/morris-data.js"></script>-->

    <!-- Custom Theme JavaScript -->
    <script src="{{ URL::asset('/bower_components/startbootstrap-sb-admin-2/dist/js/sb-admin-2.js')}}"></script>

    <script src="{{ URL::asset('/js/sorttable.js') }}"></script>


    <!-- bootstrap Date Picker -->
    
    <script src="{{ URL::asset('/bower_components/moment/min/moment.min.js')}}"></script>
    <script src="{{ URL::asset('/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>

</body>
</html>