<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Inventory</title>
	
	<script type="text/javascript" src="{{ asset("assets/bower_components/jquery/dist/jquery.min.js") }}"></script>
	<script type="text/javascript" src="{{ asset("assets/bower_components/moment/min/moment.min.js") }}"></script>
	<script type="text/javascript" src="{{ asset("assets/bower_components/bootstrap/dist/js/bootstrap.min.js") }}"></script>
	<script type="text/javascript" src="{{ asset("assets/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js") }}"></script>
	<link rel="stylesheet" href="{{ asset("assets/bower_components/bootstrap/dist/css/bootstrap.min.css") }}" />
	<link href="{{ asset("assets/css/bootstrap.css") }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset("assets/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css") }}" />
	<script src="https://code.highcharts.com/highcharts.js"></script>

	<style>
		body {
			margin-top: 25px;
		}
		.fa-btn {
			margin-right: 6px;
		}
		.table-text div {
			padding-top: 6px;
		}
	</style>

</head>

<body>
	<div class="container">
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>

					<a class="navbar-brand" href="/">Inventory</a>
				</div>

				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						@if (!Auth::guest())
							<li><a href="/product/"><i class="fa fa-btn fa-heart"></i>Products</a></li>
							<li><a href="/purchase/"><i class="fa fa-btn fa-heart"></i>Purchases</a></li>
							<li><a href="/expense/"><i class="fa fa-btn fa-heart"></i>Expenses</a></li>
						@endif
					</ul>

					<ul class="nav navbar-nav navbar-right">
						@if (Auth::guest())
							<li><a href="/auth/register"><i class="fa fa-btn fa-heart"></i>Register</a></li>
							<li><a href="/auth/login"><i class="fa fa-btn fa-sign-in"></i>Login</a></li>
						@else
							<li role="presentation" class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
									{{ Auth::user()->name }} <span class="caret"></span>
    							</a>
    							<ul class="dropdown-menu">
	    							<li><a href="/stores/"><i class="fa fa-btn fa-heart"></i>Stores</a></li>
									<li><a href="/sources/"><i class="fa fa-btn fa-heart"></i>Sources</a></li>
									<li><a href="/locations/"><i class="fa fa-btn fa-heart"></i>Locations</a></li>
	    							<li><a href="/auth/logout"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
    							</ul>
							</li>							
						@endif
					</ul>
				</div>
			</div>
		</nav>
	</div>

	@yield('content')
</body>
</html>