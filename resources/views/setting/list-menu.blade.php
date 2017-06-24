<div class="row">
	<div class="span6 half">
		<div class="widget widget-2 widget-white">
			<div class="widget-head">
				<span class="heading">
					Menus
				</span>
			</div>
			<div class="widget-body">
				<div class="dd" id="list_menu">
					<ol class="dd-list">		
					@foreach($menus as $key => $menu)
						<li class="dd-item dd3-item" data-id="{{$menu['id']}}">
									<div class="dd-handle dd3-handle">Drag</div>
									<div class="dd3-content" data-id="{{$menu['id']}}" @if(!$menu['active'])style="background: #bbb;"@endif>
										{{ $menu['name'] }}

										<input type="hidden" value="{{ json_encode($menu) }}"/>

										<span class="pull-right"><i class="fa fa-remove" onclick="delete_menu({{$menu['id']}})"></i></span>
									</div>
							@if(count($menu['children']))
								<ol class="dd-list">
									@foreach($menu['children'] as $menu_child)
										<li class="dd-item dd3-item" data-id="{{$menu_child['id']}}">
											<div class="dd-handle dd3-handle">Drag</div>
											<div class="dd3-content" data-id="{{$menu_child['id']}}" @if(!$menu_child['active'])style="background: #bbb;"@endif>
												{{ $menu_child['name'] }}
												<input type="hidden" value="{{ json_encode($menu_child) }}"/>
												<span class="pull-right"><i class="fa fa-remove" onclick="delete_menu({{$menu_child['id']}})"></i></span>
											</div>
										</li>
									@endforeach
								</ol>
							@endif
						</li>
					@endforeach
					</ol>
				</div>
			</div>
		</div>
	</div>
	<div class="span6 half">
		<div class="widget widget-2 widget-white">
			<div class="widget-head">
				<span class="heading">Menu detail
					<a href="#" onclick="reset_form()"><i class="fa fa-plus"></i></a>
				</span>
			</div>
			<div class="widget-body">
				<div class="form_detail">
				<form method="POST" accept-charset="utf-8" id="form_menu">
					<input type="hidden" name="id" id="id" value="0">
					<div class="control-group">
						<label class="control-label">Name</label>
						<div class="controls">
							<input type="text"
									id="name"
									name="name"
									value=""
							>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" style="vertical-align:bottom;  margin-bottom: 10px;">Link</label>
						<div class="controls">
							<div class="input-prepend">
							  	<span class="add-on">{{str_replace("http://","",URL)}}/</span>
							  	<input id="link" type="text" placeholder="user/login" name="link">
							</div>
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">Parent menu</label>
						<div class="controls">
							<select name="parent_id" id="parent_id">
								<option value="0">** Root **</option>}
								@foreach($menus as $menu)
								<option value="{{$menu['id']}}">{{$menu['name']}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<!-- <div class="control-group">
						<label class="control-label">Order no</label>
						<div class="controls">
							<div data-trigger="spinner">
								<input type="text" value="1" data-rule="quantity" id="order_no" name="order_no" readonly="">
								<span class="input-group-addon">
								<a href="javascript:;" data-spin="up"><i class="
								fa fa-caret-up"></i></a>	
								<a href="javascript:;" data-spin="down"><i class="
								fa fa-caret-down"></i></a>
								</span>
							</div>
						</div>
					</div> -->
					<div class="control-group">
						<label class="control-label">Icon</label>
						<div class="controls">
							<select name="icon_class" id="icon_class">
							<?php
								for($i=1;$i<=260;$i++){
									if($i<10) $class='00'.$i;
									elseif($i<100) $class='0'.$i;
									else $class=$i;
							?>
								<option value="fi fi-{{$class}}"></option>
							<?php
								}
								$arr_fontawesome=array(
									"fa fa-glass",
									"fa fa-music", "fa fa-search", "fa fa-envelope-o", "fa fa-heart", "fa fa-star", "fa fa-star-o", "fa fa-user", "fa fa-film", "fa fa-th-large", "fa fa-th", "fa fa-th-list", "fa fa-check", "fa fa-remove", "fa fa-close", "fa fa-times", "fa fa-search-plus", "fa fa-search-minus", "fa fa-power-off", "fa fa-signal", "fa fa-gear", "fa fa-cog", "fa fa-trash-o", "fa fa-home", "fa fa-file-o", "fa fa-clock-o", "fa fa-road", "fa fa-download", "fa fa-arrow-circle-o-down", "fa fa-arrow-circle-o-up", "fa fa-inbox", "fa fa-play-circle-o", "fa fa-rotate-right", "fa fa-repeat", "fa fa-refresh", "fa fa-list-alt", "fa fa-lock", "fa fa-flag", "fa fa-headphones", "fa fa-volume-off", "fa fa-volume-down", "fa fa-volume-up", "fa fa-qrcode", "fa fa-barcode", "fa fa-tag", "fa fa-tags", "fa fa-book", "fa fa-bookmark", "fa fa-print", "fa fa-camera", "fa fa-font", "fa fa-bold", "fa fa-italic", "fa fa-text-height", "fa fa-text-width", "fa fa-align-left", "fa fa-align-center", "fa fa-align-right", "fa fa-align-justify", "fa fa-list", "fa fa-dedent", "fa fa-outdent", "fa fa-indent", "fa fa-video-camera", "fa fa-photo", "fa fa-image", "fa fa-picture-o", "fa fa-pencil", "fa fa-map-marker", "fa fa-adjust", "fa fa-tint", "fa fa-edit", "fa fa-pencil-square-o", "fa fa-share-square-o", "fa fa-check-square-o", "fa fa-arrows", "fa fa-step-backward", "fa fa-fast-backward", "fa fa-backward", "fa fa-play", "fa fa-pause", "fa fa-stop", "fa fa-forward", "fa fa-fast-forward", "fa fa-step-forward", "fa fa-eject", "fa fa-chevron-left", "fa fa-chevron-right", "fa fa-plus-circle", "fa fa-minus-circle", "fa fa-times-circle", "fa fa-check-circle", "fa fa-question-circle", "fa fa-info-circle", "fa fa-crosshairs", "fa fa-times-circle-o", "fa fa-check-circle-o", "fa fa-ban", "fa fa-arrow-left", "fa fa-arrow-right", "fa fa-arrow-up", "fa fa-arrow-down", "fa fa-mail-forward", "fa fa-share", "fa fa-expand", "fa fa-compress", "fa fa-plus", "fa fa-minus", "fa fa-asterisk", "fa fa-exclamation-circle", "fa fa-gift", "fa fa-leaf", "fa fa-fire", "fa fa-eye", "fa fa-eye-slash", "fa fa-warning", "fa fa-exclamation-triangle", "fa fa-plane", "fa fa-calendar", "fa fa-random", "fa fa-comment", "fa fa-magnet", "fa fa-chevron-up", "fa fa-chevron-down", "fa fa-retweet", "fa fa-shopping-cart", "fa fa-folder", "fa fa-folder-open", "fa fa-arrows-v", "fa fa-arrows-h", "fa fa-bar-chart-o", "fa fa-bar-chart", "fa fa-twitter-square", "fa fa-facebook-square", "fa fa-camera-retro", "fa fa-key", "fa fa-gears", "fa fa-cogs", "fa fa-comments", "fa fa-thumbs-o-up", "fa fa-thumbs-o-down", "fa fa-star-half", "fa fa-heart-o", "fa fa-sign-out", "fa fa-linkedin-square", "fa fa-thumb-tack", "fa fa-external-link", "fa fa-sign-in", "fa fa-trophy", "fa fa-github-square", "fa fa-upload", "fa fa-lemon-o", "fa fa-phone", "fa fa-square-o", "fa fa-bookmark-o", "fa fa-phone-square", "fa fa-twitter", "fa fa-facebook-f", "fa fa-facebook", "fa fa-github", "fa fa-unlock", "fa fa-credit-card", "fa fa-rss", "fa fa-hdd-o", "fa fa-bullhorn", "fa fa-bell", "fa fa-certificate", "fa fa-hand-o-right", "fa fa-hand-o-left", "fa fa-hand-o-up", "fa fa-hand-o-down", "fa fa-arrow-circle-left", "fa fa-arrow-circle-right", "fa fa-arrow-circle-up", "fa fa-arrow-circle-down", "fa fa-globe", "fa fa-wrench", "fa fa-tasks", "fa fa-filter", "fa fa-briefcase", "fa fa-arrows-alt", "fa fa-group", "fa fa-users", "fa fa-chain", "fa fa-link", "fa fa-cloud", "fa fa-flask", "fa fa-cut", "fa fa-scissors", "fa fa-copy", "fa fa-files-o", "fa fa-paperclip", "fa fa-save", "fa fa-floppy-o", "fa fa-square", "fa fa-navicon", "fa fa-reorder", "fa fa-bars", "fa fa-list-ul", "fa fa-list-ol", "fa fa-strikethrough", "fa fa-underline", "fa fa-table", "fa fa-magic", "fa fa-truck", "fa fa-pinterest", "fa fa-pinterest-square", "fa fa-google-plus-square", "fa fa-google-plus", "fa fa-money", "fa fa-caret-down", "fa fa-caret-up", "fa fa-caret-left", "fa fa-caret-right", "fa fa-columns", "fa fa-unsorted", "fa fa-sort", "fa fa-sort-down", "fa fa-sort-desc", "fa fa-sort-up", "fa fa-sort-asc", "fa fa-envelope", "fa fa-linkedin", "fa fa-rotate-left", "fa fa-undo", "fa fa-legal", "fa fa-gavel", "fa fa-dashboard", "fa fa-tachometer", "fa fa-comment-o", "fa fa-comments-o", "fa fa-flash", "fa fa-bolt", "fa fa-sitemap", "fa fa-umbrella", "fa fa-paste", "fa fa-clipboard", "fa fa-lightbulb-o", "fa fa-exchange", "fa fa-cloud-download", "fa fa-cloud-upload", "fa fa-user-md", "fa fa-stethoscope", "fa fa-suitcase", "fa fa-bell-o", "fa fa-coffee", "fa fa-cutlery", "fa fa-file-text-o", "fa fa-building-o", "fa fa-hospital-o", "fa fa-ambulance", "fa fa-medkit", "fa fa-fighter-jet", "fa fa-beer", "fa fa-h-square", "fa fa-plus-square", "fa fa-angle-double-left", "fa fa-angle-double-right", "fa fa-angle-double-up", "fa fa-angle-double-down", "fa fa-angle-left", "fa fa-angle-right", "fa fa-angle-up", "fa fa-angle-down", "fa fa-desktop", "fa fa-laptop", "fa fa-tablet", "fa fa-mobile-phone", "fa fa-mobile", "fa fa-circle-o", "fa fa-quote-left", "fa fa-quote-right", "fa fa-spinner", "fa fa-circle", "fa fa-mail-reply", "fa fa-reply", "fa fa-github-alt", "fa fa-folder-o", "fa fa-folder-open-o", "fa fa-smile-o", "fa fa-frown-o", "fa fa-meh-o", "fa fa-gamepad", "fa fa-keyboard-o", "fa fa-flag-o", "fa fa-flag-checkered", "fa fa-terminal", "fa fa-code", "fa fa-mail-reply-all", "fa fa-reply-all", "fa fa-star-half-empty", "fa fa-star-half-full", "fa fa-star-half-o", "fa fa-location-arrow", "fa fa-crop", "fa fa-code-fork", "fa fa-unlink", "fa fa-chain-broken", "fa fa-question", "fa fa-info", "fa fa-exclamation", "fa fa-superscript", "fa fa-subscript", "fa fa-eraser", "fa fa-puzzle-piece", "fa fa-microphone", "fa fa-microphone-slash", "fa fa-shield", "fa fa-calendar-o", "fa fa-fire-extinguisher", "fa fa-rocket", "fa fa-maxcdn", "fa fa-chevron-circle-left", "fa fa-chevron-circle-right", "fa fa-chevron-circle-up", "fa fa-chevron-circle-down", "fa fa-anchor", "fa fa-unlock-alt", "fa fa-bullseye", "fa fa-ellipsis-h", "fa fa-ellipsis-v", "fa fa-rss-square", "fa fa-play-circle", "fa fa-ticket", "fa fa-minus-square", "fa fa-minus-square-o", "fa fa-level-up", "fa fa-level-down", "fa fa-check-square", "fa fa-pencil-square", "fa fa-external-link-square", "fa fa-share-square", "fa fa-compass", "fa fa-toggle-down", "fa fa-caret-square-o-down", "fa fa-toggle-up", "fa fa-caret-square-o-up", "fa fa-toggle-right", "fa fa-caret-square-o-right", "fa fa-euro", "fa fa-eur", "fa fa-gbp", "fa fa-dollar", "fa fa-usd", "fa fa-rupee", "fa fa-inr", "fa fa-cny", "fa fa-rmb", "fa fa-yen", "fa fa-jpy", "fa fa-ruble", "fa fa-rouble", "fa fa-rub", "fa fa-won", "fa fa-krw", "fa fa-bitcoin", "fa fa-btc", "fa fa-file", "fa fa-file-text", "fa fa-sort-alpha-asc", "fa fa-sort-alpha-desc", "fa fa-sort-amount-asc", "fa fa-sort-amount-desc", "fa fa-sort-numeric-asc", "fa fa-sort-numeric-desc", "fa fa-thumbs-up", "fa fa-thumbs-down", "fa fa-youtube-square", "fa fa-youtube", "fa fa-xing", "fa fa-xing-square", "fa fa-youtube-play", "fa fa-dropbox", "fa fa-stack-overflow", "fa fa-instagram", "fa fa-flickr", "fa fa-adn", "fa fa-bitbucket", "fa fa-bitbucket-square", "fa fa-tumblr", "fa fa-tumblr-square", "fa fa-long-arrow-down", "fa fa-long-arrow-up", "fa fa-long-arrow-left", "fa fa-long-arrow-right", "fa fa-apple", "fa fa-windows", "fa fa-android", "fa fa-linux", "fa fa-dribbble", "fa fa-skype", "fa fa-foursquare", "fa fa-trello", "fa fa-female", "fa fa-male", "fa fa-gittip", "fa fa-gratipay", "fa fa-sun-o", "fa fa-moon-o", "fa fa-archive", "fa fa-bug", "fa fa-vk", "fa fa-weibo", "fa fa-renren", "fa fa-pagelines", "fa fa-stack-exchange", "fa fa-arrow-circle-o-right", "fa fa-arrow-circle-o-left", "fa fa-toggle-left", "fa fa-caret-square-o-left", "fa fa-dot-circle-o", "fa fa-wheelchair", "fa fa-vimeo-square", "fa fa-turkish-lira", "fa fa-try", "fa fa-plus-square-o", "fa fa-space-shuttle", "fa fa-slack", "fa fa-envelope-square", "fa fa-wordpress", "fa fa-openid", "fa fa-institution", "fa fa-bank", "fa fa-university", "fa fa-mortar-board", "fa fa-graduation-cap", "fa fa-yahoo", "fa fa-google", "fa fa-reddit", "fa fa-reddit-square", "fa fa-stumbleupon-circle", "fa fa-stumbleupon", "fa fa-delicious", "fa fa-digg", "fa fa-pied-piper", "fa fa-pied-piper-alt", "fa fa-drupal", "fa fa-joomla", "fa fa-language", "fa fa-fax", "fa fa-building", "fa fa-child", "fa fa-paw", "fa fa-spoon", "fa fa-cube", "fa fa-cubes", "fa fa-behance", "fa fa-behance-square", "fa fa-steam", "fa fa-steam-square", "fa fa-recycle", "fa fa-automobile", "fa fa-car", "fa fa-cab", "fa fa-taxi", "fa fa-tree", "fa fa-spotify", "fa fa-deviantart", "fa fa-soundcloud", "fa fa-database", "fa fa-file-pdf-o", "fa fa-file-word-o", "fa fa-file-excel-o", "fa fa-file-powerpoint-o", "fa fa-file-photo-o", "fa fa-file-picture-o", "fa fa-file-image-o", "fa fa-file-zip-o", "fa fa-file-archive-o", "fa fa-file-sound-o", "fa fa-file-audio-o", "fa fa-file-movie-o", "fa fa-file-video-o", "fa fa-file-code-o", "fa fa-vine", "fa fa-codepen", "fa fa-jsfiddle", "fa fa-life-bouy", "fa fa-life-buoy", "fa fa-life-saver", "fa fa-support", "fa fa-life-ring", "fa fa-circle-o-notch", "fa fa-ra", "fa fa-rebel", "fa fa-ge", "fa fa-empire", "fa fa-git-square", "fa fa-git", "fa fa-hacker-news", "fa fa-tencent-weibo", "fa fa-qq", "fa fa-wechat", "fa fa-weixin", "fa fa-send", "fa fa-paper-plane", "fa fa-send-o", "fa fa-paper-plane-o", "fa fa-history", "fa fa-genderless", "fa fa-circle-thin", "fa fa-header", "fa fa-paragraph", "fa fa-sliders", "fa fa-share-alt", "fa fa-share-alt-square", "fa fa-bomb", "fa fa-soccer-ball-o", "fa fa-futbol-o", "fa fa-tty", "fa fa-binoculars", "fa fa-plug", "fa fa-slideshare", "fa fa-twitch", "fa fa-yelp", "fa fa-newspaper-o", "fa fa-wifi", "fa fa-calculator", "fa fa-paypal", "fa fa-google-wallet", "fa fa-cc-visa", "fa fa-cc-mastercard", "fa fa-cc-discover", "fa fa-cc-amex", "fa fa-cc-paypal", "fa fa-cc-stripe", "fa fa-bell-slash", "fa fa-bell-slash-o", "fa fa-trash", "fa fa-copyright", "fa fa-at", "fa fa-eyedropper", "fa fa-paint-brush", "fa fa-birthday-cake", "fa fa-area-chart", "fa fa-pie-chart", "fa fa-line-chart", "fa fa-lastfm", "fa fa-lastfm-square", "fa fa-toggle-off", "fa fa-toggle-on", "fa fa-bicycle", "fa fa-bus", "fa fa-ioxhost", "fa fa-angellist", "fa fa-cc", "fa fa-shekel", "fa fa-sheqel", "fa fa-ils", "fa fa-meanpath", "fa fa-buysellads", "fa fa-connectdevelop", "fa fa-dashcube", "fa fa-forumbee", "fa fa-leanpub", "fa fa-sellsy", "fa fa-shirtsinbulk", "fa fa-simplybuilt", "fa fa-skyatlas", "fa fa-cart-plus", "fa fa-cart-arrow-down", "fa fa-diamond", "fa fa-ship", "fa fa-user-secret", "fa fa-motorcycle", "fa fa-street-view", "fa fa-heartbeat", "fa fa-venus", "fa fa-mars", "fa fa-mercury", "fa fa-transgender", "fa fa-transgender-alt", "fa fa-venus-double", "fa fa-mars-double", "fa fa-venus-mars", "fa fa-mars-stroke", "fa fa-mars-stroke-v", "fa fa-mars-stroke-h", "fa fa-neuter", "fa fa-facebook-official", "fa fa-pinterest-p", "fa fa-whatsapp", "fa fa-server", "fa fa-user-plus", "fa fa-user-times", "fa fa-hotel", "fa fa-bed", "fa fa-viacoin", "fa fa-train", "fa fa-subway", "fa fa-medium"
								)
							?>
							@foreach ($arr_fontawesome as $key => $value)
								<option value="{{$value}}"></option>
							@endforeach
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" style="  margin-bottom: 10px;vertical-align: bottom;">Trạng thái</label>
						<div class="controls">
							<div class="toggle-button" data-togglebutton-width="221" data-togglebutton-label-enabled="Active" data-togglebutton-label-disabled="Inactive" data-togglebutton-height="25" data-togglebutton-font-lineheight="25px" style="margin-top:5px;">
								<input type="checkbox" value="1" name="active" id="active"/>
							</div>
						</div>
					</div>
					<div class="control-group center">
						<input type="button" class="btn btn-primary" value="Save" onclick="save_menu()">
						<input type="reset" class="btn btn-primary" value="Clear" onclick="reset_form()">
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
</div>
<style type="text/css" media="screen">
	.input-prepend{
		width:80%;
	}
	.input-prepend input{
		width:61.5% !important;
	}
	.input-prepend .add-on{
		width:35%;
	}
	.control-group label{
		width:20%;
	}
	.control-group .controls{
		width:78%;
	}

</style>
<link rel="stylesheet" type="text/css" href="{{ URL }}/scripts/iconpicker/css/jquery.fonticonpicker.css">
<link rel="stylesheet" type="text/css" href="{{ URL }}/scripts/iconpicker/themes/grey-theme/jquery.fonticonpicker.grey.min.css">
<link rel="stylesheet" type="text/css" href="{{ URL }}/scripts/iconpicker/themes/bootstrap-theme/jquery.fonticonpicker.bootstrap.css">
<link rel="stylesheet" type="text/css" href="{{ URL }}/scripts/spinner/bootstrap-spinner.css">
<script src="{{ URL }}/scripts/spinner/jquery.spinner.min.js" type="text/javascript" charset="utf-8"></script>
<script src="{{ URL }}/scripts/jquery.nestable.js" type="text/javascript" charset="utf-8"></script>
<script src="{{ URL }}/scripts/iconpicker/jquery.fonticonpicker.min.js" type="text/javascript" charset="utf-8"></script>
<script>
	$("#order_no").spinner();
	$("#list_menu").nestable({
		maxDepth:2
	})
	$('#list_menu').on('change', function() {
	   	var data = $('#list_menu').nestable('serialize');
	   	$.ajax({
	   		url:'{{URL}}/settings/update-order-menu',
	   		type:'POST',
	   		data:
	   		{
	   			'data':data
	   		},
	   		success:function(data){
	   			if(data.status="success"){
	   				toastr['success']('Update order success !');
	   				settings_list('menu-settings');
	   			}else{
	   				toastr['error'](data.message);
	   			}
	   		}
	   	});
	});

	function formatState (state) {
		if (!state.id) { return state.text; }
		var $state = $(
		'<i class="'+ state.element.value.toLowerCase() + '"></i>'
		);
		return $state;
	};

	$(".toggle-button").toggleButtons();

	$("#icon_class").fontIconPicker({
		hasSearch: false,
		theme: 'fip-bootstrap',
		emptyIcon: false,
		 iconsPerPage: 25
	});

	$(".dd3-content").on("click",function(){
		var data = $.parseJSON($(this).find('input:first-child').val());
		$("input#id").val(data.id);
		$("input#name").val(data.name);
		$("input#link").val(data.link);
		$("select#parent_id").val(data.parent_id);
		$("input#order_no").val(data.order_no);
		$("select#icon_class").val(data.icon_class);
		$(".selected-icon i").removeAttr('class');
		$(".selected-icon i").addClass($("select#icon_class").val());
		if(data.active){
			$("#active").prop("checked",true);
			$("#active").change();
		}else{
			$("#active").prop("checked",false);
			$("#active").change();

		}
	})
	function delete_menu(id){
		event.preventDefault();
		$.ajax({
			url : '{{URL}}/settings/delete-menu',
			type : 'POST',
			data : {
				'id' : id
			},
			success:function(data){
				if(data.status='success'){
					settings_list('menu-settings');
					toastr["success"]("Delete menu success!")
				}else{
					alert(data.message)
				}
			}
		});
	}
	function reset_form(){
		$("input#id").val(0);
		$("input#name").val('');
		$("input#link").val('');
		$("select#parent_id").val(0);
		$("input#order_no").val(0);
		$("select#icon_class").val('fi fi-001');
		$(".selected-icon i").removeAttr('class');
		$(".selected-icon i").addClass($("select#icon_class").val());
	}
	function save_menu(){
		var data = $("#form_menu").serialize();
		$.ajax({
			url:'{{URL}}/settings/update-menu',
			type:"POST",
			data:data,
			success:function(data){
				if(data.status='success'){
					settings_list('menu-settings');
					toastr["success"]("Saving menu success!")
				}else{
					alert(data.message)
				}
			}
		})
	}

	
</script>