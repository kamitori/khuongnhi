<?php 
	$user = Auth::user();
?>
<div class="heading-buttons main-left">
	<div class="buttons pull-left">
		@if($user->can("create-products"))
		<a href="{{URL}}/products/create" class="btn btn-small btn-primary btn-icon "><i class="fa fa-plus"></i> Thêm</a>
		@endif

		@if(!$product['status'] && $user->can("delete-products"))
		<button href="javascript:void()" class="btn btn-small btn-primary btn-icon " id="delete_product"><i class="fa fa-remove"></i> Xóa</button>
		@endif
		<a href="{{URL}}/products/list" class="btn btn-small btn-primary btn-icon "><i class="fa fa-list"></i> Danh sách</a>
		<a href="{{URL}}/products/ton-dau-thang" class="btn btn-small btn-primary btn-icon "><i class="fa fa-list"></i> Tổn đầu tháng</a>
		@if($user->can("view-history"))
		<a href="{{URL}}/products/log" class="btn btn-small btn-primary btn-icon "><i class="fa fa-clock-o"></i> Lịch sử</a>
		@endif
		<div style="display:inline-block;">
			<strong style="margin-left: 10px;">SKU/Tên SP: </strong><input type="text" class="form-control" id="search_product">
			<div id="search_list">
				<span class="close"><i class="fa fa-remove"></i></span>
				<ul>
					
				</ul>
			</div>
		</div>
	</div>
	<div class="buttons pull-right">

	</div>
