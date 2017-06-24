<?php 
	$user = Auth::user();
?>
<div class="heading-buttons main-left">
	<div class="buttons pull-left">
		@if($user->can("create-purchaseorders"))
		<a href="{{URL}}/purchaseorders/create" class="btn btn-small btn-primary btn-icon "><i class="fa fa-plus"></i> Thêm</a>
		@endif
		@if(!$purchaseorder['status'] && $user->can("delete-purchaseorders"))
		<button href="javascript:void()" class="btn btn-small btn-primary btn-icon " id="delete_purchaseorder"><i class="fa fa-remove"></i> Xóa</button>
		@endif
		<a href="{{URL}}/purchaseorders/list" class="btn btn-small btn-primary btn-icon "><i class="fa fa-search"></i> Tìm kiếm</a>
		<a href="{{URL}}/purchaseorders/list" class="btn btn-small btn-primary btn-icon "><i class="fa fa-list"></i> Danh sách</a>
		@if($user->can("view-history"))
		<a href="{{URL}}/purchaseorders/log" class="btn btn-small btn-primary btn-icon "><i class="fa fa-clock-o"></i> Lịch sử</a>
		@endif
	</div>
	<div class="buttons pull-right">
		
	</div>
</div>
<!-- Entry -->
<div class="accordion" id="accordion2" style="margin-bottom: 0;">
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse1">
				<h4 id="product_name">&nbsp;Hóa đơn mua hàng số {{$purchaseorder['id']}}</h4>
			</a>
		</div>
		<div id="collapse1" class="accordion-body in collapse" style="height: auto;">
			<div class="accordion-inner">
				<form method="post" accept-charset="utf-8" id="form_entry">
					<div class="row-fluid form_detail">
						<div class="span4">
							<div class="control-group">
								<label class="control-label">STT:</label>
								<div class="controls">
									@if($purchaseorder['status'] || !$user->can("edit-purchaseorders"))
									<span>{{$purchaseorder['id']}}</span>
									@else
									<input type="text" name="stt" value="{{$purchaseorder['id']}}" readonly="">
									@endif
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Công ty:</label>
								<div class="controls">
									@if($purchaseorder['status'] || !$user->can("edit-purchaseorders"))
									<span>
										@foreach($distributes as $distribute)
											{{ isset($purchaseorder['company_id']) && ($purchaseorder['company_id'] == $distribute['id'])?$distribute['name']:'' }}
										@endforeach
									</span>
									@else
									<select name="company_id" id="company_id" data-type="select2">
										@foreach($distributes as $distribute)
										<option value="{{$distribute['id']}}" 
									{{isset($purchaseorder['company_id']) && ($purchaseorder['company_id'] == $distribute['id'])?'selected':''}}
										 data-company="{{json_encode($distribute)}}">
											{{$distribute['name']}}
										</option>
										@endforeach
									</select>
									@endif
								</div>
							</div>

							<div class="control-group">
								<label class="control-label">Liên hệ:</label>
								<div class="controls">
									@if($purchaseorder['status'] || !$user->can("edit-purchaseorders"))
									<span>
										@foreach($users as $user_name)
											{{isset($purchaseorder['user_id']) && ($purchaseorder['user_id'] == $user_name['id'])?$user_name['name']:''}}
										@endforeach
									</span>
									@else
									<select name="user_id" id="user_id" data-type="select2">
										@foreach($users as $user_name)
										<option value="{{$user_name['id']}}"
									{{isset($purchaseorder['user_id']) && ($purchaseorder['user_id'] == $user_name['id'])?'selected':''}}
										>
											{{$user_name['name']}}
										</option>
										@endforeach
									</select>
									@endif
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Ngày:</label>
								<div class="controls">
									@if($purchaseorder['status'] || !$user->can("edit-purchaseorders"))
										<span>{{ date('d-m-Y',strtotime($purchaseorder['date']) ) }}</span>
									@else
									<input type="text" id="date" name="date" class="datepicker" value="{{ date('d-m-Y',strtotime($purchaseorder['date']) ) }}" readonly="" style="background-color: #fff;">
									@endif
								</div>
							</div>
						</div>
						<div class="span4">
							<div class="control-group">
								<label class="control-label">Điện thoại:</label>
								<div class="controls">
									@if($purchaseorder['status'] || !$user->can("edit-purchaseorders"))
										<span>{{isset($purchaseorder['company_phone'])?$purchaseorder['company_phone']:''}}</span>
									@else
									<input type="text" name="company_phone" value="{{isset($purchaseorder['company_phone'])?$purchaseorder['company_phone']:''}}" >
									@endif
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Email:</label>
								<div class="controls">
									@if($purchaseorder['status'] || !$user->can("edit-purchaseorders"))
										<span>{{isset($purchaseorder['company_email'])?$purchaseorder['company_email']:''}}</span>
									@else
									<input type="text" name="company_email" value="{{isset($purchaseorder['company_email'])?$purchaseorder['company_email']:''}}" >
									@endif
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Địa chỉ:</label>
								<div class="controls">
									@if($purchaseorder['status'] || !$user->can("edit-purchaseorders"))
										<span>{{isset($address['address'])?$address['address']:''}}</span>
									@else
									<input type="text" name="address" value="{{isset($address['address'])?$address['address']:''}}" >
									@endif
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Quận/Huyện:</label>
								<div class="controls">
									@if($purchaseorder['status'] || !$user->can("edit-purchaseorders"))
										<span>{{isset($address['town_city'])?$address['town_city']:''}}</span>
									@else
									<input type="text" name="town_city" value="{{isset($address['town_city'])?$address['town_city']:''}}" >
									@endif
								</div>
							</div>
							
						</div>
						<div class="span4">
							<div class="control-group">
								<label class="control-label">Tỉnh thành:</label>
								<div class="controls">
									@if($purchaseorder['status'] || !$user->can("edit-purchaseorders"))
										<span>{{isset($purchaseorder['province_name'])?$purchaseorder['province_name']:''}}</span>
									@else
									<select name="province_id" id="province_id">
									</select>
									@endif
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Quốc gia:</label>
								<div class="controls">
									@if($purchaseorder['status'] || !$user->can("edit-purchaseorders"))
										<span>{{isset($purchaseorder['country_name'])?$purchaseorder['country_name']:''}}</span>
									@else
									<select name="country_id" id="country_id">
										@foreach($countries as $country)
										<option value="{{$country['id']}}" data-province='{{json_encode($country['provinces'])}}' 
										{{isset($address['country_id']) && ($address['country_id']==$country['id'])?'selected':''}}>
											{{$country['name']}}
										</option>
										@endforeach
									</select>
									@endif
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Mã vùng:</label>
								<div class="controls">
									@if($purchaseorder['status'] || !$user->can("edit-purchaseorders"))
										<span>{{ isset($address['zip_postcode'])?$address['zip_postcode']:'' }}</span>
									@else
									<input type="text" name="zip_postcode" maxlength="15" value="{{ isset($address['zip_postcode'])?$address['zip_postcode']:'' }}">
									@endif
								</div>
							</div>
							<div class="control-group">
								@if($user->can("complete-purchaseorders"))
								<label class="control-label" style="vertical-align: bottom; margin-bottom:5px;">Trạng thái:</label>
								<div class="controls">
									<input type="checkbox" name="status" {{isset($purchaseorder['status']) && ($purchaseorder['status']==1)?'checked':''}}  data-toggle="toggle" data-onstyle="primary" data-on="Hoàn thành" data-off="Mới" data-height="15" data-width="140">
								</div>
								@endif
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div> 
<!-- End Entry -->

