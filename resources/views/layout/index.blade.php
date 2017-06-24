<!DOCTYPE html>
<html>
<head>
	<title>
		@foreach($menus as $menu)
			@foreach($menu['children'] as $menu_child)
				@if( $menu_child['link'] != '' && Request::is($menu_child['link'].'*') )
					{{$menu_child['name']}}
				@endif
			@endforeach
		@endforeach
	</title>
	<link rel="shortcut icon" href="./logo.ico" type="image/x-icon" />
	<link rel="icon" href="./logo.ico" type="image/x-icon" />
	<!-- Meta -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<!-- Bootstrap -->
	<link href="{{URL}}/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="{{URL}}/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
	<!-- Bootstrap Extended -->
	<link href="{{URL}}/bootstrap/extend/jasny-bootstrap/css/jasny-bootstrap.min.css" rel="stylesheet">
	<link href="{{URL}}/bootstrap/extend/jasny-bootstrap/css/jasny-bootstrap-responsive.min.css" rel="stylesheet">
	<link href="{{URL}}/bootstrap/extend/bootstrap-wysihtml5/css/bootstrap-wysihtml5-0.0.2.css" rel="stylesheet">
	<!-- JQueryUI v1.9.2 -->
	<link rel="stylesheet" href="{{URL}}/scripts/jquery-ui-1.9.2.custom/css/smoothness/jquery-ui-1.9.2.custom.min.css" />
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{URL}}/css/font-awesome.css" />
	<!-- Font Finance -->
	<link rel="stylesheet" href="{{URL}}/css/font-fi.css" />
	<!-- Bootstrap Extended -->
	<link rel="stylesheet" href="{{URL}}/bootstrap/extend/bootstrap-select/bootstrap-select.css" />
	<link rel="stylesheet" href="{{URL}}/bootstrap/extend/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />
	<!-- Uniform -->
	<!-- <link rel="stylesheet" media="screen" href="{{URL}}/scripts/pixelmatrix-uniform/css/uniform.default.css" /> -->

	<!-- MiniColors -->
	<link rel="stylesheet" media="screen" href="{{URL}}/scripts/jquery-miniColors/jquery.miniColors.css" />
	<!-- Select 2 -->
	<link rel="stylesheet" href="{{URL}}/css/select2.css" />
	<!-- Toastr -->
	<link rel="stylesheet" href="{{URL}}/scripts/toastr/toastr.css" />
	<!-- Toastr -->
	<link rel="stylesheet" href="{{URL}}/scripts/togglebutton/css/bootstrap2-toggle.css" />
	<!-- Theme -->
	<link rel="stylesheet" href="{{URL}}/css/style.css" />
	@yield('pageCSS')
	<!-- JQuery v1.8.2 -->
	<script src="{{URL}}/scripts/jquery-1.8.2.min.js"></script>
	<!-- Themer -->
	<script>
		var themerPrimaryColor = '{{\Auth::user()->primary_color}}';
		var themerMenuColor = '{{\Auth::user()->menu_color}}';
	</script>
	<script src="{{URL}}/scripts/jquery.cookie.js"></script>
	<script src="{{URL}}/scripts/themer.js"></script>
	<!-- Modernizr -->
	<script src="{{URL}}/scripts/modernizr.custom.76094.js"></script>
	<!-- LESS 2 CSS -->
	<script src="{{URL}}/scripts/less-1.3.3.min.js"></script>
