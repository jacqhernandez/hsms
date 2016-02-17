        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/home') }}">Hardware Sales Management System</a>
            </div>
            <!-- /.navbar-header -->

            @if (Auth::user()['role'] === 'General Manager' || Auth::user()['role'] === 'Accounting' || Auth::user()['role'] === 'Sales')
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{ action ('UsersController@show', Auth::user()['id']) }}"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{ url('/auth/logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->			
			
			  <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        @if (Auth::user()['role'] === 'General Manager' || Auth::user()['role'] === 'Accounting')
                        <li>
                            <a href="{{ url('/home') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>

                        </li>
                        @endif
                        @if (Auth::user()['role'] === 'Sales' || Auth::user()['role'] === 'General Manager')
                        <li>
                            <a href="{{url::action('SalesInvoicesController@quotation')}}"><i class="glyphicon glyphicon-triangle-right"></i> New Sales Invoice</a>

                        </li>
						@endif

                        @if (Auth::user()['role'] === 'Accounting')
                        <li>
                            <a href="{{url::action('CollectiblesController@index')}}">Collectibles</a>
                        </li>
                        @endif
                        @if (Auth::user()['role'] === 'Accounting' || Auth::user()['role'] === 'Sales')
                        <li>
                            <a href="{{url::action('SalesInvoicesController@index')}}">Sales Invoices</a>
                        </li>
                        <li>
                            <a href="{{url::action('ClientsController@index')}}">Clients</a>
                        </li>
                        <li>
                            <a href="{{url::action('SuppliersController@index')}}">Suppliers</a>
                        </li>
                        @endif

                        @if (Auth::user()['role'] === 'General Manager')
						<li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Admin Maintenance<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                @if (Auth::check())
                                    <li>
                                        <a href="{{url::action('SalesInvoicesController@index')}}">Sales Invoices</a>
                                    </li>
                                    <li>
                                        <a href="{{url::action('CollectiblesController@index')}}">Collectibles</a>
                                    </li>
                                    <li>
                                        <a href="{{url::action('ClientsController@index')}}">Clients</a>
                                    </li>
                                    <li>
                                        <a href="{{url::action('SuppliersController@index')}}">Suppliers</a>
                                    </li>
                                    <li>
                                        <a href="{{url::action('ReasonsController@index')}}">Reasons</a>
                                    </li>
                                    <li>
                                        <a href="{{url::action('ItemsController@index')}}">Items</a>
                                    </li>
                                    @if (Auth::user()['role'] == 'General Manager')
                                        <li>
                                            <a href="{{url::action('LogsController@index')}}">Activity Log</a>
                                        </li>
                                    @endif
                                @endif
							</ul>
						</li>
                        @endif
						
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
            @endif
        </nav>