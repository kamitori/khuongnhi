<?php 
	$user = Auth::user();
?>
<div class="heading-buttons main-left">
	<div class="buttons pull-left">
		<a href="{{URL}}/products/create" class="btn btn-small btn-primary btn-icon "><i class="fa fa-plus"></i> Thêm</a>
		<a href="{{URL}}/products/entry" class="btn btn-small btn-primary btn-icon "><i class="fa fa-list-alt"></i> Chi tiết</a>
		<a href="javascript:window.open('{{URL}}/products/export-pdf','_blank');" class="btn btn-small btn-primary btn-icon "><i class="fa fa-print"></i> Xuất PDF</a>
		<a href="javascript:window.open('{{URL}}/products/export-excel','_blank');" class="btn btn-small btn-primary btn-icon "><i class="fa fa-print"></i> Xuất Excel</a>
		<a href="{{URL}}/products/ton-dau-thang" class="btn btn-small btn-primary btn-icon "><i class="fa fa-list"></i> Tổn đầu tháng</a>
		@if($user->can("view-history"))
		<a href="{{URL}}/products/log" class="btn btn-small btn-primary btn-icon "><i class="fa fa-clock-o"></i> Lịch sử</a>
		@endif
	</div>
	<div class="buttons span3" style="line-height: 30px;"><h5>Tổng vốn lưu: {{number_format($sum_invest)}}</h5></div>
	<div class="buttons pull-right">

		<div class="pagination pagination-small pull-right" style="margin: -15px 20px 5px 20px;">
			<?php echo $list_product->render(); ?>
		</div>
	</div>
</div>
<form action="{{URL}}/products/list" method="POST" accept-charset="utf-8" id="form-list">

