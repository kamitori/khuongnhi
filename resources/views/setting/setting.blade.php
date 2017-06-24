<!DOCTYPE html>
<html>
<head>
	<title>BootAdmin - Responsive Admin HTML Template</title>
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
	<!-- Theme -->
	<link rel="stylesheet" href="{{URL}}/css/style.css" />

	<!-- JQuery v1.8.2 -->
	<script src="{{URL}}/scripts/jquery-1.8.2.min.js"></script>
	<!-- Themer -->
	<script>
		var themerPrimaryColor = '#0088cc',
		themerHeaderColor = '#393D41',
		themerMenuColor = '#383f48';
	</script>
	<script src="{{URL}}/scripts/jquery.cookie.js"></script>
	<script src="{{URL}}/scripts/themer.js"></script>
	<!-- Modernizr -->
	<script src="{{URL}}/scripts/modernizr.custom.76094.js"></script>
	<!-- LESS 2 CSS -->
	<script src="{{URL}}/scripts/less-1.3.3.min.js"></script>
	<style type="text/css" media="screen">
		body{
			background: #f5f5f5;
			height: 100%;
			position: absolute;
			width:100%;
			padding-bottom: 0 !important;
		}
		.bs-docs-sidenav li a i{
			float:right;
		}
		.bs-docs-sidebar{
			background: #455a64;
			height: 100%;
		}
		.bs-docs-sidenav{
			margin-top:50px;
			background: #455a64;
		}
		.bs-docs-sidenav li a,
		.bs-docs-sidenav li a i{
			color: #ccc;
		}
		.nav-list{
			font-size: 110%;
		}
		.bs-docs-sidenav li a:hover,
		.bs-docs-sidenav li.active a,
		.bs-docs-sidenav li.active a:hover{
			color:#d15353;
			background: #f5f5f5;
		}
		.btn-navbar{
			position: absolute;
			top:0;
			right:15px;
			color: #666 !important;
		}
		.span3{
			width: 15%;
		}
		.span9{
			margin-left: 2%;
			width: 80.55%;
			height: 100%;
			overflow-y: auto;
		}
		@media (max-width: 1000px) {
			.span3{
				width: 20%;
			}
			.span9{
				width: 75.25%;
			}
		}
		@media (max-width: 767px) {
			body{
				overflow-y: scroll !important;
			}
			.bs-docs-sidenav li a{
				padding: 5px;
			}
			.span3{
				margin-bottom: 10px;
			}
			.span3,.span9{
				width:100% !important;
				margin-left: 0%  !important;
			}
			.span9{
				overflow-y: visible !important;
			}
			.bs-docs-sidebar{
				height: auto !important;
				background: none !important;
			}
			.bs-docs-sidenav{
				margin-top:0 !important;
				display: none;
			}
		}
	</style>
</head>
<body>
	<!-- Start Content -->
	<div class="row" style="height: 100%;">
		<div class="span3 bs-docs-sidebar">
			<button type="button" class="btn btn-navbar hidden-desktop hidden-tablet">
				<i class="fa fa-list"></i>
			</button>
			<ul class="nav nav-list bs-docs-sidenav affix-top" id="settings_ul_nav_setup">
				<li><a href="{{URL}}"> Trang chủ</a></li>
				<li><a href="javascript:void(0)" onclick="settings_list('manage-user-settings')">Tài khoản</a></li>
				<li><a href="javascript:void(0)" onclick="settings_list('province-settings')">Tỉnh thành</a></li>
				<li><a href="javascrip:void(0)" onclick="settings_list('menu-settings')"> Menu</a></li>
				<li><a href="javascrip:void(0)" onclick="settings_list('other-settings')"> Tùy chỉnh khác</a></li>
				<li><a href="javascrip:void(0)" onclick="settings_list('pdf-settings')"> Xuất file PDF</a></li>
				<li><a href="javascrip:void(0)" onclick="settings_list('import-settings')"> Nhập dữ liệu</a></li>
			</ul>
		</div>
		<div class="span9" id="content_setting">
			<?php echo isset($content) ? $content : '' ?>
		</div>
	</div>
	<!-- End Content -->
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
			<script>
				toastr.options ={
					"positionClass": "toast-top-center",
					"preventDuplicates": true,
					"newestOnTop": false,
				} ;
			</script>

			<!-- Custom Onload Script -->
			<script src="{{URL}}/scripts/load-setting.js"></script>
			<script type="text/javascript">
				themerUpdateColors(themerPrimaryColor, themerMenuColor);
				$.ajaxSetup({
				    headers: {
				        'X-CSRF-Token': '{{ csrf_token() }}'
				    }
				});
				$(".bs-docs-sidenav li").on("click",function(){
					$(".bs-docs-sidenav li").removeClass("active");
					$(this).addClass('active');
				})
				function settings_list(setting_function_name){
					history.pushState('', "", "{{ URL }}/settings/"+ setting_function_name);
					$("#settings_ul_nav_setup a").removeClass("active");
					$.ajax({
						url: "<?php echo URL; ?>/settings/" + setting_function_name,
						type:"GET",
						// timeout: 15000,
						success: function(html){
							$("div#content_setting").html(html);
						}
					});
				}
			</script>
	<!-- End script -->
</body>

</html>

<script type="text/javascript">
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-Token': '{{ csrf_token() }}'
	    }
	});
	function settings_list(setting_function_name){
		$.ajax({
			url: "<?php echo URL; ?>/settings/" + setting_function_name,
			type:"GET",
			// timeout: 15000,
			success: function(html){
				$("div#content_setting").html(html);
			}
		});
	}

</script>
