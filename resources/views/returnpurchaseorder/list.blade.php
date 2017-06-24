<div class="heading-buttons main-left">
	<div class="buttons pull-left">
		<a href="{{URL}}/returnpurchaseorders/create" class="btn btn-small btn-primary btn-icon "><i class="fa fa-plus"></i> Thêm</a>
		<a href="{{URL}}/returnpurchaseorders/entry" class="btn btn-small btn-primary btn-icon "><i class="fa fa-list-alt"></i> Chi tiết</a>
		<a href="javascript:window.open('{{URL}}/returnpurchaseorders/export-pdf-list','_blank');" class="btn btn-small btn-primary btn-icon "><i class="fa fa-print"></i> Xuất PDF</a>
		<a href="{{URL}}/returnpurchaseorders/log" class="btn btn-small btn-primary btn-icon "><i class="fa fa-clock-o"></i> Lịch sử</a>
	</div>
	<div class="buttons pull-right">

		<div class="pagination pagination-small pull-right" style="margin: -15px 20px 5px 20px;">
			<?php  echo $list_returnpurchaseorder->render(); ?>
		</div>
	</div>
</div>

<form action="{{URL}}/returnpurchaseorders/list" method="POST" accept-charset="utf-8" id="form-list">

<input type="hidden" id="input-sort" name="input-sort">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<table class="table table-bordered table-condensed table-striped table-primary table-vertical-center table-list-view">
	<thead>
		<tr class="small">
			<th style="width: 10%" data-column="id" {{ isset($arr_sort['id'])?'data-sort='.$arr_sort['id']:'' }}>Mã hóa đơn</th>
			<th style="width: 39%" data-column="company_id" {{ isset($arr_sort['company_id'])?'data-sort='.$arr_sort['company_id']:'' }}>Nhà cung cấp</th>
			<th style="width: 13%" data-column="date" {{ isset($arr_sort['date'])?'data-sort='.$arr_sort['date']:'' }}>Ngày trả hàng</th>
			<th style="width: 20%" data-column="sum_invest" {{ isset($arr_sort['sum_invest'])?'data-sort='.$arr_sort['sum_invest']:'' }}>Tổng tiền trả hàng</th>
			<th style="width: 13%" data-column="status" {{ isset($arr_sort['status'])?'data-sort='.$arr_sort['status']:'' }}>Tình trạng</th>
			<th style="width: 5%" class="no-sort">&nbsp;</th>
		</tr>
		<tr class="sort">
			<th>
				<select name="input-filter[id]" id="id" data-type="select2">
					<option value="">&nbsp;</option>
					@foreach($list_id as $value)
						<option value="{{$value}}" {{$arr_filter['id']==$value?'selected':''}}>{{$value}}</option>
					@endforeach
				</select>
			</th>
			<th>
				<select name="input-filter[company_id]" id="company_id" data-type="select2">
					<option value="">&nbsp;</option>
					@foreach($distributes as $company)
						<option value="{{$company['id']}}" {{$arr_filter['company_id']==$company['id']?'selected':''}}>{{$company['name']}}</option>
					@endforeach
				</select>
			</th>
			<th>
				<select name="input-filter[date]" id="date" data-type="select2">
					<option value="">&nbsp;</option>
					@foreach($list_date as $value)
						<option value="{{$value}}" {{$arr_filter['date']==$value?'selected':''}}>{{$value}}</option>
					@endforeach
				</select>
			</th>
			<th></th>
			<th>
				<select name="input-filter[status]" id="status">
					<option value="">&nbsp;</option>
					<option value="0" {{$arr_filter['status']=='0'?'selected':''}}>Mới</option>
					<option value="1" {{$arr_filter['status']=='1'?'selected':''}}>Hoàn thành</option>
				</select>
			</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@foreach($list_returnpurchaseorder as $key => $rpo)
		<tr class="selectable" data-id="{{$rpo['id']}}">
			<td>{{($rpo['id'])}}</td>
			<td>{{$rpo['company']['name']}}</td>
			<td>{{date('d-m-Y',strtotime($rpo['date']))}}</td>
			<td data-type="currency">{{$rpo['sum_invest']!=null?$rpo['sum_invest']:0}}</td>
			<td>{{$rpo['status']==1?'Hoàn thành':'Mới'}}</td>
			<td>
				<a href="{{URL}}/returnpurchaseorders/delete-from-list/{{$rpo['id']}}">
					<i class="fa fa-remove" data-id="{{$rpo['id']}}"></i>
				</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</form>

<script>
	$(function(){
		$('.table-list-view thead tr:first-child th:not(.no-sort)').on('click',function(){
			var column = $(this).attr('data-column');
			var sort = $(this).attr('data-sort');
			if(sort==undefined){
				sort='asc'
				$(this).attr('data-sort',sort);
			}else{
				if(sort=='asc'){
					sort='desc';
					$(this).attr('data-sort',sort);
				}else{
					$(this).removeAttr('data-sort');
				}
			}
			var data_sort={};
			$('.table-list-view thead tr:first-child th:not(.no-sort)').each(function(key,element){
				if($(element).attr('data-sort') != undefined){
					data_sort[ $(element).attr('data-column') ] =  $(element).attr('data-sort');
				}
				
			});
			$("#input-sort").val( JSON.stringify(data_sort) );
			$('#form-list').submit();
		})

		$('.table-list-view thead tr:nth-child(2) th:not(.no-sort)').on('change',function(){
			$('#form-list').submit();
		});

		$('.table-list-view tbody tr').on("click",function(){
			var id = $(this).attr('data-id');
			window.location = '{{URL}}/returnpurchaseorders/entry/'+id;
		})
	})
</script>