</head>
<body>
	<div class="showload"></div>
	<!-- Start Content -->
			<div class="container-fluid left-menu">
			<!-- Menu Mobile-->
				<div class="navbar main">
					<div class="innerpx">
						<button type="button" class="btn btn-navbar hidden-desktop hidden-tablet">
						<span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
						</button>
					</div>
				</div>
			<!-- End Menu Mobile -->
				<div class="row-fluid rrow main">
					<div class="span12 main col" role="main">
						<div class="row-fluid rrow">
							@include('layout.menu')
							<div class="span10 col main-right">
								<div class="rrow scroll-y" id="mainYScroller">
									<div class="inner topRight">
										<?php echo isset($content) ? $content : '' ?>
										@yield('content')
										<!-- <div style="height:70px; dispplay:block">&nbsp;</div> -->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				@include('layout.footer')
			</div>
	<!-- End Content -->
	@yield('otherPage')
	<div id="otherpage">
	<div id="modal_confirm" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- dialog header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h5 id="header_confirm">&nbsp;</h5>
				</div>
				<!-- dialog body -->
				
				<div class="modal-body">
					<div id="content_confirm">
						
					</div>
				</div>
				<!-- dialog buttons -->
				<div class="modal-footer text-center">
					<button id="ok_confirm" type="button" onclick="" class="btn btn-primary">OK</button>
					<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Cancel</button>
				</div>
			</div>
		</div>
	</div>
	</div>
	<!-- Script -->
			<!-- Cubiq iScroll -->
			<!--[if gte IE 9]><!-->
			<script src="{{URL}}/scripts/cubiq-iscroll/src/iscroll.js"></script>
			<!--<![endif]-->
			<!-- JQueryUI v1.9.2 -->
			<script src="{{URL}}/scripts/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.min.js"></script>
			<!-- JQueryUI Touch Punch -->
			<!-- small hack that enables the use of touch events on sites using the jQuery UI user interface library -->
			<script src="{{URL}}/scripts/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
			<!-- MiniColors -->
			<script src="{{URL}}/scripts/jquery-miniColors/jquery.miniColors.js"></script>
			<!-- Resize Script -->
			<script src="{{URL}}/scripts/jquery.ba-resize.js"></script>
			<!-- DataTables -->
			<script src="{{URL}}/scripts/DataTables/media/js/jquery.dataTables.min.js"></script>
			<script src="{{URL}}/scripts/DataTables/media/js/DT_bootstrap.js"></script>
			<!-- Uniform -->
			<script src="{{URL}}/scripts/pixelmatrix-uniform/jquery.uniform.min.js"></script>
			<!-- Bootstrap Script -->
			<script src="{{URL}}/bootstrap/js/bootstrap.min.js"></script>
			<!-- Bootstrap Extended -->
			<script src="{{URL}}/bootstrap/extend/bootstrap-select/bootstrap-select.js"></script>
			<script src="{{URL}}/bootstrap/extend/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
			<script src="{{URL}}/bootstrap/extend/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js"></script>
			<script src="{{URL}}/bootstrap/extend/jasny-bootstrap/js/jasny-bootstrap.min.js" type="text/javascript"></script>
			<script src="{{URL}}/bootstrap/extend/jasny-bootstrap/js/bootstrap-fileupload.js" type="text/javascript"></script>
			<script src="{{URL}}/bootstrap/extend/bootbox.js" type="text/javascript"></script>
			<script src="{{URL}}/bootstrap/extend/bootstrap-wysihtml5/js/wysihtml5-0.3.0_rc2.min.js" type="text/javascript"></script>
			<script src="{{URL}}/bootstrap/extend/bootstrap-wysihtml5/js/bootstrap-wysihtml5-0.0.2.js" type="text/javascript"></script>
			<script src="{{URL}}/scripts/select2.min.js" type="text/javascript"></script>
			<script src="{{URL}}/scripts/toastr/toastr.js" type="text/javascript"></script>
			<script src="{{URL}}/scripts/togglebutton/js/bootstrap2-toggle.min.js" type="text/javascript"></script>
			<script src="{{URL}}/scripts/jquery-sortable-min.js" type="text/javascript"></script>
			

			<script>
				toastr.options ={
					"positionClass": "toast-top-center",
					"preventDuplicates": true,
					"newestOnTop": false,
				};

				$.minicolors.init();
				$.minicolors.settings.letterCase = 'uppercase';
			</script>
			
			
			<script type="text/javascript">
			$.ajaxSetup({
			    headers: {
			        'X-CSRF-Token': '{{ csrf_token() }}'
			    }
			});
			</script>
			@yield('pageJS')
			<!-- Custom Onload Script -->
			<script src="{{URL}}/scripts/load.js"></script>
	<!-- End script -->
</body>
</html>