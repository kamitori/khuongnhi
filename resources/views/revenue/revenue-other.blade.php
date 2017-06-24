<div class="heading-buttons main-left">
	<div class="buttons pull-left">
		
	</div>
	<div class="buttons pull-right">
		<a href="javascript:addOther()" class="btn btn-small btn-primary btn-icon "><i class="fa fa-plus"></i> Thêm chi khác</a>
		<a href="" class="btn btn-small btn-primary btn-icon "><i class="fa fa-list-alt"></i> Xuất PDF</a>
		<a href="" class="btn btn-small btn-primary btn-icon "><i class="fa fa-list"></i> Xuất Excel</a>
	</div>
</div>

<div class="block" style="height: 100%;position:static;">
	<div class="span3 bs-docs-sidebar">
		<div class="accordion" id="accordion2" style="margin-bottom: 0;">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle">
						<strong>&nbsp;</strong>
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
								<li data-year="{{$value['year']}}" data-month="{{$value['month']}}" onclick="loadOther(this)">
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
							Chi khác <span id="date_name"></span>
						</strong>
					</a>
				</div>
				<div id="collapse1" class="accordion-body in collapse" style="height: auto;">
					<div class="accordion-inner">
						<table class="table table-bordered table-condensed table-striped table-primary table-vertical-center">
							<thead>
								<tr class="small">
									<th class="center">Ngày</th>
									<th class="center">Người chi</th>
									<th class="center">Lý do chi</th>
									<th class="center">Tổng chi</th>
									<th class="center">&nbsp;</th>
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
@section('otherPage')
<div id="modal_other" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- dialog header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h5>Thêm chi khác</h5>
			</div>
			<!-- dialog body -->
			<form  method="post" accept-charset="utf-8" id="form_other">
			<div class="modal-body">
				<div class="row-fluid form_detail">
					<div class="span6">
						<input type="hidden" id="other_id" value="">
						<div class="control-group">
							<label class="control-label">Ngày:</label>
							<div class="controls">
								<input type="text" id="date" name="date" class="datepicker" value="{{ date('d-m-Y') }}" readonly="" style="background-color: #fff;">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Người chi:</label>
							<div class="controls">
								<select id="user_other" width="auto" data-type="select2">
									@foreach($users as $user)
									<option value="{{$user['id']}}">{{$user['name']}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="span6">
						<div class="control-group">
							<label class="control-label">Tổng chi:</label>
							<div class="controls">
								<input type="text" id="sum_amount" value="" data-type='number'>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Lý do chi:</label>
							<div class="controls">
								<input type="text" id="ly_do" value="">
							</div>
						</div>
					</div>
				</div>
				<br/>
				<div class="row center">
					<button class="btn btn-primary" type="button" onclick="saveOther()">
						Lưu
					</button>
					<button class="btn btn-primary" type="button" onclick="deleteOther()">
						Xóa
					</button>
				</div>
			</div>
			</form>
			<!-- dialog buttons -->
		</div>
	</div>
</div>
@stop
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
		#modal_other{
			width: 66%;
			margin-left: -33%;
		}
		@media (max-width: 767px) {
			.block .span9{
				width:100% !important;
			}
			#modal_other{
				width: 100% !important;
				margin-left: -4% !important;
			}
		}
		#modal_other .select2{
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

	$("#modal_other").modal({
			"backdrop":true,
			"show":false,
			"container":"body"
	});
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
	function loadOther(obj){
		$("#date_name").text($(obj).find(".date").text());
		var month = $(obj).attr('data-month');
		var year = $(obj).attr('data-year');
		current_month = month;
		current_year = year;
		$.ajax({
			url : '{{URL}}/revenues/list-revenue-other',
			type : 'POST',
			data :{
				'month' : month,
				'year' : year
			},
			success : function(data){
				$("#list-revenue").html(data);
			}
		})
	}
	function addOther(){
		$("#form_other")[0].reset();
		$("#other_id").val(0);
		$("#modal_other").modal("show");
	}

	function saveOther(){
		var id = $("#other_id").val();
		var date = $("#date").val();
		var sum_amount = $("#sum_amount").val();
		while(sum_amount.indexOf(',')>0){
			sum_amount = sum_amount.replace(',','');
		}
		sum_amount = parseFloat(sum_amount);
		var ly_do = $("#ly_do").val();
		var user_other = $("#user_other").val();
		$.ajax({
			url : '{{URL}}/revenues/save-other',
			type : 'POST',
			data : {
				id 		: id,
				date 		: date,
				sum_amount	: sum_amount,
				ly_do 	: ly_do,
				user_id 	: user_other,
			},
			success : function(data){
				if(data.status == 'success'){
					toastr['success']('Saving success!');
					$("#modal_other").modal("hide");
					$(".left-list li[data-year="+current_year+"][data-month="+current_month+"]").click();
					$("#form_other")[0].reset();
				}else{
					toastr['error'](data.message);
				}
			}
		})
	}

	function deleteOther(){
		var id = $("#other_id").val();
		$.ajax({
			url : '{{URL}}/revenues/delete-other',
			type : 'POST',
			data : {
				id : id
			},
			success : function(data){
				if(data.status == 'success'){
					toastr['success']('Delete success!');
					
				}else{
					toastr['error'](data.message);
				}
			}
		});			
	}

	function editOther(obj){
		var data = $(obj).attr('data-value');
		data = JSON.parse(data);
		$("#other_id").val(data.id);
		console.log(data);
		$("#date").val(data.date);
		$("#date").datepicker();
		$("#sum_amount").val(data.sum_amount);
		$("#ly_do").val(data.ly_do);
		$("#user_other").val(data.user_id);
		$("#user_other").select2('val',data.user_id);
		datatype_number();
		$("#modal_other").modal("show");
	}

</script>
@stop