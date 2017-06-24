<?php
	$tong_nhap = 0;
?>

@foreach($list_order as $po)
	<tr>
		<td  class="center" >
			{{ date('d-m-Y',strtotime($po['date'])) }}
		</td>
		<td class="center" >{{ $po['id'] }}</td>
		<td>
			@if($po['type']=='po')
				Mua hàng
			@elseif($po['type']=='rpo')
				Đại lý trả
			@elseif($po['type']=='in_stock')
				Tồn đầu
			@endif
		</td>
		<td class="center" >{{ $po['company_name'] }}</td>
		<td class="center" >{{ $po['oum_name'] }}</td>
		<td class="center" >{{ $po['specification'] }}</td>
		<td class="center" >{{ $po['quantity'] }}</td>
		<td class="center" >{{ $po['quantity']*$po['specification'] }} cái</td>
		<?php
			$tong_nhap+=($po['quantity']*$po['specification']);
			$tonkho = floor($po['in_stock']/$po['specification']);
			$view_tonkho = $tonkho.' '.$po['oum_name'];
			if($po['in_stock']%$po['specification'] && $po['specification']!=1){
				$sodu = $po['in_stock']%$po['specification'];
				$view_tonkho .= ' + '.$sodu.' '.'cái';
			}
		?>
		<td  class="center" >
		@if($po['type']!=='rpo')
			{{ $view_tonkho }}
		@endif
		</td>
		@if(!$product['status'])
		<td  class="center" >
			@if($po['type']!=='rpo')
			<button class="btn btn-primary" type="button" onclick="popup_sellprice({{$po['product_id']}})" title="Thêm giá cho sản phẩm" >
				<i class="fa fa-usd"></i>
				Giá bán
			</button>
			@endif
		</td>
		@endif
	</tr>
@endforeach
<tr class="sum">
	<td class="right" colspan="7">Tổng:</td>
	<td style="text-align:center !important;">{{$tong_nhap}} cái</td>
	<td></td>
	<td></td>
</tr>