</div>
<!-- Entry -->
<div class="accordion" id="accordion2" style="margin-bottom: 0;">
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse1">
				<h4 id="product_name">{{ $product['name'] != '' ? $product['name'] : 'Sản phẩm mới' }}</h4>
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
									@if($product['status'] || !$user->can("edit-products"))
									<span>{{$product['id']}}</span>
									@else
									<input type="text" name="stt" value="{{$product['id']}}" readonly="">
									@endif
									
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Mã sản phẩm:</label>
								<div class="controls">
									@if($product['status'] || !$user->can("edit-products"))
									<span>{{$product['sku']}}</span>
									@else
									<input type="text" name="sku" value="{{ $product['sku'] }}">
									@endif
								</div>
							</div>
						</div>
						<div class="span4">
							<div class="control-group">
								<label class="control-label">Tên sản phẩm:</label>
								<div class="controls">
									@if($product['status'] || !$user->can("edit-products"))
									<span>{{$product['name']}}</span>
									@else
									<input type="text" name="name" value="{{$product['name']}}">
									@endif
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Loại sản phẩm:</label>
								<div class="controls">
									@if($product['status'] || !$user->can("edit-products"))
									<span>
										@foreach($producttypes as $producttype)
										@if($producttype['id']==$product['product_type'])
											{{$producttype['name']}}
										@endif
										@endforeach
									</span>
									@else
									<select name="product_type" id="product_type">
										@foreach($producttypes as $producttype)
										<option value="{{$producttype['id']}}"
										{{$producttype['id']==$product['product_type']?'selected':''}}
										>
											{{$producttype['name']}}
										</option>
										@endforeach
									</select>
									@endif
								</div>
							</div>

						</div>
						<div class="span4">
							
							<div class="control-group">
								<label class="control-label" style="vertical-align: bottom; margin-bottom:5px;">&nbsp;</label>
								<div class="controls"  >
									@if($user->can("edit-products"))
									<button class="btn btn-primary" type="button" onclick="popup_instock()" title="Thêm tồn kho ban đầu cho sản phẩm" >
										<i class="fa fa-cubes"></i>
										Tồn kho ban đầu
									</button>
									@endif
								</div>
							</div>
							<div class="control-group">
								@if($user->can("edit-products"))
								<label class="control-label" style="vertical-align: bottom; margin-bottom:5px;">Trạng thái:</label>
								<div class="controls">
									<input type="checkbox" name="status" {{$product['status']==1?'checked':''}} data-toggle="toggle" data-onstyle="primary" data-on="Hoàn thành" data-off="Mới" data-height="15" data-width="140">
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
				<a href="#stockTab1" data-toggle="tab">
					<strong>Nhập hàng</strong>
					@if(!$product['status'])
					<i class="fa fa-plus" id="add_po"></i>
					@endif
				</a>
			</li>
			<li class="">
				<a href="#stockTab2" data-toggle="tab">
					<strong>Xuất kho</strong>
				</a>
			</li>
		</ul>
	</div>
	<div class="widget-body">
		<div class="tab-content">
			<div class="tab-pane active" id="stockTab1">
				<div class="block row">
					<table class="table table-bordered table-condensed table-striped table-primary table-vertical-center " id="table_nhap">
						<thead>
							<tr class="small">
								<th class="center" style="width:10px%">Ngày nhập</th>
								<th class="center" style="width:6%">Mã</th>
								<th class="center" style="width:10%">Loại</th>
								<th class="center" style="width:24%">Công ty</th>
								<th class="center" style="width:8%">Đơn vị</th>
								<th class="center" style="width:8%">Quy cách</th>
								<th class="center" style="width:8%">Số lượng</th>
								<th class="center" style="width:8%">Đã nhập</th>
								<th class="center" style="width:8%">Tồn kho</th>
								@if(!$product['status'])
								<th class="center" style="width:10%">&nbsp;</th>
								@endif
							</tr>
							<tr class="sort">
								<th class="center">
									<select id="select_month" data-type="select2">
										<option value="all"></option>
										@foreach($list_month as $key => $value)
										<option value="{{$value['month']}}-{{$value['year']}}">Tháng {{$value['month']}}-{{$value['year']}}</option>
										@endforeach
									</select>
								</th>
								<th class="center"></th>
								<th class="center">
									<select id="select_type">
										<option value="all"></option>
										<option value="po">Mua hàng</option>
										<option value="rpo">Đại lý trả</option>
										<option value="in_stock">Tồn đầu</option>
									</select>
								</th>
								<th class="center">
									<select id="select_company" data-type="select2">
											<option value="all"></option>
										@foreach($companies as $key => $value)
											<option value="{{$value['id']}}">{{$value['name']}}</option>
										@endforeach
									</select>
								</th>
								<th class="center"></th>
								<th class="center"></th>
								<th class="center"></th>
								<th class="center"></th>
								<th class="center"></th>
								<th class="center"></th>
							</tr>
						</thead>
						<tbody id="list_po">

							<?php echo $view_list_po; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="tab-pane" id="stockTab2">
				<div class="block row">
					<table class="table table-bordered table-condensed table-striped table-primary table-vertical-center" id="table_xuat">
						<thead>
							<tr class="small">
								<th class="center" style="width:10%">Ngày bán</th>
								<th class="center" style="width:10%">Mã đơn hàng</th>
								<th class="center" style="width:10%">Loại</th>
								<th class="center" style="width:36%">Khách hàng</th>
								<th class="center" style="width:8%">Đơn vị</th>
								<th class="center" style="width:8%">Quy cách</th>
								<th class="center" style="width:8%">Số lượng</th>
								<th class="center" style="width:8%">Đã xuất</th>
							</tr>
							<tr class="sort">
								<th class="center">
									<select id="select_month" data-type="select2">
										<option value="all"></option>
										@foreach($list_month as $key => $value)
										<option value="{{$value['month']}}-{{$value['year']}}">Tháng {{$value['month']}}-{{$value['year']}}</option>
										@endforeach
									</select>
								</th>
								<th class="center"></th>
								<th class="center">
									<select id="select_type">
										<option value="all"></option>
										<option value="po">Mua hàng</option>
										<option value="rpo">Đại lý trả</option>
										<option value="in_stock">Tồn đầu</option>
									</select>
								</th>
								<th class="center">
									<select id="select_company" data-type="select2">
											<option value="all"></option>
										@foreach($companies as $key => $value)
											<option value="{{$value['id']}}">{{$value['name']}}</option>
										@endforeach
									</select>
								</th>
								<th class="center"></th>
								<th class="center"></th>
								<th class="center"></th>
								<th class="center"></th>
							</tr>
						</thead>
						<tbody id="list_po">
							<?php echo $view_list_so; ?> 
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Sub Entry -->
@section('otherPage')
<div id="modal_sellprice" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- dialog header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h5>&nbsp;</h5>
			</div>
			<!-- dialog body -->
			<form  method="post" accept-charset="utf-8" id="form_oum">
			<div class="modal-body">
				<input type="hidden" name="mproduct_id" id="mproduct_id" value="">
				@if($user->can("edit-products"))
				<div class="row">
					<div class="span3">
						<div class="control-group">
							<input type="hidden" name="id_sellprice" id="id_sellprice" value="0">
							<label class="control-label">Nhãn:</label>
							<div class="controls">
								<input type="text"
										id="name_sell_price"
										name="name_sell_price"
										value=""
										style="width:100%"
								>
							</div>
						</div>
					</div>
					<div class="span3">
						<div class="control-group">
							<label class="control-label">Giá:</label>
							<div class="controls">
								<input type="text"
										id="sell_price"
										name="sell_price"
										value=""
										style="width:100%"
										data-type="number"
								>
							</div>
						</div>
					</div>
					<div class="span1 right">
						<button type="button" onclick="saveSellPrice()" class="btn btn-primary">Lưu</button>
					</div>
				</div>
				@endif
				<div id="list_price">
					
				</div>
			</div>
			</form>
			<!-- dialog buttons -->
		</div>
	</div>
