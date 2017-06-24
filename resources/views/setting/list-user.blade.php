
<div class="pagination pagination-small pull-right" style="margin: 0;">
	<?php echo $users->render(); ?>
</div>
<table class="table table-bordered table-condensed table-striped table-primary table-vertical-center checkboxs js-table-sortable ui-sortable">
	<thead>
		<tr>
			<th>ID</th>
			<th>Tên</th>
			<th>Email</th>
			<th>Loại tài khoản</th>
			<th>Kích hoạt</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		@foreach($users as $key => $value)
		 <tr>
			<td>{{$value['id']}}</td>
			<td>{{$value['name']}}</td>
			<td>{{$value['email']}}</td>
			<td>{{$value['type_name']}}</td>
			<td>@if($value['confirmed'])<span class="label label-success">Kích hoạt</span>@else <span class="label">Chưa kích hoạt</span>@endif</td>
			<td class="center">
				<button class="btn btn-primary" data-value='{{ json_encode($value) }}' onclick="popup_edit_user(this)"><i class="fa fa-pencil"></i></button>
				<button class="btn btn-danger" onclick="delete_user({{$value['id']}})"><i class="fa fa-remove"></i></button>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

<!-- set up the modal to start hidden and fade in and out -->
<div id="myModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- dialog header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h5>Create User</h5>
			</div>
			<!-- dialog body -->
			<form  method="post" accept-charset="utf-8" id="form_user">
			<div class="modal-body">
				<div class="accordion" id="accordion2" style="margin-bottom: 0;">
					<div class="accordion-group">
						<div id="collapse1" class="accordion-body in collapse" style="height: auto;">
							<div class="accordion-inner">

									<div class="row-fluid form_detail">
										<div class="span6">
											<input type="hidden" value="0" name="id" />
											<input type="hidden" name="_token" value="{{ csrf_token() }}" />
											<div class="control-group">
												<label class="control-label">Name</label>
												<div class="controls">
													<input type="text"
															id="name"
															name="name"
															value="{{Input::old('name', isset($user) ? $user->name : null) }}">
												</div>
											</div>
											<!-- <div class="control-group">
												<label class="control-label">Username</label>
												<div class="controls">
													<input type="text"
															id="username"
															name="username"
															value="{{Input::old('username', isset($user) ? $user->username : null) }}">
												</div>
											</div> -->
											<div class="control-group">
												<label class="control-label">User type</label>
												<div class="controls">
													<select name="type_id" id="type_id">
														@foreach($user_types as $key => $type)
														<option value="{{$type['id']}}">{{$type['display_name']}}</option>
														@endforeach
													</select>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">Email</label>
												<div class="controls">
													<input type="text"
															id="email"
															name="email"
															value="{{Input::old('email', isset($user) ? $user->email : null)}}">
												</div>
											</div>

										</div>
										<div class="span6">
											<div class="control-group">
												<label class="control-label">Password</label>
												<div class="controls">
													<input type="password"
															id="password"
															name="password"
															value=""
													>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label">Re-password</label>
												<div class="controls">
													<input type="password"
															id="password_confirmation"
															name="password_confirmation"
															value=""
													>
												</div>
											</div>
											<!-- <div class="control-group">
												<label class="control-label">Active user</label>
												<div class="controls">
													<select name="confirmed" id="confirmed">
														<option value="1" {{{ ((isset($user) && $user->confirmed == 1)? '
															selected="selected"' : '') }}}>{{{ trans('admin/users.yes')
															}}}</option>
														<option value="0" {{{ ((isset($user) && $user->confirmed == 0) ?
															' selected="selected"' : '') }}}>{{{ trans('admin/users.no')
															}}}</option>
													</select>
												</div>
											</div> -->
											<div class="control-group">
												<label class="control-label">Trạng thái</label>
												<div class="controls">
													<div class="toggle-button" data-togglebutton-width="221" data-togglebutton-label-enabled="Active" data-togglebutton-label-disabled="Inactive" data-togglebutton-height="25" data-togglebutton-font-lineheight="25px">
														<input type="checkbox" value="1" name="confirmed" id="confirmed" {{ (isset($user) && $user->confirmed == 1)?"checked":"" }}/>
													</div>
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
					<button type="button" onclick="saveUser()" class="btn btn-primary">Save</button>
					<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
		</form>
			<!-- dialog buttons -->


		</div>
	</div>
</div>
<style type="text/css">
	.modal{
		width:auto !important;
		min-width: 63% !important;
		left:33% !important;
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
	function popup_user(){
		$("#myModal").modal("show");

	}

	function create_user(){
		$("#form_user").get(0).reset();
		$("#myModal").modal("show");
	}

	function saveUser(){
		var data = $("#form_user").serialize();
		$.ajax({
			url:"{{URL}}/settings/update-user",
			type:"POST",
			data:data,
			success:function(data){
				if(data.status='success'){
					toastr['success']('Save success');
					settings_list('user-settings');
					$("#myModal").modal("hide");
				}else{
					toastr['error'](data.message);
				}
			}
		});
	}

	function popup_edit_user(object){
		var data = $(object).attr("data-value");
		data = $.parseJSON(data);
		$.each(data,function(key,value){
			if(key!='confirmed'){
				$("[name="+key+"]").val(value);
			}
			else{
				if(value)
					$("[name="+key+"]").attr("checked",true);
				else
					$("[name="+key+"]").attr("checked",false);

				$("[name="+key+"]").trigger('change');
			}
		})
		popup_user();
	}

	function delete_user(id){
		$.ajax({
			url:"{{URL}}/settings/delete-user/"+id,
			success:function(result){
				if(result.status='success'){
					toastr['success']('Delete success');
					settings_list('user-settings');
				}else{
					toastr['error'](result.message);
				}
			}

		});
	}
</script>


