<!DOCTYPE html>
<html ng-app="tutapos">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>بيت السجاد ستايل</title>
<!-- bower:css -->
   <!-- <link rel="stylesheet" href="/daterangepicker/lib/bootstrap/dist/css/bootstrap.css" /> -->
    <!-- <link rel="stylesheet" href="/daterangepicker/lib/bootstrap-daterangepicker/daterangepicker.css" /> -->
    <!-- endbower -->


<!-- datepicker -->
    
    <link href="{{ asset('/datepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" media="screen">
<!-- datepicker -->

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/footer.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/bootstrap-rtl.css') }}" rel="stylesheet">
	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	<link rel="shortcut icon" href="http://tutahosting.net/wp-content/uploads/2015/01/tutaico.png" type="image/x-icon" />

<!-- FontAwesome 4.3.0 -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons 2.0.0 -->
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />


<!-- adminlte -->
<!-- Theme style -->
        <link href="{{ asset('/dist/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('/dist/css/admin_lte.css') }}" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
        <link href="{{ asset('/dist/css/skins/_all-skins.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="{{ asset('/plugins/iCheck/flat/blue.css') }}" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="{{ asset('/plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="{{ asset('/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />
        <!-- Date Picker -->
<!--         <link href="{{ asset('/plugins/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css" />
 -->        <!-- Daterange picker -->
<!--         <link href="{{ asset('/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css" />
 -->        <!-- bootstrap wysihtml5 - text editor -->
        <link href="{{ asset('/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" type="text/css" />
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body>
<!-- datepicker -->
{!!Html::script('datepicker/jquery/jquery-1.8.3.min.js')!!}
{!!Html::script('datepicker/bootstrap/js/bootstrap.min.js')!!}
{!!Html::script('datepicker/js/bootstrap-datetimepicker.js')!!}
{!!Html::script('datepicker/js/locales/bootstrap-datetimepicker.ar.js')!!}

<!-- datepicker -->

<!-- bower:js -->
  <!--  <script src="/daterangepicker/lib/jquery/dist/jquery.js"></script>
    <script src="/daterangepicker/lib/angular/angular.js"></script>
    <script src="/daterangepicker/lib/angular-messages/angular-messages.js"></script>
    <script src="/daterangepicker/lib/bootstrap/dist/js/bootstrap.js"></script>
    <script src="/daterangepicker/lib/moment/moment.js"></script>
    <script src="/daterangepicker/lib/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript" src="/daterangepicker/lib/moment/locale/en.js" charset="UTF-8"></script> -->
    <!-- endbower -->

   <!-- <script src="/daterangepicker/js/angular-daterangepicker.js"></script>-->


<header class="main-header">
 
	<!-- <nav class="navbar navbar-default"> -->
	<nav class="navbar navbar-static-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				
				<a class="navbar-brand" href="#" style="font-size:22px; font-weight:bold; color:#cff899;">Style</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav" style="font-size:20px; ">
					<li><a href="{{ url('/') }}">{{trans('menu.dashboard')}}</a></li>
					@if (Auth::check())
					<?php
 $permission_customers = Auth::user()->permission_customers ;
 $permission_suppliers = Auth::user()->permission_suppliers ;
 $permission_reports = Auth::user()->permission_reports ;
?>           

@if($permission_customers==1)
						<li><a href="{{ url('/customers') }}">{{trans('menu.customers')}}</a></li>
						@endif
						<li><a href="{{ url('/items') }}">{{trans('menu.items')}}</a></li>
						<!-- <li><a href="{{ url('/item-kits') }}">{{trans('menu.item_kits')}}</a></li> -->
						@if($permission_suppliers)
						<li><a href="{{ url('/suppliers') }}">{{trans('menu.suppliers')}}</a></li>
						@endif
						<li><a href="{{ url('/receivings') }}">{{trans('menu.receivings')}}</a></li>
						<li><a href="{{ url('/sales') }}">{{trans('menu.sales')}}</a></li>

                      @if($permission_reports==1) 
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{trans('menu.reports')}} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/reports/receivings') }}">{{trans('menu.receivings_report')}}</a></li>
								<li><a href="{{ url('/reports/sales') }}">{{trans('menu.sales_report')}}</a></li>
								<li><a href="{{ url('/reports/reserved') }}">{{'تقرير الحجوزات'}}</a></li>
							</ul>
						</li>
						@endif
						<li><a href="{{ url('/employees') }}">{{trans('menu.employees')}}</a></li>
					@endif
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">تسجيل الدخول</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/tutapos-settings') }}">{{trans('menu.application_settings')}}</a></li>
								<li class="divider"></li>
								<li><a href="{{ url('/auth/logout') }}">{{trans('menu.logout')}}</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
	</header>

	@yield('content')

	<footer class="footer hidden-print">
      <div class="container">
       
      </div>
    </footer>
	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

	
</body>
</html>
