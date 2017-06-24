@if(count($list_order))
	<?php 
		$tong_doanh_so = 0;
		$tong_khoang_giam = 0;
		$tong_gia_von = 0;
		$tong_lai = 0;
		$tong_loi_nhuan = 0;
	?>
	@foreach($list_order as $order)
	<tr>
		<!-- <td class="center">{{date('d-m-Y',strtotime($order['date']))}}</td> -->
		<td class="center">{{$order['name']}}</td>
		<td class="right" data-type="currency">{{$order['sum_invest']}}</td>
		<td class="right" data-type="currency">{{$order['sum_amount']}}</td>
		<td class="right" data-type="currency">{{$order['khoang_giam']}}</td>
		<td class="right" data-type="currency">{{$order['lai']}}</td>
		<td class="right"><span data-type="percent">{{number_format(((float)$order['lai']/(float)$order['sum_invest'])*100,2)}}</span>%</td>
		<td class="right" data-type="currency">{{$order['loi_nhuan']}}</td>

		<?php
			$tong_doanh_so += $order['sum_amount'];
			$tong_khoang_giam += $order['khoang_giam'];
			$tong_gia_von += $order['sum_invest'];
			$tong_lai += $order['lai'];
			$tong_loi_nhuan +=$order['loi_nhuan'];
		?>
	</tr>
	@endforeach
	<tr class="sum">
		<td class="right"><strong>Tổng cộng:</strong></td>
		<td class="right" data-type="currency">{{$tong_gia_von}}</td>
		<td class="right" data-type="currency">{{$tong_doanh_so}}</td>
		<td class="right" data-type="currency">{{$tong_khoang_giam}}</td>
		<td class="right" data-type="currency">{{$tong_lai}}</td>
		<td></td>
		<td class="right" data-type="currency">{{$tong_loi_nhuan}}</td>
	</tr>
	<tr class="sum">
		<td colspan="6" class="right">Chi khác:</td>
		<td class="right" data-type="currency">{{-$chi_khac}}</td>
	</tr>
	<tr class="sum">
		<td colspan="6" class="right">Lãi thực:</td>
		<td class="right" data-type="currency">{{$tong_loi_nhuan - $chi_khac}}</td>
	</tr>
@endif
<style type="text/css" media="screen">
	*[data-type=currency],*[data-type=percent]{
		font-weight: bold;
	}
</style>
<script>
	datatype_currency();
</script>