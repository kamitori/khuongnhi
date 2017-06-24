<?php
	$tong_xuat = 0;
?>
@foreach($list_order as $so)
	<tr>
		<td  class="center" >{{ date('d-m-Y',strtotime($so['date'])) }}</td>
		<td  class="center" >{{ $so['id'] }}</td>
		<td  class="center">
			@if($so['type']=='so')
				Đơn hàng
			@elseif($so['type']=='rpo')
				Trả hàng NCC
			@endif
		</td>
		<td  class="center" >{{ $so['company_name'] }}</td>
		<td  class="center" >{{ $so['oum_name'] }}</td>
		<td  class="center" >{{ $so['specification'] }}</td>
		<td  class="center" >{{ $so['quantity'] }}</td>
		<td  class="center" >{{ $so['quantity']*$so['specification'] }} cái</td>
		<?php $tong_xuat+=$so['quantity']*$so['specification']; ?>
	</tr>
@endforeach
<tr class="sum">
	<td colspan="7">Tổng</td>
	<td style="text-align:center !important;">{{$tong_xuat}} cái</td>
</tr>