<input type="hidden" id="input-sort" name="input-sort">
<input type="hidden" id="like_name" name="input-filter[like_name]">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<table class="table table-bordered table-condensed table-striped table-primary table-vertical-center table-list-view">
	<thead>
		<tr class="small">
			<th style="width: 4%" data-column="id" {{ isset($arr_sort['id'])?'data-sort='.$arr_sort['id']:'' }}>Mã</th>
			<th style="width: 10%" data-column="sku" {{ isset($arr_sort['sku'])?'data-sort='.$arr_sort['sku']:'' }}>SKU</th>
			<th style="width: 18%" data-column="name" {{ isset($arr_sort['name'])?'data-sort='.$arr_sort['name']:'' }}>Tên sản phẩm</th>
			<th style="width: 15%" data-column="company_id" {{ isset($arr_sort['company_id'])?'data-sort='.$arr_sort['company_id']:'' }}>Nhà cung cấp</th>
			<th style="width: 7%" data-column="oum_id" {{ isset($arr_sort['oum_id'])?'data-sort='.$arr_sort['oum_id']:'' }}>Đơn vị</th>
			<th style="width: 7%" data-column="specification" {{ isset($arr_sort['specification'])?'data-sort='.$arr_sort['specification']:'' }}>Quy cách</th>
			<th style="width: 12%" data-column="in_stock" {{ isset($arr_sort['in_stock'])?'data-sort='.$arr_sort['in_stock']:'' }}>Tồn kho</th>
			<th style="width: 7%" data-column="origin_price" {{ isset($arr_sort['origin_price'])?'data-sort='.$arr_sort['origin_price']:'' }}>Giá gốc</th>
			<th style="width: 8%" data-column="status" {{ isset($arr_sort['status'])?'data-sort='.$arr_sort['status']:'' }}>Tình trạng</th>
			<th style="width: 12%" data-column="invest" {{ isset($arr_sort['invest'])?'data-sort='.$arr_sort['invest']:'' }}>Vốn lưu</th>
		</tr>
		<tr class="sort">
			<th style="width: 4%">
			</th>
			<th style="width: 10%">
				<select name="input-filter[sku]" id="sku" data-type="select2">
					<option value="">&nbsp;</option>
					@foreach($list_all_product as $sku)
						<option value="{{$sku['sku']}}" {{$arr_filter['sku']==$sku['sku']?'selected':''}}>{{$sku['sku']}}</option>
					@endforeach
				</select>
			</th>
			<th style="width:18%">
				<select name="input-filter[name]" id="name" data-type="select2">
					<option value="">&nbsp;</option>
					@foreach($list_all_product as $name)
						<option value="{{$name['name']}}" {{$arr_filter['name']==$name['name']?'selected':''}}>{{$name['name']}}</option>
					@endforeach
				</select>
			</th>
			<th style="width:15%">
				<select name="input-filter[company_id]" id="company_id" data-type="select2">
					<option value="">&nbsp;</option>
					@foreach($distributes as $company)
						<option value="{{$company['id']}}" {{$arr_filter['company_id']==$company['id']?'selected':''}}>{{$company['name']}}</option>
					@endforeach
				</select>
			</th>
			<th style="width: 7%">
				<select name="input-filter[oum_id]" id="oum_id">
					<option value="">&nbsp;</option>
					@foreach($oums as $oum)
						<option value="{{$oum['id']}}" {{$arr_filter['oum_id']==$oum['id']?'selected':''}}>{{$oum['name']}}</option>
					@endforeach
				</select>
			</th>
			<th style="width: 7%">
			</th>
			<th style="width: 12%">
			</th>
			
			<th style="width: 7%"></th>
			<th style="width: 8%">
				<select name="input-filter[status]" id="status">
					<option value="">&nbsp;</option>
					<option value="0" {{$arr_filter['status']=='0'?'selected':''}}>Mới</option>
					<option value="1" {{$arr_filter['status']=='1'?'selected':''}}>Hoàn thành</option>
				</select>
			</th>
			<th style="width: 12%"></th>
		</tr>
	</thead>
	<tbody>
		@foreach ($list_product as $key => $product)
		<tr class="selectable" data-id="{{$product['id']}}">
			<td>{{($product['id'])}}</td>
			<td>{{$product['sku']}}</td>
			<td><a href="{{URL}}/products/{{$product['id']}}">{{$product['name']}}</a></td>
			<td><a href="{{URL}}/companies/{{$product['company_id']}}">{{$product['company_name']}}</a></td>
			<td>{{$product['oum_name']}}</td>
			<td>{{$product['specification']}}</td>
			<?php
				$view_tonkho = '';
				if($product['specification'] !=0 ){
					$tonkho = floor($product['in_stock']/$product['specification']);
					$view_tonkho = $tonkho.' '.$product['oum_name'];
					if($product['in_stock']%$product['specification'] && $product['specification']!=1){
						$sodu = $product['in_stock']%$product['specification'];
						$view_tonkho .= ' + '.$sodu.' '.'cái';
					}
				}
			?>
			<td>{{$view_tonkho}}</td>
			<td data-type="currency">{{isset($product['origin_price'])?$product['origin_price']:0}}</td>
			<td>{{$product['status']==1?'Hoàn thành':'Mới'}}</td>
			<td data-type="currency">{{($product['origin_price']*$product['in_stock'])}}</td>
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
			window.location = '{{URL}}/products/entry/'+id;
		})

		var create = 1;
		$("#name").on('select2:open',function(e){
			if(create){
				$("#select2-name-results").parent().prev().find('input').val($("#like_name").val());
				$("#select2-name-results").parent().prev().find('input').css('width','80%').css('float','left');
				$("#select2-name-results").parent().prev().append('<button style="  margin-left: 3px;  margin-bottom: 2px; line-height: 14px;" id="search_by_name" onclick="search_list_by_name(this)"><i class="fa fa-search"></i></button >')
				create =0;
			}
		});
	})

	function search_list_by_name(obj){
		$("#like_name").val($(obj).prev().val());
		$('#form-list').submit();
	}
</script>