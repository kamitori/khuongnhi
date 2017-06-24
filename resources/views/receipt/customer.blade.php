<div class="heading-buttons main-left">
	<div class="buttons pull-left">
		<a href="{{URL}}/receipts/customer-month" class="btn btn-small btn-primary btn-icon "><i class="fa fa-plus"></i> Công nợ tháng KH</a>
		<a href="{{URL}}/receipts/customer-year" class="btn btn-small btn-primary btn-icon "><i class="fa fa-plus"></i> Công nợ năm KH</a>
	</div>
	<div class="buttons pull-right">
		<a href="javascript:addNoDauKy()" class="btn btn-small btn-primary btn-icon "><i class="fa fa-plus"></i> Thêm công nợ đầu</a>
		<a href="javascript:addPaid()" class="btn btn-small btn-primary btn-icon "><i class="fa fa-plus"></i> Thêm thanh toán</a>
		<a href="javascript:window.open('{{URL}}/receipts/export-pdf-customer','_blank');" class="btn btn-small btn-primary btn-icon "><i class="fa fa-print"></i> Xuất PDF</a>
		<a href="javascript:window.open('{{URL}}/receipts/export-excel-customer','_blank');" class="btn btn-small btn-primary btn-icon "><i class="fa fa-list"></i> Xuất Excel</a>
	</div>
</div>