</div>
<div id="modal_instock" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- dialog header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h5>Tồn kho ban đầu</h5>
			</div>
			<!-- dialog body -->
			<form  method="post" accept-charset="utf-8" id="form_in_stock">
			<div class="modal-body">
				<table class="table table-bordered table-condensed table-striped table-primary table-vertical-center table-list-edit">
					<thead>
						<tr>
							<!-- <th style="width:7%">Mã</th> -->
							<th style="width:30%">Nhà cung cấp</th>
							<th style="width:15%">ĐV tính</th>
							<th  class="center" style="width:10%">Quy cách</th>
							<th class="right" style="width:15%">Đơn giá</th>
							<th  class="center" style="width:10%">Số lượng</th>
							<th class="right" style="width:15%">Tổng tiền</th>
							@if(!$product['check_in_stock'])
								<th style="5%">&nbsp;</th>
							@endif
						</tr>
					</thead>
					<tbody>
					@if($product['check_in_stock'])
						@foreach($list_instock as $instock)
						<tr>
							<td>{{ $instock['company']['name'] }}</td>
							<td>{{ $instock['oum']['name'] }}</td>
							<td class="center" >{{ $instock['specification'] }}</td>
							<td class="right" data-type="currency">{{ $instock['origin_price'] }}</td>
							<td class="center" >{{ $instock['quantity'] }}</td>
							<td class="right" data-type="currency">{{ $instock['invest']  }}</td>
						</tr>
						@endforeach
					@else
						<tr>
							<td>
								<select name="company_id" id="company_id" data-type="select2">
									<option value="">&nbsp;</option>
									@foreach($distributes as $company)
										<option value="{{$company['id']}}" >{{$company['name']}}</option>
									@endforeach
								</select>
							</td>
							<td>
								<select name="oum_id" id="oum_id">
									<option value="">&nbsp;</option>
									@foreach($oums as $oum)
										<option value="{{$oum['id']}}" >{{$oum['name']}}</option>
									@endforeach
								</select>
							</td>
							<td>
								<input type="text" name="specification"  id="specification" data-type="quantity" onchange="changeInstock(this)">
							</td>
							<td>
								<input type="text" name="origin_price" id="origin_price" data-type="number" onchange="changeInstock(this)">
							</td>
							<td>
								<input type="text" name="quantity"  id="quantity" data-type="quantity" onchange="changeInstock(this)">
							</td>
							<td data-type="currency" id="invest">
								0
							</td>
						</tr>
					@endif
					</tbody>
				</table>
				<br/>
				<div class="row center">
					@if(!$product['check_in_stock'])
					<button class="btn btn-primary" type="button" onclick="saveInstock()">
						Lưu
					</button>
					<button class="btn btn-primary" type="button" onclick="addInstock()">
						Thêm
					</button>
					@endif
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
		#modal_sellprice{
			width: 66%;
			margin-left: -33%;
		}
		#modal_instock{
			width: 88%;
			margin-left: -44%;
		}
		@media (max-width: 767px) {
			#modal_sellprice{
				width: 100% !important;
				margin-left: -4% !important;
			}
			#modal_instock{
				width: 100% !important;
				margin-left: -4% !important;
			}
		}
		#modal_instock .select2{
			width:100% !important;
		}

		#search_list{
			position: absolute;
			background-color: #fff;
			z-index: 1;
			padding: 10px;
			padding-top:20px;
			padding-right:20px;
			margin-left: 100px;
			text-align: left;
			display:none;
			min-width: 200px;
			max-height: 320px;
			overflow-y: auto;
			overflow-x:hidden;
		}
		#search_list span.close{
			position: absolute;
			top: 0;
			right: 5px;
			cursor: pointer;
			padding: 5px;
		}
		#search_list ul{
			margin: 0 !important;
			margin-bottom: 10px;
			display: table-row;
		}
		#search_list ul li{
			list-style: none;
			cursor: pointer;
			padding: 3px;
			white-space: nowrap;
		}
		#search_list ul li:hover{
			background: #ddd;
		}

		.sort .select2-selection__rendered{
			font-size: 90% !important;
			font-weight: normal !important;
			text-transform: capitalize !important;
			text-shadow: none !important;
			font-family: 'Open-San',Tahoma, Geneva, sans-serif !important;
			line-height: 18px !important;
			margin-left: 12px;
		}
		.sort .select2-container .select2-selection--single{
			height: 20px;
		}
		.sort .select2-container--default .select2-selection--single .select2-selection__arrow{
			height:15px;
		}
		#select2-select_company-results li:first-child,
		#select2-select_month-results li:first-child{
			height: 18px;
		}
		#table_xuat .select2{
			width:100% !important;
		}
	</style>
