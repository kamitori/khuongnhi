<table class="table table-bordered table-condensed table-striped table-primary table-vertical-center checkboxs js-table-sortable ui-sortable">
	<thead>
		<tr>
			<th style="width:20%">STT</th>
			<th style="width:60%">Name</th>
			<th class="center" style="width:20%">Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($provinces as $key => $value)
		 <tr class="selectable">
			<td>{{($key+1)}}</td>
			<td>{{$value['name']}}</td>
			<td class="center">
				<button class="btn btn-primary" data-value='{{ json_encode($value) }}' onclick="popup_edit_province(this)"><i class="fa fa-pencil"></i></button>
				<button class="btn btn-danger" onclick="delete_province({{$value['id']}})"><i class="fa fa-remove"></i></button
>			</td>
		</tr>
		@endforeach
	</tbody>
</table>
<style type="text/css" media="screen">
	td i.link:nth-child(2n){
		margin-left: 20px;
	}
	td i.link:before{
		font-size: 150%;
	}
</style>
<div id="modal_province" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- dialog header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h5>&nbsp;</h5>
			</div>
			<!-- dialog body -->
			<form  method="post" accept-charset="utf-8" id="form_province_list">
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

					<div class="control-group">
						<label class="control-label">Country</label>
						<div class="controls">
							<select name="country_id" id="country_id">
								@foreach($countries as $key => $country)
								<option value="{{$country['id']}}">{{$country['name']}}</option>
								@endforeach
							</select>
						</div>
					</div>

			</div>
			<div class="modal-footer text-center">
					<button type="button" onclick="saveProvince()" class="btn btn-primary">Save</button>
					<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
			</form>
			<!-- dialog buttons -->
		</div>
	</div>
</div>

<script>
	$("#modal_province").modal({
		"backdrop":true,
		"show":false,
		"container":"body"
	});
	function popup_province(){
		$("#modal_province").modal("show");

	}
	function create_province(){
		$("#form_province_list").get(0).reset();
		$("#modal_province").modal("show");
	}
	function popup_edit_province(object){
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
		popup_province();
	}
	function saveProvince(){
		var data = $("#form_province_list").serialize();
		$.ajax({
			url:"{{URL}}/settings/update-province",
			type:"POST",
			data:data,
			success:function(data){
				if(data.status='success'){
					toastr['success']('Save success');
					settings_list('province-settings');
					$("#modal_province").modal("hide");
				}else{
					toastr['error'](data.message);
				}
			}
		});
	}

	function delete_province(id){
		$.ajax({
			url:"{{URL}}/settings/delete-province/"+id,
			success:function(result){
				if(result.status='success'){
					toastr['success']('Delete success');
					settings_list('province-settings');
				}else{
					toastr['error'](result.message);
				}
			}

		});
	}
</script>