<div class="block" style="height: 100%;position:static;">
	<div class="span3 bs-docs-sidebar">
		<div class="accordion" id="accordion2" style="margin-bottom: 0;">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle">
						<strong>Danh sách khách hàng</strong>
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
										<option value="{{$i}}" {{$i==$current_month?'selected':''}}>Tháng {{$i}}</option>
									@endfor		
								</select>
							</div>
							<div class="date right" style="width:48%;">
								<?php 
									$current_year = intval(date('Y'));
								?>
								<select id="year" class="span12">
									@for($i=$min_year;$i <= $current_year;$i++)
									<option value="{{$i}}" {{$i==$current_year?'selected':''}}>Năm {{$i}}</option>
									@endfor	
								</select>
							</div>
							
							<div class="company">
								<select id="company_select" class="span12" data-type="select2">
									<option value="all">&nbsp;</option>
									@foreach($customers as $company)
									<option value="{{$company['id']}}">{{$company['name']}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<ul class="nav bs-docs-sidenav affix-top left-list">
							@foreach($customers as $company)
								<li data-id="{{$company['id']}}">
									<span  class='company'>{{$company['name']}}</span>
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
							Công nợ khách hàng <span id="company_name"></span>
						</strong>
					</a>
				</div>
				<div id="collapse1" class="accordion-body in collapse" style="height: auto;">
					<div class="accordion-inner">
						<table class="table table-bordered table-condensed table-striped table-primary table-vertical-center">
							<thead>
								<tr class="small">
									<th class="center">Ngày</th>
									<th class="center">Tổng tiền toa</th>
									<th class="center">Tiền thanh toán</th>
									<th class="center">Nợ cũ</th>
									<th class="center">Còn lại</th>
									<th class="center">Hình thức TT</th>
								</tr>
							</thead>
							<tbody id="list-receipt">
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@section('otherPage')
<div id="modal_paid" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- dialog header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h5>Thêm thanh toán</h5>
			</div>
			<!-- dialog body -->
			<form  method="post" accept-charset="utf-8" id="form_paid">
			<div class="modal-body">
				<div class="row-fluid form_detail">
					<div class="span4">
						<input type="hidden" id="paid_id" value="">
						<div class="control-group">
							<label class="control-label">Công ty:</label>
							<div class="controls">
								<select id="company_paid" width="auto" data-type="select2">
									@foreach($customers as $company)
									<option value="{{$company['id']}}">{{$company['name']}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Ngày:</label>
							<div class="controls">
								<input type="text" id="date" name="date" class="datepicker" value="{{ date('d-m-Y') }}" readonly="" style="background-color: #fff;">
							</div>
						</div>
					</div>
					<div class="span4">
						<div class="control-group">
							<label class="control-label">Tiền TT:</label>
							<div class="controls">
								<input type="text" id="sum_paid" value="" data-type='number'>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Hình thức TT:</label>
							<div class="controls">
								<input type="text" id="hinh_thuc" value="">
							</div>
						</div>
					</div>
					<div class="span4">
						<div class="control-group">
							<label class="control-label">Người thu:</label>
							<div class="controls">
								<select id="user_paid" width="auto" data-type="select2">
									@foreach($users as $user)
									<option value="{{$user['id']}}">{{$user['name']}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
				</div>
				<br/>
				<div class="row center">
					<button class="btn btn-primary" type="button" onclick="savePaid()">
						Lưu
					</button>
					<button class="btn btn-primary" type="button" onclick="deletePaid()">
						Xóa
					</button>
				</div>
			</div>
			</form>
			<!-- dialog buttons -->
		</div>
	</div>
</div>
<div id="modal_no_dau_ky" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- dialog header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h5>Thêm công nợ đầu</h5>
			</div>
			<!-- dialog body -->
			<form  method="post" accept-charset="utf-8" id="form_no_dau_ky">
			<div class="modal-body">
				<div class="row-fluid form_detail">
					<div class="span12">
						<div class="control-group">
							<label class="control-label">Công ty:</label>
							<div class="controls">
								<select id="company_no_dau_ky" width="auto" data-type="select2">
									@foreach($customers as $company)
									<option value="{{$company['id']}}">{{$company['name']}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Tổng nợ:</label>
							<div class="controls">
								<input type="text" id="sum_no_dau_ky" value="" data-type='number'>
							</div>
						</div>
						
					</div>
				</div>
				<br/>
				<div class="row center">
					<button class="btn btn-primary" type="button" onclick="saveNoDauKy()">
						Lưu
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
		#modal_paid .select2,#modal_no_dau_ky .select2{
			width:84% !important;
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
	var current_company = 0;
	$(".left-list li").on('click',function(){
		$("#company_name").text($(this).find(".company").text());
		var company_id = $(this).attr('data-id');
		current_company = company_id;
		var month = $("#month").val();
		var year = $("#year").val();
		$.ajax({
			url : '{{URL}}/receipts/list-receipt-customer',
			type : 'POST',
			data :{
				'company_id' : company_id,
				'month' : month,
				'year' : year
			},
			success : function(data){
				$("#list-receipt").html(data);
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
		$(".left-list li[data-id="+current_company+"]").click();
	})

	$("#modal_paid").modal({
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
	function addPaid(){
		$("#form_paid")[0].reset();
		$("#paid_id").val(0);
		$("#modal_paid").modal("show");
	}

	function savePaid(){
		var id = $("#paid_id").val();
		var company_id = $("#company_paid").val();
		var date = $("#date").val();
		var sum_paid = $("#sum_paid").val();
		while(sum_paid.indexOf(',')>0){
			sum_paid = sum_paid.replace(',','');
		}
		sum_paid = parseFloat(sum_paid);
		var hinh_thuc = $("#hinh_thuc").val();
		var user_paid = $("#user_paid").val();
		$.ajax({
			url : '{{URL}}/receipts/save-paid',
			type : 'POST',
			data : {
				id 		: id,
				company_id 	: company_id,
				date 		: date,
				sum_paid	: sum_paid,
				type_paid	: 'customer',
				hinh_thuc 	: hinh_thuc,
				user_id 	: user_paid,
			},
			success : function(data){
				if(data.status == 'success'){
					toastr['success']('Saving success!');
					$("#modal_paid").modal("hide");
					$(".left-list li[data-id="+current_company+"]").click();
			        $("#form_paid")[0].reset();
					$("#paid_id").val(0);
					// $("#modal_paid").modal("show");
					$(".modal-backdrop").remove();
				}else{
					toastr['error'](data.message);
				}
			}
		})
	}

	function deletePaid(){
		var id = $("#paid_id").val();
		$.ajax({
			url : '{{URL}}/receipts/delete-paid',
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

	function editPaid(obj){
		var data = $(obj).attr('data-value');
		data = JSON.parse(data);
		$("#paid_id").val(data.id);
		console.log(data);
		$("#company_paid").val(data.company_id);
		$("#company_paid").select2('val',data.company_id);
		$("#date").val(data.date);
		$("#sum_paid").val(data.paid);
		$("#hinh_thuc").val(data.hinh_thuc);
		$("#user_paid").val(data.user_id);
		$("#user_paid").select2('val',data.user_id);
		datatype_number();
		$("#modal_paid").modal("show");
	}

	function addNoDauKy(){
		$("#form_no_dau_ky")[0].reset();
		$("#no_dau_ky_id").val(0);
		$("#modal_no_dau_ky").modal("show");
	}

	function saveNoDauKy(){
		var company_id = $("#company_no_dau_ky").val();
		var sum_no_dau_ky = $("#sum_no_dau_ky").val();
		while(sum_no_dau_ky.indexOf(',')>0){
			sum_no_dau_ky = sum_no_dau_ky.replace(',','');
		}
		sum_no_dau_ky = parseFloat(sum_no_dau_ky);
		$.ajax({
			url : '{{URL}}/receipts/save-no-dau-ky-customer',
			type : 'POST',
			data : {
				
				company_id 	: company_id,
				sum_no_dau_ky	: sum_no_dau_ky,
				type_no_dau_ky	: 'no_dau_ky_customer',
			},
			success : function(data){
				if(data.status == 'success'){
					toastr['success']('Saving success!');
					$("#modal_no_dau_ky").modal("hide");
					$(".left-list li[data-id="+current_company+"]").click();
					$("#form_no_dau_ky")[0].reset();
					$("#no_dau_ky_id").val(0);
				}else{
					toastr['error'](data.message);
				}
			}
		})
	}

</script>
@stop