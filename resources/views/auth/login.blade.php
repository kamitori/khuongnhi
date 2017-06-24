<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Đăng nhập</title>
	<link rel="shortcut icon" href="./logo.ico" type="image/x-icon" />
	<link rel="icon" href="./logo.ico" type="image/x-icon" />
	<!-- Bootstrap -->
	<link href="{{URL}}/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="{{URL}}/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />

</head>
<body>

	<div id="div_login">
		<img src="{{URL}}/images/logo_inner.png" id="logo">
		<h3 class="text-center" style="text-align:center">Khương nhi 3</h3>
		<form class="form-horizontal" action="{{URL::to('auth/login')}}" accept-charset="UTF-8" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<div class="control-group">
				<label class="control-label" for="email">Email</label>
				<div class="controls">
					<input type="text" name="email" id="email" placeholder="Email" value="{{Input::old('email')}}">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="password">Password</label>
				<div class="controls">
					<input type="password" name="password" id="password" placeholder="Password">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label checkbox" style="padding-left: 0 !important;">
					&nbsp;
				</label>
				<div class="controls">
					<label class="checkbox">
						<input type="checkbox"><span>Remember me</span>
					</label>
				</div>
			</div>
			<div class="control-group">
				<div class="bl">
					<button type="submit" class="btn btn-lg btn-primary btn-block" >Sign in</button>
				</div>
				<div class="bl">
					<button type="reset" class="btn btn-lg btn-danger  btn-block" >Cancel</button>
				</div>
			</div>
		</form>
	</div>
	<style type="text/css" media="screen">
		body{
			background: #F5F5F5;
		}
		#logo{
			max-height:140px;
			max-width:40%;
			margin:auto;
			display: block;
			margin-bottom: 10px;
		}
		#div_login{
			position: fixed;
			top:25%;
			padding-top: 25px;
			width:40%;
			left:30%;
			background-color: #fff;
			-webkit-box-shadow: 0px 40px 60px 5px rgba(55,71,63,0.66);
			-moz-box-shadow: 0px 40px 60px 5px rgba(55,71,63,0.66);
			box-shadow: 0px 40px 60px 5px rgba(55,71,63,0.66);
			/*border-top-left-radius: 150px;
			border-bottom-right-radius: 150px;*/
			-webkit-animation-duration: 1.2s;
			animation-duration: 1.2s;
			-webkit-animation-fill-mode: both;
			animation-fill-mode: both;
			-webkit-animation-name: fadeIn;
			animation-name: fadeIn;
		}
		@-webkit-keyframes fadeIn {
			0% {
				opacity: 0;
			}

			50% {
				opacity: 0.45;
			}

			80% {
				opacity: 0.85;
			}

			100% {
				opacity: 1;
			}
		}

		@keyframes fadeIn {
			0% {
				opacity: 0;
			}

			50% {
				opacity: 0.45;
			}

			80% {
				opacity: 0.85;
			}

			100% {
				opacity: 1;
			}
		}

		.control-label{
			width:33% !important;
			font-weight: 600;
			float:left !important;
			text-align: right !important;
		}
		.controls{
			width: 60% !important;
			margin-left:3% !important;
			display:inline-block !important;
		}
		.controls input[type="text"],
		.controls input[type="password"]{
			width: 70% !important;
		}
		.bl{
			width:20%;
			margin-left:5%;
			float:left;
		}
		.bl:first-child{
			margin-left: 30% !important;
		}

		@media (max-width: 767px) {
			#div_login{
				top: 0 !important;
				width:100% !important;
				left:0 !important;
				padding-top: 0 !important;
			}
		}
	</style>
</body>
</html>