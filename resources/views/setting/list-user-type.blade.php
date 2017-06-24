<table class="table table-bordered table-condensed table-striped table-primary table-vertical-center checkboxs js-table-sortable ui-sortable">
	<thead>
		<tr>
			<th style="width:10%">STT</th>
			<th style="width:15%">Name</th>
			<th style="width:40%">Mô tả</th>
			<th style="width:15%">Loại</th>
			<th style="width:20%">Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($usertypes as $key => $value)
		 <tr>
			<td>{{($key+1)}}</td>
			<td>{{$value['display_name']}}</td>
			<td>{{$value['description']}}</td>
			<td>{{$value['main']?"Dùng chung":"Dùng riêng"}}</td>
			<td class="center">
				<button class="btn btn-primary" data-value='{{ json_encode($value) }}' onclick="popup_edit_usertype(this)"><i class="fa fa-pencil"></i></button>
				<button class="btn btn-danger" onclick="delete_usertype({{$value['id']}})"><i class="fa fa-remove"></i></button>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
<div id="myModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- dialog header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h5>&nbsp;</h5>
			</div>
			<!-- dialog body -->
			<form  method="post" accept-charset="utf-8" id="form_user_type">
			<div class="modal-body">
				<div class="control-group">
					<input type="hidden" name="id" id="id">
					<label class="control-label">Tên</label>
					<div class="controls">
						<input type="text"
								id="name"
								name="name"
								value=""
								style="width:340px;"
						>
					</div>
				</div>
				<div class="control-group">
					<input type="hidden" name="id" id="id">
					<label class="control-label">Mô tả</label>
					<div class="controls">
						<input type="text"
								id="description"
								name="description"
								value=""
								style="width:340px;"
						>
					</div>
				</div>
				<div class="control-group">
					<input type="hidden" name="id" id="id">
					<label class="control-label">&nbsp;</label>
					<div class="controls">
						Dùng chung: <input type="radio" value="1" name="main" checked>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						Dùng riêng: <input type="radio" value="0" name="main">
					</div>
				</div>
			</div>
			<div class="modal-footer text-center">
					<button type="button" onclick="saveproducttype()" class="btn btn-primary">Save</button>
					<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
			</form>
			<!-- dialog buttons -->
		</div>
	</div>
</div>

<script>
	$("#myModal").modal({
		"backdrop":true,
		"show":false,
		"container":"body"
	});
	function popup_user_type(){
		$("#myModal").modal("show");

	}
	function create_user_type(){
		$("#form_user_type").get(0).reset();
		$("#myModal").modal("show");
	}
	function popup_edit_usertype(object){
		var data = $(object).attr("data-value");
		data = $.parseJSON(data);
		$.each(data,function(key,value){
			if(key!='main'){
				$("[name="+key+"]").val(value);
			}
			else{
				$("[name="+key+"]").attr("checked",false);
				$("[name="+key+"][value="+value+"]").attr("checked",true);
				$("[name="+key+"]").trigger('change');
			}
		})
		popup_user_type();
	}
	function saveproducttype(){
		var data = $("#form_user_type").serialize();
		$.ajax({
			url:"{{URL}}/settings/update-user-type-settings",
			type:"POST",
			data:data,
			success:function(data){
				if(data.status='success'){
					toastr['success']('Save success');
					other_settings_list('user-type-settings','User type','user_type')
					$("#myModal").modal("hide");
				}else{
					toastr['error'](data.message);
				}
			}
		});
	}

	function delete_usertype(id){
		$.ajax({
			url:"{{URL}}/settings/delete-user-type/"+id,
			success: function(result){
				if(result.status == 'success'){
					toastr['success']('Delete success');
					other_settings_list('user-type-settings','User type','user_type');
				}else{
					toastr['error'](result.message);
				}
			}
		});
	}
</script>