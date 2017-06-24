<div class="heading-buttons main-left">
	<div class="pagination pagination-small pull-right" style="margin: -15px 20px 5px 20px;" id="paginate_popup">
		<?php echo $list_product->render(); ?>
	</div>
</div>
<?php
	$session_product = session('product_of_rso'.session('current_returnsaleorder'));
?>

<form action="{{URL}}/products/list" method="POST" accept-charset="utf-8" id="form-list">
	<input type="hidden" id="input-sort" name="input-sort">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<table class="table table-bordered table-condensed table-striped table-primary table-vertical-center table-list-view">
		<thead>
			<tr class="small">
				<th style="width: 4%">
					Chọn
				</th>
				<th style="width: 8%" data-column="id" {{ isset($arr_sort['id'])?'data-sort='.$arr_sort['id']:'' }}>STT</th>
				<th style="width: 12%" data-column="sku" {{ isset($arr_sort['sku'])?'data-sort='.$arr_sort['sku']:'' }}>SKU</th>
				<th style="width: 25%" data-column="name" {{ isset($arr_sort['name'])?'data-sort='.$arr_sort['name']:'' }}>Tên sản phẩm</th>
				<th style="width: 25%">Nhà cung cấp</th>
				<th style="width: 8%">ĐVT</th>
				<th style="width: 8%">Quy cách</th>
				<th style="width: 10%">Số lượng</th>
			</tr>
			<tr class="sort">
				<th style="width: 4%" class="center no-sort">
					<input type="checkbox" id="check_all" value="">
				</th>
				<th style="width: 4%">
				</th>
				<th style="width: 12%">
					<select name="input-filter[sku]" id="sku" data-type="select2">
						<option value="">&nbsp;</option>
						@foreach($list_all_product as $sku)
							<option value="{{$sku['sku']}}" {{$arr_filter['sku']==$sku['sku']?'selected':''}}>{{$sku['sku']}}</option>
						@endforeach
					</select>
				</th>
				<th style="width:27%">
					<select name="input-filter[name]" id="name" data-type="select2">
						<option value="">&nbsp;</option>
						@foreach($list_all_product as $name)
							<option value="{{$name['name']}}" {{$arr_filter['name']==$name['name']?'selected':''}}>{{$name['name']}}</option>
						@endforeach
					</select>
				</th>
				<th style="width:27%">
					
				</th>
				<th style="width:8%">
					<select name="input-filter[oum_id]" id="oum_id">
						<option value="">&nbsp;</option>
						@foreach($oums as $oum)
							<option value="{{$oum['id']}}" {{$arr_filter['oum_id']==$oum['id']?'selected':''}}>{{$oum['name']}}</option>
						@endforeach
					</select>
				</th>
				<th style="width:8%">
				</th>
				<th style="width:10%">
				</th>
			</tr>
		</thead>
		<tbody style="position: relative !important;">
			@foreach ($list_product as $key => $product)

			<tr class="selectable" data-id="{{$product['id']}}" >
				<td  style="width: 3%" class="center"><input type="checkbox" value="" class="chk_product" data-id="{{$product['id']}}" {{ isset( $session_product[$product['id']] )?'checked':''}}> </td>
				<td>{{($product['id'])}}</td>
				<td>{{$product['sku']}}</td>
				<td>{{$product['name']}}</td>
				<td>{{$product['company_name']}}</td>
				<td>{{$product['oum']['name']}}</td>
				<td>{{$product['specification']}}</td>
				<?php
					$view_tonkho = $product['quantity'].' '.$product['oum']['name'];
					if($product['so_le'] && $product['specification']!=1){
						$view_tonkho .= ' + '.$product['so_le'].' '.'cái';
					}
				?>
				<td>{{$view_tonkho}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</form>

<div class="heading-buttons main-left">
	<div class="pagination pagination-small pull-right" style="margin: -15px 20px 5px 20px;" id="paginate_popup">
		<?php echo $list_product->render(); ?>
	</div>
</div>


<style type="text/css" media="screen">
	.table-primary{
		overflow: hidden;
	}
</style>
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
			data = $("#form-list").serialize();
			$.ajax({
				url : '{{URL}}/products/list-popup-rso',
				type : 'POST',
				data : data,
				success : function(html){
					$("#form-list select[data-type=select2]").select2('destroy');
					$("#list_product_popup").html(html);
					$("#modal_add_product").modal("show");
					$("#form-list select[data-type=select2]").each(function(key,element){
						$(element).select2();
					});
				}
			})
		})

		$('.table-list-view thead tr:nth-child(2) th:not(.no-sort)').on('change',function(){
			data = $("#form-list").serialize();
			$.ajax({
				url : '{{URL}}/products/list-popup-rso',
				type : 'POST',
				data : data,
				success : function(html){
					$("#form-list select[data-type=select2]").select2('destroy');
					$("#list_product_popup").html(html);
					$("#modal_add_product").modal("show");
					$("#form-list select[data-type=select2]").each(function(key,element){
						$(element).select2();
					});
				}
			})
		});

		$('.table-list-view tbody tr td:not(:first-child)').bind("click",function(){
			$('.table-list-view tbody tr td:not(:first-child)').unbind("click");
			var id = $(this).parent().attr('data-id');
			var current = $("input[type=checkbox][data-id="+id+"]").is(":checked");
			$(".chk_product[data-id="+id+"]").prop("checked", !current);
			$(".chk_product[data-id="+id+"]").trigger("change");
		})

		$("#check_all").on('change',function(){
			$(".chk_product").prop('disabled',true);
			$(".chk_product").prop('checked',$("#check_all").prop('checked'));
			var arr_check = [];
			$(".chk_product").each(function(key,element){
				arr_check.push($(element).attr('data-id'));
			})
			if($("#check_all").is(':checked')){
				$.ajax({
					url : '{{URL}}/returnsaleorders/add-product-session',
					type : 'POST',
					data:{
						id : arr_check
					},
					success:function(data){
						console.log(data)
						$(".chk_product").prop('disabled',false);
					}
				});
			}else{
				$.ajax({
					url : '{{URL}}/returnsaleorders/remove-product-session',
					type : 'POST',
					data:{
						id : arr_check
					},
					success:function(data){
						console.log(data)
						$(".chk_product").prop('disabled',false);
					}
				});
			}
		})

		$("#paginate_popup ul li a").on("click",function(e){
			e.preventDefault();
			data = $("#form-list").serialize();
			var link = $(this).attr('href');
			$.ajax({
				url : link,
				type : 'POST',
				data : data,
				success : function(html){
					$("#form-list select[data-type=select2]").select2('destroy');
					$("#list_product_popup").html(html);
					$("#modal_add_product").modal("show");
					$("#form-list select[data-type=select2]").each(function(key,element){
						$(element).select2();
					});
				}
			})
		})
		var check = true;
		$(".chk_product").each(function(){
			check = check && $(this).is(":checked");
			$("#check_all").prop("checked",check);
		})
		$(".chk_product").on("change",function(e){
			e.preventDefault();
			var id = $(this).attr('data-id');
			$(".chk_product").prop('disabled',true);
			if($(this).is(":checked")){
				$.ajax({
					url : '{{URL}}/returnsaleorders/add-product-session',
					type : 'POST',
					data:{
						id : [id]
					},
					success:function(data){
						console.log(data)
						$(".chk_product").prop('disabled',false);
						bind_click();
					}
				});
			}else{
				$.ajax({
					url : '{{URL}}/returnsaleorders/remove-product-session',
					type : 'POST',
					data:{
						id : [id]
					},
					success:function(data){
						console.log(data)
						$(".chk_product").prop('disabled',false);
						bind_click();
					}
				});
			}
		});


	})

	function bind_click(){
		$('.table-list-view tbody tr td:not(:first-child)').bind("click",function(){
			$('.table-list-view tbody tr td:not(:first-child)').unbind("click");
			var id = $(this).parent().attr('data-id');
			var current = $("input[type=checkbox][data-id="+id+"]").is(":checked");
			$(".chk_product[data-id="+id+"]").prop("checked", !current);
			$(".chk_product[data-id="+id+"]").trigger("change");
		})
	}
</script>