<!-- Sub Entry -->
<div class="widget widget-2 widget-tabs">
	<div class="widget-head">
		<ul>
			<li class="active">
				<a href="#stockTab" data-toggle="tab">
					<h4>Danh sách sản phẩm</h4>
				</a>
			</li>
		</ul>
	</div>
	<div class="widget-body">
		<div class="tab-content">
			<div class="tab-pane active" id="stockTab">
				<div class="block row">
					<div class="heading-buttons main-left">
						<div class="buttons pull-left">
							@if(!$purchaseorder['status'] && $user->can("edit-purchaseorders"))
							<button class="btn btn-primary btn-small btn-icon"  onclick="popup_product();"><i class="fa fa-plus"></i>Thêm sản phẩm</button>
							<button class="btn btn-primary btn-small btn-icon"  onclick="popup_createproduct();"><i class="fa fa-plus"></i>Tạo mới sản phẩm</button>
							@endif
							<button class="btn btn-primary btn-small btn-icon" onclick="print_pdf();"><i class="fa fa-print"></i>Xuất PDF</button>
							<button class="btn btn-primary btn-small btn-icon" onclick="print_excel();"><i class="fa fa-print"></i>Xuất Excel</button>
						</div>
					</div>
					<table class="table table-bordered table-condensed table-striped table-primary table-vertical-center table-list-edit">
						<thead>
							<tr>
								<th style="width:7%">SKU</th>
								<th style="width:35%">Tên sản phẩm</th>
								<th style="width:8%">ĐV tính</th>
								<th style="width:7%">Quy cách</th>
								<th style="width:13%">Đơn giá</th>
								<th style="width:7%">Số lượng</th>
								<th style="width:20%" class="right">Thành tiền</th>
								@if(!$purchaseorder['status'] && $user->can("edit-purchaseorders"))
								<th style="width:3%">&nbsp;</th>
								@endif
							</tr>
						</thead>
						<tbody id="list_product">
							<?php echo $view_list_product; ?>
						</tbody>
					</table>
					@if(!$purchaseorder['status'] && $user->can("edit-purchaseorders"))
					<div class="control-group" style="margin-top: 10px;width:400px;">
						<label class="control-label">SKU/Tên SP:</label>
						<div class="controls">
							<input type="text" name="sku_quick" id="sku_quick" maxlength="50" style="width:190px;">
						</div>
					</div>
					<div id="list_product_quick">
						<span class="close"><i class="fa fa-remove"></i></span>
						<ul class="unstyled">
						</ul>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Sub Entry -->

