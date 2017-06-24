<!--  Footer -->
<div id="footer" class="hide">
	<div class="wrap">
		<div class="span3 pull-left">
			@if(isset($arr_create))
			<ul>
				<li>Thêm: {{date('d/m/Y',strtotime($arr_create['created_at']))}}</li>
				<li>{{date('H:i',strtotime($arr_create['created_at']))}}</li>
				<li>bởi: {{$arr_create['name']}}</li>
			</ul>
			@endif
		</div>
		<div class="span3 pull-left">
			@if(isset($arr_update))
			<ul>
				<li>Sửa: {{date('d/m/Y',strtotime($arr_update['updated_at']))}}</li>
				<li>{{date('H:i',strtotime($arr_update['updated_at']))}}</li>
				<li>bởi: {{$arr_update['name']}}</li>
			</ul>
			@endif
		</div>
		<div class="span6 pull-right">
			<ul>
				<li><a href="{{URL}}">Trang chủ</a></li>
				<li  data-check="0" id="show_select_color">
					<a href="javascript:void(0);">Giao diện</a>

				</li>
				@if(\Auth::user()->can('view-settings'))
				<li><a href="{{URL}}/settings">Bảng điều khiển</a></li>
				@endif
				<li><a href="#">{{\Auth::user()->name}}</a></li>
				<li><a href="{{URL}}/auth/logout">Đăng xuất</a></li>
			</ul>
		</div>
	</div>
</div>
<div id="select_color" style="display: none;">
	Màu chính <input type="minicolors" value="{{\Auth::user()->primary_color}}" data-position="top right" class="color_picker" id="primary_color">
	<br/><br/>
	Màu menu <input type="minicolors" value="{{\Auth::user()->menu_color}}" data-position="top right" class="color_picker" id="menu_color">
	<br/><br/>
	<div class="row-fluid center">
		<button class="btn btn-primary" onclick="save_color_user()">Lưu</button>
		<button class="btn btn-primary" onclick="default_color_user()">Mặc định</button>
	</div>
</div>
<script>
		$("#show_select_color").on("click",function(){
			var select_div = $("#select_color");
			if($(this).attr("data-check") == 0){
				$(this).attr("data-check",1);
				select_div.css({
								"left":$(this).offset().left
							});
				select_div.toggle(500);
			}else{
				$(this).attr("data-check",0);
				select_div.css({"display":"none"});
			}
		})


		$(".color_picker").on("change",function(){
			themerPrimaryColor = $("#primary_color").val();
			themerMenuColor = $("#menu_color").val();
			themerUpdateColors(themerPrimaryColor, themerMenuColor);
		})

		function save_color_user(){
			primary_color = $("#primary_color").val();
			menu_color = $("#menu_color").val();
			$.ajax({
				url : '{{URL}}/users/change-color',
				type: 'POST',
				data:{
					primary_color : primary_color,
					menu_color : menu_color
				},
				success: function(data){
					if(data.status=='success'){
						toastr['success']('Save success!');
					}else{
						toastr['error'](data.message);
					}
				}
			})
		}

		function default_color_user(){
			$("#primary_color").val("#4EA0CF");
			$("#menu_color").val('#383F48');
			themerPrimaryColor = $("#primary_color").val();
			themerMenuColor = $("#menu_color").val();
			themerUpdateColors(themerPrimaryColor, themerMenuColor);
			save_color_user();
		}
</script>
<style>
	#select_color{
		position: fixed;
		bottom: 35px;
		z-index: 99999;
		padding: 10px;
		font-weight: bold;
	}
</style>
<!-- End footer -->