@stop

@section('pageJS')
	<script>
		$("#search_list span.close").on("click",function(){
			$("#search_list").hide();
		})

		$("#search_product").keypress(function(e){
			if(e.keyCode==13){
				var key = $(this).val();
				$.ajax({
					url : '{{URL}}/products/search-product-by-key',
					type : 'POST',
					data : {
						key : key
					},
					success : function(data){
						if(data.length){
							var html='';
							for(i=0;i<data.length;i++){
								html+='<li onclick="go_to_product('+data[i]['id']+')">'+data[i]['sku']+' - '+data[i]['name']+'</li>';
							}
							$("#search_list ul").html(html);
							$(window).trigger('resize');
							$("#search_list").css('display','block');
						}else{
							$("#search_list ul").html('<strong>Không tìm thấy sản phẩm</strong>');
							$(window).trigger('resize');
							$("#search_list").css('display','block');
						}
					}
				})
			}
		})

		$("#form_entry input,#form_entry select").on("change",function(){
			var data = $("#form_entry").serialize();
			var id = $(this).attr("name");
			console.log(id)
			$.ajax({
				url: '{{URL}}/products/update',
				type:'POST',
				data: data,
				success:function(data){
					if(data.status=='success'){
						if(data.name != '')
							$("#product_name").text(data.name);
						toastr['success']('Saving success !');

						if(id=='status')
							window.location.reload();
					}else{
						toastr['error'](data.message);
					}
				}
			})
		})

		$("#modal_sellprice").modal({
			"backdrop":true,
			"show":false,
			"container":"body"
		});
		$("#modal_instock").modal({
			"backdrop":true,
			"show":false,
			"container":"body"
		});
		$("#company_id").select2({
			width:"100%"
		});
		$("#delete_product").on("click",function(){
			confirms('Xóa sản phẩm này ?', function(){
				$("#modal_confirm").modal("hide");
				$.ajax({
					url : '{{URL}}/products/delete',
					type : 'GET',
					success : function(data){
						if(data.status=='success'){
							window.location = '{{URL}}/products';
						}else{
							toastr['error'](data.message);
						}
					}
				})
			});
		});

		$("#add_po").on("click",function(e){
			e.preventDefault();
			window.location = '{{URL}}/purchaseorders/create'
		})

		$("#table_nhap select").on("change",function(){
			var type = $("#table_nhap #select_type").val();
			var company_id = $("#table_nhap #select_company").val();
			var month_year = $("#table_nhap #select_month").val();
			$.ajax({
				url : '{{URL}}/products/list-po',
				type: 'GET',
				data:{
					type : type,
					company_id : company_id,
					month_year : month_year,
				},
				success:function(data){
					$("#table_nhap tbody").html(data);				
				}
			})
		})
		$("#table_xuat select").on("change",function(){
			var type = $("#table_xuat #select_type").val();
			var company_id = $("#table_xuat #select_company").val();
			var month_year = $("#table_xuat #select_month").val();
			$.ajax({
				url : '{{URL}}/products/list-so',
				type: 'GET',
				data:{
					type : type,
					company_id : company_id,
					month_year : month_year
				},
				success:function(data){
					$("#table_xuat tbody").html(data);				
				}
			})
		})

		function popup_instock(){
			$("#modal_instock").modal("show");
		}
		function popup_sellprice(id){
			$("#mproduct_id").val(id);
			$.ajax({
				url : '{{URL}}/products/list-sell-price',
				type : 'GET',
				data : {
					'mproduct_id' : $("#mproduct_id").val()
				},
				success: function(data){
					$("#list_price").html( data );
					$("#modal_sellprice").modal("show");
				}
			})
			
		}

		function saveSellPrice(){
			var product_id = $("#mproduct_id").val();
			var id_sellprice = $("#id_sellprice").val();
			var name_sell_price = $("#name_sell_price").val();
			var sell_price = $("#sell_price").val();
			$.ajax({
				url : '{{URL}}/products/save-sell-price',
				type : 'POST',
				data : {
					'product_id' : product_id,
					'id' : id_sellprice,
					'name' : name_sell_price,
					'price' : sell_price
				},
				success: function(data){
					if(data.status=='success'){
						$.ajax({
							url : '{{URL}}/products/list-sell-price',
							type : 'GET',
							data : {
								'mproduct_id' : product_id
							},
							success: function(data){
								$("#list_price").html( data );
								$("#id_sellprice").val(0);
								$("#name_sell_price").val('');
								$("#sell_price").val('');
							}
						})

					}else{
						toastr['error'](data.message);
					}
				}
			})
		}

		function editSellPrice(obj) {
			var data = $.parseJSON( $(obj).attr('data-value') );
			console.log(data);
			$("#id_sellprice").val(data.id);
			$("#name_sell_price").val(data.name);

			var value = data.price;
			value = value.toString();
			while(value.indexOf(',')>0){
				value = value.replace(',','')
			}
			console.log(value);
			value = parseInt(value);
			value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

			$("#sell_price").val(value);
		}

		function deleteSellPrice(id){
			$.ajax({
				url : '{{URL}}/products/delete-sell-price',
				type : 'POST',
				data : {
					'id' : id,
				},
				success: function(data){
					if(data.status=='success'){
						toastr['success']('delete success');
						$.ajax({
							url : '{{URL}}/products/list-sell-price',
							type : 'GET',
							data : {
								'mproduct_id' : $("#mproduct_id").val()
							},
							success: function(data){
								$("#list_price").html( data );
							}
						})
					}else{
						toastr['error'](data.message);
					}
				}
			})
		}

		function addInstock(){
			var html = $("#form_in_stock table tbody tr:first-child").html();

			
			var select_company = $("#form_in_stock table tbody tr:first-child td:first-child")[0].outerHTML;
			html = html.replace(select_company,'');
			var select = $("#form_in_stock table tbody tr:first-child td:first-child #company_id").html();
			html = '<td>'+
					'<select name="company_id" id="company_id" data-type="select2">'+select+'</select>'+
				'</td>'+html;
			html = '<tr>'+
					html+
					'<td> <i class="fa fa-remove link" onclick="deleteInstock(this)"></i></td>'+
				'</tr>';
			$("#form_in_stock table tbody").append(html);
			$("#form_in_stock table tbody tr:last-child #invest").text(0);
			$("[data-type=select2]").select2();
			datatype_number();
			datatype_quantity();
		}
		function deleteInstock(obj){
			$(obj).parent().parent().remove();
		}

		function saveInstock(){
			confirms('Sau khi ấn lưu tồn đầu sẽ không thể chỉnh sửa nữa', function(){
				$("#modal_confirm").modal('hide');
				var data ={};
				$("#form_in_stock table tbody tr").each(function(key){
					var tmp = {};
					tmp['company_id'] = $(this).find("#company_id").val();
					tmp['oum_id'] = $(this).find("#oum_id").val();
					tmp['specification'] = $(this).find("#specification").val();
					tmp['origin_price'] = $(this).find("#origin_price").val();
					tmp['quantity'] = $(this).find("#quantity").val();
					data[key]=tmp;
				});
				data = JSON.stringify(data);
				console.log(data);
				$.ajax({
					url : '{{URL}}/products/save-instock',
					type : 'POST',
					data :{
						'instock' : data
					},
					success : function(data){
						if(data.status=='success'){
							toastr['success']('Saving success');
							setTimeout(function(){
								window.location.reload();
							},1000)
						}else{
							toastr['error'](data.message);
						}
					}
				})
			});
		}

		function changeInstock(obj){
			var invest = 0;
			if($(obj).parent().parent().find('#specification').val() != ''){
				var specification = $(obj).parent().parent().find('#specification').val();
				specification = parseInt(specification);
			}else{
				specification = 0
			}
			
			if($(obj).parent().parent().find('#origin_price').val() != ''){
				var origin_price = $(obj).parent().parent().find('#origin_price').val();
				while(origin_price.indexOf(',')>0){
					origin_price = origin_price.replace(',','');
				}
				origin_price = parseInt(origin_price);
			}else{
				origin_price = 0
			}

			if($(obj).parent().parent().find('#quantity').val() != ''){
				var quantity = $(obj).parent().parent().find('#quantity').val();
				quantity = parseInt(quantity);
			}else{
				quantity = 0
			}

			invest = origin_price * specification * quantity;
			invest = invest.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			$(obj).parent().parent().find('#invest').text(invest);
		}

		function go_to_product(id){
			window.location = "{{URL}}/products/"+id;
		}
	
	</script>
@stop