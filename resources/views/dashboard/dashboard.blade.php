<div class="block" style="height: 100%;position:static;">
	<div class="span9">
		<div class="row-fluid pages">
			<ul>
				<li class="span3 primary" data-link="{{URL}}/saleorders/entry">
					<i class="fa fa-file-text-o"></i>
					<strong>Đơn hàng</strong>
					<strong>{{$new_so}}</strong>
				</li>
				<li class="span3 primary" data-link="{{URL}}/returnsaleorders/entry">
					<i class="fa fa-undo"></i>
					<strong>Đại lý trả</strong>
					<strong>{{$new_rso}}</strong>
				</li>
				<li class="span3 primary" data-link="{{URL}}/purchaseorders/entry">
					<i class="fa fa-file-text-o"></i>
					<strong>Mua hàng</strong>
					<strong>{{$new_po}}</strong>
				</li>
				<li class="span3 primary" data-link="{{URL}}/returnpurchaseorders/entry">
					<i class="fa fa-undo"></i>
					<strong>Trả NCC</strong>
					<strong>{{$new_rpo}}</strong>
				</li>
			</ul>
		</div>
		<div class="accordion" id="accordion2" style="margin-bottom: 0;">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle">
						<strong style="font-size:125%;">Doanh số trong tuần</strong>
					</a>
				</div>
				<div id="collapse1" class="accordion-body in collapse" style="height: auto;">
					<div class="accordion-inner">
						<div id="chartContainer" style="height: 300px; width:100%;">
		    				</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="span3">
		<div class="relativeWrap">
			<div class="widget widget-2 widget-body-white">
				<div class="widget-head">
					<h4 class="heading"><i class="fi fi-023" style="width:30px;"></i> Thống kê</h4>
				</div>
				<div class="widget-body list">
					<ul>
						<li><span class="count">{{number_format($tong_san_pham)}}</span> <strong>Tổng sản phẩm</strong></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@section('pageCSS')
	<style type="text/css" media="screen">
		.pages .span3{
			cursor: pointer;
		}
	</style>
@stop
@section('pageJS')
<script src="{{URL}}/scripts/canvasjs/canvasjs.min.js" type="text/javascript"></script>
<script>

	$(function(){
		var doanhso = <?php echo $doanh_so; ?>;
		$.each(doanhso,function(key,element){
			doanhso[key]['x'] = new Date(element['x']);
			doanhso[key]['indexLabel'] = doanhso[key]['y'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		})
		console.log(doanhso)
		var chart  = new CanvasJS.Chart("chartContainer",
		{
			title:{
				//text: "Doanh số trong tuần"
			},
			theme: "theme2",
			axisY :{
				includeZero: true,
				valueFormatString: "#,###"
			},
			axisX: {
				valueFormatString: "DD/MM",
				intervalType: "day"
			},
			data:[
				{
					type: "line",
					markerSize: 15,
					yValueFormatString: "#,###",
					indexLabelFontColor: "#f4544f",
					indexLabelFontFamily: "tahoma",
					dataPoints: doanhso
				}
			]

		});
		chart.render();
		$("a.canvasjs-chart-credit").remove();
		chart.render();

		$(".pages .span3").on("click",function(){
			window.location = $(this).attr('data-link');
		})

	});

	function get_week(d,off){
		var d = new Date(d);
		var day = d.getDate();
		var month = d.getMonth();
		var year = d.getFullYear();
		return new Date(year,month,day-off);
	}
</script>
@stop