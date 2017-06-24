<?php
	$user = \Auth::user();
 ?>
<table class="table table-bordered table-condensed table-striped table-primary table-vertical-center checkboxs js-table-sortable ui-sortable table-list-view">
	<thead>
		<tr>
			<th style="width:15%">STT</th>
			<th style="width:40%">Nhãn</th>
			<th style="width:30%">Giá</th>
			@if($user->can("edit-products"))
			<th style="width:15%">&nbsp;</th>
			@endif
		</tr>
	</thead>
	<tbody style="height:auto !important; position: inherit !important;">
		@foreach($list_price as $key => $price)
		<tr>
			<td>{{($key+1)}}</td>
			<td>{{$price['name']}}</td>
			<td data-type="currency">{{$price['price']}}</td>
			@if($user->can("edit-products"))
			<td class="center">
				<button class="btn btn-primary" type="button" data-value='{{ json_encode($price) }}' onclick="editSellPrice(this)"><i class="fa fa-pencil"></i></button>
				<button class="btn btn-danger" type="button" onclick="deleteSellPrice({{$price['id']}})"><i class="fa fa-remove"></i></button>
			</td>
			@endif
		</tr>
		@endforeach
	</tbody>
</table>
<script>
	$(".table-list-view tbody tr td[data-type=currency]").each(function(){
		value = $(this).text().replace(',','')
		while(value.indexOf(',')>0){
			value = value.replace(',','')
		}
		value = parseInt(value);
		value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		$(this).text(value);
	})
	
</script>