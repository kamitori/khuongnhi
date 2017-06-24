<div class="heading-buttons main-left">
	<div class="buttons pull-left">
		
	</div>
	<div class="buttons pull-right">
		<a href="javascript:window.open('{{URL}}/revenues/export-pdf-product','_blank');" class="btn btn-small btn-primary btn-icon "><i class="fa fa-print"></i> Xuất PDF</a>
		<a href="" class="btn btn-small btn-primary btn-icon "><i class="fa fa-list"></i> Xuất Excel</a>
	</div>
</div>

<div class="block" style="height: 100%;position:static;">
	<div class="span3 bs-docs-sidebar">
		<div class="accordion" id="accordion2" style="margin-bottom: 0;">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle">
						<!-- <strong>Danh sách khách hàng</strong> -->
					</a>
				</div>
				<div id="collapse1" class="accordion-body in collapse" style="height: auto;">
					<div class="accordion-inner" style="padding:0;">
						<div id="sort_receipt" style="margin-bottom: 10px;">
							<div class="date" style="margin-left: 1.5%;">
								<select id="month" class="span12">
									<option value="all">Xem tất cả</option>
									<?php
										$current_month = intval(date('m'));
									?>
									@for($i=1;$i<13;$i++)
										<option value="{{$i}}">Tháng {{$i}}</option>
									@endfor		
								</select>
							</div>
							<div class="date right" style="width:48%;">
								<select id="year" class="span12">
									<option value="all">Xem tất cả</option>
								<?php 
									$current_year = intval(date('Y'));
								?>
									@for($i=$min_year;$i <= $current_year;$i++)
										<option value="{{$i}}">Năm {{$i}}</option>
									@endfor	
								</select>
							</div>
						</div>
						<ul class="nav bs-docs-sidenav affix-top left-list">
							@foreach($arr_month_year as $value)
								<li data-year="{{$value['year']}}" data-month="{{$value['month']}}">
									<span  class='date'>Tháng {{$value['month']}} - {{$value['year']}}</span>
								</li>
							@endforeach
						</ul>
						<br/>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="span9" id="content_setting">
		<div class="accordion" id="accordion2" style="margin-bottom: 0;">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle">
						<strong>
							Doanh thu theo sản phẩm <span id="date_name"></span>
						</strong>
					</a>
				</div>
				<div id="collapse1" class="accordion-body in collapse" style="height: auto;">
					<div class="accordion-inner">
						<table class="table table-bordered table-condensed table-striped table-primary table-vertical-center">
							<thead>
								<tr class="small">
									<!-- <th class="center">Ngày</th> -->
									<th class="center">Sản phẩm</th>
									<th class="center">Giá vốn</th>
									<th class="center">Doanh Thu</th>
									<th class="center">Khoảng giảm</th>
									<th class="center">Lãi</th>
									<th class="center">Tỷ lệ lãi</th>
									<th class="center">Lợi nhuận</th>
								</tr>
							</thead>
							<tbody id="list-revenue">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@section('pageCSS')
	<style type="text/css" media="screen">
		.block .span3,.block .span9{
			display:inline-block;
			float:none;
			vertical-align: top;
		}
		.block .span3{
			width:23%;
		}

		.block .span9{
			margin-left: 1%;
			width:75.358974%;
		}
		#modal_paid{
			width: 88%;
			margin-left: -44%;
		}
		@media (max-width: 767px) {
			.block .span9{
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
	</style>
@stop
@section('pageJS')
<script>
	$(window).resize();
	var current_user = 0;
	$(".left-list li").on('click',function(){
		$("#date_name").text($(this).find(".date").text());
		var month = $(this).attr('data-month');
		var year = $(this).attr('data-year');
		current_month = month;
		current_year = year;
		$.ajax({
			url : '{{URL}}/revenues/list-revenue-product',
			type : 'POST',
			data :{
				'month' : month,
				'year' : year
			},
			success : function(data){
				$("#list-revenue").html(data);
			}
		})
	})

	$("#company_select").on('change',function(){
		var id = $(this).val();
		if(id!='all'){
			$(".left-list li").hide();
			$(".left-list li[data-id="+id+"]").show();
			$(".left-list li[data-id="+id+"]").click();
		}else{
			$(".left-list li").show();
		}
	})

	$("#month,#year").on('change',function(){
		var month = $("#month").val();
		var year = $("#year").val();
		if(month=='all'){
			if(year=="all"){
				$(".left-list li").show();
			}else{
				$(".left-list li").hide();
				$(".left-list li[data-year="+year+"]").show();
				current_year = year;
			}
			
		}else{
			if(year=="all"){
				$(".left-list li").hide();
				$(".left-list li[data-month="+month+"]").show();
			}else{
				$(".left-list li").hide();
				$(".left-list li[data-year="+year+"]").show();
				$(".left-list li[data-year="+year+"][data-month="+month+"]").click();
			}
		}
		
	})

	resizeLeftList();
	$(window).resize(function(){
		resizeLeftList();
	})
	function resizeLeftList(){
		var top = $(".left-list").offset()['top'];
		var height =  $(window).height() - top-120;
		$(".left-list").height(height);
		$(".left-list").css({'overflow-y':'auto','overflow-x':'hidden'});
	}

</script>
@stop