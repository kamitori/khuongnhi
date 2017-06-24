<style type="text/css" media="screen">
	/*.dd3-content{
		height:45px !important;
	}*/
</style>
<div class="row">
	<div class="span6 quarter1">
		<div class="widget widget-2 widget-white">
			<div class="widget-head">
				<span class="heading">
					Quốc gia
					<a href="#" onclick="popupCountry();"><i class="fa fa-plus"></i></a>
				</span>
			</div>
		
			<div class="widget-body">
				<div class="dd" id="list_menu">
					<ol class="dd-list">
						@foreach($countries as $key => $country)
						<li class="dd-item dd3-item"  >
							<div class="dd3-content" onclick="listProvinceDetail({{$country['id']}})">
								{{$country['name']}}
								<!-- <button class="btn btn-danger pull-right" onclick="delete_country({{$country['id']}})"><i class="fa fa-remove"></i></button>
								<button class="btn btn-primary pull-right" data-value='{{ json_encode($country) }}' onclick="popup_edit_country(this)"><i class="fa fa-pencil"></i></button> -->
							</div>
						</li>
						@endforeach
					</ol>
				</div>
			</div>
		</div>
	</div>
	<div class="span6 quarter3">
		<div class="widget widget-2 widget-white">
			<div class="widget-head">
				<span class="heading">
					Tỉnh thành
					<a href="#" id="popupProvince"><i class="fa fa-plus"></i></a>
				</span>
			</div>
		
			<div class="widget-body" id="list_province_detail">
				<div class="dd" id="list_province">

				</div>
			</div>
		</div>
	</div>
</div>
<!-- set up the modal to start hidden and fade in and out -->
<div id="myModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- dialog header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h5>Create Country</h5>
			</div>
			<!-- dialog body -->
			<form  method="post" accept-charset="utf-8" id="form_country">
			<div class="modal-body">
				<div class="accordion" id="accordion2" style="margin-bottom: 0;">
					<div class="accordion-group">
						<div id="collapse1" class="accordion-body in collapse" style="height: auto;">
							<div class="accordion-inner">
								<div class="row-fluid form_detail">
									<div class="span6">
										<input type="hidden" value="0" name="id" />
										<div class="control-group">
											<label class="control-label">Name</label>
											<div class="controls">
												<input type="text"
														id="name"
														name="name"
														value="">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer text-center">
					<button type="button" onclick="saveCountry()" class="btn btn-primary">Save</button>
					<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
		</form>
			<!-- dialog buttons -->


		</div>
	</div>
</div>
<!-- <div id="province_list" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			dialog header
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h5>Create Province</h5>
			</div>
			dialog body
			<form  method="post" accept-charset="utf-8" id="form_province">
			<div class="modal-body">
				<div class="accordion" id="accordion2" style="margin-bottom: 0;">
					<div class="accordion-group">
						<div id="collapse1" class="accordion-body in collapse" style="height: auto;">
							<div class="accordion-inner">
								<div class="row-fluid form_detail">
									<div class="span6">
										<input type="hidden" value="0" name="id" />
										<div class="control-group">
											<label class="control-label">Name</label>
											<div class="controls">
												<input type="text"
														id="name"
														name="name"
														value="">
											</div>
										</div>
									</div>
									<div class="span6">
										<div class="control-group">
											<label class="control-label">Country</label>
											<div class="controls">
												<select name="popup_country" id="popup_country">
													@foreach($countries as $key => $country)
													<option value="{{$country['id']}}">{{$country['name']}}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer text-center">
					<button type="button" onclick="saveProvince()" class="btn btn-primary">Save</button>
					<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
		</form>
			dialog buttons


		</div>
	</div>
</div> -->
<style type="text/css">
	.modal{
		width:auto !important;
		min-width: 33% !important;
		left:60% !important;
		top:10% !important;
	}
</style>
<script>
	$("#myModal").modal({
		"backdrop":true,
		"show":false,
		"container":"body"
	});
	$(".toggle-button").toggleButtons();
	$('.pagination a').click(function(e){
		var url = $(this).attr('href');
		e.preventDefault();
		$.ajax({
			url: url,
			success: function(html) {
				$('#content_setting').html(html);
			}
		})
	});
	function popupCountry(){
		$("#myModal").modal("show");
	}
	/*function popupProvince(){
		$("#province_list").modal("show");
	}*/
	function saveCountry(){
		var data = $("#form_country").serialize();
		$.ajax({
			url:"{{URL}}/settings/create-country",
			type:"POST",
			data:data,
			success:function(data){
				if(data.status='success'){
					alert('Save success');
					settings_list('province-settings');
					$("#myModal").modal("hide");
				}else{
					alert(data.message);
				}
			}
		});
	}
	function listProvinceDetail(id){
		$("#popupProvince").attr("onclick","create_province()");
		$.ajax({
			url: "{{URL}}/settings/list-province/"+id,
			success:function(html){
				$("div#list_province_detail").html(html);
			}
		})
	}
	/*function saveProvince(){
		var data = $("#form_province").serialize();
		$.ajax({
			url:"{{URL}}/settings/create-province",
			type: "POST",
			data: data,
			success: function(data){
				if(data.status = 'success'){
					alert('Save success');
					$("#province_list").modal("hide");
				}else{
					alert(data.message);
				}
			}
		})
	}*/
</script>


