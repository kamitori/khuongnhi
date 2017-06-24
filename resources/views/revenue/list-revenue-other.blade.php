@if(count($list_order))
<?php
	$total_sum_amount = 0;
?>
@foreach($list_order as $key => $order)
<tr >
	<td class="center">{{date('d-m-Y',strtotime($order['date']))}}</td>
	<td class="center">{{$order['name']}}</td>
	<td class="center">{{$order['ly_do']}}</td>
	<td  class="right" data-type="currency">{{$order['sum_amount']}}</td>
	<td class="link" onclick="editOther(this)"  data-value="{{json_encode($order)}}"><i class="fa fa-caret-left"></i></td>
</tr>
<?php
	$total_sum_amount += $order['sum_amount'];
?>
@endforeach
<tr class="sum">
	<td class="strong right" colspan="3">Tổng:</td>
	<td  class="right" data-type="currency">{{$total_sum_amount}}</td>
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