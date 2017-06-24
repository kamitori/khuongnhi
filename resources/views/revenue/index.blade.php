<div class="heading-buttons main-left">
	<div class="buttons pull-left">
		<a href="{{URL}}/revenues/customer" class="btn btn-small btn-primary btn-icon "><i class="fa fa-plus"></i> Doanh thu KH</a>
		<a href="{{URL}}/revenues/distribute" class="btn btn-small btn-primary btn-icon "><i class="fa fa-plus"></i> Doanh thu NCC</a>
		<a href="{{URL}}/revenues/product" class="btn btn-small btn-primary btn-icon "><i class="fa fa-plus"></i> Doanh thu sản phẩm</a>
		<a href="{{URL}}/revenues/user" class="btn btn-small btn-primary btn-icon "><i class="fa fa-plus"></i> Doanh thu nhân viên</a>
		<a href="{{URL}}/revenues/other" class="btn btn-small btn-primary btn-icon "><i class="fa fa-plus"></i> Chi khác</a>
	</div>
</div>
<div class="block" style="height: 100%;position:static;">
	<div class="span8">
		<div class="accordion" id="accordion2" style="margin-bottom: 0;">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle">
						<h4>Thống kê thu chi</h4>
						<div class="pull-right" style="margin-top: -4px;">
							<select style="width:80px;" id="year_chart">
								@for($i=intval($min_year);$i<=intval($current_year);$i++)
								<option value="{{$i}}">{{$i}}</option>
								@endfor
							</select>
						</div>
					</a>
				</div>
				<div id="collapse1" class="accordion-body in collapse" style="height: auto;">
					<div class="accordion-inner" style="background:#fff;">
						<div id="grap_all" style="height:400px;width:100%">
							
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
	<div class="span4">
		<div class="widget widget-2 widget-body-white">
			<div class="widget-head">
				<h4>&nbsp;</h4>
			</div>
			<div class="widget-body list">
				<ul>
					<li><span class="count"><span data-type="currency">{{$tong_thu}}</span></span> Tổng thu</li>
					<li><span class="count">-<span data-type="currency">{{$tong_chi}}</span></span> Tổng chi</li>
					<li><span class="count">-<span data-type="currency">{{$chi_khac}}</span></span> Chi khác</li>
					<li><span class="count"><span data-type="currency">{{$tong_thu - $tong_chi -$chi_khac}}</span></span> Còn lại</li>
				</ul>
			</div>
		</div>
	</div>
</div>
@section('pageCSS')
<style type="text/css" media="screen">
	.block .span4,.block .span8{
		display:inline-block;
		float:none;
		vertical-align: top;
	}
	.block .span4{
		width:31%;
	}

	.block .span8{
		margin-left: 1%;
		width:65.358974%;
	}
	#modal_paid{
		width: 88%;
		margin-left: -44%;
	}
	@media (max-width: 767px) {
		.block .span8{
			width:100% !important;
		}
		.block .span4{
			width:100% !important;
		}
		#modal_paid{
			width: 100% !important;
			margin-left: -4% !important;
		}
	}
	#modal_paid .select2{
		width:84.5% !important;
	}
	.select2-hidden-accessible{
		width:0 !important;
	}
	.toggle-on,.toggle-off{
		line-height: 13px !important;
	}
	#grap_all{
		opacity: 0;
		-webkit-transition: all 500ms cubic-bezier(0.860, 0.000, 0.070, 1.000); 
		-moz-transition: all 500ms cubic-bezier(0.860, 0.000, 0.070, 1.000); 
		-o-transition: all 500ms cubic-bezier(0.860, 0.000, 0.070, 1.000); 
		transition: all 500ms cubic-bezier(0.860, 0.000, 0.070, 1.000); /* easeInOutQuint */
		
		-webkit-transition-timing-function: cubic-bezier(0.860, 0.000, 0.070, 1.000); 
		-moz-transition-timing-function: cubic-bezier(0.860, 0.000, 0.070, 1.000); 
		-o-transition-timing-function: cubic-bezier(0.860, 0.000, 0.070, 1.000); 
		transition-timing-function: cubic-bezier(0.860, 0.000, 0.070, 1.000); /* easeInOutQuint */
	}
</style>
@stop
@section('pageJS')
<script src="{{URL}}/scripts/canvasjs/canvasjs.js" type="text/javascript"></script>
<script>
	var tong_thu = <?php echo json_encode($list_chart['tong_thu']) ?>;
	var tong_chi = <?php echo json_encode($list_chart['tong_chi']) ?>;
	var chi_khac = <?php echo json_encode($list_chart['chi_khac']) ?>;
	var chart = new CanvasJS.Chart("grap_all",
	{
		axisY:{
			// interval: 50000000,
			padding:100
		},
		axisX: {
			interval:1,
			valueFormatString: "0#",
		},
		data: [
			{        
				type: "column",
				legendText: "Thu khách hàng",
				showInLegend: "true",
				toolTipContent: "{name} tháng {x}:<br/><center><strong>{y}</strong></center>",
				name:"Thu khách hàng",
				dataPoints: tong_thu
			},
			{
				type: "column",
				legendText: "Chi khách hàng",
				showInLegend: "true",
				toolTipContent: "{name} tháng {x}:<br/><center><strong>{y}</strong></center>",
				name:"Chi khách hàng",
				dataPoints: tong_chi
			},
			{
				type: "column",
				legendText: "Chi khác",
				showInLegend: "true",
				toolTipContent: "{name} tháng {x}:<br/><center><strong>{y}</strong></center>",
				name:"Chi khác",
				dataPoints: chi_khac
			}
		],
		legend:{
			cursor:"pointer",
			itemclick: function(e){
				if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
					e.dataSeries.visible = false;
				}
				else {
					e.dataSeries.visible = true;
				}
				chart.render();
			}
		},
	});
	chart.render();
	$("#year_chart").on('change',function(){
		var year = $(this).val();
		$.ajax({
			url : '{{URL}}/revenues/list-revenue/'+year,
			type : 'GET',
			success : function(data){
				tong_thu = data.tong_thu;
				tong_chi = data.tong_chi;
				chi_khac = data.chi_khac;
				chart.options.data=[
					{        
						type: "column",
						legendText: "Thu khách hàng",
						showInLegend: "true",
						toolTipContent: "{name} tháng {x}:<br/><center><strong>{y}</strong></center>",
						name:"Thu khách hàng",
						dataPoints: tong_thu
					},
					{
						type: "column",
						legendText: "Chi khách hàng",
						showInLegend: "true",
						toolTipContent: "{name} tháng {x}:<br/><center><strong>{y}</strong></center>",
						name:"Chi khách hàng",
						dataPoints: tong_chi
					},
					{
						type: "column",
						legendText: "Chi khác",
						showInLegend: "true",
						toolTipContent: "{name} tháng {x}:<br/><center><strong>{y}</strong></center>",
						name:"Chi khác",
						dataPoints: chi_khac
					}
				];
				chart.render();
				$("#grap_all").css('opacity',1);
			}
		})

	});
	$(window).resize();
	$("#year_chart").trigger('change')
</script>
@stop