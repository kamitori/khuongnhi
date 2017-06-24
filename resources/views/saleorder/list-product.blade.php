<?php 
	$sum_amount = 0;
	$user = \Auth::user();
?>
@foreach ($list_product as $product)
<tr data-id="{{$product['id']}}" id="row_product_{{$product['id']}}" class="sort">
	<input type="hidden" id="id" value="{{$product['id']}}">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	@if(!$saleorder['status'])
	<td><i class="fa fa-arrows" style="cursor: move;"></i></td>
	@endif
	<td>{{$product['sku']}}</td>
	<td>{{$product['name']}}</td>
	<td>
		@if($saleorder['status'] || !$user->can("edit-saleorders"))
			
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
		@if($saleorder['status'] || !$user->can("edit-saleorders"))
		{{$product['specification']}}
		@else
		<input type="text" id="specification" name="specification" value="{{$product['specification']}}" data-type="quantity">
		@endif
	</td>
	<td data-type="{{$saleorder['status']?'currency':''}}">
		@if($saleorder['status'] || !$user->can("edit-saleorders"))
			{{$product['sell_price']}}
		@else
		<select class="sell_price" name="sell_price" id="sell_price">
			@foreach($product['getsellprices'] as $sellprice)
			<option value="{{$sellprice['price']}}"  {{$product['sell_price']==$sellprice['price']?'selected':''}} data-type="currency" data-name="{{$sellprice['name']}}">
				{{$sellprice['price']}}
			</option>
		 	@endforeach
		</select>
		@endif
	</td>
	<td>
		@if($saleorder['status'] || !$user->can("edit-saleorders"))
		{{$product['quantity']}}
		@else
		<input type="text" id="quantity" name="quantity" value="{{$product['quantity']}}" data-type="quantity">
		@endif
	</td>
	<td data-type="currency" class="amount">{{$product['amount']}}</td>
	@if(!$saleorder['status'] && $user->can("edit-saleorders"))
	<td><i class="fa fa-remove link" onclick="delete_product(this)"></i></td>
	@endif
</tr>
<?php $sum_amount+= $product['amount'];?>
@endforeach
@if(count($list_product))
<tr class="sum">
	@if(!$saleorder['status'])
	<td colspan="7">Tổng tiền: </td>
	@else
	<td colspan="6">Tổng tiền: </td>
	@endif
	<td data-type="currency" class="right" id="sum_amount">{{$sum_amount}}</td>
	@if(!$saleorder['status'] && $user->can("edit-saleorders"))
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
			sell_price = row.find("#sell_price").val();
			if(sell_price){
				while(sell_price.indexOf(',')>0){
					sell_price = sell_price.replace(',','')
				}
			}
			data['sell_price'] = sell_price;
			data['specification'] = row.find("#specification").val();
			data['quantity'] = row.find("#quantity").val();
			$.ajax({
				url : "{{URL}}/saleorders/update-mproduct",
				type : "POST",
				data : data,
				success : function(data){
					if(data.status == 'success'){
						$("tr[data-id="+id+"]").find(".amount").text(data.amount);
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

		$('.table-list-edit').sortable({
			containerSelector: 'table',
			itemPath: '> tbody',
			handle: 'tr:not(.sum)',
			itemSelector: 'tr:not(.sum)',
			placeholder: '<tr class="placeholder"/>',
			onDrop:function (item, container, _super, event){
				var arr_order = [];
				$('.table-list-edit tr.sort').each(function(key,elem){
					arr_order[$(elem).index()] = $(elem).attr("data-id");
					$(elem).removeClass('dragged');
				});
				console.log(arr_order);
				$.ajax({
					url :'{{URL}}/saleorders/update-order',
					type: 'POST',
					data:{
						arr_order:arr_order
					},
					success:function(data){
						if(data.status == 'success'){
							toastr['success']('Saving success !');
							$.ajax({
								url : '{{URL}}/saleorders/list-product',
								type :'GET',
								success:function(html){
									$("#list_product").html(html);
									$(window).trigger('resize');
								}
							})
						}else{
							toastr['error'](data.message);
						}
					}
				})
			},
			onMousedown:function ($item, _super, event) {
				if (event.target.className === 'fa fa-arrows') {
					event.preventDefault()
					return true;
				}
			}
		});
	})
</script>