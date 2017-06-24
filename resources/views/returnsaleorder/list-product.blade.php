<?php 
	$sum_amount = 0;
	$user = Auth::user();
?>
@foreach ($list_product as $product)
<tr data-id="{{$product['id']}}" id="row_product_{{$product['id']}}">
	<input type="hidden" id="id" value="{{$product['id']}}">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<td>{{$product['sku']}}</td>
	<td>{{$product['name']}}</td>
	<td>
		@if($returnsaleorder['status'] || !$user->can("edit-returnsaleorders"))
			
			@foreach($oums as $oum)
				{{$product['oum_id']==$oum['id']?$oum['name']:''}}
		 	@endforeach
		 	
		@else
		<select class="oum_id" name="oum_id" id="oum_id">
			@foreach($oums as $oum)
			<option value="{{$oum['id']}}"  
					<?php 
						if($product['oum_id']){
							if ($product['oum_id']==$oum['id'])  echo ' selected';
							else echo ''; 
						}else{
							if($oum['name']=='Cái') echo 'selected';
						} 
					?> 
			>
				{{$oum['name']}}
			</option>
		 	@endforeach
		</select>
		@endif
	</td>
	<td>
		@if($returnsaleorder['status'] || !$user->can("edit-returnsaleorders"))
		{{$product['specification']}}
		@else
		<input type="text" id="specification" name="specification" value="{{$product['specification']}}" data-type="quantity">
		@endif
	</td>
	<td data-type="currency" id="sell_price">
			{{$product['sell_price']}}
	</td>
	<td>
		@if($returnsaleorder['status'] || !$user->can("edit-returnsaleorders"))
		{{$product['quantity']}}
		@else
		<input type="text" id="quantity" name="quantity" value="{{$product['quantity']}}" data-type="quantity">
		@endif
	</td>
	<td data-type="currency" class="amount">{{$product['amount']}}</td>
	@if(!$returnsaleorder['status'] && $user->can("edit-returnsaleorders"))
	<td><i class="fa fa-remove link" onclick="delete_product(this)"></i></td>
	@endif
</tr>
<?php $sum_amount+= $product['amount'];?>
@endforeach
@if(count($list_product))
<tr class="sum">
	<td colspan="6">Tổng tiền: </td>
	<td data-type="currency" class="right" id="sum_amount">{{$sum_amount}}</td>
	@if(!$returnsaleorder['status'] && $user->can("edit-returnsaleorders"))
	<td></td>
	@endif
</tr>
@endif
<script>

	$(function(){
		datatype_currency();
		datatype_number();
		datatype_quantity();
		select_table();
		var old_quantity = 0;
		var old_specification = 0;
		$("#list_product input#quantity").on('focusin', function(){
			old_quantity = $(this).val();
		});
		$("#list_product input#specification").on('focusin', function(){
			old_specification = $(this).val();
		});

		$("#list_product select, #list_product input").on('change',function(e){
			e.preventDefault();
			var id_input = $(this).attr('id');
			var id = $(this).parent().parent().attr('data-id');
			var row = $("#row_product_"+id);
			data = {};
			data['id'] = row.find("#id").val();
			data['oum_id'] = row.find("#oum_id").val();
			sell_price = row.find("#sell_price").text();
			if(sell_price){
				while(sell_price.indexOf(',')>0){
					sell_price = sell_price.replace(',','')
				}
			}
			data['sell_price'] = sell_price;
			data['specification'] = row.find("#specification").val();
			data['quantity'] = row.find("#quantity").val();
			$.ajax({
				url : "{{URL}}/returnsaleorders/update-mproduct",
				type : "POST",
				data : data,
				success : function(data){
					if(data.status == 'success'){
						$("tr[data-id="+id+"]").find(".amount").text(data.amount);
						console.log($("#row_product_"+id).find(".amount"));
						toastr['success']('Saving success !');
						sum_amount();
						old_quantity = row.find("#quantity").val();
						old_specification = row.find("#specification").val();
					}else{
						toastr['error'](data.message);
						if(id_input=='quantity'){
							$("tr[data-id="+id+"]").find("#quantity").val(old_quantity);
						}else{
							console.log(old_specification);
							$("tr[data-id="+id+"]").find("#specification").val(old_specification);
						}
					}
					
				}
			})
		})
	})
</script>