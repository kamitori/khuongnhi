@if(count($list_order))
<?php
	$total_sum_amount = 0;
	$total_paid = 0;
	$total_con_lai= 0;
?>
@foreach($list_order as $key => $order)
<tr >
	<td class="center">{{date('d-m-Y',strtotime($order['date']))}}</td>
	<td  class="right" data-type="currency">{{$order['sum_amount']}}</td>
	<td  class="right" data-type="currency">{{$order['paid']}}</td>
	<td  class="right" data-type="currency">{{$order['no_cu']}}</td>
	<td  class="right" data-type="currency">{{$order['con_lai']}}</td>
	<td>{{$order['hinh_thuc']}}</td>
	@if($order['paid'])
	<td class="link" onclick="editPaid(this)"  data-value="{{json_encode($order)}}"><i class="fa fa-caret-left"></i></td>
	@elseif($order['sum_amount']>0)
	<td><a href="{{URL}}/purchaseorders/{{$order['id']}}" title=""><i class="fa fa-caret-left"></i></a></td>
	@else
	<td><a href="{{URL}}/returnpurchaseorders/{{$order['id']}}" title=""><i class="fa fa-caret-left"></i></a></td>
	@endif
</tr>
<?php
	$total_sum_amount += $order['sum_amount'];
	$total_paid += $order['paid'];
	$total_con_lai = $order['con_lai'];
?>
@endforeach
<tr>
	<td class="strong right">Tổng</td>
	<td  class="right" data-type="currency">{{$total_sum_amount}}</td>
	<td  class="right" data-type="currency">{{$total_paid}}</td>
	<td  class="right"> </td>
	<td  class="right" data-type="currency">{{$total_con_lai}}</td>
	<td></td>
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