@section('otherPage')
<div id="modal_add_product" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- dialog header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h5>&nbsp;</h5>
			</div>
			<!-- dialog body -->
			<div class="modal-body">
				<div class=" block row" id="list_product_popup">
					
				</div>
			</div>
			<!-- dialog buttons -->
			<div class="modal-footer">
				<button href="#" class="btn btn-primary" onclick="add_product()">Chọn sản phẩm</button>
				<button href="#" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Đóng</button>
			</div>
		</div>
	</div>
</div>
<div id="modal_create_product" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- dialog header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h5>&nbsp;</h5>
			</div>
			<!-- dialog body -->
			<div class="modal-body">
				<form action="#" method="POST" accept-charset="utf-8" class="form_detail" id="form_create_product">
					<div class="control-group">
						<label class="control-label">SKU:</label>
						<div class="controls">
							<input type="text" name="sku" value="" >
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Tên sản phẩm:</label>
						<div class="controls">
							<input type="text" name="name" value="" >
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Loại sản phẩm:</label>
						<div class="controls">
							<select name="product_type" id="product_type">
								@foreach($producttypes as $producttype)
								<option value="{{$producttype['id']}}">
									{{$producttype['name']}}
								</option>
								@endforeach
							</select>
						</div>
					</div>
				</form>
			</div>
			<!-- dialog buttons -->
			<div class="modal-footer center">
				<button href="#" class="btn btn-primary" onclick="create_product()">Tạo mới</button>
				<button href="#" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Đóng</button>
			</div>
		</div>
	</div>
</div>
@stop


