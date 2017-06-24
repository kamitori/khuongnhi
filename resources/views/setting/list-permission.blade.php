<form id="frm_permission">
<div class="control-group">
	<label class="control-label">Loại tài khoản:</label>
	<div class="controls">
		<select id="select_role" name="role_id" onchange="permission_detail(this)">
			@foreach($roles as $role)
				<option value="{{$role['id']}}" title="{{$role['description']}}">{{$role['display_name']}}</option>
			@endforeach
		</select>
		<button type="button" class="btn btn-primary" onclick="save_permission()">Lưu phân quyền</button>
	</div>
</div>
<div class="row-fluid">
	<div class="span6">
		<table  class="table table-bordered table-condensed table-striped table-primary table-vertical-center checkboxs js-table-sortable ui-sortable">
			<tbody>
				@for($i=0;$i < count($permissions)/2;$i++)
				<tr class="selectable">
					<td><strong><label for="chk_{{$permissions[$i]['id']}}">{{$permissions[$i]['display_name']}}</label></strong></td>
					<td width="15" class="center"><input type="checkbox"  class="chk_per" name="permission_id[]" value="{{$permissions[$i]['id']}}" id="chk_{{$permissions[$i]['id']}}"></td>
				</tr>
				@endfor
			</tbody>
		</table>
	</div>
	<div class="span6">
		<table  class="table table-bordered table-condensed table-striped table-primary table-vertical-center checkboxs js-table-sortable ui-sortable">
			<tbody>
				@for($i=count($permissions)/2;$i<=count($permissions);$i++)
				<tr class="selectable">
					<td><strong><label for="chk_{{$permissions[$i]['id']}}">{{$permissions[$i]['display_name']}}</label></strong></td>
					<td width="15" class="center"><input type="checkbox"  class="chk_per" name="permission_id[]" value="{{$permissions[$i]['id']}}" id="chk_{{$permissions[$i]['id']}}"></td>
				</tr>
				@endfor
			</tbody>
		</table>
	</div>
</div>
</form>

<script>
	$("#select_role").trigger("change");

	function save_permission(){
		var data = $("#frm_permission").serialize();
		$.ajax({
			url : '{{URL}}/settings/save-permission',
			type : 'POST',
			data : data,
			success : function(data){
				if(data.status == 'success'){
					toastr['success']('Save success!');
				}else{
					toastr['error'](data.message);
				}
			}
		});
	}

	function permission_detail(obj){
		var id = $(obj).val();
		$.ajax({
			url : '{{URL}}/settings/permission-detail',
			type : 'POST',
			data : {
				id : id
			},
			success : function(data){
				$(".chk_per").attr("checked",false);
				if(data.length){
					$.each(data,function(key,value){
						$(".chk_per[value="+value['permission_id']+"]").attr("checked",true);
					})
				}
			}
		})
	}
</script>