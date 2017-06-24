<table class="table table-bordered table-condensed table-striped table-primary table-vertical-center checkboxs js-table-sortable ui-sortable">
	<thead>
		<tr>
			<th style="width:20%">STT</th>
			<th style="width:60%">Name</th>
			<th style="width:20%">Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($producttypes as $key => $value)
		 <tr>
			<td>{{($key+1)}}</td>
			<td>{{$value['name']}}</td>
			<td class="center">
				<button class="btn btn-primary" data-value='{{ json_encode($value) }}' onclick="popup_edit_producttype(this)"><i class="fa fa-pencil"></i></button>
				<button class="btn btn-danger" onclick="delete_producttype({{$value['id']}})"><i class="fa fa-remove"></i></button>
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
			<form  method="post" accept-charset="utf-8" id="form_producttype">
			<div class="modal-body">
				<div class="control-group">
					<input type="hidden" name="id" id="id">
					<label class="control-label">Name</label>
					<div class="controls">
						<input type="text"
								id="name"
								name="name"
								value=""
						>
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
	function popup_producttype(){
		$("#myModal").modal("show");

	}
	function create_producttype(){
		$("#form_producttype").get(0).reset();
		$("#myModal").modal("show");
	}
	function popup_edit_producttype(object){
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
		popup_producttype();
	}
	function saveproducttype(){
		var data = $("#form_producttype").serialize();
		$.ajax({
			url:"{{URL}}/settings/update-producttype",
			type:"POST",
			data:data,
			success:function(data){
				if(data.status='success'){
					toastr['success']('Save success');
					other_settings_list('producttype-settings','đơn vị','producttype')
					$("#myModal").modal("hide");
				}else{
					toastr['error'](data.message);
				}
			}
		});
	}

	function delete_producttype(id){
		$.ajax({
			url:"{{URL}}/settings/delete-producttype/"+id,
			success:function(result){
				if(result.status='success'){
					toastr['success']('Delete success');
					other_settings_list('producttype-settings','đơn vị','producttype');
				}else{
					toastr['error'](result.message);
				}
			}

		});
	}
</script>