<style type="text/css" media="screen">
	#modal_add_product.modal.fade.in{
		width: 80%;
		left: 28%;
	}
	#modal_create_product.modal.fade.in{
		width: 40%;
		left: 52%;
	}
	#list_product_quick{
		width:350px;
		background-color: #fff;
		position: absolute;
		border:1px solid #ddd;
		display:none;
		height: 300px;
		margin-top: -350px;
		overflow-y: auto;
	}
	#list_product_quick strong{
		margin: 20px;
	}
	#list_product_quick ul{
		margin-bottom: 0 !important;
		margin-top:10px;
	}
	#list_product_quick ul li{
		padding: 10px;
		cursor: pointer;
	}
	#list_product_quick ul li:hover{
		background: #bbb;
	}
	#list_product_quick span.close{
		position: absolute;
		top: 0;
		right: 5px;
		cursor: pointer;
		padding: 5px;
	}
</style>

@section('pageJS')
	<script>
		$(function(){
			$("#modal_add_product").modal({
				"backdrop":true,
				"show":false,
				"container":"body"
			});

			$("#modal_create_product").modal({
				"backdrop":true,
				"show":false,
				"container":"body"
			});

			$("#country_id").on('change',function(){
				// alert(123);
				var provinces = $("#country_id option[value="+$("#country_id").val()+"]").attr('data-province');
				provinces = JSON.parse(provinces);
				var options = '';
				$.each(provinces,function(key,value){
					options+='<option value="'+value.id+'" ';
					if(value.id == {{isset($address['province_id'])?$address['province_id']:0}}){
						options+=' selected ';
					}
					options+='>'
					options+=value.name;
					options+='</option>';
				})
				$("#province_id").html(options).select2({width:'84%'});
			})
			

			$("#company_id").on("change",function(e){
				if($("#company_id option[value="+$(this).val()+"]").length){
					var company = $("#company_id option[value="+$(this).val()+"]").attr('data-company');
					company = JSON.parse(company);
				}else{
					company = {};
				}
				
				e.preventDefault();
				$("[name=company_phone]").val( company.phone?company.phone:'' );
				$("[name=company_email]").val( company.email?company.email:'' );
				if(company.address && company.address.length){
					$("[name=address]").val( company.address[0].address?company.address[0].address:'' );
					$("[name=town_city]").val( company.address[0].town_city?company.address[0].town_city:'' );
					$("[name=country_id]").val( company.address[0].country_id?company.address[0].country_id:'' );
					$("#country_id").trigger("change");
					$("#province_id").val(  company.address[0].province_id?company.address[0].province_id:'' );
					$("#province_id").trigger("change");
					$("[name=zip_postcode]").val( company.address[0].zip_postcode?company.address[0].zip_postcode:'' );
				}
			})
			
			$("#country_id").trigger('change');

			$("#form_entry input,#form_entry select").not("#country_id, #company_id").on("change",function(e){
				var name = $(this).attr('name');
				e.preventDefault();
				var data = $("#form_entry").serialize();
				$.ajax({
					url: '{{URL}}/purchaseorders/update',
					type:'POST',
					data: data,
					success:function(data){
						if(data.status=='success'){
							if(data.name != '')
								$("#product_name").text(data.name);
							toastr['success']('Saving success !');
							if(name == 'status')
								window.location.reload();
						}else{
							if(name == 'status'){
								$('input[name=status]').data("bs.toggle").off(true);
							}
							toastr['error'](data.message);
						}
					}
				})
			})
			@if(!$purchaseorder['company_id'])
				$("#company_id").trigger("change");
			@endif
			$("#delete_purchaseorder").on("click",function(){
				confirms('Xóa hóa đơn này ?', function(){
					$.ajax({
						url : '{{URL}}/purchaseorders/delete',
						type : 'GET',
						success : function(data){
							if(data.status == 'success'){
								toastr['success']('Delete success');
								window.location = '{{URL}}/purchaseorders';
							}else{
								toastr['success'](data.message);
							}
						}
					})
					
				});
			});

			$("#sku_quick").keypress(function(e){
				if(e.keyCode==13){
					var key = $(this).val();
					$.ajax({
						url : '{{URL}}/products/search-product',
						type : 'POST',
						data : {
							key : key
						},
						success : function(data){
							if(data.length){
								var html='';
								for(i=0;i<data.length;i++){
									html+='<li onclick="add_product_quick('+data[i]['id']+')">'+data[i]['sku']+' - '+data[i]['name']+'</li>';
								}
								$("#list_product_quick ul").html(html);
								$(window).trigger('resize');
								$("#list_product_quick").css('display','block');
							}else{
								$("#list_product_quick ul").html('<strong>Không tìm thấy sản phẩm</strong>');
								$(window).trigger('resize');
								$("#list_product_quick").css('display','block');
							}
						}
					})
				}
			});

			$("#list_product_quick .close").on("click",function(){
				$("#list_product_quick ul").html('');
				$("#list_product_quick").css('display','none');
				$(window).trigger('resize');
			})
			

		}) // End Jquery
		function add_product_quick(id){
			$("#list_product_quick").css('display','none');
			$.ajax({
				url : '{{URL}}/purchaseorders/add-product-quick',
				type : 'POST',
				data:{
					company_id : $("#company_id").val(),
					product_id : id
				},
				success:function(data){
					if(data.status=='success'){
						toastr['success']('Add success');
						$.ajax({
							url : '{{URL}}/purchaseorders/list-product',
							type :'GET',
							success:function(html){
								$("#list_product").html(html);
								$(window).trigger('resize');
							}
						})
						
					}else{
						toastr['error'](data.message);
					}
				}
			});
		}
		function popup_product(){
			$.ajax({
				url : '{{URL}}/products/list-popup/po',
				type : 'GET',
				success : function(html){
					$("#list_product_popup").html(html);
					$("#modal_add_product").modal("show");
					$('#modal_add_product').on('shown',function(){
						$("#form-list select[data-type=select2]").each(function(key,element){
							$(element).select2();
						});
					})
				}
			});
		}

		function popup_createproduct(){
			$("#modal_create_product").modal("show");
		}

		function add_product(){
			$.ajax({
				url : '{{URL}}/purchaseorders/add-product',
				type : 'POST',
				data:{
					company_id : $("#company_id").val()
				},
				success : function(data){
					if(data.status=='success'){
						toastr['success']('Add success');
						$.ajax({
							url : '{{URL}}/purchaseorders/list-product',
							type :'GET',
							success:function(html){
								$("#list_product").html(html);
								$("#modal_add_product").modal('hide');
								$(window).trigger('resize');
							}
						})
						
					}else{
						toastr['error'](data.message);
					}
				}
			});
		}

		function delete_product(obj){
			var id = $(obj).parent().parent().attr('data-id');
			$.ajax({
				url : '{{URL}}/purchaseorders/delete-product',
				type : 'POST',
				data : {
					'id' : id
				},
				success : function(data){
					if(data.status=='success'){
						toastr['success']('Delete success');
						$.ajax({
							url : '{{URL}}/purchaseorders/list-product',
							type :'GET',
							success:function(html){
								$("#list_product").html(html);
								$("#modal_add_product").modal('hide');
								$(window).trigger('resize');
								sum_invest();
							}
						})
					}else{
						toastr['error'](data.message);
					}
				}
			});
		}

		function sum_invest(){
			var sum_invest =0;
			$(".invest").each(function(){
				var value = $(this).text();
				while(value.indexOf(',')>0){
					value = value.replace(',','');
				}
				value = parseFloat(value);
				sum_invest += value;
			})
			sum_invest = sum_invest.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			$("#sum_invest").text(sum_invest);
		}

		function create_product(){
			var data = $("#form_create_product").serialize();
			$.ajax({
				url : '{{URL}}/products/create-product',
				type : 'POST',
				data : data,
				success : function(data){
					if(data.status == 'success'){
						$("#form_create_product")[0].reset();
						toastr['success']('Create success');
						$("#modal_create_product").modal("hide");
					}else{
						toastr['success'](data.message);
					}
				}
			})
		}

		function print_pdf(){
			window.open('{{URL}}/purchaseorders/export-pdf','_blank');
		}
		function print_excel(){
			window.open('{{URL}}/purchaseorders/export-excel','_blank');
		}
	</script>
@stop