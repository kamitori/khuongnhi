@if(count($list_order))
<?php
	$total_sum_amount = 0;
	$total_paid = 0;
	$total_con_lai= 0;
	$total_no_cu= 0;
?>
@foreach($list_order as $key => $order)
<tr >
	<td class="center">{{$order['company_name']}}</td>
	<td  class="right" data-type="currency">{{$order['sum_amount']}}</td>
	<td  class="right" data-type="currency">{{$order['paid']}}</td>
	<td  class="right" data-type="currency">{{$order['no_cu']}}</td>
	<td  class="right" data-type="currency">{{$order['con_lai']}}</td>
</tr>
<?php
	$total_sum_amount += $order['sum_amount'];
	$total_paid += $order['paid'];
	$total_con_lai += $order['con_lai'];
	$total_no_cu += $order['no_cu']
?>
@endforeach
<tr>
	<td class="strong right">Tổng</td>
	<td  class="right" data-type="currency">{{$total_sum_amount}}</td>
	<td  class="right" data-type="currency">{{$total_paid}}</td>
	<td  class="right" data-type="currency">{{$total_no_cu}}</td>
	<td  class="right" data-type="currency">{{$total_con_lai}}</td>
</tr>
@endif
<style type="text/css" media="screen">
	*[data-type=currency]{
		font-weight: bold;
	}
</style>
<script>
	datatype_currency();
</script>