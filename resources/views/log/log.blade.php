<div class="heading-buttons main-left">
	<div class="buttons pull-left">
		<a href="create" class="btn btn-small btn-primary btn-icon "><i class="fa fa-plus"></i> Thêm</a>
		<a href="entry" class="btn btn-small btn-primary btn-icon "><i class="fa fa-list-alt"></i> Chi tiết</a>
		<a href="list" class="btn btn-small btn-primary btn-icon "><i class="fa fa-list"></i> Danh sách</a>
	</div>
	<div class="buttons pull-right">

		<div class="pagination pagination-small pull-right" style="margin: -15px 20px 5px 20px;">
			<?php echo $list_log->render(); ?>
		</div>
	</div>
</div>
<table class="table table-bordered table-condensed table-striped table-primary table-vertical-center table-list-view">
	<thead>
		<tr class="small">
			<th class="center" style="width:20%">Thời gian</th>
			<th class="center" style="width:20%">Người dùng</th>
			<th class="center" style="width:60%">Thao tác</th>
		</tr>
	</thead>
	<tbody>
		@foreach($list_log as $log)
		<tr class="selectable">
			<td class="center">{{ $log['created_at'] }}</td>
			<td class="center">{{ $log['name'] }}</td>
			<td class="center">{{ $log['content'] }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
@section('pageJS')
<script>
	setTimeout(function(){
		$(".table-list-view tbody").height($(".table-list-view tbody").height()+30)
	},300)
	
</script>
@stop